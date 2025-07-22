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
            <x-adminlte-card title="Filtros de Busqueda" theme="light" icon="fas fa-search" class="w-100">
                <form action="{{ route('technicalSheet.index') }}" method="GET">
                    <div class="row">
                        <div class="col-lg-4">
                            <x-adminlte-input name="search" label="Buscar por Sticker o Modelo" placeholder="Buscar..."
                                value="{{ request('search') }}" />
                        </div>
                        <div class="col-lg-2">
                            <x-adminlte-select name="brand_id" label="Marca">
                                <option value="">Todas</option>
                                @foreach ($brands as $brand)
                                    <option value="{{ $brand->id }}"
                                        {{ request('brand_id') == $brand->id ? 'selected' : '' }}>
                                        {{ $brand->name }}</option>
                                @endforeach
                            </x-adminlte-select>
                        </div>
                        <div class="col-md-12">
                            <x-adminlte-button type="submit" label="Buscar" theme="primary" icon="fas fa-search" />
                        </div>
                    </div>
                </form>
            </x-adminlte-card>
        </div>
        <div class="col-md-8">
            @php
                $computers = $technicalSheets->where('technicalSheetable.deviceable_type', \App\Models\Computer::class);
                $printers = $technicalSheets->where('technicalSheetable.deviceable_type', \App\Models\Printer::class);
                $scanners = $technicalSheets->where('technicalSheetable.deviceable_type', \App\Models\Scanner::class);
                $contents = [
                    view('components.technical-sheets.pc-table', [
                        'computers' => $computers,
                    ]),
                    view('components.technical-sheets.printer-table', [
                        'printers' => $printers,
                    ]),
                    view('components.technical-sheets.scanner-table', [
                        'scanners' => $scanners,
                    ]),
                ];
                $items = [
                    "Computadores ({$computers->count()})",
                    "Impresoras ({$printers->count()})",
                    "Escaners ({$scanners->count()})",
                ];
            @endphp
            <x-tab title="Resultados de la Búsqueda" icon="fas fa-search" theme="light" :items="$items"
                :contents="$contents" />
        </div>
    </div>
@endsection
