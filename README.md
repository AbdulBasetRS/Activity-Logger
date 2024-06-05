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

To update the Activity Logger package in your Laravel project, you can use Composer's update command. Here's how you can do it:

```bash
composer update abdulbaset/activity-logger
```

After running the update command in your Laravel project directory, and Composer will check for updates to the abdulbaset/activity-logger package and its dependencies. If a newer version is available, Composer will download and install it, updating your project.

### Configuration

After installing the package, publish the configuration file using the following command:

```bash
php artisan vendor:publish --provider="Abdulbaset\ActivityLogger\Providers\ActivityLoggerServiceProvider"
```

You can configure the Activity Logger package by modifying the config/activity-logger.php file. This file allows you to specify settings such as the log table name, log method (database or file), log file path, etc.

```php
return [
        'enabled' => env('ACTIVITY_LOGGER_ENABLED', true),
        'table_name' => 'activity_logs',
        'log_method' => 'database', // Options: 'database', 'file'
        'log_file_path' => storage_path('logs/activity_logs.log'),
        'log_only_changes' => true,
        'log_login_auth' => true,
        'log_logout_auth' => true
    ];
```

### Migrations

After installing the package, you need to run the migrations to create the required database tables. To do this, use the following Artisan command:

1. Running Migrations for Specific Tables

```bash
php artisan migrate --path=vendor/abdulbaset/activity-logger/src/Migrations
```

2. Rolling Back Specific Migrations

```bash
php artisan migrate:rollback --path=vendor/abdulbaset/activity-logger/src/Migrations
```

3. Refreshing Migrations for Specific Tables

```bash
php artisan migrate:refresh --path=vendor/abdulbaset/activity-logger/src/Migrations
```

## Usage

There are multiple ways to integrate the Activity Logger package into your Laravel application, allowing you to track various activities and events within your system, These three methods provide flexibility in how you integrate the Activity Logger package into your Laravel application, allowing you to choose the approach that best fits your project's requirements.

### Logging Events Directly

To log events directly in your application code, you can use the `ActivityLogger` facade provided by the package. Here's an example of how to log an event:

```php
  use Abdulbaset\ActivityLogger\Facades\ActivityLogger;

  ActivityLogger::event(string $event ,string $description ,array $otherInfo);
  ActivityLogger::retrieved(Model::class $model ,string $description ,array $otherInfo);
  ActivityLogger::visited(string $description ,array $otherInfo);
  ActivityLogger::log(Model::class $model, string $event ,string $description ,array $otherInfo);
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

For usage examples and code snippets.

- if you need use in **Controller** following example.

```php
namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use Abdulbaset\ActivityLogger\Facades\ActivityLogger;
use App\Models\Blog;

class BlogController extends Controller
{
    public function index()
    {
      $blogs = Blog::all();
      // set visited event for who visited the blogs page
      ActivityLogger::visited($description = 'Auth visited the blogs page', $otherInfo = ['local' => app()->getLocale()]);
      return view('blog.index');
    }

    public function show(string $id)
    {
      $blog = Blog::find($id);
      // set retrieved event for who gets the blog
      ActivityLogger::retrieved($model = $blog, $description = 'Auth show blog', $otherInfo = ['local' => app()->getLocale()]);
      return view('blog.show');
    }

    public function store(Request $request)
    {
      $blog = Blog::create([
        'title' => 'Test Blog Title',
        'slug' => 'test-blog-slug',
      ]);
      // set log event when you dont use the trait in blog model or observer at app provider
      ActivityLogger::log($model = $blog,$event = 'created' ,$description = 'blog created successfully');
      return view('blog.store');
    }

    public function update(Request $request,string $id)
    {
      $blog = Blog::findOrFail($id);
      $blog->update([
          'title' => 'Test Blog Title Update',
      ]);
      // set log event when you dont use the trait in blog model or observer at app provider
      ActivityLogger::log($model = $blog ,$event = 'updated' ,$description =  'blog updated successfully');
      return view('blog.update');
    }

    public function destroy(string $id)
    {
      $blog = Blog::findOrFail($id);
      // set log event when you dont use the trait in blog model or observer at app provider
      ActivityLogger::log($model = $blog ,$event = 'deleted' ,$description =  'blog deleted successfully');
      $blog->delete();
      return view('blog.destroy');
    }

    public function export(string $id)
    {
      // your logic here
      ActivityLogger::event($event = 'export-excel' ,$description = 'export blogs for excel file' , ['key' => 'value']);
      return view('blog.destroy');
    }

    // etc..
}
```

- if you need use by **Trait** inside model following example.

```php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Abdulbaset\ActivityLogger\Traits\ActivityLoggerTrait;

class Blog extends Model
{
    use HasFactory;
    // tracking activity log for created, updated and deleted
    use ActivityLoggerTrait;

    protected $table = 'blogs';

    protected $fillable = [
        'title',
        'slug',
        // etc..
    ];
}
```

- if you need use by **Observer** following example.

```php
namespace App\Providers;

use Abdulbaset\ActivityLogger\Observers\ActivityLoggerObserver;
use App\Models\Blog;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
      // tracking activity log for created, updated and deleted
        Blog::observe(ActivityLoggerObserver::class);
    }
}
```

- if you want make customized **Observer** following example.

```php
namespace App\Observers;

use App\Models\Blog;
use Abdulbaset\ActivityLogger\Facades\ActivityLogger;

class BlogObserver
{
    public function created(Blog $blog)
    {
        ActivityLogger::log($blog, 'created', 'Blog created');
    }

    public function updated(Blog $blog)
    {
        ActivityLogger::log($blog, 'updated', 'Blog updated');
    }

    public function deleted(Blog $blog)
    {
        ActivityLogger::log($blog, 'deleted', 'Blog deleted');
    }

    // etc..
}
```

and assign inside boot method at AppServiceProvider namespace

```php
namespace App\Providers;

use App\Observers\BlogObserver;
use App\Models\Blog;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blog::observe(BlogObserver::class);
    }
}
```

## Features

- **Comprehensive Activity Logging**: Track various user actions such as create, update, delete, and etc.. operations on models.
- **Flexible Configuration**: Customize logging behavior with configuration options such as log method (database or file), log file path.
- **Automatic Login and Logout Tracking**: Automatically log user login and logout events with configurable options.
- **Event-Specific Data Logging**: Log event-specific data such as changes made during updates, old and new values, IP address, browser details, and more.
- **Support for Laravel**: Use the package seamlessly with Laravel applications.
- **Trait and Observer Support**: Easily integrate activity logging into your models using provided traits or observers.
- **Easy to Use**: Simple API for logging activities, making it straightforward to implement in your application.
- **Custom Event Logging**: Extend the functionality by adding custom event listeners to log additional events specific to your application.
- **Configurable**: Configure the package to suit your application's requirements, including enabling or disabling specific logging features.

## Author

The Activity Logger package was created by Abdulbaset R. Sayed <AbdulbasetRedaSayedHF@Gmail.com>

## Contributing

Contributions are welcome! If you encounter any issues or have suggestions for improvements, feel free to open an issue or submit a pull request on GitHub.

## License

This Package is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.
