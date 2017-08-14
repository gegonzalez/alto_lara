<?php namespace app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AcEspecialidadesExtranet extends Model {

    use SoftDeletes;
    /**
     * Generated
     */

    protected $table = 'ac_especialidades_extranet';
    protected $fillable = ['id', 'codigo_especialidad', 'rama', 'descripcion', 'deleted_at'];

    /**
     * Get the Procedimientos For Especialidades.
     */
    public function procedimientos()
    {
        return $this->hasMany(\App\Models\AcCoberturaExtranet::class,'codigo_especialidad','codigo_especialidad');
    }
    
    /**
     * Get the Claves Detalle for Especialidades.
     */
    public function acClavesDetalles() {
        return $this->hasMany(\App\Models\AcClavesDetalle::class, 'codigo_especialidad', 'codigo_especialidad');
    }

}
