<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AcEstatusDetalle extends Model {

    use SoftDeletes;
    /**
     * Generated
     */

    protected $table = 'ac_estatus_detalle';
    protected $fillable = ['id', 'nombre', 'deleted_at'];



}
