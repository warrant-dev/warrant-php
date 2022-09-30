<?php

namespace Warrant\Exceptions;

class NotFoundException extends ApiErrorException {
    public const ERROR_CODE = "not_found";

    private string $type;
    private string $key;

    public function __construct(string $type, string $key, string $message, Throwable $previous = null) {
        $this->type = $type;
        $this->key = $key;

        parent::__construct(self::ERROR_CODE, $message, 404, $previous);
    }

    public function getType(): string {
        return $this->type;
    }

    public function getKey(): string {
        return $this->key;
    }

    public function __toString() {
        return __CLASS__ . ": {$this->message}\n";
    }

    public static function fromArray(array $json): NotFoundException {
        return new NotFoundException($json["message"]);
    }
}
