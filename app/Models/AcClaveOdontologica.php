<?php namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AcClaveOdontologica extends Model {

    use SoftDeletes;
    /**
     * Generated
     */

    protected $table = 'ac_clave_odontologica';
    protected $fillable = ['id', 'clave', 'tipo_control', 'cedula_afiliado', 'codigo_contrato', 'fecha_atencion1', 'fecha_atencion2', 'fecha_atencion3', 'clave_primaria', 'motivo', 'codigo_proveedor_creador', 'estatus', 'numero_control','creador', 'telefono', 'deleted_at'];
    protected $dates = ['fecha_atencion1','fecha_atencion2','fecha_atencion3','deleted_at'];

    /**
     * The storage format of the model's date columns.
     * @var string
     */
    protected $dateFormat = 'Y-m-d';
    
    public function getCreatedAtAttribute($date){
        return Carbon::createFromFormat('Y-m-d H:i:s', $date);
    }
    public function getUpdatedAtAttribute($date){
        return Carbon::createFromFormat('Y-m-d H:i:s', $date);
    }
    function setFechaAtencion1Attribute($date) {
        $this->attributes['fecha_atencion1'] = new Carbon($date);
    }
    
    function setFechaAtencion2Attribute($date) {
        $this->attributes['fecha_atencion2'] = new Carbon($date);
    }
    
    function setFechaAtencion3Attribute($date) {
        $this->attributes['fecha_atencion3'] = new Carbon($date);
    }
    
    public function acAfiliado() {
        return $this->belongsTo(\App\Models\AcAfiliado::class, 'cedula_afiliado', 'cedula');
    }
    
    public function acEstatus() {
        return $this->belongsTo(\App\Models\AcEstatus::class, 'estatus', 'id');
    }

    public function user() {
        return $this->belongsTo(\App\Models\User::class, 'creador', 'id');
    }

    public function acProveedoresExtranet() {
        return $this->belongsTo(\App\Models\AcProveedoresExtranet::class, 'codigo_proveedor_creador', 'codigo_proveedor');
    }

    public function acTipoControl() {
        return $this->belongsTo(\App\Models\AcTipoControl::class, 'tipo_control', 'id');
    }

    public function acTramientoOdontologico() {
        return $this->hasMany(\App\Models\AcTratamientoOdontologico::class, 'id_clave', 'id');
    }
    
}
