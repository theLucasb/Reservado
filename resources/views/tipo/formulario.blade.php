@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Dados do Tipo
                    <a href="{{ url('tipo') }}" class="btn btn-success btn-sm float-end">
                        Listar Tipos
                    </a>
                </div>
                <div class="card-body">
                    @if(Session::has('mensagem_sucesso'))
                    <div class="alert alert-success">
                        {{ Session::get('mensagem_sucesso')}}
                    </div>
                    @endif
                    @if(Session::has('mensagem_erro'))
                    <div class="alert alert-warning">
                        {{ Session::get('mensagem_erro')}}
                    </div>
                    @endif

                    @if(Route::is('tipo.show'))
                    {!! Form::model($tipo,
                    ['method'=>'PATCH',
                    'files'=>'True',
                    'url'=>'tipo/'.$tipo->id]) !!}
                    <div class="text-center">
                        <img src="{{ url('/') }}/uploads/tipos/{{ $tipo->icone }}" alt="{{ $tipo->titulo }}"
                            title="{{ $tipo->titulo }}" class="img-thumbnail" width="150" />
                    </div>
                    @else
                    {!! Form::open(['method' => 'POST', 'files' => 'True','url' => 'tipo']) !!}
                    @endif

                    {!! Form::label('titulo', 'Titulo') !!}
                    {!! Form::input('text', 'titulo',
                    null,
                    ['class'=>'form-control',
                    'placeholder'=>'Titulo',
                    'required',
                    'maxlength'=>50,
                    'autofocus']) !!}
                    {!! Form::label('icone', 'Icone') !!}
                    {!! Form::file('icone',
                    ['class'=>'form-control btn-sm']) !!}
                    {!! Form::submit('Salvar',
                    ['class' => 'float-end btn btn-primary mt-3']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection