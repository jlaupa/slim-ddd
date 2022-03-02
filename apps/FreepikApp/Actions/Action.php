<?php

declare(strict_types=1);

namespace FreepikApp\Actions;

use App\Shared\Domain\Exception\DomainRecordNotFoundException;
use App\Shared\Domain\Exception\ParamsAreMissingException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Log\LoggerInterface;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpNotFoundException;

abstract class Action
{
    protected Request $request;
    protected Response $response;
    protected array $args;

    public function __construct(
        protected LoggerInterface $logger
    ) {
    }

    /**
     * @throws HttpNotFoundException
     * @throws HttpBadRequestException
     */
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $this->request = $request;
        $this->response = $response;
        $this->args = $args;

        try {
            return $this->action();
        } catch (DomainRecordNotFoundException $e) {
            throw new HttpNotFoundException($this->request, $e->getMessage());
        }
    }

    /**
     * @throws DomainRecordNotFoundException
     * @throws HttpBadRequestException
     */
    abstract protected function action(): Response;

    /**
     * @throws HttpBadRequestException
     */
    protected function getFormData(): array
    {
        $input = json_decode(file_get_contents('php://input'));

        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new HttpBadRequestException($this->request, 'Malformed JSON input.');
        }

        return $input;
    }

    /**
     * @throws HttpBadRequestException
     */
    protected function resolveArg(string $name): mixed
    {
        if (!isset($this->args[$name])) {
            throw new HttpBadRequestException($this->request, "Could not resolve argument {$name}.");
        }

        return $this->args[$name];
    }

    /**
     * @throws ParamsAreMissingException
     */
    protected function resolveQueryParam(string $name): mixed
    {
        $queryParams = $this->request->getQueryParams();

        if (!isset($queryParams[$name])) {
            throw new ParamsAreMissingException($this->request, $name);
        }

        return $queryParams[$name];
    }

    protected function respondWithData(array|object|null $data = null, int $statusCode = 200): Response
    {
        $payload = new ActionPayload($statusCode, $data);

        return $this->respond($payload);
    }

    /**
     * @throws \JsonException
     */
    protected function respond(ActionPayload $payload): Response
    {
        $json = json_encode($payload, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT);

        $bodyResponse = $this->response->getBody();
        $bodyResponse->write($json);

        return $this->response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($payload->getStatusCode());
    }
}
