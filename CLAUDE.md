# CLAUDE.md - Module Funding

This file provides guidance to Claude Code when working with the `hanafalah/module-funding` package.

## Package Overview

Module Funding is a specialized financial module for managing funding sources and records in Laravel applications. It extends the `module-payment` package's `FinanceStuff` functionality to provide dedicated funding entity management with flag-based type differentiation using the `unicodes` polymorphic table.

**Namespace:** `Hanafalah\ModuleFunding`

**Dependencies:**
- `hanafalah/laravel-support` - Laravel utilities and base classes (required)
- `hanafalah/module-payment` - Parent classes for FinanceStuff schema and model (implicit dependency)

## CRITICAL: Memory Exhaustion Warning

This module's ServiceProvider uses `registers(['*'])` which can trigger memory issues in certain conditions. See the `hanafalah/laravel-support` CLAUDE.md for detailed information about memory exhaustion patterns.

```php
// Current implementation in ModuleFundingServiceProvider
$this->registerMainClass(ModuleFunding::class)
    ->registerCommandService(Providers\CommandServiceProvider::class)
    ->registers(['*']);  // CAUTION: Can cause memory issues with Schema loading
```

### Safe Pattern If Memory Issues Occur

If you experience memory exhaustion during boot, refactor the ServiceProvider:

```php
public function register()
{
    $this->registerMainClass(ModuleFunding::class)
        ->registerCommandService(Providers\CommandServiceProvider::class);

    // Register services manually instead of using registers(['*'])
    $this->app->singleton(
        \Hanafalah\ModuleFunding\Contracts\Schemas\Funding::class,
        fn() => new \Hanafalah\ModuleFunding\Schemas\Funding()
    );
}
```

## Architecture

### Class Hierarchy

```
ModuleFunding (Main Class)
    └── extends BaseModuleFunding
        └── extends PackageManagement (from laravel-support)

Funding Schema
    └── extends FinanceStuff (from module-payment)
        └── extends Unicode (from laravel-support)
            └── extends PackageManagement

Funding Model
    └── extends FinanceStuff Model (from module-payment)
        └── extends Unicode Model (from laravel-support)

FundingData DTO
    └── extends FinanceStuffData (from module-payment)
```

### Directory Structure

```
module-funding/
├── assets/
│   └── config/
│       └── config.php          # Module configuration
├── src/
│   ├── Commands/
│   │   ├── EnvironmentCommand.php    # Base command class
│   │   └── InstallMakeCommand.php    # Installation command
│   ├── Concerns/
│   │   └── HasFunding.php            # Trait for model relationships
│   ├── Contracts/
│   │   ├── Data/
│   │   │   └── FundingData.php       # DTO interface
│   │   ├── Schemas/
│   │   │   └── Funding.php           # Schema interface
│   │   └── ModuleFunding.php         # Main module interface
│   ├── Data/
│   │   └── FundingData.php           # DTO implementation
│   ├── Facades/
│   │   └── ModuleFunding.php         # Laravel Facade
│   ├── Models/
│   │   └── Funding/
│   │       └── Funding.php           # Eloquent model
│   ├── Providers/
│   │   └── CommandServiceProvider.php # Command registration
│   ├── Resources/
│   │   └── Funding/
│   │       ├── ViewFunding.php       # List resource
│   │       └── ShowFunding.php       # Detail resource
│   ├── Schemas/
│   │   └── Funding.php               # Business logic
│   ├── Supports/
│   │   └── BaseModuleFunding.php     # Base support class
│   ├── ModuleFunding.php             # Main module class
│   └── ModuleFundingServiceProvider.php
└── composer.json
```

## Core Components

### Funding Model

The Funding model uses the polymorphic `unicodes` table with flag-based type differentiation:

```php
// src/Models/Funding/Funding.php
class Funding extends FinanceStuff
{
    protected $table = 'unicodes';

    protected static function booted(): void
    {
        parent::booted();
        // Auto-filters all queries to only 'Funding' flagged records
        static::addGlobalScope('flag', function($query) {
            $query->flagIn('Funding');
        });
        // Auto-sets flag on new records
        static::creating(function($query) {
            $query->flag = 'Funding';
        });
    }
}
```

**Important:** The model uses global scopes to automatically:
1. Filter queries to only return records with `flag = 'Funding'`
2. Set `flag = 'Funding'` on newly created records

### Funding Schema

The Schema class provides business logic for CRUD operations:

```php
// src/Schemas/Funding.php
class Funding extends FinanceStuff implements ContractsFunding
{
    protected string $__entity = 'Funding';
    protected $__config_name = 'module-funding';

    protected array $__cache = [
        'index' => [
            'name'     => 'funding',
            'tags'     => ['funding', 'funding-index'],
            'duration' => 24 * 60  // 24 hours
        ]
    ];

    public function prepareStoreFunding(FundingData $funding_dto): Model;
    public function funding(mixed $conditionals = null): Builder;
}
```

**Available Schema Methods** (via contract + inheritance):
| Method | Purpose |
|--------|---------|
| `prepareStoreFunding(FundingData $dto)` | Create/update funding record |
| `storeFunding(?FundingData $dto)` | Transaction-wrapped store |
| `funding($conditionals)` | Query builder for funding records |
| `prepareShowFunding(?Model $model)` | Prepare single record for display |
| `showFunding(?Model $model)` | Transform for API response |
| `prepareViewFundingList()` | Prepare collection for listing |
| `viewFundingList()` | Transform collection for API |
| `prepareViewFundingPaginate(PaginateData $dto)` | Paginated query |
| `viewFundingPaginate(?PaginateData $dto)` | Paginated API response |
| `prepareDeleteFunding(?array $attributes)` | Soft delete preparation |
| `deleteFunding()` | Execute deletion |
| `getFunding()` | Get current funding model |
| `export(string $type)` | Export data |

### FundingData DTO

Data Transfer Object for funding operations:

```php
// src/Data/FundingData.php
class FundingData extends FinanceStuffData implements DataFundingData
{
    public static function before(array &$attributes)
    {
        $attributes['flag'] ??= 'Funding';  // Ensures flag is always set
        parent::before($attributes);
    }
}
```

### HasFunding Trait

Use this trait to add funding relationships to other models:

```php
use Hanafalah\ModuleFunding\Concerns\HasFunding;

class MyModel extends Model
{
    use HasFunding;

    // Adds: funding() belongsTo relationship
    // Adds: funding_id to fillable
}
```

## Configuration

The module configuration is at `assets/config/config.php`:

```php
return [
    'namespace' => 'Hanafalah\ModuleFunding',
    'app' => [
        'contracts' => [
            // Custom contract bindings
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
    'commands' => [
        InstallMakeCommand::class
    ],
    'database' => [
        'models' => [
            // Model bindings for dynamic resolution
        ]
    ]
];
```

**Config Key:** `module-funding`

Publish configuration:
```bash
php artisan vendor:publish --provider="Hanafalah\ModuleFunding\ModuleFundingServiceProvider" --tag=config
```

## Artisan Commands

### Installation Command

```bash
php artisan module-funding:install
```

This command:
1. Publishes the configuration file to `config/module-funding.php`
2. Publishes any migrations

## Usage Examples

### Using the Schema

```php
use Hanafalah\ModuleFunding\Contracts\Schemas\Funding as FundingSchema;
use Hanafalah\ModuleFunding\Data\FundingData;

// Via dependency injection
public function storeFunding(FundingSchema $fundingSchema, Request $request)
{
    $dto = FundingData::from($request->validated());
    $funding = $fundingSchema->prepareStoreFunding($dto);
    return $fundingSchema->showFunding($funding);
}

// Via app container
$fundingSchema = app(FundingSchema::class);
$results = $fundingSchema->viewFundingPaginate();
```

### Using the Facade

```php
use Hanafalah\ModuleFunding\Facades\ModuleFunding;

// Access main module class methods
ModuleFunding::someMethod();
```

### Querying Funding Records

```php
use Hanafalah\ModuleFunding\Models\Funding\Funding;

// All queries automatically filtered to flag='Funding'
$fundings = Funding::all();

// With conditions
$funding = Funding::where('name', 'Grant A')->first();

// Via Schema for complex queries
$fundingSchema = app(FundingSchema::class);
$query = $fundingSchema->funding(['status' => 'active']);
```

### Adding Funding Relationship to Models

```php
use Hanafalah\ModuleFunding\Concerns\HasFunding;

class Project extends Model
{
    use HasFunding;
}

// Usage
$project->funding;  // Returns related Funding model
$project->funding()->associate($funding);
```

## Resource Transformation

### ViewFunding (List Format)

```php
// src/Resources/Funding/ViewFunding.php
// Inherits from ViewFinanceStuff, customize array output for lists
```

### ShowFunding (Detail Format)

```php
// src/Resources/Funding/ShowFunding.php
// Extends ViewFunding with additional ShowFinanceStuff data
```

## Caching

The schema uses tag-based caching:

```php
protected array $__cache = [
    'index' => [
        'name'     => 'funding',
        'tags'     => ['funding', 'funding-index'],
        'duration' => 24 * 60  // 24 hours in minutes
    ]
];
```

Cache is automatically invalidated on store/delete operations when using schema methods.

## Common Pitfalls

1. **Flag Handling** - The model automatically sets `flag = 'Funding'` on creation. Don't manually set different flags or records won't be retrievable via the Funding model.

2. **Parent Dependencies** - This module relies heavily on `module-payment`'s FinanceStuff classes. Ensure module-payment is properly installed and configured.

3. **Unicode Table** - Data is stored in the shared `unicodes` table (polymorphic). The `flag` column differentiates Funding records from other entity types.

4. **Memory Issues** - If experiencing memory exhaustion on boot, see the Memory Exhaustion Warning section above.

5. **Schema Contract Resolution** - Always use the contract interface for dependency injection, not the concrete class:
   ```php
   // Correct
   use Hanafalah\ModuleFunding\Contracts\Schemas\Funding;

   // Avoid
   use Hanafalah\ModuleFunding\Schemas\Funding;
   ```

6. **DTO Before Hook** - The `FundingData::before()` method ensures the flag is set. If you extend FundingData, always call `parent::before($attributes)`.

## Testing Changes

After modifying this module:

```bash
# Clear caches
docker exec -it wellmed-backbone php artisan config:clear
docker exec -it wellmed-backbone php artisan cache:clear

# Reload Octane (if using Octane)
docker exec -it wellmed-backbone php artisan octane:reload

# Check for memory issues in logs
docker logs wellmed-backbone 2>&1 | grep -i "memory\|fatal"
```

## Related Modules

- `hanafalah/laravel-support` - Base classes and traits
- `hanafalah/module-payment` - Parent FinanceStuff classes
- `hanafalah/module-service` - Service layer foundation
