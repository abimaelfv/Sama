<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Archivos extends Model
{
    protected $guarded = [];
    protected $primaryKey = 'arc_id';

    const CREATED_AT = 'arc_created';
    const UPDATED_AT = 'arc_updated';
}
