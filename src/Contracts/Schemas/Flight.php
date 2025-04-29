<?php

namespace Hanafalah\ModuleFunding\Contracts\Schemas;

use Hanafalah\ModuleFunding\Contracts\Data\FlightData;
//use Hanafalah\ModuleFunding\Contracts\Data\FlightUpdateData;
use Hanafalah\LaravelSupport\Contracts\Supports\DataManagement;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @see \Hanafalah\ModuleFunding\Schemas\Flight
 * @method self conditionals(mixed $conditionals)
 * @method array updateFlight(?FlightData $flight_dto = null)
 * @method Model prepareUpdateFlight(FlightData $flight_dto)
 * @method bool deleteFlight()
 * @method bool prepareDeleteFlight(? array $attributes = null)
 * @method mixed getFlight()
 * @method ?Model prepareShowFlight(?Model $model = null, ?array $attributes = null)
 * @method array showFlight(?Model $model = null)
 * @method Collection prepareViewFlightList()
 * @method array viewFlightList()
 * @method LengthAwarePaginator prepareViewFlightPaginate(PaginateData $paginate_dto)
 * @method array viewFlightPaginate(?PaginateData $paginate_dto = null)
 * @method array storeFlight(?FlightData $flight_dto = null);
 * @method Builder flight(mixed $conditionals = null);
 */

interface Flight extends DataManagement
{
    public function prepareStoreFlight(FlightData $flight_dto): Model;
}