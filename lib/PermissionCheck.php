<?php

namespace Warrant;

class PermissionCheck implements \JsonSerializable {
    private string $permissionId;
    private string $userId;
    private bool $consistentRead;
    private bool $debug;

    public function __construct(string $permissionId, string $userId, bool $consistentRead = false, bool $debug = false) {
        $this->permissionId = $permissionId;
        $this->userId = $userId;
        $this->consistentRead = $consistentRead;
        $this->debug = $debug;
    }

    public function getPermissionId(): string {
        return $this->permissionId;
    }

    public function getUserId(): string {
        return $this->userId;
    }

    public function getConsistentRead(): bool {
        return $this->consistentRead;
    }

    public function getDebug(): bool {
        return $this->debug;
    }

    public function jsonSerialize(): mixed {
        return [
            "permissionId" => $this->permissionId,
            "userId" => $this->userId,
            "consistentRead" => $this->consistentRead,
            "debug" => $this->debug,
        ];
    }
}
