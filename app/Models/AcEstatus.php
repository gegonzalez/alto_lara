<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AcEstatus extends Model {

    use SoftDeletes;
    /**
     * Generated
     */

    protected $table = 'ac_estatus';
    protected $fillable = ['id', 'nombre', 'deleted_at', 'referencia'];



}
