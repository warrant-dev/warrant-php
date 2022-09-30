<?php

namespace Warrant;

class Config {
    private string $apiKey;
    private string $endpoint;
    private string $authorizeEndpoint;

    /** @var string default base URL for Warrant's API */
    public const DEFAULT_API_URL_BASE = "https://api.warrant.dev";

    /** @var string base URL for Warrant's Self Service Dashboard */
    public const SELF_SERVICE_DASH_URL_BASE = "https://self-serve.warrant.dev";

    public function __construct(string $apiKey, string $endpoint = "", string $authorizeEndpoint = "") {
        $this->apiKey = $apiKey;
        $this->endpoint = self::DEFAULT_API_URL_BASE;
        $this->authorizeEndpoint = self::DEFAULT_API_URL_BASE;

        if (!empty($endpoint)) {
            $this->endpoint = $endpoint;
        }

        if (!empty($authorizeEndpoint)) {
            $this->authorizeEndpoint = $authorizeEndpoint;
        }
    }

    public function getApiKey(): string {
        return $this->apiKey;
    }

    public function getEndpoint(): string {
        return $this->endpoint;
    }

    public function getAuthorizeEndpoint(): string {
        return $this->authorizeEndpoint;
    }
}
