<?php

declare(strict_types=1);

namespace Zahzah\ModuleFunding;

use Zahzah\LaravelSupport\Providers\BaseServiceProvider;
use Zahzah\ModuleFunding\Schemas\Funding;

class ModuleFundingServiceProvider extends BaseServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return $this
     */
    public function register()
    {
        $this->registerMainClass(ModuleFunding::class)
             ->registerCommandService(Providers\CommandServiceProvider::class)
             ->registers([
                '*','Services' => function(){
                    $this->binds([
                        Contracts\ModuleFunding::class => new ModuleFunding,
                        Contracts\Funding::class => new Funding
                    ]);
                }
            ]);
    }

    /**
     * Get the base path of the package.
     *
     * @return string
     */
    protected function dir(): string{
        return __DIR__.'/';
    }

    protected function migrationPath(string $path = ''): string{
        return database_path($path);
    }
}
