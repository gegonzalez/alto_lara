<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AcTipoDocumento extends Model {

    use SoftDeletes;
    /**
     * Generated
     */

    protected $table = 'ac_tipo_documentos';
    protected $fillable = ['id', 'descripcion', 'deleted_at'];

    /**
     * Get the Documentos for Tipo Documento.
     */
    public function documentos()
    {
        return $this->hasMany(\App\Models\AcDocumento::class,'id_tipo_documento','id');
    }

}
