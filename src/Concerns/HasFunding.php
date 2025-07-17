<?php

namespace Hanafalah\ModuleFunding\Concerns;

trait HasFunding
{

    public function initializeFunding()
    {
        $this->mergeFillable([
            $this->getFundingForeignKey()
        ]);
    }

    protected function getFundingForeignKey(): string
    {
        return $this->FundingModel()->getForeignKey();
    }

    //EIGER SECTION
    public function funding()
    {
        return $this->belongsToModel('Funding', $this->getFundingForeignKey());
    }
    //END EIGER SECTION
}
