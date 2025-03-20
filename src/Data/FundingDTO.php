<?php

namespace Hanafalah\ModuleFunding\Data;

use Hanafalah\LaravelSupport\Supports\Data;

class FundingDTO extends Data
{
    public function __construct(
        public mixed $id = null,
        public string $name
    ) {}
}
