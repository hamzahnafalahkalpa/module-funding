<?php

namespace Zahzah\ModuleFunding\Models\Funding;

use Illuminate\Database\Eloquent\SoftDeletes;
use Zahzah\LaravelHasProps\Concerns\HasProps;
use Zahzah\LaravelSupport\Models\BaseModel;
use Zahzah\ModuleFunding\Resources\Funding\{
    ViewFunding, ShowFunding
};

class Funding extends BaseModel{
    use HasProps, SoftDeletes;

    public $list = ['id','name','props'];
    protected $casts = [
        'name' => 'string'
    ];

    public function toViewApi(){
        return new ViewFunding($this);
    }

    public function toShowApi(){
        return new ShowFunding($this);
    }
}