@extends('layouts.app')

@section('title', 'Ficha Tecnica')

@section('header')
    <h1>Listado de Ficha Técnica</h1>
@stop

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-8">
            @foreach (['success', 'error', 'warning'] as $messageType)
                @if (session($messageType))
                    <x-adminlte-alert theme="{{ $messageType }}" dismissable>
                        {{ session($messageType) }}
                    </x-adminlte-alert>
                @endif
            @endforeach
            @if ($errors->any())
                <x-adminlte-alert theme="danger" dismissable>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </x-adminlte-alert>
            @endif
        </div>
        <div class="col-md-8">
            <x-adminlte-card title="Listado de Ficha Tecnica" theme="primary" icon="fas fa-desktop">
                <x-slot name="toolsSlot">
                    <x-adminlte-button class="ml-2" label="Crear Ficha Tecnica" theme="success" icon="fas fa-plus"
                        onclick="window.location.href='{{ route('technicalSheet.create') }}'" />
                </x-slot>

                <x-adminlte-datatable id="table1" :heads="['ID', 'Acciones']" striped hoverable>
                    @foreach ($technicalSheets as $technicalSheet)
                        <tr>
                            <td>{{ $technicalSheet->id }}</td>
                            <td>
                                <x-adminlte-button class="btn-xs" label="Ver Detalles" theme="primary" icon="fas fa-eye"
                                    onclick="window.location.href='{{ route('technicalSheet.show', $technicalSheet->id) }}'" />
                                <x-adminlte-button class="btn-xs" label="Editar" theme="warning" icon="fas fa-edit"
                                    onclick="window.location.href='{{ route('technicalSheet.edit', $technicalSheet->id) }}'" />
                                <x-adminlte-button class="btn-xs" label="Eliminar" theme="danger" icon="fas fa-trash-alt"
                                    data-toggle="modal" data-target="#deleteModal{{ $technicalSheet->id }}" />
                            </td>
                        </tr>
                    @endforeach

                </x-adminlte-datatable>


            </x-adminlte-card>
        </div>
    </div>
@endsection
