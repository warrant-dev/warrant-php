<?php

namespace Warrant\HttpClient;

class RequestOptions {
    protected string $url;
    protected string $apiKey;
    protected string $baseUrl;
    protected ?\JsonSerializable $data;
    protected array $params;

    public function __construct(string $url, string $apiKey = "", string $baseUrl = "", \JsonSerializable $data = null, array $params = []) {
        $this->url = $url;
        $this->apiKey = $apiKey;
        $this->baseUrl = $baseUrl;
        $this->data = $data;
        $this->params = $params;
    }

    public function getUrl(): string {
        return $this->url;
    }

    public function getApiKey(): string {
        return $this->apiKey;
    }

    public function getBaseUrl(): string {
        return $this->baseUrl;
    }

    public function getData(): ?\JsonSerializable {
        return $this->data;
    }

    public function getParams(): array {
        return $this->params;
    }
}
