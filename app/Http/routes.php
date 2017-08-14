<?php
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::get('/', function () {
    return view('home');
});
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/
Route::group(['middleware' => ['web']], function () {
//  Route::get('/login', ['as' => 'login', 'uses' => 'AuthController@login']);
    Route::post('/handleLogin', ['as' => 'handleLogin', 'uses' => 'Auth\AuthController@handleLogin']);
//  Route::get('/home', ['middleware' => 'auth', 'as' => 'home', 'uses' => 'UsersController@home']);
    Route::get('/logout', ['as' => 'logout', 'uses' => 'AuthController@logout']);
    //Route::resource('users', 'UsersController');
});
Route::auth();

Route::group(['middleware' => ['auth']], function () {
    Route::get('/home', 'HomeController@index');
   // ++++++++++++++++++++ MENU +++++++++++++++++++++++++++++++++    
    //CONSULTAR CLAVE ODONTOLOGICA
    Route::get('clavesOdonto/consultar'       , 'ClaveOdontologica\ConsultarController@getFilter');
    Route::get('clavesOdonto/consultarDetalle', 'ClaveOdontologica\ClaveOdontologicaController@show');
    Route::get('clavesOdonto/pdfDetalle'      , 'ClaveOdontologica\ConsultarController@pdfdetalle');
    
    //GENERAR CLAVE DE ATENCION
    Route::get('claves/generar'      , 'ClaveController@generar');
    Route::post('claves/generar'     , 'ClaveController@generar');
    Route::post('claves/generarFinal', 'ClaveController@buscarCobertura');
    Route::post('claves/procesar'    , 'ClaveController@procesarGuardar');
     
    //CONSULTAR CLAVES DE ATENCION
    Route::get('claves/consultar'       , 'ConsultarClaveController@getFilter');
    Route::get('claves/consultarDetalle', 'ConsultarClaveController@show');
    Route::get('claves/pdfDetalle'      , 'ConsultarClaveController@pdfdetalle');
    
    // CONFIRMACION DE CLAVES DE ATENCION
    Route::get('claves/confirmar'          ,'ConfirmarClaveController@getFilter');
    Route::get('claves/verificarClave'     ,'ConfirmarClaveController@show');
    Route::post('claves/procesarConfirmar' ,'ConfirmarClaveController@confirmar');
    
        
    // CONFIRMACION DE CLAVES DE ATENCION ESPECIAL
    Route::get( 'clavesEspeciales/confirmarEspeciales','ConfirmarClaveEspecialController@getFilter');
    Route::get( 'clavesEspeciales/verificarClave'     ,'ConfirmarClaveEspecialController@show');
    Route::post('clavesEspeciales/procesarConfirmar'  ,'ConfirmarClaveEspecialController@confirmar');
    
    
    //CONSULTAR CLAVES TEMPORALES
    Route::get('claves/consultarAfiliadosTemporales' , 'ConsultarClaveTemporalController@getFilter');
    Route::get('claves/consultarDetalleClaveTemporal', 'ConsultarClaveTemporalController@show');
    Route::get('claves/pdfDetalleTemporal'           , 'ConsultarClaveTemporalController@pdfdetalle');
    
    //GENERAR CLAVE DE ATENCION ESPECIAL
    Route::get('clavesEspeciales/generar'                       , 'ClaveEspecialesController@generar');
    Route::post('clavesEspeciales/generar'                      , 'ClaveEspecialesController@generar');
   Route::resource('clavesEspeciales/procesarClaveEspeciales'      , 'ClaveEspecialesController@procesarGuardar');
    Route::resource('clavesEspeciales/crearAfiliadosTemporales' , 'AfiliadoTemporalController@crearAfiliadosTemporalesClaveEspecial');
    Route::resource('clavesEspeciales/generarFinalClaveEspeciales'  , 'ClaveEspecialesController@buscarCobertura');

    

    // AUTORIZACION CLAVE DE ATENCION ESPECIAL
    Route::get('clavesEspeciales/autorizar'    , 'AutorizarClaveEspecialesController@getFilter');
    Route::get('clavesEspeciales/showAfiliados', 'AutorizarClaveEspecialesController@Show');
    Route::post('clavesEspeciales/rechazar'    , 'AutorizarClaveEspecialesController@rechazar');
    Route::get('clavesEspeciales/aprobar'      , 'AutorizarClaveEspecialesController@aprobar');
    
    // AUTORIZACION CLAVE DE ATENCION ESPECIAL TEMPORALES
    Route::get('clavesEspeciales/autorizarTemporales'    , 'AutorizarClaveEspecialesTemporalesController@getFilter');
    Route::get('clavesEspeciales/showAfiliadosTemporales', 'AutorizarClaveEspecialesTemporalesController@Show');
    Route::post('clavesEspeciales/rechazarTemporales'    , 'AutorizarClaveEspecialesTemporalesController@rechazar');
    Route::get('clavesEspeciales/aprobarTemporales'      , 'AutorizarClaveEspecialesTemporalesController@aprobar');
    
    //CONSULTAR CLAVES ESPECIALES
    Route::get('clavesEspeciales/consultar'         , 'ConsultarClaveEspecialesController@getFilter');
    Route::get('clavesEspeciales/consultarDetalle'  , 'ConsultarClaveEspecialesController@show');
    Route::get('clavesEspeciales/consultarDocumento', 'ConsultarClaveEspecialesController@download');
    
    //CONSULTAR CLAVES ESPECIALES TEMPORALES
    Route::get('clavesEspeciales/consultarAfiliadosTemporales'     , 'ConsultarClaveEspecialTemporalController@getFilter');
    Route::get('clavesEspeciales/consultarDetalleEspecialTemporal' , 'ConsultarClaveEspecialTemporalController@show');
    Route::get('clavesEspeciales/consultarDocumentoTemporal'       , 'ConsultarClaveEspecialTemporalController@download');
    
    //AFILIADOS TEMPORALES                                   
    Route::resource('claves/afiliadosTemporales'     , 'AfiliadoTemporalController@generarClave');
    Route::resource('claves/crearAfiliadosTemporales', 'AfiliadoTemporalController@crearAfiliadosTemporales');
   
   //AUTORIZAR AFILIADOS TEMPORALES
    Route::get('claves/autorizarAfiliadosTemporales', 'AutorizarAfiliadosTemporalesController@getFilter');
    Route::get('claves/showAfiliados'               , 'AutorizarAfiliadosTemporalesController@Show');
    Route::post('claves/rechazarAfiliadosTemporales', 'AutorizarAfiliadosTemporalesController@rechazar');
    Route::get('claves/aprobarAfiliadosTemporales'  , 'AutorizarAfiliadosTemporalesController@aprobar');
    
    // PACIENTES ATENDIDOS
//    Route::get('servicios/registrar'           , 'PacienteAtendidoController@registar');
//    Route::post('servicios/buscarServicios'    , 'PacienteAtendidoController@buscarServicios');
//    Route::get('servicios/registrarAtencion'   , 'PacienteAtendidoController@show');
//    Route::post('servicios/registrarAtencion'  , 'PacienteAtendidoController@show');
//    Route::post('servicios/grabar'             , 'PacienteAtendidoController@procesarRegistrar');
    
    // CONSULTAR PACIENTES ATENDIDOS 
//    Route::get('servicios/consultar'         , 'ConsultarPacienteAtendidoController@getFilter');
//    Route::get('servicios/consultarDetalle'  , 'ConsultarPacienteAtendidoController@show');
//    Route::get('servicios/consultarDocumento', 'ConsultarClaveEspecialesController@download');
    
    
    // FACTURACION E INCIDENCIAS
    Route::get('facturacion/registrar'      , 'FacturacionController@gestionar');
    Route::post('facturacion/crear'         , 'FacturacionController@procesar');
    Route::post('facturacion/buscar'        , 'FacturacionController@gestionar');

    // INCIDENCIAS
    Route::get( 'incidencias/consultar'            , 'IncidenciasController@getFilter');
    Route::get( 'incidencias/procesarIncidencias'  , 'IncidenciasController@show');
    Route::post('incidencias/gestionar'           , 'IncidenciasController@gestionar');
    Route::get( 'incidencias/email'                , 'IncidenciasController@emailRechazo');
    
    // AUDITORIA 
    Route::get('auditoria/consultar'              , 'AuditoriaController@getFilter');
    Route::get('auditoria/procesarClavesAtencion' , 'AuditoriaController@show'); 
    Route::get('auditoria/detalleClaveAtencion'   , 'AuditoriaController@detalleClaveAtencion'); 
    Route::get('auditoria/descargarDocumento'     , 'AuditoriaController@download');    
    Route::get('auditoria/aprobar'                , 'AuditoriaController@aprobar');
    Route::get('auditoria/rechazar'                , 'AuditoriaController@rechazar');
    
    // PAGOS
    Route::get('pagos/consultar'            , 'PagosController@getFilter');

    
    //GESTIONAR CLAVE ODONTOLOGICA dontologica\GenerarController@getProveedores');
    Route::get('clavesOdonto/gestionar'       , 'ClaveOdontologica\GenerarController@buscar');
    Route::post('clavesOdonto/buscar'         , 'ClaveOdontologica\GenerarController@buscar');
    Route::post('clavesOdonto/gestionarDos'   , 'ClaveOdontologica\GenerarController@buscarClave');
    Route::resource('clavesOdonto'            , 'ClaveOdontologica\ClaveOdontologicaController');
    #Route::post('clavesOdonto/gestionarTres'  , 'ClaveOdontologica\GenerarController@gestionarTres');
    Route::post('clavesOdonto/gestionarTres'  , 'ClaveOdontologica\GenerarController@gestionarSecuencia');
    Route::post('clavesOdonto/actualSecuencia', 'ClaveOdontologica\GenerarController@actualizarSecuencia');
    Route::get('clavesOdonto/editarSecuencia/{id}'      , 'ClaveOdontologica\GenerarController@actualizarFechaAtencion');
    Route::post('clavesOdonto/update'                    , 'ClaveOdontologica\GenerarController@updateFechaSecuencia');
    
    //TRATAMIENTO ODONTOLOGICOS   
    Route::get('tratamiento/registrar'                  , 'ClaveOdontologica\TratamientoController@buscar');
    Route::post('tratamiento/buscar'                    , 'ClaveOdontologica\TratamientoController@buscar');
    Route::post('tratamiento/gestionar'                 , 'ClaveOdontologica\TratamientoController@buscarClave');
    Route::post('tratamiento/cargar'                    , 'ClaveOdontologica\TratamientoController@cargarTratamiento');
    Route::post('tratamiento/procesar'                  , 'ClaveOdontologica\TratamientoController@store');
    Route::get('tratamiento/consultar/{iclave}/{cedula}', 'ClaveOdontologica\TratamientoController@buscarPorClave');
    Route::get('tratamiento/editar/{id}/{cedula}'       , 'ClaveOdontologica\TratamientoController@edit');
    Route::post('tratamiento/update/{id}'               , 'ClaveOdontologica\TratamientoController@update');
    Route::post('tratamiento/realizados'                , 'ClaveOdontologica\TratamientoController@getTratamientoSeisMese');

    
    //CRUDS
    Route::resource('afiliados'  , 'AfiliadoController');
    Route::resource('claves'     , 'ClaveController');
    Route::resource('proveedores', 'ProveedorController');
    Route::resource('usuarios'   , 'Auth\AuthController');
    
    //USARIOS
    Route::resource('auth/register' , 'Auth\AuthController@getRegister');
    Route::post('auth/register', 'Auth\AuthController@postRegister');
    Route::get('auth/confirm/email/{email}/confirm_token/{confirm_token}', 'Auth\AuthController@confirmRegister');

    // Consultar Ajax
    Route::post('selectColectivos'    , 'Ajax\SelectController@getColectivos');
    Route::post('selectProcedimientos', 'Ajax\SelectController@getProcedimientos');
    Route::post('selectProveedores'   , 'Ajax\SelectController@getProveedores');
    Route::post('getTitular'          , 'Ajax\SelectController@getTitular');
    
    
    Route::get('/server/php/', function () {
        return view('server.php.index.php');
    });
});
//Archivo XML
Route::get('dataXml', 'GenerateXmlController@getData');
Route::get('procesarResponseXml', 'GenerateXmlController@procesarResponseXml');