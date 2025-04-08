<?php

namespace Lnext\AuxiliarySolutions\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class Singleton extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:singleton
                    {name? : name singleton class}
                    {-- arrayBox : extended parent class SingletonArrayBox}
                    ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Singleton classes';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        if ($this->argument('name') === null) {
            $name = $this->ask('enter the name of the service');
        } else {
            $name = $this->argument('name');
        }

        $nameClass = Str::studly($name);
        $arrayBox = $this->option('arrayBox');

        if ($arrayBox) {
            if (!class_exists('App\Singletons\Parent\SingletonArrayBox')) {
                $this->call('utility:SingletonArrayBox', [
                    'name' => 'SingletonArrayBox',
                ]);
            }
        }

        $this->call('utility:singletonClass', [
            'name' => $nameClass,
            '--arrayBox' => $arrayBox,
        ]);

        $this->call('utility:singletonFacade', [
            'name' => str($nameClass)->prepend('Facade'),
        ]);

        $abstract = str($nameClass)->prepend('abstract');
        $this->newLine();
        $this->comment('this line needs to be added to the class: app/Providers/AppServiceProvider::register()');
        $this->alert('$this->app->singleton(\''.$abstract.'\', function ($app) {
            return new \App\Singletons\\'.$nameClass.'();
        });');
        $facade = str($nameClass)->prepend('Facade');
        $this->comment('this line needs to be added to the file: config/app.php in array aliases');
        $this->alert('\''.$nameClass.'\' => \App\Singletons\Facades\\'.$facade.'::class,');
        $this->comment('to support the IDE, run command if the ide helper is installed');
        $this->alert('php artisan ide-helper:generate');

    }
}
