<?php

namespace ActivismeBe\Console\Database\Models;

use Illuminate\Database\Eloquent\Model;

class Labels extends Model
{
    protected $table    = 'groups';
    protected $fillable = ['group', 'description'];
}