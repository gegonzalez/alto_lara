<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AcTipoAfiliado extends Model {

    use SoftDeletes;
    /**
     * Generated
     */

    protected $table = 'ac_tipo_afiliado';
    protected $fillable = ['id', 'nombre', 'orden', 'deleted_at'];

    /**
     * Get the Afiliados for the TIpo Afiliado.
     */
    public function afiliados()
    {
        return $this->hasMany(\App\Models\AcAfiliado::class,'tipo_afiliado','id');
    }

}
