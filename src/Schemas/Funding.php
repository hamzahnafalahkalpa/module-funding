<?php

namespace Hanafalah\ModuleFunding\Schemas;

use Hanafalah\LaravelSupport\Contracts\Data\PaginateData;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Hanafalah\ModuleFunding\{
    Supports\BaseModuleFunding
};
use Hanafalah\ModuleFunding\Contracts\Schemas\Funding as ContractsFunding;
use Hanafalah\ModuleFunding\Contracts\Data\FundingData;

class Funding extends BaseModuleFunding implements ContractsFunding
{
    protected string $__entity = 'Funding';
    public static $funding_model;

    protected array $__cache = [
        'index' => [
            'name'     => 'funding',
            'tags'     => ['funding', 'funding-index'],
            'forever'  => true
        ]
    ];

    protected function viewUsingRelation(): array{
        return [];
    }

    protected function showUsingRelation(): array{
        return [];
    }

    public function getFunding(): mixed{
        return static::$funding_model;
    }

    public function prepareShowFunding(?Model $model = null, ?array $attributes = null): ?Model{
        $attributes ??= request()->all();
        $model      ??= $this->getFunding();
        if (!isset($model)) {
            $id = $attributes['id'] ?? null;
            if (!$id) throw new \Exception('No id provided', 422);
            $model = $this->funding()->with($this->showUsingRelation())->findOrFail($id);
        }else{
            $model->load($this->showUsingRelation());
        }
        return static::$funding_model = $model;
    }

    public function showFunding(?Model $model = null): array{
        return $this->showEntityResource(function() use ($model){
            return $this->prepareShowFunding($model);
        });
    }

    public function prepareStoreFunding(FundingData $funding_dto): Model{
        $funding = $this->FundingModel()->updateOrCreate([
                        'id' => $funding_dto->id ?? null
                    ], [
                        'name' => $funding_dto->name
                    ]);
        static::$funding_model = $funding;
        return $funding;
    }

    public function storeFunding(?FundingData $funding_dto = null): array{
        return $this->transaction(function() use ($funding_dto){
            return $this->showFunding($this->prepareStoreFunding($funding_dto ?? $this->requestDTO(FundingData::class)));
        });
    }

    public function prepareViewFundingList(): Collection{
        return static::$funding_model = $this->cacheWhen(!$this->isSearch(), $this->__cache['index'], function () {
            return $this->funding()->orderBy('name', 'asc')->get();
        });
    }

    public function viewFundingList(): array{
        return $this->viewEntityResource(function() {
            return $this->prepareViewFundingList();
        });
    }

    public function prepareViewFundingPaginate(PaginateData $paginate_dto): LengthAwarePaginator{
        $this->addSuffixCache($this->__cache['index'], "funding-index", 'paginate');
        return $this->cacheWhen(!$this->isSearch(), $this->__cache['index'], function () use ($paginate_dto) {
            return $this->funding()->paginate(...$paginate_dto->toArray())
                        ->appends(request()->all());
        });
    }

    public function viewFundingPaginate(?PaginateData $paginate_dto = null): array{
        return $this->viewEntityResource(function() use ($paginate_dto){
            return $this->prepareViewFundingPaginate($paginate_dto ?? $this->requestDTO(PaginateData::class));
        }, ['rows_per_page' => [50]]);
    }

    public function prepareDeleteFunding(? array $attributes = null): bool{
        $attributes ??= \request()->all();
        if (!$attributes['id']) throw new \Exception('No id provided', 422);
        $result = $this->funding()->find($attributes['id'])->delete();
        $this->flushTagsFrom('index');
        return $result;
    }

    public function deleteFunding(): bool{
        return $this->transaction(function () {
            return $this->prepareDeleteFunding();
        });
    }

    public function funding(mixed $conditionals = null): Builder{
        $this->booting();
        return $this->FundingModel()->withParameters()
                    ->conditionals($this->mergeCondition($conditionals ?? []))->orderBy('name', 'asc');
    }
}
