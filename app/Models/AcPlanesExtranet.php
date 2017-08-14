<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AcPlanesExtranet extends Model {

    use SoftDeletes;
    /**
     * Generated
     */

    protected $table = 'ac_planes_extranet';
    protected $fillable = ['id', 'codigo_plan', 'nombre', 'cobertura', 'orden', 'deleted_at'];

    /**
     * Get the Coberturas for Planes.
     */
    public function coberturas()
    {
        return $this->hasMany(\App\Models\AcCoberturaExtranet::class,'id_plan','codigo_plan');
    }

    /**
     * Get the Contratos for Planes.
     */
    public function contratos()
    {
        return $this->hasMany(\App\Models\AcContrato::class,'codigo_plan','codigo_plan');
    }
}
