<?php

namespace Hanafalah\ModuleFunding\Contracts\Schemas;

use Hanafalah\LaravelSupport\Contracts\Data\PaginateData;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Hanafalah\LaravelSupport\Contracts\Supports\DataManagement;
use Hanafalah\ModuleFunding\Contracts\Data\FundingData;

interface Funding extends DataManagement
{
    public function getFunding(): mixed;
    public function prepareShowFunding(?Model $model = null, ?array $attributes = null): ?Model;
    public function showFunding(?Model $model = null): array;
    public function prepareStoreFunding(FundingData $funding_dto): Model;
    public function storeFunding(?FundingData $funding_dto = null): array;
    public function prepareViewFundingList(): Collection;
    public function viewFundingList(): array;
    public function prepareViewFundingPaginate(PaginateData $paginate_dto): LengthAwarePaginator;
    public function viewFundingPaginate(?PaginateData $paginate_dto = null): array;
    public function prepareDeleteFunding(? array $attributes = null): bool;
    public function deleteFunding(): bool;
    public function funding(mixed $conditionals = null): Builder;
    
}
