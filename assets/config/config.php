<?php

use Hanafalah\ModuleFunding\{
    Models as ModuleFundingModels,
    Commands as ModuleFundingCommands,
    Contracts
};

return [
    'app' => [
        'contracts' => [
            'funding'        => Contracts\Funding::class,
            'module_funding' => Contracts\ModuleFunding::class,
        ],
    ],
    'commands'  => [
        ModuleFundingCommands\InstallMakeCommand::class
    ],
    'libs' => [
        'model' => 'Models',
        'contract' => 'Contracts'
    ],
    'database' => [
        'models' => [
            'Funding' => ModuleFundingModels\Funding\Funding::class
        ]
    ]
];
