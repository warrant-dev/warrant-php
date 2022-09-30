<?php

namespace Warrant\Exceptions;

class ApiErrorException extends \Exception {
    protected string $errorCode;

    public function __construct(string $errorCode, string $message, string $code, Throwable $previous = null) {
        $this->errorCode = $errorCode;

        parent::__construct($message, $code, $previous);
    }

    public function getErrorCode(): string {
        return $this->errorCode;
    }

    public function __toString() {
        return __CLASS__ . ": [{$this->errorCode}]: {$this->message}\n";
    }

    public static function fromArray(array $json): ApiErrorException {
        return new ApiErrorException($json["message"], $json["code"]);
    }
}
