<?php

namespace Lnext\AuxiliarySolutions\Traits;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\MissingValue;

trait CheckRelation
{
    protected function whenRelation(string $relationship, string $callbackFunctionName = null, $default = null, array $arguments = [], bool $inCheck = null)
    {
        $check = is_null($inCheck) ? $this->resource->relationLoaded($relationship) : $inCheck;
        if (is_null($callbackFunctionName)) {
            return $check;
        } else {
            if (is_null($default)) {
                $default = value(new MissingValue());
            } else {
                $default = is_array($default) ? array_filter($default) : $default;
                $default = $default === 0 ? 0 : (empty($default) ? null : $default);
            }

            return ($check && method_exists($this, $callbackFunctionName)) ? $this->$callbackFunctionName(...$arguments) : $default;
        }
    }

    protected function whenRelationArguments(string $relationship, string $callbackFunctionName, array $arguments = [])
    {
        array_unshift($arguments, $relationship);
        return $this->whenRelation($relationship, $callbackFunctionName, null, $arguments);
    }

    protected function whenIf(bool $if, string $callbackFunctionName, $default = null)
    {
        return $this->whenRelation('empty', $callbackFunctionName, $default, [], $if);
    }

    protected function whenIfArguments(bool $if, string $callbackFunctionName, array $arguments, $default = null)
    {
        return $this->whenRelation('empty', $callbackFunctionName, $default, $arguments, $if);
    }


    public static function collection($resource, callable $each = null): AnonymousResourceCollection
    {
        $collection = new AnonymousResourceCollection($resource, \get_called_class());

        if ($resource && (!$resource instanceof MissingValue) && $each) {
            $collection->resource->each($each);
        }

        return $collection;
    }

    protected function getEmpty()
    {
        return value(new MissingValue());
    }
}
