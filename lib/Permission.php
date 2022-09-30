<?php

namespace Warrant;

class Permission implements \JsonSerializable {
    private string $permissionId;

    public function __construct(string $permissionId) {
        $this->permissionId = $permissionId;
    }

    public function getPermissionId(): string {
        return $this->permissionId;
    }

    public function jsonSerialize(): mixed {
        return [
            "permissionId" => $this->permissionId,
        ];
    }

    public static function fromArray(array $json): Permission {
        return new Permission($json["permissionId"]);
    }
}
