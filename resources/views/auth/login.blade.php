@extends('layouts.app')

@section('content')
<div class="col-md-8 col-md-offset-2">
    <div class="panel panel-default">
        <div class="panel-heading">Login</div>
        <div class="panel-body">
            <!--<form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">-->
                {!! Form::open(array('route' => 'handleLogin')) !!}
                <div class="form-group{{ $errors->has('user') ? ' has-error' : '' }}">
                    <label class="col-md-2 col-md-offset-2 control-label">Usuario</label>

                    <div class="col-md-6">
                        <input type="text" class="form-control" name="user" value="{{ old('user') }}">

                        @if ($errors->has('user'))
                            <span class="help-block">
                                <strong>{{ $errors->first('user') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label class="col-md-2 col-md-offset-2 control-label">Clave</label>

                    <div class="col-md-6">
                        <input type="password" class="form-control" name="password">

                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="remember"> Recuerdame
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-btn fa-sign-in"></i>Ingresar
                        </button>

                        <a class="btn btn-link" href="{{ url('/password/reset') }}">Olvidó su Clave?</a>
                    </div>
                </div>
                {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
