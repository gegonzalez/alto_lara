<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AcBaremo extends Model {

    use SoftDeletes;
    /**
     * Generated
     */

    protected $table = 'ac_baremos';
    protected $fillable = ['id', 'id_procedimiento', 'id_proveedor', 'monto', 'observaciones', 'deleted_at'];


    public function acProveedoresExtranet() {
        return $this->belongsTo(\App\Models\AcProveedoresExtranet::class, 'id_proveedor', 'codigo_proveedor');
    }

    public function acProcedimientosMedico() {
        return $this->belongsTo(\App\Models\AcProcedimientosMedico::class, 'id_procedimiento', 'id');
    }


}
