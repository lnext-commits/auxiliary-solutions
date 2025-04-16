## Expanding the capabilities of the Laravel resource
#### To use it, you need to connect the trait resource.
```php
use CheckRelation;
```
The whenRelation function checks if the relation is loaded,
then it runs a private function, the result of which lies in the field
for which it is called, otherwise the field is not added to the resource at the output
``` php
<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Lnext\AuxiliarySolutions\Traits\CheckRelation;

class UserResource extends JsonResource
{
    use CheckRelation;

    public function toArray(Request $request): array
    {
        /** @var User|UserResource $this */
        return [
            'id' => $this->id,
            'name' => $this->name,
            'is_have_use' => $this->whenRelation('buildings', 'getPrice')
        ];
    }

    private function getPrice(): int
    {
        $priceOut = $this->buildings->map(function ($building) {
           return $building->cost;
        });

        return array_sum($priceOut);
    }
}
```
The whenRelationArguments function does the same thing,
but it allows you to pass arguments to a private function.
The first value is always a relation, the rest are those that are passed from above

```php
<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Lnext\AuxiliarySolutions\Traits\CheckRelation;

class UserResource extends JsonResource
{
    use CheckRelation;

    public function toArray(Request $request): array
    {
        /** @var User|UserResource $this */
        return [
            'id' => $this->id,
            'name' => $this->name,
            'is_have_use' => $this->whenRelationArguments('car', 'getPrice', [100, 'up'])
        ];
    }

    private function getPrice($relation, $cost, $action): int
    {
        $priceOut = $this->$relation->cost;
        if ($action == 'up') {
            $priceOut += $cost;
        } else {
            $priceOut -= $cost;
        }

        return $priceOut;
    }
}
```
The whenIf function checks the first value,
if it is true, it runs a private function,
if it is false and the third parameter is not specified,
the field is excluded from the resource, if there is a value, it is inserted into it.

```php
<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Lnext\AuxiliarySolutions\Traits\CheckRelation;

class UserResource extends JsonResource
{
    use CheckRelation;

    public function toArray(Request $request): array
    {
        /** @var User|UserResource $this */
        return [
            'id' => $this->id,
            'name' => $this->name,
            'is_have_use' => $this->whenIf($this->is_active, 'getFlag', 'is_deleted')
        ];
    }

    private function getFlag(): array
    {
        return [
            'go_in' => $this->is_here,
            'main' => $this->persone
        ];
    }
}
```
The whenIfArguments function does the same thing, 
but supports passing arguments to a private function.

---
By connecting the trait, 
it becomes possible to pass the value when calling the resource::collection.

```php
  $companyId = $currentCompany->id;
  $users = User::all();
  $out = UserResource::collection($users, function (UserResource $resource) use ($companyId) {
       $resource->setCompanyId($companyId);
   });
```
```php
<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Lnext\AuxiliarySolutions\Traits\CheckRelation;

class UserResource extends JsonResource
{
    use CheckRelation;

    private int $companyId;

    public function toArray(Request $request): array
    {
        /** @var User|UserResource $this */
        return [
            'id' => $this->id,
            'name' => $this->name,
            'is_have_use' => $this->whenIf($this->is_active, 'getFlag', 'is_deleted')
        ];
    }

    public function setCompanyId($id): void
    {
        $this->companyId = $id;
    }

    private function getFlag(): array
    {
        return [
            'go_in' => $this->is_here,
            'main' => $this->persone,
            'this_company' => $this->user_compay_id == $this->companyId
        ];
    }
}
```