**Rlustosa Generator** is a new Laravel structure based on data from the existing database table.

## Installation
  After you clone the Laravel 5.1 e.g. 
  `composer create-project laravel/laravel aplicacao "5.1.*"`

1) Edit your project's `composer.json` file to require `rupertlustosa/rlustosa`.

    "require": {
        ...
       "laravelcollective/html": "5.1.*",
       "intervention/image": "^2.3",
       "barryvdh/laravel-debugbar": "^2.3",
       "greggilbert/recaptcha": "^2.1",
       "proengsoft/laravel-jsvalidation": "^1.5",
       "arcanedev/log-viewer": "^4.3"
    },
    "require-dev": {
        ...
        "rupertlustosa/rlustosa": "dev-master",
        "doctrine/dbal": "^2.5"
    },
    "repositories": [
        {
            "type": "vcs",
            "url":  "git@bitbucket.org:rupertlustosa/rlustosa.git"
        }
    ]

2) Update Composer from the CLI:
  
      composer update

3) Open your `config/auth.php` and change:
    
    'model' => App\User::class, TO 'model' => App\Models\Gestor::class,
    
    'table' => 'users', TO 'table' => 'gestores',

4) Go to your .env and adjust the connection to the database.

5) Open your DatabaseSeeder.php and add:

    $this->call(ConfiguracaoTableSeeder::class);
    $this->call(ContatoContatoConfiguracaoTableSeeder::class);
    $this->call(GestorTableSeeder::class);

6) Next, add your new provider to the providers array of config/app.php:
  
    /*
     * Adicionados ao Projeto...
     */
    Collective\Html\HtmlServiceProvider::class,
    Rupertlustosa\Rlustosa\RlustosaServiceProvider::class,
    Intervention\Image\ImageServiceProvider::class,
    Greggilbert\Recaptcha\RecaptchaServiceProvider::class,
    Barryvdh\Debugbar\ServiceProvider::class,
    Proengsoft\JsValidation\JsValidationServiceProvider::class,
    #App\Providers\ComposerServiceProvider::class,
    Arcanedev\LogViewer\LogViewerServiceProvider::class,

  Finally, add six class aliases to the aliases array of config/app.php:

    /*
     * Adicionados ao Projeto...
     */
    'Form' => Collective\Html\FormFacade::class,
    'Html' => Collective\Html\HtmlFacade::class,
    'RForm' => App\Helpers\RForm::class,
    'HeaderPaginacao' => App\Helpers\MontaLinksHeaderPaginacao::class,
    'Image' => Intervention\Image\Facades\Image::class,
    'Recaptcha' => Greggilbert\Recaptcha\Facades\Recaptcha::class,
    'Debugbar' => Barryvdh\Debugbar\Facade::class,
    'JsValidator' => Proengsoft\JsValidation\Facades\JsValidatorFacade::class,


5) First, you must publish the basic files with the command: `php artisan vendor:publish`

7) Dumps the autoloader from the CLI:
    
    composer du

8) Run migrations and seeds:

    php artisan migrate:refresh --seed


## Usage

For generating functional screens (CRUD), run the command: `php artisan rlustosa:create-crud`

## Observações

    