<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AcCoberturaExtranet extends Model {

    use SoftDeletes;
    /**
     * Generated
     */

    protected $table = 'ac_cobertura_extranet';
    protected $fillable = ['id', 'id_plan', 'id_aseguradora', 'id_servicio', 'id_especialidad', 'id_procedimiento', 'deleted_at'];
    protected $dates = ['deleted_at'];

    public function acProcedimientosMedico() {
        return $this->belongsTo(\App\Models\AcProcedimientosMedico::class, 'id_procedimiento', 'id');
    }

    public function acAseguradora() {
        return $this->belongsTo(\App\Models\AcAseguradora::class, 'id_aseguradora', 'id');
    }

    public function acPlanesExtranet() {
        return $this->belongsTo(\App\Models\AcPlanesExtranet::class, 'id_plan', 'id');
    }


}
