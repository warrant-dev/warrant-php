<?php

namespace Warrant;

abstract class Session implements \JsonSerializable {
    private string $type;
    private string $userId;
    private ?string $tenantId;

    public function __construct(string $type, string $userId, ?string $tenantId = "") {
        $this->type = $type;
        $this->userId = $userId;
        $this->tenantId = $tenantId;
    }

    public function jsonSerialize(): mixed {
        $json = [
            "type" => $this->type,
            "userId" => $this->userId,
        ];

        if (!empty($this->tenantId)) {
            $json["tenantId"] = $this->tenantId;
        }

        return $json;
    }

    public static function fromArray(array $json): Session {
        return new Session($json["type"], $json["userId"], $json["tenantId"]);
    }
}
