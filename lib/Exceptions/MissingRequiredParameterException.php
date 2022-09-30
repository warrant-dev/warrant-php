<?php

namespace Warrant\Exceptions;

class MissingRequiredParameterException extends ApiErrorException {
    public const ERROR_CODE = "missing_required_parameter";

    protected string $parameter;

    public function __construct(string $parameter, string $message, Throwable $previous = null) {
        $this->parameter = $parameter;

        parent::__construct(self::ERROR_CODE, $message, 400, $previous);
    }

    public function getParameter(): string {
        return $this->parameter;
    }

    public function __toString() {
        return __CLASS__ . ": {$this->parameter} {$this->message}\n";
    }

    public static function fromArray(array $json): MissingRequiredParameterException {
        return new MissingRequiredParameterException($json["parameter"], $json["message"]);
    }
}
