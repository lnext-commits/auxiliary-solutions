<?php

namespace Lnext\AuxiliarySolutions\Console\Maker;

use Illuminate\Console\GeneratorCommand;

class FacadeSingleton extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'utility:singletonFacade
                    {name : name facade singleton class}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new facade Singleton class';

    protected $type = 'Facade Singleton class'; // shows up in console

    public function getStub(): string
    {
        return base_path().'/vendor/lnext/auxiliary-solutions/src/Console/stubs/facadeSingleton.stub';
    }

    protected function getDefaultNamespace($rootNamespace): string
    {
        return "$rootNamespace/Singletons/Facades";
    }

    public function replaceClass($stub, $name): array|string
    {
        $class = str_replace($this->getNamespace($name).'\\', '', $name);
        $abstract = str($class)->remove('Facade')->prepend('abstract');
        return str_replace(['DummyClass', '{{abstractAppName}}'], [$class, $abstract], $stub);
    }
}
