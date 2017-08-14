<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\AcClavesDetalle;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;

class ClaveDetalleController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $clavesdetalle = AcClavesDetalle::paginate(15);

        return view('clavesdetalle.index', compact('clavesdetalle'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('clavesdetalle.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, id_clave,codigo_servicio,codigo_especialidad,id_procedimiento,codigo_proveedor,costo);

        AcClavesDetalle::create($request->all());

        Session::flash('flash_message', 'Detalle incluido!');

        //return redirect('clavesdetalle');
        return true;
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
        $clavesdetalle = AcClavesDetalle::findOrFail($id);

        return view('clavesdetalle.show', compact('clavesdetalle'));
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
        $clavesdetalle = AcClavesDetalle::findOrFail($id);

        return view('clavesdetalle.edit', compact('clavesdetalle'));
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
        $this->validate($request, id_clave,codigo_servicio,codigo_especialidad,id_procedimiento,codigo_proveedor,costo);

        $clavesdetalle = AcClavesDetalle::findOrFail($id);
        $clavesdetalle->update($request->all());

        Session::flash('flash_message', 'Detalle actualizado!');

        return redirect('clavesdetalle');
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
        AcClavesDetalle::destroy($id);

        Session::flash('flash_message', 'Detalle eliminado!');

        return redirect('clavesdetalle');
    }

}
