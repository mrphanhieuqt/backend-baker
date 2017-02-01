<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class {{Model}} extends Model
{
    protected $table = "{{table}}";
    {{timestamps}}
    protected $fillable = {{fillable}};
}
