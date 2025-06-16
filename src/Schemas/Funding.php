<?php

namespace Hanafalah\ModuleFunding\Schemas;

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
    protected mixed $__order_by_created_at = false; //asc, desc, false

    protected array $__cache = [
        'index' => [
            'name'     => 'funding',
            'tags'     => ['funding', 'funding-index'],
            'duration' => 24 * 60
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
}