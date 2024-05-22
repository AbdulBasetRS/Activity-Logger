# Activity Logger for Laravel

Activity Logger is a comprehensive logging package for Laravel projects, designed to track various activities within your application. It provides functionality to log events such as entity creation, updates, deletions, and retrievals, along with additional contextual information like user ID, IP address, device type, and more.

## Table of Contents

- [Activity Logger for Laravel](#activity-logger-for-laravel)
  - [Table of Contents](#table-of-contents)
  - [Installation](#installation)
    - [Install](#install)
    - [Configuration](#configuration)
    - [Migrations](#migrations)
  - [Usage](#usage)
    - [Logging Events Directly](#logging-events-directly)
    - [Using Traits](#using-traits)
    - [Using Observers](#using-observers)
  - [Examples](#examples)
  - [Testing](#testing)
  - [Features](#features)
  - [Author](#author)
  - [Contributing](#contributing)
  - [License](#license)

## Installation

### Install

You can install the Activity Logger package via Composer. Run the following command in your terminal:

```bash
composer require abdulbaset/activity-logger
```

### Configuration

After installing the package, publish the configuration file using the following command:

```bash
php artisan vendor:publish --provider="Abdulbaset\ActivityLogger\Providers\ActivityLoggerServiceProvider"
```

You can configure the Activity Logger package by modifying the config/activity-logger.php file. This file allows you to specify settings such as the log table name, log method (database or file), log file path, etc.

```php
return [
        'table_name' => 'activity_logs',
        'log_method' => 'database', // Options: 'database', 'file'
        'log_file_path' => storage_path('logs/activity_logs.log'),
    ];
```

### Migrations

After installing the package, you need to run the migrations to create the required database tables. To do this, use the following Artisan command:

```bash
php artisan migrate --path=vendor/abdulbaset/activity-logger/src/Migrations
```

## Usage

There are multiple ways to integrate the Activity Logger package into your Laravel application, allowing you to track various activities and events within your system, These three methods provide flexibility in how you integrate the Activity Logger package into your Laravel application, allowing you to choose the approach that best fits your project's requirements.

### Logging Events Directly

To log events directly in your application code, you can use the `ActivityLogger` facade provided by the package. Here's an example of how to log an event:

```php
    use Abdulbaset\ActivityLogger\Facades\ActivityLogger;

    ActivityLogger::log(Model::class, 'retrieved', 'Entity retrieved', ['user_id' => auth()->id()]);
```

In this example, Model::class represents the entity being logged, 'retrieved' is the event type, 'Entity retrieved' is the event description, and ['example_key' => 'example value'] is additional information associated with the event.

### Using Traits

With the ActivityLoggerTrait trait applied, you can call methods like logCreated, logUpdated, and logDeleted directly on your model instances:

```php
    // ExampleModel.php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;
    use Abdulbaset\ActivityLogger\Traits\ActivityLoggerTrait; // Adjust namespace based on your package structure

    class ExampleModel extends Model
    {
        use ActivityLoggerTrait;
    }
```

### Using Observers

The Activity Logger Observer allows you to automatically log events when certain actions are performed on your models. To use the Activity Logger Observer:

```php
namespace App\Providers;

namespace Abdulbaset\ActivityLogger\Observers\ActivityLoggerObserver;
use App\Models\ExampleModel;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        ExampleModel::observe(ActivityLoggerObserver::class);
    }
}
```

## Examples

For usage examples and code snippets, please refer to the [Usage](#usage) section above.

## Testing

To run the tests for the Activity Logger package, you can use PHPUnit. Execute the following command in your terminal:

```bash
vendor/bin/phpunit tests/ActivityLoggerTest.php
```

## Features

1. Log various activities such as entity creation, updates, deletions, and retrievals.
2. Capture contextual information like user ID, IP address, device type, etc.
3. Flexibility to choose between logging methods: database or file.

## Author

The Activity Logger package was created by Abdulbaset R. Sayed <AbdulbasetRedaSayedHF@Gmail.com>

## Contributing

Contributions are welcome! If you encounter any issues or have suggestions for improvements, feel free to open an issue or submit a pull request on GitHub.

## License

This Package is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.
