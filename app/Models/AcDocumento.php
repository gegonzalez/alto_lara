<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AcDocumento extends Model {

    use SoftDeletes;
    /**
     * Generated
     */

    protected $table = 'ac_documentos';
    protected $fillable = ['id', 'id_paciente', 'id_tipo_documento', 'file', 'deleted_at'];


    public function acTipoDocumento() {
        return $this->belongsTo(\App\Models\AcTipoDocumento::class, 'id_tipo_documento', 'id');
    }

    public function acPacientesAtendido() {
        return $this->belongsTo(\App\Models\AcPacientesAtendido::class, 'id_paciente', 'id');
    }


}
