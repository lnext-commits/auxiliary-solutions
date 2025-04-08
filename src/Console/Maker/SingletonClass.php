<?php

namespace Lnext\AuxiliarySolutions\Console\Maker;

use Illuminate\Console\GeneratorCommand;

class SingletonClass extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'utility:singletonClass
                    {name : name singleton class}
                    {-- arrayBox : extended parent class SingletonArrayBox}
                    ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Singleton class';

    protected $type = 'Singleton class'; // shows up in console

    public function getStub(): string
    {
        return base_path().'/vendor/lnext/auxiliary-solutions/src/Console/stubs/singleton.stub';
    }

    protected function getDefaultNamespace($rootNamespace): string
    {
        return "$rootNamespace/Singletons";
    }

    public function replaceClass($stub, $name): array|string
    {
        $class = str_replace($this->getNamespace($name).'\\', '', $name);
        if ($this->option('arrayBox')) {
            $extended = 'extends SingletonArrayBox';
            $use = 'use App\Singletons\Parent\SingletonArrayBox;';
        } else {
            $extended = $use = '';
        }

        return str_replace(['DummyClass', 'useDummy', 'extended'], [$class, $use, $extended], $stub);
    }
}
