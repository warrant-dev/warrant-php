<?php

namespace Warrant;

class Subject implements \JsonSerializable {
    private string $objectType;
    private string $objectId;
    private ?string $relation;

    public function __construct(string $objectType, string $objectId, ?string $relation = null) {
        $this->objectType = $objectType;
        $this->objectId = $objectId;
        $this->relation = $relation;
    }

    public function jsonSerialize(): mixed {
        $json = [
            "objectType" => $this->objectType,
            "objectId" => $this->objectId,
        ];

        if (!empty($this->relation)) {
            $json["relation"] = $this->relation;
        }

        return $json;
    }

    public static function fromArray(array $json): Subject {
        return new Subject($json["objectType"], $json["objectId"], $json["relation"]);
    }
}
