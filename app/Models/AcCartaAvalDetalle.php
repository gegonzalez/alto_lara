<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AcCartaAvalDetalle extends Model {

    use SoftDeletes;
    /**
     * Generated
     */

    protected $table = 'ac_carta_aval_detalle';
    protected $fillable = ['id', 'id_carta', 'codigo_servicio', 'codigo_especialidad', 'id_procedimiento', 'codigo_proveedor', 'costo', 'detalle', 'deleted_at','estatus'];


    public function acCartaAval() {
        return $this->belongsTo(\App\Models\AcCartaAval::class, 'id_carta', 'id');
    }

    public function acServiciosExtranet() {
        return $this->belongsTo(\App\Models\AcServiciosExtranet::class, 'codigo_servicio', 'codigo_servicio');
    }

    public function acProveedoresExtranet() {
        return $this->belongsTo(\App\Models\AcProveedoresExtranet::class, 'codigo_proveedor', 'codigo_proveedor');
    }

    public function acEspecialidadesExtranet() {
        return $this->belongsTo(\App\Models\AcEspecialidadesExtranet::class, 'codigo_especialidad', 'codigo_especialidad');
    }

    public function acProcedimientosMedico() {
        return $this->belongsTo(\App\Models\AcProcedimientosMedico::class, 'id_procedimiento', 'id');
    }

    public function acEstatus() {
        return $this->belongsTo(\App\Models\AcEstatusDetalle::class, 'estatus', 'id');
    }

}
