<?php

namespace Hanafalah\ModuleFunding\Schemas;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
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

    public function funding(mixed $conditionals = null): Builder{
        $this->booting();
        return $this->FundingModel()->withParameters()
                    ->conditionals($this->mergeCondition($conditionals ?? []))
                    ->orderBy('name', 'asc');
    }
}