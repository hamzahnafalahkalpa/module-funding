<?php

use Hanafalah\ModuleFunding\{
    Models as ModuleFundingModels,
    Commands as ModuleFundingCommands,
    Contracts
};

return [
    'namespace' => 'Hanafalah\ModuleFunding',
    'app' => [
        'contracts' => [
        ],
    ],
    'commands'  => [
        ModuleFundingCommands\InstallMakeCommand::class
    ],
    'libs' => [
        'model' => 'Models',
        'contract' => 'Contracts',
        'schema' => 'Schemas',
        'database' => 'Database',
        'data' => 'Data',
        'resource' => 'Resources',
        'migration' => '../assets/database/migrations',
    ],
    'database' => [
        'models' => [
        ]
    ]
];
