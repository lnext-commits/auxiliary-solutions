## The command to create a seeder file

```sh
php artisan make:ownSeeder forTest
```

a file with a specific naming will be created.
````
database/seeds/seed_2025_04_17_forTest.php
````
and the structure
```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class seed_2025_04_17_forTest extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $this->command->getOutput()->info('status: start');
        $items = [];
        
        $out = [];
        foreach ($items as $item) {
            $out[] = [
                'key1' => $item->field,
                'key2' => $item->field,
                'key3' => $item->field,
            ];
            
        }
        
        $this->command->getOutput()->newLine();
        $this->command->getOutput()->table(['key1', 'key2', 'key3'], $out);
        $this->command->getOutput()->info('status: finish');
    }
}
```
if you want to add a progress bar to the created file, then you need to add the option
```sh
php artisan make:ownSeeder forTest --progress
```
the resulting result will be like this
```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class seed_2025_04_17_forTest extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $this->command->getOutput()->info('status: start');
        $items = [];
        $bar = $this->command->getOutput()->createProgressBar(count($items));
        $this->command->getOutput()->text('description for progress bar ');
        $bar->start();
        $out = [];
        foreach ($items as $item) {
            $out[] = [
                'key1' => $item->field,
                'key2' => $item->field,
                'key3' => $item->field,
            ];
            $bar->advance();
        }
        $bar->finish();
        $this->command->getOutput()->newLine();
        $this->command->getOutput()->table(['key1', 'key2', 'key3'], $out);
        $this->command->getOutput()->info('status: finish');
    }
}
```
This is an opportunity to add a visual effect while you wait for the base to be seeded.