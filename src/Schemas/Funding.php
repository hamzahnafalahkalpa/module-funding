<?php

namespace Hanafalah\ModuleFunding\Schemas;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Hanafalah\ModuleFunding\{
    Supports\BaseModuleFunding
};
use Hanafalah\ModuleFunding\Contracts\Funding as ContractsFunding;
use Hanafalah\ModuleFunding\Data\FundingDTO;
use Hanafalah\ModuleFunding\Resources\Funding\ViewFunding;

class Funding extends BaseModuleFunding implements ContractsFunding
{
    protected array $__guard   = ['id'];
    protected array $__add     = ['name'];
    protected string $__entity = 'Funding';
    public static $funding_model;

    protected array $__resources = [
        'view' => ViewFunding::class
    ];

    protected array $__cache = [
        'index' => [
            'name'     => 'funding',
            'tags'     => ['funding', 'funding-index'],
            'forever'  => true
        ]
    ];

    public function addOrChange(?array $attributes = []): self
    {
        $this->updateOrCreate($attributes);
        return $this;
    }

    public function getFunding(): mixed
    {
        return static::$funding_model;
    }

    public function prepareShowFunding(?Model $model = null, ?array $attributes = null): ?Model
    {
        $this->booting();

        $attributes ??= request()->all();
        $model      ??= $this->getFunding();
        if (!isset($model)) {
            $id = $attributes['id'] ?? null;
            if (!request()->has('id')) throw new \Exception('No id provided', 422);
            if (!isset($model)) $model = $this->funding()->find($id);
        }
        return static::$funding_model = $model;
    }

    public function showFunding(?Model $model = null): array
    {
        return $this->transforming($this->__resources['view'], $this->prepareShowFunding($model));
    }

    protected function createFunding(FundingDTO $funding): Model
    {
        return $this->FundingModel()->updateOrCreate([
            'id' => $funding->id ?? null
        ], ['name' => $funding->name]);
    }

    protected function storeFundingMapper(array $attributes): FundingDTO
    {
        //        if (!isset($attributes['id'])) throw new \Exception('No id provided',422);
        if (!isset($attributes['name'])) throw new \Exception('No name provided', 422);
        return new FundingDTO($attributes['id'] ?? null, $attributes['name'] ?? null);
    }

    public function prepareStoreFunding(?array $attributes = null): Model
    {
        $attributes ??= request()->all();

        static::$funding_model = $funding = $this->createFunding($this->storeFundingMapper($attributes));
        $this->flushTagsFrom('index');
        return $funding;
    }

    public function storeFunding(): array
    {
        return $this->transaction(function () {
            return $this->showFunding($this->prepareStoreFunding());
        });
    }

    public function prepareViewFundingList(): Collection
    {
        return static::$funding_model = $this->cacheWhen(!$this->isSearch(), $this->__cache['index'], function () {
            return $this->funding()->orderBy('name', 'asc')->get();
        });
    }

    public function viewFundingList(): array
    {
        return $this->transforming($this->__resources['view'], fn() => $this->prepareViewFundingList());
    }

    public function prepareViewFundingPaginate(int $perPage = 50, array $columns = ['*'], string $pageName = 'page', ?int $page = null, ?int $total = null): LengthAwarePaginator
    {
        $paginate_options = compact('perPage', 'columns', 'pageName', 'page', 'total');

        $this->addSuffixCache($this->__cache['index'], "funding-index", 'paginate');
        return $this->cacheWhen(!$this->isSearch(), $this->__cache['index'], function () use ($paginate_options) {
            return $this->funding()->orderBy('name', 'asc')->paginate(
                ...$this->arrayValues($paginate_options)
            );
        });
    }

    public function viewFundingPaginate(int $perPage = 50, array $columns = ['*'], string $pageName = 'page', ?int $page = null, ?int $total = null): array
    {
        $paginate_options = compact('perPage', 'columns', 'pageName', 'page', 'total');
        return $this->transforming($this->__resources['view'], function () use ($paginate_options) {
            return $this->prepareViewFundingPaginate(...$this->arrayValues($paginate_options));
        }, ['rows_per_page' => [50]]);
    }

    public function prepareRemoveFunding(): bool
    {
        $id = request()->id;
        if (!request()->has('id')) throw new \Exception('No id provided', 422);
        $this->funding()->find($id)->delete();
        $this->flushTagsFrom('index');
        return true;
    }

    public function removeFundingById(): bool
    {
        return $this->transaction(function () {
            return $this->prepareRemoveFunding();
        });
    }

    public function funding(mixed $conditionals = null): Builder
    {
        return $this->FundingModel()->withParameters()->conditionals($conditionals)->orderBy('name', 'asc');
    }
}
