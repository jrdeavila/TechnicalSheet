@extends('layouts.app')

@section('title', 'Ficha Tecnica')

@section('header')

@stop

@section('content')
    <div x-data="data()" class="row justify-content-center mt-4">
        <div class="col-md-12">
            @foreach (['success', 'error', 'warning'] as $messageType)
                @if (session($messageType))
                    <x-adminlte-alert theme="{{ $messageType }}" title="{{ __('messages.' . $messageType) }}">
                        {{ session($messageType) }}
                    </x-adminlte-alert>
                @endif
            @endforeach

            @if ($errors->any())
                <x-adminlte-alert theme="danger" title="Error">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </x-adminlte-alert>
            @endif
        </div>
        <div class="col-md-4">
            <x-adminlte-card title="Crear Ficha Tecnica de Escaner" theme="primary" icon="fas fa-desktop">
                <form action="{{ route('technicalSheet.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="features[]" :value="newFeaturesStr">
                    <input type="hidden" name="type" value="scanner">

                    <x-adminlte-select name="brand_id" label="Marca">
                        @foreach ($brands as $brand)
                            <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                                {{ $brand->name }}</option>
                        @endforeach
                    </x-adminlte-select>


                    <x-adminlte-input name="model" label="Modelo" placeholder="Ingrese el modelo"
                        value="{{ old('model') }}" />
                    <x-adminlte-input name="serial_number" label="Numero de serie" placeholder="Ingrese el numero de serie"
                        value="{{ old('serial_number') }}" />

                    <x-adminlte-input name="code" label="Sticker" placeholder="Ingrese el codigo del sticker"
                        value="{{ old('code') }}" />

                    <x-adminlte-input name="mac" label="Direccion MAC" placeholder="Ingrese la direccion MAC"
                        value="{{ old('mac') }}" />

                    <x-adminlte-button type="submit" label="Guardar" theme="primary" icon="fas fa-save" />
                </form>
            </x-adminlte-card>
        </div>

        <div class="col-md-4">
            <div class="row">
                <div class="col-md-12">
                    <x-adminlte-card title="Caracteristicas del Equipo" theme="secondary" icon="fas fa-cogs">
                        <form @submit.prevent="addFeature">
                            @csrf
                            <input type="hidden" name="type" value="pc">

                            <x-adminlte-select x-on:change="setAnwsers" name="feature_id" label="Caracteristicas">
                                @foreach ($features as $feature)
                                    <option value="{{ $feature->id }}">{{ $feature->name }}</option>
                                @endforeach
                            </x-adminlte-select>

                            <div x-show="answers.length > 0">
                                <x-adminlte-select name="feature_answers" id="feature_answers"
                                    label="Respuestas de la Caracteristica">
                                    <template x-for="(answer, index) in answers" :key="index">
                                        <option x-text="answer"></option>
                                    </template>
                                </x-adminlte-select>
                            </div>

                            <div x-show="answers.length == 0">
                                <x-adminlte-input name="feature_value" label="Valor de la Caracteristica"
                                    placeholder="Ingrese el valor de la caracteristica" />
                            </div>
                            <x-adminlte-button type="submit" label="Agregar Caracteristicas" theme="success"
                                icon="fas fa-plus" />
                    </x-adminlte-card>
                </div>
                <div x-show="newFeatures.length > 0" class="col-md-12">
                    <x-adminlte-card title="Caracteristicas Agregadas" theme="info" icon="fas fa-list">
                        <x-adminlte-datatable id="featureTable" :heads="['Caracteristica', 'Valor', 'Acciones']" :config="[
                            'searching' => false,
                            'paging' => false,
                            'info' => false,
                        ]">
                            <template x-for="feature in newFeatures" :key="feature.feature_id">
                                <tr>
                                    <td x-text="fetures.find(f => f.id == feature.feature_id).name"></td>
                                    <td x-text="feature.value"></td>
                                    <td>
                                        <x-adminlte-button class="btn-xs" theme="danger" icon="fas fa-trash"
                                            @click="removeFeature(feature.feature_id)" />
                                    </td>
                                </tr>
                            </template>
                        </x-adminlte-datatable>
                    </x-adminlte-card>
                </div>

            </div>

        </div>
    </div>


@endsection

@section('css')
    {{-- Sweetalert --}}
    <link rel="stylesheet" href="{{ asset('vendor/sweetalert2/sweetalert2.css') }}">
@endsection


@section('js')
    {{-- Sweetalert --}}
    <script src="{{ asset('vendor/sweetalert2/sweetalert2.js') }}"></script>
    {{-- Alpine --}}
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
        const alert2 = (title, text, icon) => {
            Swal.fire({
                title: title,
                text: text,
                icon: icon,
                confirmButtonText: 'Aceptar'
            });
        };

        function data() {
            const newFeatures = JSON.parse(@json(old('features') ?? '[]'));
            return {
                fetures: @json($features),
                answers: [],
                newFeaturesStr: JSON.stringify(newFeatures),
                newFeatures,
                setAnwsers() {
                    const featureId = document.querySelector('select[name="feature_id"]').value;
                    const feature = this.fetures.find(f => f.id == featureId);
                    if (feature) {
                        this.answers = feature.answers.map(answer => answer.value);
                    } else {
                        this.answers = [];
                    }

                },
                removeFeature(featureId) {
                    this.newFeatures = this.newFeatures.filter(f => f.feature_id !== featureId);
                    this.newFeaturesJson = JSON.stringify(this.newFeatures);
                },
                addFeature(e) {
                    e.preventDefault();
                    const featureId = document.querySelector('select[name="feature_id"]').value;
                    const featureValue = document.querySelector('input[name="feature_value"]').value;

                    const feature = {
                        feature_id: featureId,
                        value: featureValue
                    };

                    if (!feature.feature_id) {
                        alert2('Error', 'La caracteristica es obligatoria.', 'error');
                        return;
                    }

                    if (!feature.value) {
                        alert2('Error', 'El valor de la caracteristica es obligatorio.', 'error');
                        return;
                    }

                    if (this.newFeatures.some(f => f.feature_id === feature.feature_id)) {
                        alert2('Error', 'La caracteristica ya ha sido agregada.', 'error');
                        return;
                    } else {
                        this.newFeatures.push(feature);
                        document.querySelector('input[name="feature_value"]').value = '';
                    }
                    this.newFeaturesStr = JSON.stringify(this.newFeatures);
                },
            }
        }
    </script>

@endsection
