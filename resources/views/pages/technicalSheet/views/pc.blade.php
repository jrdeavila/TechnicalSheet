@props(['technicalSheet' => null])

@extends('layouts.app')

@section('title', 'Ficha Tecnica')

@section('header')

@stop

@section('content')
    <div x-data="data()">
        <div class="row justify-content-center mt-4">
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
                @php
                    $route = $technicalSheet
                        ? route('technicalSheet.update', $technicalSheet->id)
                        : route('technicalSheet.store');
                @endphp
                <x-adminlte-card title="Crear Ficha Tecnica de Computadora" theme="primary" icon="fas fa-desktop">
                    <form action="{{ $route }}" method="POST">
                        @csrf
                        @if ($technicalSheet)
                            @method('PUT')
                        @endif
                        <input type="hidden" name="peripherals[]" :value="peripheralsStr">
                        <input type="hidden" name="features[]" :value="newFeaturesStr">
                        <input type="hidden" name="type" value="pc">

                        <x-adminlte-select name="brand_id" label="Marca">
                            @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}"
                                    {{ old('brand_id', $technicalSheet?->technicalSheetable->brand_id) == $brand->id ? 'selected' : '' }}>
                                    {{ $brand->name }}</option>
                            @endforeach
                        </x-adminlte-select>


                        <x-adminlte-input name="model" label="Modelo" placeholder="Ingrese el modelo"
                            value="{{ old('model', $technicalSheet?->technicalSheetable->model) }}" />
                        <x-adminlte-input name="serial_number" label="Numero de serie"
                            placeholder="Ingrese el numero de serie"
                            value="{{ old('serial_number', $technicalSheet?->technicalSheetable->serial_number) }}" />

                        <x-adminlte-input name="mac" label="Direccion MAC" placeholder="Ingrese la direccion MAC"
                            value="{{ old('mac', $technicalSheet?->technicalSheetable->mac) }}" />

                        <x-adminlte-input name="code" label="Sticker" placeholder="Ingrese el codigo de la sticker"
                            value="{{ old('code', $technicalSheet?->technicalSheetable->code) }}" />


                        <x-adminlte-select name="operation_system_id" label="Sistema Operativo">
                            @foreach ($operatingSystems as $operatingSystem)
                                <option value="{{ $operatingSystem->id }}"
                                    {{ old('operation_system_id', $technicalSheet?->technicalSheetable->operation_system_id) == $operatingSystem->id ? 'selected' : '' }}>
                                    {{ $operatingSystem->name }}</option>
                            @endforeach
                        </x-adminlte-select>
                        <x-adminlte-button type="submit" label="Guardar" theme="primary" icon="fas fa-save" />
                    </form>
                </x-adminlte-card>
            </div>
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-12">
                        <x-adminlte-card title="Perifericos" theme="secondary" icon="fas fa-mouse">
                            <form @submit.prevent="addperipheral">
                                <x-adminlte-select name="peripheral_type_id" label="Tipo de Periferico">
                                    @foreach ($peripheralTypes as $peripheralType)
                                        <option value="{{ $peripheralType->id }}">{{ $peripheralType->name }}</option>
                                    @endforeach
                                </x-adminlte-select>

                                <x-adminlte-select name="peripheral_brand_id" label="Marca">
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                    @endforeach
                                </x-adminlte-select>

                                <x-adminlte-input name="peripheral_model" label="Modelo"
                                    placeholder="Ingrese el modelo del periferico" />
                                <x-adminlte-input name="peripheral_serial_number" label="Numero de serie"
                                    placeholder="Ingrese el numero de serie del periferico" />

                                <x-adminlte-button type="submit" label="Agregar Periferico" theme="success"
                                    icon="fas fa-plus" />
                            </form>
                        </x-adminlte-card>
                    </div>
                    <div x-show="peripherals.length > 0" class="col-md-12">
                        <x-adminlte-card title="Perifericos Agregados" theme="info" icon="fas fa-list">
                            <x-adminlte-datatable id="peripheralTable" :heads="['Tipo', 'Marca', 'Modelo', 'Numero de Serie', 'Acciones']" :config="[
                                'searching' => false,
                                'paging' => false,
                                'info' => false,
                            ]">
                                <template x-for="peripheral in peripherals" :key="peripheral.serial_number">
                                    <tr>
                                        <td x-text="peripheralTypes.find(pt => pt.id == peripheral.type_id).name">
                                        </td>
                                        <td x-text="brands.find(b => b.id == peripheral.brand_id).name"></td>
                                        <td x-text="peripheral.model"></td>
                                        <td x-text="peripheral.serial_number"></td>
                                        <td>
                                            <x-adminlte-button class="btn-xs" theme="danger" icon="fas fa-trash"
                                                @click="removeperipheral(peripheral.serial_number)" />
                                        </td>
                                    </tr>
                                </template>
                            </x-adminlte-datatable>
                        </x-adminlte-card>
                    </div>


                </div>
            </div>
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-12">
                        <x-adminlte-card title="Caracteristicas del Equipo" theme="secondary" icon="fas fa-cogs">
                            <form @submit.prevent="addFeature">
                                @csrf
                                <input type="hidden" name="type" value="pc">

                                <x-adminlte-select x-on:change="setAnswers" name="feature_id" label="Caracteristicas">
                                    @foreach ($features as $feature)
                                        <option value="{{ $feature->id }}">{{ $feature->name }}</option>
                                    @endforeach
                                </x-adminlte-select>

                                <div x-show="answers.length > 0">
                                    <x-adminlte-select name="feature_value" id="feature_value"
                                        label="Respuestas de la Caracteristica">
                                        <template x-for="(answer, index) in answers" :key="index">
                                            <option x-text="answer"></option>
                                        </template>
                                    </x-adminlte-select>
                                </div>

                                <div x-show="answers.length == 0">
                                    <x-adminlte-input name="feature_value" id="feature_value"
                                        label="Valor de la Caracteristica"
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


    @php
        $oldPeripherals = old(
            'peripherals',
            json_encode($technicalSheet?->technicalSheetable?->deviceable?->peripherals?->toArray() ?? []),
        );
        $oldFeatures = old(
            'features',
            json_encode($technicalSheet?->technicalSheetable?->featureValues?->toArray() ?? []),
        );
    @endphp


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
            let peripherals = @json($oldPeripherals);
            peripherals = peripherals.toString();
            peripherals = peripherals ? JSON.parse(peripherals) : [];
            let newFeatures = @json($oldFeatures);
            newFeatures = newFeatures.toString();
            newFeatures = newFeatures ? JSON.parse(newFeatures) : [];

            console.log('Peripherals:', peripherals);
            console.log('New Features:', newFeatures);
            return {
                brands: @json($brands),
                answers: [],
                peripheralTypes: @json($peripheralTypes),
                peripherals,
                peripheralsStr: JSON.stringify(peripherals),
                fetures: @json($features),
                newFeaturesStr: JSON.stringify(newFeatures),
                newFeatures,
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

                removeperipheral(serialNumber) {
                    this.peripherals = this.peripherals.filter(p => p.serial_number !== serialNumber);
                },
                addperipheral(e) {
                    e.preventDefault();
                    const peripheralTypeId = document.querySelector('select[name="peripheral_type_id"]').value;
                    const peripheralBrandId = document.querySelector('select[name="peripheral_brand_id"]').value;
                    const peripheralModel = document.querySelector('input[name="peripheral_model"]').value;
                    const peripheralserialNumber = document.querySelector('input[name="peripheral_serial_number"]')
                        .value;

                    const peripheral = {
                        type_id: peripheralTypeId,
                        brand_id: peripheralBrandId,
                        model: peripheralModel,
                        serial_number: peripheralserialNumber
                    };

                    if (!peripheral.type_id) {
                        alert2('Error', 'El tipo de periferico es obligatorio.', 'error');
                        return;
                    }
                    if (!peripheral.brand_id) {
                        alert2('Error', 'La marca del periferico es obligatoria.', 'error');
                        return;
                    }
                    if (!peripheral.model) {
                        alert2('Error', 'El modelo del periferico es obligatorio.', 'error');
                        return;
                    }
                    if (!peripheral.serial_number) {
                        alert2('Error', 'El numero de serie del periferico es obligatorio.', 'error');
                        return;
                    }
                    if (this.peripherals.some(p => p.serial_number === peripheral.serial_number)) {
                        alert2('Error', 'El periferico con este numero de serie ya ha sido agregado.', 'error');
                        return;
                    } else {
                        this.peripherals.push(peripheral);
                        document.querySelector('input[name="peripheral_model"]').value = '';
                        document.querySelector('input[name="peripheral_serial_number"]').value = '';
                    }
                    this.peripheralsStr = JSON.stringify(this.peripherals);
                },
                setAnswers() {
                    const featureId = document.querySelector('select[name="feature_id"]').value;
                    const feature = this.fetures.find(f => f.id == featureId);
                    if (feature) {
                        this.answers = feature.answers.map(answer => answer.value);
                    } else {
                        this.answers = [];
                    }

                }
            }
        }
    </script>

@endsection
