<?php

namespace ActivismeBe\Console\Database\Models;

use Illuminate\Database\Eloquent\Model;

class Groups extends Model
{
    protected $table    = 'groups';
    protected $fillable = ['group', 'description'];
}