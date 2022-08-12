<?php

/**
 * ------------
 * UUID
 * ------------
 *
 * Create a UUID for the increment primary
 * by Fukigen Media
 * https://github.com/fukigenmedia
 */

namespace App\Models\Traits;

use Illuminate\Support\Str;

trait UUID
{
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (!$model->getKey()) {
                $model->{$model->getKeyName()} = (string) Str::orderedUuid();
            }
        });
    }

    public function getIncrementing()
    {
        return false;
    }

    public function getKeyType()
    {
        return 'string';
    }
}
