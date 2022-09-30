<?php

namespace Warrant;

class Warrant implements \JsonSerializable {
    private string $objectType;
    private string $objectId;
    private string $relation;
    private Subject $subject;

    public function __construct(string $objectType, string $objectId, string $relation, Subject $subject) {
        $this->objectType = $objectType;
        $this->objectId = $objectId;
        $this->relation = $relation;
        $this->subject = $subject;
    }

    public function jsonSerialize(): mixed {
        return [
            "objectType" => $this->objectType,
            "objectId" => $this->objectId,
            "relation" => $this->relation,
            "subject" => $this->subject,
        ];
    }

    public static function fromArray(array $json): Warrant {
        return new Warrant($json["objectType"], $json["objectId"], $json["relation"], Subject::fromArray($json["subject"]));
    }
}
