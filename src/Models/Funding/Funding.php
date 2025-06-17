<?php

namespace Hanafalah\ModuleFunding\Models\Funding;

use Hanafalah\ModuleFunding\Resources\Funding\{
    ViewFunding,
    ShowFunding
};
use Hanafalah\ModulePayment\Models\Price\FinanceStuff;

class Funding extends FinanceStuff
{
    protected $table = 'finance_stuffs';

    public function getViewResource(){return ViewFunding::class;}
    public function getShowResource(){return ShowFunding::class;}
}
