<?php

namespace Lnext\AuxiliarySolutions\Console\Maker;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;

class OwnSeeder extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:ownSeeder
                    {name : name seeder seed_Y_m_d_name}
                    {-- progress : create an opportunity for progress }
                    ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new own seeder class';

    protected $type = 'Own Seeder data base'; // shows up in console

    public function getStub(): string
    {
        return base_path().'/vendor/lnext/auxiliary-solutions/src/Console/stubs/ownSeeder.stub';
    }

    protected function getPath($name): string
    {
        $name = str_replace('\\', '/', Str::replaceFirst($this->rootNamespace(), '', $name));
        $name = 'seed_'.date('Y_m_d_').$name;

        if (is_dir($this->laravel->databasePath().'/seeds')) {
            return $this->laravel->databasePath().'/seeds/'.$name.'.php';
        }

        return $this->laravel->databasePath().'/seeders/'.$name.'.php';
    }

    /**
     * Get the root namespace for the class.
     *
     * @return string
     */
    protected function rootNamespace(): string
    {
        return 'Database\Seeders\\';
    }

    public function replaceClass($stub, $name): array|string
    {
        $name = str_replace('\\', '/', Str::replaceFirst($this->rootNamespace(), '', $name));
        $name = 'seed_'.date('Y_m_d_').$name;
        if ($this->option('progress')) {
            $barCreate = '$bar = $this->command->getOutput()->createProgressBar(count($items));';
            $barDescription = '$this->command->getOutput()->text(\'description for progress bar \');';
            $barStart = '$bar->start();';
            $barAdvance = '$bar->advance();';
            $barFinish = '$bar->finish();';
        } else {
            $barCreate = $barDescription = $barStart = $barAdvance = $barFinish = '';
        }

        return str_replace(['DummyClass', '{{BARCreate}}', '{{BARDescription}}', '{{BARStart}}', '{{BARAdvance}}', '{{BARFinish}}'],
            [$name, $barCreate, $barDescription, $barStart, $barAdvance, $barFinish],
            $stub);
    }
}
