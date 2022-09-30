<?php

namespace Warrant;

class Role implements \JsonSerializable {
    private string $roleId;

    public function __construct(string $roleId) {
        $this->roleId = $roleId;
    }

    public function getRoleId(): string {
        return $this->roleId;
    }

    public function jsonSerialize(): mixed {
        return [
            "roleId" => $this->roleId,
        ];
    }

    public static function fromArray(array $json): Role {
        return new Role($json["roleId"]);
    }
}
