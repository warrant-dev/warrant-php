<?php

namespace Warrant;

class User implements \JsonSerializable {
    private ?string $userId;
    private ?string $email;

    public function __construct(?string $userId = "", ?string $email = "") {
        $this->userId = $userId;
        $this->email = $email;
    }

    public function getUserId(): ?string {
        return $this->userId;
    }

    public function getEmail(): ?string {
        return $this->email;
    }

    public function jsonSerialize(): mixed {
        if (empty($this->userId) && empty($this->email)) {
            return new \stdClass();
        }

        $json = [];

        if (!empty($this->userId)) {
            $json["userId"] = $this->userId;
        }

        if (!empty($this->email)) {
            $json["email"] = $this->email;
        }

        return $json;
    }

    public static function fromArray(array $json): User {
        return new User($json["userId"], $json["email"]);
    }
}
