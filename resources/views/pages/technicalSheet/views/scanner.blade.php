@extends('layouts.app')

@section('title', 'Ficha Tecnica')

@section('header')

@stop

@section('content')
    <div class="row justify-content-center mt-4">
        <div class="col-md-8">
            <x-adminlte-card title="Crear Ficha Tecnica de Escaner" theme="primary" icon="fas fa-desktop">
                <form action="{{ route('technicalSheet.store') }}" method="POST">
                    @csrf
                    {{-- TODO: Agregar el contenido del formulario de ficha tecnica --}}
                    <x-adminlte-input name="name" label="Nombre del scanner" placeholder="Ingrese el nombre del scanner" />
                    <x-adminlte-input name="estate" label="Estado" placeholder="Ingrese el estado del scaner" />
                    <div class="row justify-content-center">
                        <x-adminlte-button type="submit" label="Guardar" theme="primary" icon="fas fa-save" />
                    </div>
                </form>
            </x-adminlte-card>
        </div>
    </div>


@endsection

@section('admintle_js')

@endsection
