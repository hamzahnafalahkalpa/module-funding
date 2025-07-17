<?php

namespace Hanafalah\ModuleFunding\Resources\Funding;

use Hanafalah\ModulePayment\Resources\FinanceStuff\ShowFinanceStuff;

class ShowFunding extends ViewFunding
{
  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
   */
  public function toArray(\Illuminate\Http\Request $request): array
  {
    $arr = [];
    $show = $this->resolveNow(new ShowFinanceStuff($this));
    $arr = $this->mergeArray(parent::toArray($request), $show, $arr);
    return $arr;
  }
}
