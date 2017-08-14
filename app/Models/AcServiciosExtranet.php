<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AcServiciosExtranet extends Model {

    use SoftDeletes;
    /**
     * Generated
     */

    protected $table = 'ac_servicios_extranet';
    protected $fillable = ['id', 'codigo_servicio', 'descripcion', 'deleted_at'];

    /**
     * Get the Procedimientos for Servicios.
     */
    public function procedimientos()
    {
        return $this->hasMany(\App\Models\AcProcedimientoMedico::class,'codigo_servicio','codigo_servicio');
    }

    /**
     * Get the claves Detalle for Proveedores.
     */
    public function acClavesDetalles()
    {
        return $this->hasMany(\App\Models\AcClavesDetalle::class,'codigo_servicio','codigo_servicio');
    } 
}
