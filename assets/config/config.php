<?php

use Hanafalah\ModuleFunding\{
    Models as ModuleFundingModels,
    Commands as ModuleFundingCommands,
    Contracts
};

return [
    'app' => [
        'contracts' => [
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
        ]
    ]
];
