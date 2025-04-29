<?php

namespace Hanafalah\ModuleFunding\Schemas;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Hanafalah\ModuleFunding\{
    Supports\BaseModuleFunding
};
use Hanafalah\ModuleFunding\Contracts\Schemas\Flight as ContractsFlight;
use Hanafalah\ModuleFunding\Contracts\Data\FlightData;

class Flight extends BaseModuleFunding implements ContractsFlight
{
    protected string $__entity = 'Flight';
    public static $flight_model;

    protected array $__cache = [
        'index' => [
            'name'     => 'flight',
            'tags'     => ['flight', 'flight-index'],
            'duration' => 24 * 60
        ]
    ];

    public function prepareStoreFlight(FlightData $flight_dto): Model{
        $flight = $this->usingEntity()->updateOrCreate([
                        'id' => $flight_dto->id ?? null
                    ], [
                        'name' => $flight_dto->name
                    ]);
        $this->fillingProps($flight,$flight_dto->props);
        $flight->save();
        return static::$flight_model = $flight;
    }
}