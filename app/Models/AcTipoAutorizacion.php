<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AcTipoAutorizacion extends Model {

    use SoftDeletes;
    /**
     * Generated
     */

    protected $table = 'ac_tipo_autorizacion';
    protected $fillable = ['id', 'descripcion', 'deleted_at'];

    /**
     * Get Paciente Atendido for the Tipo Autorizacion.
     */
    public function pacientes()
    {
        return $this->hasMany(\App\Models\AcPacientesAtendido::class,'tipo_autorizacion','id');
    }

}
