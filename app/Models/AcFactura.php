<?php namespace app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AcFactura extends Model {

    use SoftDeletes;
    /**
     * Generated
     */

    protected $table = 'ac_facturas';
    protected $fillable = ['id', 'numero_factura', 'numero_control', 'fecha_factura', 'monto', 'observaciones', 'fecha_creacion', 'usuario_creador', 
                           'codigo_estatus', 'deleted_at','documento','codigo_proveedor_creador'];
    protected $dates = ['fecha_factura'];
    
    /**
     * The storage format of the model's date columns.
     * @var string
     */
    protected $dateFormat = 'Y-m-d';
    
    function setFechaFacturaAttribute($date) {
        $this->attributes['fecha_factura'] = new Carbon($date);
    }

    public function acEstatus() {
        return $this->belongsTo(\App\Models\AcEstatus::class, 'codigo_estatus', 'id');
    }
    
    public function acProveedor() {
        return $this->belongsTo(\App\Models\AcProveedoresExtranet::class, 'codigo_proveedor_creador', 'codigo_proveedor');
    }
}
