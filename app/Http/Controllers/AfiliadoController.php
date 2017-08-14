<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\AcAfiliado;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;

class AfiliadoController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $afiliados = AcAfiliado::paginate(15);

        return view('afiliados.index', compact('afiliados'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('afiliados.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, cedula, nombre, apellido, fecha_nacimiento, email, sexo, val_user,tipo_afiliado,telefono, cedula_titular);

        AcAfiliado::create($request->all());

        Session::flash('flash_message', 'Afiliado registrado!');

        return redirect('afiliados');
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
        $afiliado = AcAfiliado::findOrFail($id);

        return view('afiliados.show', compact('afiliado'));
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
        $afiliado = AcAfiliado::findOrFail($id);

        return view('afiliados.edit', compact('afiliado'));
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
        $this->validate($request, cedula, nombre, apellido, fecha_nacimiento, email, sexo, val_user,tipo_afiliado,telefono, cedula_titular);

        $afiliado = AcAfiliado::findOrFail($id);
        $afiliado->update($request->all());

        Session::flash('flash_message', 'Afiliado actualizado!');

        return redirect('afiliados');
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
        AcAfiliado::destroy($id);

        Session::flash('flash_message', 'Afiliado eliminado!');

        return redirect('afiliados');
    }

}
