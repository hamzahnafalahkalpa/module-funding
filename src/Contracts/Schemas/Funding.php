<?php

namespace Hanafalah\ModuleFunding\Contracts\Schemas;

use Hanafalah\LaravelSupport\Contracts\Data\PaginateData;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Hanafalah\ModuleFunding\Contracts\Data\FundingData;
use Hanafalah\ModulePayment\Contracts\Schemas\FinanceStuff;

/**
 * @see \Hanafalah\ModuleFunding\Schemas\Funding
 * @method self setParamLogic(string $logic, bool $search_value = false, ?array $optionals = [])
 * @method self conditionals(mixed $conditionals)
 * @method mixed export(string $type)
 * @method bool deleteFunding()
 * @method bool prepareDeleteFunding(? array $attributes = null)
 * @method mixed getFunding()
 * @method ?Model prepareShowFunding(?Model $model = null, ?array $attributes = null)
 * @method array showFunding(?Model $model = null)
 * @method Collection prepareViewFundingList()
 * @method array viewFundingList()
 * @method LengthAwarePaginator prepareViewFundingPaginate(PaginateData $paginate_dto)
 * @method array viewFundingPaginate(?PaginateData $paginate_dto = null)
 * @method array storeFunding(?FundingData $funding_dto = null)
 */
interface Funding extends FinanceStuff
{
    public function prepareStoreFunding(FundingData $funding_dto): Model;
    public function funding(mixed $conditionals = null): Builder;
}
