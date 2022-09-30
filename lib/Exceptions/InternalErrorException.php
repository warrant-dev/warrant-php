<?php

namespace Warrant\Exceptions;

class InternalErrorException extends ApiErrorException {
    public const ERROR_CODE = "internal_error";

    public function __construct(string $message, Throwable $previous = null) {
        parent::__construct(self::ERROR_CODE, $message, 500, $previous);
    }

    public function __toString() {
        return __CLASS__ . ": {$this->message}\n";
    }

    public static function fromArray(array $json): InternalErrorException {
        return new InternalErrorException($json["message"]);
    }
}
