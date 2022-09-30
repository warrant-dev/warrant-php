<?php

namespace Warrant\HttpClient;

class Config {
    protected string $apiKey;
    protected string $baseUrl;

    public function __construct(string $apiKey, string $baseUrl) {
        $this->apiKey = $apiKey;
        $this->baseUrl = $baseUrl;
    }

    public function getApiKey(): string {
        return $this->apiKey;
    }

    public function getBaseUrl(): string {
        return $this->baseUrl;
    }
}
