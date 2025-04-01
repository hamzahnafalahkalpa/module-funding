<?php

namespace Hanafalah\ModuleFunding\Data;

use Hanafalah\LaravelSupport\Supports\Data;
use Hanafalah\ModuleFunding\Contracts\Data\FundingData as DataFundingData;
use Hanafalah\ModuleFunding\Enums\Funding\Status;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;

class FundingData extends Data implements DataFundingData
{
    public function __construct(
        #[MapInputName('id')]
        #[MapName('id')]
        public mixed $id = null,

        #[MapInputName('name')]
        #[MapName('name')]
        public string $name,

        #[MapInputName('status')]
        #[MapName('status')]
        public ?string $status = Status::ACTIVE->value
    ) {}
}
