@extends('layouts.app')

@section('title', 'Ficha Tecnica')

@section('header')
    <h1>Crear Ficha Tecnica</h1>
@stop

@section('content')
    <div class="row mt-4 justify-content-center">
        <div class="col-lg-5">
            <x-adminlte-info-box title="Crear Ficha Tecnica de Computador"
                text="Necesitara la informacion de la computadora para crear la ficha tecnica" icon="fas fa-desktop"
                theme="light" icon-theme="primary" class="cursor-pointer w-100"
                onclick="window.location.href='{{ route('technicalSheet.createDevice', ['type' => 'pc']) }}'"></x-adminlte-info-box>
        </div>
        <div class="col-lg-5">
            <x-adminlte-info-box title="Crear Ficha Tecnica de Impresora"
                text="Necesitara la informacion de la impresora para crear la ficha tecnica" icon="fas fa-print"
                theme="light" icon-theme="success" class="cursor-pointer w-100"
                onclick="window.location.href='{{ route('technicalSheet.createDevice', ['type' => 'printer']) }}'"></x-adminlte-info-box>
        </div>
        <div class="col-lg-5">
            <x-adminlte-info-box title="Crear Ficha Tecnica de Escaner"
                text="No es necesario informacion adicional para crear la ficha tecnica" icon="fas fa-file-image"
                theme="light" icon-theme="info" class="cursor-pointer w-100"
                onclick="window.location.href='{{ route('technicalSheet.createDevice', ['type' => 'scanner']) }}'"></x-adminlte-info-box>
        </div>
    </div>
@endsection
