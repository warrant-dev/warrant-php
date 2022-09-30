<?php

namespace Warrant;

class SelfServiceSession extends Session {
    public function __construct(string $userId, string $tenantId) {
        parent::__construct("ssdash", $userId, $tenantId);
    }
}
