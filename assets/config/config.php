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
            //ADD YOUR CONTRACTS HERE
        ]
    ],
    'libs' => [
        'model' => 'Models',
        'contract' => 'Contracts',
        'schema' => 'Schemas',
        'database' => 'Database',
        'data' => 'Data',
        'resource' => 'Resources',
        'migration' => '../assets/database/migrations'
    ],
    'commands'  => [
        ModuleFundingCommands\InstallMakeCommand::class
    ],
    'database' => [
        'models' => [
        ]
    ]
];
