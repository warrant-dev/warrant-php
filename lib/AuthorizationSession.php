<?php

namespace Warrant;

class AuthorizationSession extends Session {
    public function __construct(string $userId) {
        parent::__construct("sess", $userId, null);
    }
}
