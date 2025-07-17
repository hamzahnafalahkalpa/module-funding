<?php

namespace Hanafalah\ModuleFunding\Data;

use Hanafalah\ModuleFunding\Contracts\Data\FundingData as DataFundingData;
use Hanafalah\ModulePayment\Data\FinanceStuffData;

class FundingData extends FinanceStuffData implements DataFundingData
{
    public static function before(array &$attributes){
        $attributes['flag'] ??= 'Funding';
        parent::before($attributes);
    }
}
