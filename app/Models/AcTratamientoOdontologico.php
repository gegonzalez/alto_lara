<?php namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AcTratamientoOdontologico extends Model {

    use SoftDeletes;
    /**
     * Generated
     */

    protected $table = 'ac_tratamiento_odontologico';
    protected $fillable = ['id', 'id_clave', 'id_procedimiento', 'id_diente', 'id_ubicacion', 'fecha_atencion', 'observaciones', 'estatus', 'creador', 'telefono', 'doc1', 'doc2', 'deleted_at'];
    protected $dates = ['fecha_atencion','deleted_at'];

    /**
     * The storage format of the model's date columns.
     * @var string
     */
    protected $dateFormat = 'Y-m-d';
    
    function setFechaAtencionAttribute($date) {
        $this->attributes['fecha_atencion'] = new Carbon($date);
    }
    
    public function acEstatusDetalle() {
        return $this->belongsTo(\App\Models\AcEstatusDetalle::class, 'estatus', 'id');
    }

    public function acClaveOdontologica() {
        return $this->belongsTo(\App\Models\AcClaveOdontologica::class, 'id_clave', 'id');
    }

    public function acProcedimientosMedico() {
        return $this->belongsTo(\App\Models\AcProcedimientosMedico::class, 'id_procedimiento', 'id');
    }

    public function acDiente() {
        return $this->belongsTo(\App\Models\AcDiente::class, 'id_diente', 'id');
    }
    
    public function acUbicacionTratamiento() {
        return $this->belongsTo(\App\Models\AcUbicacionTratamiento::class, 'id_ubicacion', 'id');
    }

}
