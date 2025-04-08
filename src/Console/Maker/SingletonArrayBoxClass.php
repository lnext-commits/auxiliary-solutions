<?php

namespace Lnext\AuxiliarySolutions\Console\Maker;

use Illuminate\Console\GeneratorCommand;

class SingletonArrayBoxClass extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'utility:SingletonArrayBox  {name : default SingletonArrayBox}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new SingletonArrayBox class';

    protected $type = 'SingletonArrayBox class'; // shows up in console

    public function getStub(): string
    {
        return base_path().'/vendor/lnext/auxiliary-solutions/src/Console/stubs/singletonArrayBox.stub';
    }

    protected function getDefaultNamespace($rootNamespace): string
    {
        return "$rootNamespace/Singletons/Parent";
    }
}
