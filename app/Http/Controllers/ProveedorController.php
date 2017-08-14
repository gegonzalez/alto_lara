<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\AcProveedoresExtranet;
use App\Models\AcEstado;
use App\Models\AcEspecialidadesExtranet;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;

class ProveedorController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $proveedoresextranet = AcProveedoresExtranet::paginate(15);
        return view('proveedoresExtranet.index', compact('proveedoresextranet'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $estado = AcEstado::where('es_id','>','0')->get();
        $especialidad = AcEspecialidadesExtranet::where('codigo_especialidad','>','0')->get();
        $especialidades = array_pluck($especialidad,'descripcion','codigo_especialidad'); // ++++++++++++++++ ARRAY
        $estados = array_pluck($estado,'es_desc','es_id');
        return view('proveedoresExtranet.create', compact('especialidades','estados'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request,  ['codigo_proveedor'  => 'required',
                                    'cedula'            => 'required|max:10',
                                    'nombre'            => 'required', 
                                    'fecha_nacimiento'  => 'required|date',
                                    'codigo_especialidad'=> 'required',
                                    'direccion'         => 'required',
                                    'telefono_movil'    => 'required',
                                    'urbanizacion'      => 'required',
                                    'codigo_estado'     => 'required',
                                    'ciudad'            => 'required',
                                    'email'             => 'required',
                                    'colegiatura'       => 'required',
                                    'msas'              => 'required',
                                    ]);
        AcProveedoresExtranet::create($request->all());

        Session::flash('flash_message', 'Proveedores incluido!');

        return redirect('proveedores');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return Response
     */
    public function show($id)
    {
        $proveedoresextranet = AcProveedoresExtranet::findOrFail($id);

        return view('proveedoresExtranet.show', compact('proveedoresextranet'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $proveedoresextranet = AcProveedoresExtranet::findOrFail($id);
        $estado = AcEstado::get();
        $especialidad = AcEspecialidadesExtranet::get();
        $especialidades = array_pluck($especialidad,'descripcion','codigo_especialidad'); // ++++++++++++++++ ARRAY
        $estados = array_pluck($estado,'es_desc','es_id');
        return view('proveedoresExtranet.edit', compact('proveedoresextranet','estados','especialidades'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $this->validate($request,  ['codigo_proveedor'  => 'required',
                                    'cedula'            => 'required|max:10',
                                    'nombre'            => 'required', 
                                    'fecha_nacimiento'  => 'required|date',
                                    'codigo_especialidad'=> 'required',
                                    'direccion'         => 'required',
                                    'telefono_movil'    => 'required',
                                    'urbanizacion'      => 'required',
                                    'codigo_estado'     => 'required',
                                    'ciudad'            => 'required',
                                    'email'             => 'required',
                                    'colegiatura'       => 'required',
                                    'msas'              => 'required',
                                    ]);
        $request->fecha_nacimiento = new Carbon($request->fecha_nacimiento);
        $proveedoresextranet = AcProveedoresExtranet::findOrFail($id);
        $proveedoresextranet->update($request->all());

        Session::flash('flash_message', 'Proveedor actualizado!');

        return redirect('proveedores');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        AcProveedoresExtranet::destroy($id);

        Session::flash('flash_message', 'Proveedor eliminado!');

        return redirect('proveedores');
    }

}
