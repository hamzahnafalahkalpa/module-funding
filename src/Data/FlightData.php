<?php

namespace Hanafalah\ModuleFunding\Data;

use Hanafalah\LaravelSupport\Supports\Data;
use Hanafalah\ModuleFunding\Contracts\Data\FlightData as DataFlightData;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;

class FlightData extends Data implements DataFlightData
{
    #[MapInputName('id')]
    #[MapName('id')]
    public mixed $id = null;

    #[MapInputName('name')]
    #[MapName('name')]
    public string $name;

    #[MapInputName('props')]
    #[MapName('props')]
    public ?array $props = null;
}