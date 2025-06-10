<?php

namespace Hanafalah\ModuleFunding\Contracts\Schemas;

use Hanafalah\LaravelSupport\Contracts\Data\PaginateData;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Hanafalah\LaravelSupport\Contracts\Supports\DataManagement;
use Hanafalah\ModuleFunding\Contracts\Data\FundingData;

/**
 * @see \Hanafalah\ModuleFunding\Schemas\Funding
 * @method self conditionals(mixed $conditionals)
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
 * @method Builder funding(mixed $conditionals = null)
 */

interface Funding extends DataManagement
{
    public function prepareStoreFunding(FundingData $funding_dto): Model;
}
