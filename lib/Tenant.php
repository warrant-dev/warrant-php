<?php

namespace Warrant;

class Tenant implements \JsonSerializable {
    private ?string $tenantId;
    private ?string $name;

    public function __construct(?string $tenantId = "", ?string $name = "") {
        $this->tenantId = $tenantId;
        $this->name = $name;
    }

    public function getTenantId(): ?string {
        return $this->tenantId;
    }

    public function getName(): ?string {
        return $this->name;
    }

    public function jsonSerialize(): mixed {
        if (empty($this->tenantId) && empty($this->name)) {
            return new \stdClass();
        }

        $json = [];

        if (!empty($this->tenantId)) {
            $json["tenantId"] = $this->tenantId;
        }

        if (!empty($this->name)) {
            $json["name"] = $this->name;
        }

        return $json;
    }

    public static function fromArray(array $json): Tenant {
        return new Tenant($json["tenantId"], $json["name"]);
    }
}
