<?php

namespace Zahzah\ModuleFunding\Contracts;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Zahzah\LaravelSupport\Contracts\DataManagement;

interface Funding extends DataManagement
{
    public function addOrChange(? array $attributes=[]): self;
    public function getFunding(): mixed;
    public function prepareShowFunding(? Model $model = null, ? array $attributes = null): ?Model;
    public function showFunding(? Model $model = null): array;
    public function prepareStoreFunding(? array $attributes = null): Model ;
    public function storeFunding(): array;
    public function prepareViewFundingList(): Collection;
    public function viewFundingList(): array;
    public function prepareViewFundingPaginate(int $perPage = 50, array $columns = ['*'], string $pageName = 'page',? int $page = null,? int $total = null): LengthAwarePaginator;
    public function viewFundingPaginate(int $perPage = 50, array $columns = ['*'], string $pageName = 'page',? int $page = null,? int $total = null): array;
    public function prepareRemoveFunding(): bool;
    public function removeFundingById(): bool;
    public function funding(mixed $conditionals = null): Builder;
}