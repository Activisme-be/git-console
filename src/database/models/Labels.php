<?php

namespace ActivismeBe\Console\Database\Models;

use Illuminate\Database\Eloquent\Model;

class Labels extends Model
{
    protected $table    = 'labels';
    protected $fillable = ['name', 'hex_color'];

    public function group()
    {
        return $this->belongsToMany(Groups::class)
            ->withTimestamps();
    }
}
