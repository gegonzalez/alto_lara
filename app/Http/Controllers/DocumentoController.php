<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\AcDocumento;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;

class DocumentoController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $documento = AcDocumento::paginate(15);

        return view('documento.index', compact('documento'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('documento.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, id_paciente,id_tipo_documento,file);

        AcDocumento::create($request->all());

        Session::flash('flash_message', 'Documento incluido!');

        return redirect('documento');
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
        $documento = AcDocumento::findOrFail($id);

        return view('documento.show', compact('documento'));
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
        $documento = AcDocumento::findOrFail($id);

        return view('documento.edit', compact('documento'));
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
        $this->validate($request, id_paciente,id_tipo_documento,file);

        $documento = AcDocumento::findOrFail($id);
        $documento->update($request->all());

        Session::flash('flash_message', 'Documento actualizado!');

        return redirect('documento');
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
        AcDocumento::destroy($id);

        Session::flash('flash_message', 'Documento eliminado!');

        return redirect('documento');
    }

}
