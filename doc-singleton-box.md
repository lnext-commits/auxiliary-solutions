## The command to create a singleton and a facade to it

```sh
 php artisan make:singleton UserData
```

two files will be created, 
a singleton file and a facade to it, 
and instructions for connecting a singleton file 
and a facade to the system will be displayed.

> app/Singletons/UserData.php

> app/Singletons/Facades/FacadeUserData.php

> this line needs to be added to the class: app/Providers/AppServiceProvider::register()
>****************************************************************************************************************************************
>     $this->app->singleton('abstractUserData', function ($app) {
>            return new \App\Singletons\UserData();
>        });     
>****************************************************************************************************************************************
>
>this line needs to be added to the file: config/app.php in array aliases
>************************************************************************
>     'UserData' => \App\Singletons\Facades\FacadeUserData::class,     
>************************************************************************
>
>to support the IDE, run command if the ide helper is installed
>*******************************************
>     php artisan ide-helper:generate     
>*******************************************

_file structure_
```php
<?php

namespace App\Singletons\Facades;

use Illuminate\Support\Facades\Facade;

class FacadeUserData extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'abstractUserData';
    }
}
````
```php
<?php

namespace App\Singletons;


class UserData 
{

}

```
the facade file does not need editing.
And the singleton file implements its own methods. 
They are accessed by facade methods.

```php
  UserData::method();
```
---
If you want to have box methods on board in addition to standard methods, 
you need to run the command with the option

```sh
 php artisan make:singleton UserBox --arrayBox
```
A SingletonArrayBox file will be created and you singleton has inherited it.

#### Your singleton is armed with the following methods:
```php
    UserData::putData('key', 'value'); // save the values in the box under the key
    UserData::putData([
        'key1' => 'value1',
        'key2' => 'value2'
    ]);  // keep the values and keys as they are
    
    UserData::getData(); // get the whole data box
    UserData::getData('key'); // get values by key
    UserData::only(['key1', 'key2', 'keyN']); // get only these values out of the box
    UserData::except(['key1', 'key2', 'keyN']); // get all the values out of the box except these
  
    UserData::exist(); // is there anything in the box?
    UserData::exist('key'); // does this key exist?
    UserData::exist(['key1', 'key2', 'keyN']); // does any of these keys exist?
    UserData::exist(['key1', 'key2', 'keyN'], true); // does all these keys exist at the same time?
    
    UserData::existValue('key', 'search_value'); // is there a value in this key?
    UserData::existValue('key', ['search_value1','search_value2','search_valueN']); // is there any of these values in this key?
    UserData::existValue('key', ['search_value1','search_value2','search_valueN'], true); // are there all these values in this key?
```

_You can put values in a box anywhere in the code and then take it anywhere without 
increasing the passed parameters from function to function._