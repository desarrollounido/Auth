<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelRol extends Model
{
    protected $table = 'roles';
    protected $primaryKey = 'cod_rol';
    protected $fillable = ['nombre_rol', 'descripcion'];
    
    public function usuarios()
    {
        return $this->hasMany(ModelUser::class, 'cod_rol', 'cod_rol');
    }
}
