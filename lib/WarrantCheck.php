<?php

namespace Warrant;

enum WarrantCheckOp: string {
    case ALL_OF = "allOf";
    case ANY_OF = "anyOf";
}

class WarrantCheck implements \JsonSerializable {
    private WarrantCheckOp $op;
    private array $warrants;
    private bool $consistentRead;
    private bool $debug;

    public function __construct(WarrantCheckOp $op, array $warrants, bool $consistentRead = false, bool $debug = false) {
        $this->op = $op;
        $this->warrants = $warrants;
        $this->consistentRead = $consistentRead;
        $this->debug = $debug;
    }

    public function jsonSerialize(): mixed {
        return [
            "op" => $this->op,
            "warrants" => $this->warrants,
            "consistentRead" => $this->consistentRead,
            "debug" => $this->debug,
        ];
    }
}
