<?php

namespace Hanafalah\ModuleFunding\Schemas;

use Illuminate\Database\Eloquent\Model;
use Hanafalah\ModuleFunding\Contracts\Schemas\Funding as ContractsFunding;
use Hanafalah\ModuleFunding\Contracts\Data\FundingData;
use Hanafalah\ModulePayment\Schemas\FinanceStuff;
use Illuminate\Database\Eloquent\Builder;

class Funding extends FinanceStuff implements ContractsFunding
{
    protected string $__entity = 'Funding';
    public $funding_model;
    protected mixed $__order_by_created_at = false; //asc, desc, false
    protected $__config_name = 'module-funding';

    protected array $__cache = [
        'index' => [
            'name'     => 'funding',
            'tags'     => ['funding', 'funding-index'],
            'duration' => 24 * 60
        ]
    ];

    public function prepareStoreFunding(FundingData $funding_dto): Model{
        $funding = parent::prepareStoreFinanceStuff($funding_dto);
        static::$funding_model = $funding;
        return $funding;
    }

    public function funding(mixed $conditionals = null): Builder{
        return parent::financeStuff($conditionals);
    }
}