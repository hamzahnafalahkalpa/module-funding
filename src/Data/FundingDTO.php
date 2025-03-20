<?php

namespace Zahzah\ModuleFunding\Data;

use Zahzah\LaravelSupport\Supports\Data;

class FundingDTO extends Data{
    public function __construct(
        public mixed $id = null,
        public string $name
    ){}
}
