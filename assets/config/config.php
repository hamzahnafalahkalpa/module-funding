<?php 

use Zahzah\ModuleFunding\{
    Models as ModuleFundingModels,
    Commands as ModuleFundingCommands,
    Contracts
};

return [
    'contracts' => [
        'funding'        => Contracts\Funding::class,
        'module_funding' => Contracts\ModuleFunding::class,
    ],
    'commands'  => [
        ModuleFundingCommands\InstallMakeCommand::class
    ],
    'database' => [
        'models' => [
            'Funding' => ModuleFundingModels\Funding\Funding::class
        ]
    ]
];