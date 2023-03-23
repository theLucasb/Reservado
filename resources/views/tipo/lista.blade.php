@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Lista de Tipos
                    <a href="{{ url('tipo/create') }}"
                        class="btn btn-success btn-sm float-end">
                        Novo Tipo
                    </a>
                </div>
                <div class="card-body">
                    <table class="table table-sm table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Titulo</th>
                                <th>Opções</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tipos as $tipo)
                                <tr>
                                    <td>{{ $tipo->id }}</td>
                                    <td>{{ $tipo->titulo }}</td>
                                    <td>
                                        <a href="{{ url('tipo/'.$tipo->id) }}"
                                            class="btn btn-primary btn-sm">
                                            Editar
                                        </a>
                                        {!! Form::open([
                                            'method'=>'DELETE',
                                            'url'=>'tipo/'.$tipo->id,
                                            'style'=>'display:inline']) !!}
                                            <button type="submit"
                                                class="btn btn-danger btn-sm">
                                                Excluir
                                            </button>
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="pagination justify-content-center">
                        {{ $tipos->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
