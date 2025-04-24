<?php

namespace Hanafalah\ModuleFunding\Facades;

class ModuleFunding extends \Illuminate\Support\Facades\Facade
{
  /**
   * Get the registered name of the component.
   *
   * @return string
   */
  protected static function getFacadeAccessor()
  {
    return \Hanafalah\ModuleFunding\Contracts\ModuleFunding::class;
  }
}
