<?php

namespace Warrant\HttpClient;

/**
 * Class HttpClient.
 */
class HttpClient implements HttpClientInterface {
    protected Config $config;
    protected \GuzzleHttp\Client $client;

    private const PREFIX_API_KEY = "ApiKey ";

    public function __construct(Config $config) {
        $this->config = $config;
        $this->client = new \GuzzleHttp\Client([
            "http_errors" => false,
            "headers" => [
                "Authorization" => self::PREFIX_API_KEY . $config->getApiKey(),
                "Content-Type" => "application/json",
            ]
        ]);
    }

    public function get(RequestOptions $requestOptions) {
        $response = $this->client->request(
            "GET",
            $this->buildRequestUrl($requestOptions),
            $this->buildRequestOptions($requestOptions)
        );

        if ($response->getStatusCode() !== 200) {
            throw $this->buildError($response);
        }

        return json_decode($response->getBody(), true);
    }

    public function post(RequestOptions $requestOptions) {
        $response = $this->client->request(
            "POST",
            $this->buildRequestUrl($requestOptions),
            $this->buildRequestOptions($requestOptions)
        );

        if ($response->getStatusCode() !== 200) {
            throw $this->buildError($response);
        }

        return json_decode($response->getBody(), true);
    }

    public function put(RequestOptions $requestOptions) {
        $response = $this->client->request(
            "PUT",
            $this->buildRequestUrl($requestOptions),
            $this->buildRequestOptions($requestOptions)
        );

        if ($response->getStatusCode() !== 200) {
            throw $this->buildError($response);
        }

        return json_decode($response->getBody(), true);
    }

    public function delete(RequestOptions $requestOptions) {
        $response = $this->client->request(
            "DELETE",
            $this->buildRequestUrl($requestOptions),
            $this->buildRequestOptions($requestOptions)
        );

        if ($response->getStatusCode() !== 200) {
            throw $this->buildError($response);
        }

        return json_decode($response->getBody(), true);
    }

    private function buildRequestUrl(?RequestOptions $requestOptions): string {
        $url = $requestOptions->getUrl();
        $baseUrl = $this->config->getBaseUrl();
        if ($requestOptions->getBaseUrl()) {
            $baseUrl = $requestOptions->getBaseUrl();
        }

        return $baseUrl . $url;
    }

    private function buildRequestOptions(?RequestOptions $requestOptions) {
        $guzzleRequestOptions = [
            "headers" => [
                "Authorization" => self::PREFIX_API_KEY . $this->config->getApiKey(),
                "Content-Type" => "application/json",
                "User-Agent" => "warrant-php/" . \Warrant\Client::VERSION,
            ],
        ];

        if (!empty($requestOptions->getApiKey())) {
            $guzzleRequestOptions["headers"]["Authorization"] = self::PREFIX_API_KEY . $requestOptions->getApiKey();
        }

        if (!empty($requestOptions->getParams())) {
            $guzzleRequestOptions["query"] = $requestOptions->getParams();
        }

        if (!empty($requestOptions->getData())) {
            $guzzleRequestOptions["json"] = $requestOptions->getData();
        }

        return $guzzleRequestOptions;
    }

    private function buildError(\GuzzleHttp\Psr7\Response $response): \Exception {
        $json = json_decode($response->getBody(), true);
        switch ($json["code"]) {
            case \Warrant\Exceptions\InternalErrorException::ERROR_CODE:
                return new \Warrant\Exceptions\InternalErrorException($json["message"]);
            case \Warrant\Exceptions\InvalidParameterException::ERROR_CODE:
                return new \Warrant\Exceptions\InvalidParameterException($json["parameter"], $json["message"]);
            case \Warrant\Exceptions\InvalidRequestException::ERROR_CODE:
                return new \Warrant\Exceptions\InvalidRequestException($json["message"]);
            case \Warrant\Exceptions\MissingRequiredParameterException::ERROR_CODE:
                return new \Warrant\Exceptions\MissingRequiredParameterException($json["parameter"], $json["message"]);
            case \Warrant\Exceptions\NotFoundException::ERROR_CODE:
                return new \Warrant\Exceptions\NotFoundException($json["type"], $json["key"], $json["message"]);
            case \Warrant\Exceptions\UnauthorizedException::ERROR_CODE:
                return new \Warrant\Exceptions\UnauthorizedException($json["message"]);
            default:
                return new \Warrant\Exceptions\ApiErrorException($json["code"], $json["message"], $response->getStatusCode());
        }
    }
}
