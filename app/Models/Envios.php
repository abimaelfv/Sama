<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Envios extends Model
{
    protected $guarded = [];
    protected $primaryKey = 'env_id';

    public $timestamps = false;

    public function archivos()
    {
        return $this->hasMany(Archivos::class, 'env_id');
    }
}
