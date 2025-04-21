<?php

namespace Hanafalah\ModuleFunding\Supports;

use Hanafalah\LaravelSupport\Contracts\Supports\DataManagement;
use Hanafalah\LaravelSupport\Supports\PackageManagement;

class BaseModuleFunding extends PackageManagement implements DataManagement
{
    /** @var array */
    protected $__module_funding_config = [];

    /**
     * A description of the entire PHP function.
     *
     * @param Container $app The Container instance
     * @throws Exception description of exception
     * @return void
     */
    public function __construct()
    {
        $this->setConfig('module-funding', $this->__module_funding_config);
    }
}
