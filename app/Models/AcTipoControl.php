<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AcTipoControl extends Model {

    use SoftDeletes;
    /**
     * Generated
     */

    protected $table = 'ac_tipo_control';
    protected $fillable = ['id', 'descripcion', 'deleted_at'];



}
