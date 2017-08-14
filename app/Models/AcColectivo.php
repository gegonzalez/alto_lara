<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AcColectivo extends Model {

    use SoftDeletes;
    /**
     * Generated
     */

    protected $table = 'ac_colectivos';
    protected $fillable = ['id', 'codigo_colectivo', 'nombre', 'codigo_aseguradora', 'deleted_at'];


    public function acAseguradora() {
        return $this->belongsTo(\App\Models\AcAseguradora::class, 'codigo_aseguradora', 'codigo_aseguradora');
    }
    
    /**
     * Get contratos for colectivo.
     */
    public function contratos() {
        return $this->hasMany(\App\Models\AcContrato::class, 'codigo_colectivo', 'codigo_colectivo');
    }
}
