<?php

namespace Warrant;

class WarrantCheckResult {
    private int $code;
    private string $result;
    private ?int $processingTime;
    private ?array $decisionPath;

    public function __construct(int $code, string $result, ?int $processingTime = null, ?array $decisionPath = null) {
        $this->code = $code;
        $this->result = $result;
        $this->processingTime = $processingTime;
        $this->decisionPath = $decisionPath;
    }

    public function getCode(): int {
        return $this->code;
    }

    public function getResult(): string {
        return $this->result;
    }

    public function getProcessingTime(): ?int {
        return $this->processingTime;
    }

    public function getDecisionPath(): ?array {
        return $this->decisionPath;
    }

    public static function fromArray(array $json): WarrantCheckResult {
        return new WarrantCheckResult($json["code"], $json["result"], $json["processingTime"], $json["decisionPath"]);
    }
}
