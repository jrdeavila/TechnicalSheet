@extends('layouts.app')

@section('title', 'Ficha Tecnica')

@section('header')

@stop

@section('content')
    <div class="row justify-content-center mt-4">
        <div class="col-md-8">
            <x-adminlte-card title="Crear Ficha Tecnica de Impresora" theme="primary" icon="fas fa-print">
                <form action="{{ route('technicalSheet.store') }}" method="POST">
                    @csrf 
                    <x-adminlte-input name="name" label="Nombre de la Impresora" placeholder="Ingrese el nombre de la impresora" />
                    <x-adminlte-select name="type" label="Tipo de impresora" placeholder="" />
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
