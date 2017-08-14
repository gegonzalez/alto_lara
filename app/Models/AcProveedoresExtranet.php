<?php namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AcProveedoresExtranet extends Model {

    use SoftDeletes;
    /**
     * Generated
     */

    protected $table = 'ac_proveedores_extranet';
    protected $fillable = ['id', 'codigo_proveedor', 'cedula', 'nombre', 'fecha_nacimiento', 'codigo_especialidad', 'direccion', 'telefono_casa', 'telefono_movil', 'urbanizacion', 'codigo_estado', 'ciudad', 'email', 'colegiatura', 'msas', 'deleted_at'];
    protected $dates = ['fecha_nacimiento','deleted_at'];
    
    /**
     * The storage format of the model's date columns.
     * @var string
     */
    protected $dateFormat = 'Y-m-d';
    
    function setFechaNacimientoAttribute($date) {
        $this->attributes['fecha_nacimiento'] = new Carbon($date);
    }
    /**
     * Get the Baremos for Proveedores.
     */
    public function acBaremos()
    {
        return $this->hasMany(\app\Models\AcBaremo::class,'id_proveedor','codigo_proveedor');
    }

    /**
     * Get the claves Detalle for Proveedores.
     */
    public function acClavesDetalles()
    {
        return $this->hasMany(\App\Models\AcClavesDetalle::class,'codigo_proveedor','codigo_proveedor');
    }
    
    /**
     * Get the users for Proveedores.
     */
    public function acUsers()
    {
        return $this->hasMany(\App\Models\AcClavesDetalle::class,'proveedor','codigo_proveedor');
    }

    /**
     * Get the users for Proveedores.
     */
    public function acCartaAvalDetalles()
    {
        return $this->hasMany(\App\Models\AcClavesDetalle::class,'codigo_proveedor','codigo_proveedor');
    }
    
}
