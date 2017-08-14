<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AcAseguradora extends Model {

    use SoftDeletes;
    /**
     * Generated
     */

    protected $table = 'ac_aseguradora';
    protected $fillable = ['id', 'codigo_aseguradora', 'nombre', 'rif', 'deleted_at'];

    /**
     * Get the Colectivos for Aseguradora.
     */
    public function colectivos()
    {
        return $this->hasMany(\App\Models\AcColectivo::class,'codigo_aseguradora','codigo_aseguradora');
    }
    /**
     * Get the Coberturas for Aseguradora.
     */
    public function coberturas()
    {
        return $this->hasMany(\App\Models\AcCoberturaExtranet::class,'id_aseguradora','codigo_aseguradora');
    }
}
