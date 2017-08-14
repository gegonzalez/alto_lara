<?php namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AcCartaAval extends Model {

    use SoftDeletes;
    /**
     * Generated
     */

    protected $table = 'ac_carta_aval';
    protected $fillable = ['id', 'clave', 'cedula_afiliado', 'codigo_contrato', 'fecha_solicitud', 'fecha_emision', 'motivo', 'diagnostico', 
                            'costo_total', 'documentos', 'estatus', 'codigo_proveedor_creador', 'creador', 'telefono', 'rechazo', 'cantidad_servicios', 
                            'tipo_afiliado', 'fecha_autorizacion', 'deleted_at','id_factura'];
    protected $dates = ['fecha_solicitud','fecha_emision','fecha_autorizacion'];

    /**
     * The storage format of the model's date columns.
     * @var string
     */
    protected $dateFormat = 'Y-m-d';
    
    function setFechaSolicitudAttribute($date) {
        $this->attributes['fecha_solicitud'] = new Carbon($date);
    }
    
    function setFechaEmisionAttribute($date) {
        $this->attributes['fecha_emision'] = new Carbon($date);
    }
    
    function setFechaAutorizacionAttribute($date) {
        $this->attributes['fecha_autorizacion'] = new Carbon($date);
    }
    
    public function acEstatus() {
        return $this->belongsTo(\App\Models\AcEstatus::class, 'estatus', 'id');
    }
    
    public function acCartaDetalles() {
        return $this->hasMany(\App\Models\AcCartaAvalDetalle::class, 'id_clave', 'id');
    }
    
    public function users() {
        return $this->belongsTo(\App\User::class, 'creador', 'id');
    }
    
    public function factura() {
        return $this->belongsTo(\App\User::class, 'id_factura', 'id');
    }
    
    public function acProveedor() {
        return $this->belongsTo(\app\Models\AcProveedoresExtranet::class, 'codigo_proveedor_creador', 'codigo_proveedor');
    }
    
    public function contratos() {
        return $this->belongsTo(\App\User::class, 'codigo_contrato', 'codigo_contrato');
    }
}
