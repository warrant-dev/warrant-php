<?php

namespace Warrant\Exceptions;

class UnauthorizedException extends ApiErrorException {
    public const ERROR_CODE = "unauthorized";

    public function __construct(string $message, Throwable $previous = null) {
        parent::__construct(self::ERROR_CODE, $message, 400, $previous);
    }

    public function __toString() {
        return __CLASS__ . ": {$this->message}\n";
    }

    public static function fromArray(array $json): UnauthorizedException {
        return new UnauthorizedException($json["message"]);
    }
}
