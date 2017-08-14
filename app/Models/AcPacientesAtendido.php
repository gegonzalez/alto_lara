<?php namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AcPacientesAtendido extends Model {

    use SoftDeletes;
    /**
     * Generated
     */

    protected $table = 'ac_pacientes_atendidos';
    protected $fillable = ['id', 'tipo_autorizacion', 'cedula_afiliado', 'clave', 'id_clave_detalle', 'fecha_atencion', 'patologia', 'observaciones', 'deleted_at'];
    protected $dates = ['fecha_atencion'];

     /**
     * The storage format of the model's date columns.
     * @var string
     */
    protected $dateFormat = 'Y-m-d';
    
    function setFechaAtencionAttribute($date) {
        $this->attributes['fecha_atencion'] = new Carbon($date);
    }
    
    public function acAfiliado() {
        return $this->belongsTo(\App\Models\AcAfiliado::class, 'cedula_afiliado', 'cedula');
    }

    public function acTipoAutorizacion() {
        return $this->belongsTo(\App\Models\AcTipoAutorizacion::class, 'tipo_autorizacion', 'id');
    }

    /**
     * Get the Documentos for Pacientes Atendidos.
     */
    public function documentos()
    {
        return $this->hasMany(\App\Models\AcDocumento::class,'id','id_paciente');
    }

}
