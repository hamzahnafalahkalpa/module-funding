<?php

namespace Hanafalah\ModuleFunding\Models\Funding;

use Hanafalah\ModuleFunding\Resources\Funding\{
    ViewFunding,
    ShowFunding
};
use Hanafalah\ModulePayment\Models\Price\FinanceStuff;

class Funding extends FinanceStuff
{
    protected $table = 'unicodes';

    protected static function booted(): void{
        parent::booted();
        static::addGlobalScope('flag',function($query){
            $query->flagIn('Funding');
        });
        static::creating(function($query){
            $query->flag = 'Funding';
        });
    }

    public function getViewResource(){return ViewFunding::class;}
    public function getShowResource(){return ShowFunding::class;}
}
