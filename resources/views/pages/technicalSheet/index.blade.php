@extends('layouts.app')

@section('title', 'Ficha Tecnica')

@section('header')
    <h1>Listado de Ficha Técnica</h1>
@stop

@section('content')
    <div class="row mt-4 justify-content-center">
        <div class="col-md-2 mb-3">
            <form action="{{ route('technicalSheet.index') }}" method="GET">
                @csrf
                <input type="hidden" name="type" value="pcs">
                <button class="btn btn-outline-primary btn-lg custom-large-button w-100" data-device-type="computadora"
                    id="pc" type="submit">
                    <i class="fas fa-desktop fa-4x d-block mb-2"></i> <span>Computadora</span>
                </button>
            </form>
        </div>

        <div class="col-md-2 mb-3">
            <form action="{{ route('technicalSheet.index') }} " method="GET">
                @csrf
                <input type="hidden" name="type" value="printers">
                <button type="submit" class="btn btn-outline-info btn-lg custom-large-button w-100"
                    data-device-type="impresora" id="printer">
                    <i class="fas fa-print fa-4x d-block mb-2"></i>
                    <span>Impresora</span>
                </button>

            </form>
        </div>

        <div class="col-md-2 mb-3">
            <form action="{{ route('technicalSheet.index') }}" method="GET">
                @csrf
                <input type="hidden" name="type" value="scanners">
                <button type="submit" class="btn btn-outline-success btn-lg custom-large-button w-100"
                    data-device-type="escáner" id="scanner">
                    <i class="fas fa-camera fa-4x d-block mb-2"></i>
                    <span>Escáner</span>
                </button>
            </form>
        </div>
    </div>
@endsection

@section('adminlte_js')

@endsection
