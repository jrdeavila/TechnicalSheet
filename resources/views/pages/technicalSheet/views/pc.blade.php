@props(['technicalSheet' => null])

@extends('layouts.app')

@section('title', 'Ficha Tecnica')

@section('header')

@stop

@section('content')

    <div x-data="data()" x-init="listen()">
        <div class="row justify-content-center mt-4">
            <div class="col-md-8">
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

            <div class="col-md-8">
                <x-tab title="Informacion de la computadora" theme="light">
                    <x-slot name="items">
                        <li class="nav-item">
                            <a class="nav-link active" id="info-tab" data-toggle="pill" href="#info" aria-controls="info"
                                aria-selected="true">
                                <span class="fas fa-info-circle"></span>
                                <span>Detalles del equipo</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" id="user-tab" data-toggle="pill" href="#user" aria-controls="user"
                                aria-selected="false">
                                <span class="fas fa-user"></span>
                                <span>Responsable y ubicacion</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" id="peripherals-tab" data-toggle="pill" href="#peripherals"
                                aria-controls="peripherals" aria-selected="false">
                                <span class="fas fa-laptop"></span>
                                <span>Perifericos</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" id="features-tab" data-toggle="pill" href="#features"
                                aria-controls="features" aria-selected="false">
                                <span class="fas fa-laptop"></span>
                                <span>Caracteristicas</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" id="resume-tab" data-toggle="pill" href="#resume" aria-controls="resume"
                                aria-selected="false">
                                <span class="fas fa-laptop"></span>
                                <span>Resumen</span>
                            </a>
                        </li>


                    </x-slot>

                    <x-slot name="contents">

                        <div class="tab-pane fade show active" id="info" role="tabpanel" aria-labelledby="info-tab">

                            <x-adminlte-select x-model="brandId" name="brand_id" label="Marca">
                                <template x-for="brand in brands" :key="brand.id">
                                    <option x-bind:value="brand.id"
                                        x-bind:selected="brand.id ==
                                            {{ old('brand_id', $technicalSheet?->technicalSheetable->brand_id) }}"
                                        x-text="brand.name">
                                    </option>
                                </template>
                            </x-adminlte-select>

                            <x-adminlte-input x-model="model" name="model" label="Modelo"
                                placeholder="Ingrese el modelo" />
                            <x-adminlte-input x-model="serialNumber" name="serial_number" label="Numero de serie"
                                placeholder="Ingrese el numero de serie" />
                            <x-adminlte-input x-model="mac" name="mac" label="Direccion MAC"
                                placeholder="Ingrese la direccion MAC" />
                            <x-adminlte-input x-model="code" name="code" label="Sticker"
                                placeholder="Ingrese el codigo de la sticker" />
                            <x-adminlte-select x-model="operation_system_id" name="operation_system_id"
                                label="Sistema Operativo">
                                <template x-for="operatingSystem in operationSystems" :key="operatingSystem.id">
                                    <option x-bind:value="operatingSystem.id"
                                        x-bind:selected="operatingSystem.id ==
                                            {{ old('operation_system_id', $technicalSheet?->technicalSheetable->operation_system_id) }}"
                                        x-text="operatingSystem.name">
                                    </option>
                                </template>
                            </x-adminlte-select>
                            <div class="row justify-content-between">
                                <x-adminlte-button label="Regresar" theme="primary" icon="fas fa-arrow-left" />
                                <x-adminlte-button label="Siguiente" theme="primary" icon="fas fa-arrow-right"
                                    x-on:click="nextTab('user-tab')" />

                            </div>
                        </div>
                        <div class="tab-pane fade" id="user" role="tabpanel" aria-labelledby="user-tab">
                            <form action="{{ route('technicalSheet.createDevice', 'pc') }}" method="GET">
                                <x-adminlte-input name="search" label="Buscar por nombre o cedula"
                                    placeholder="Ingrese el nombre o cedula" />
                                <x-adminlte-button type="submit" label="Buscar" theme="primary" icon="fas fa-search" />
                                @if (isset($users))
                                    <x-adminlte-button
                                        onclick="window.location = '{{ route('technicalSheet.createDevice', 'pc') }}';"
                                        label="Limpiar" theme="warning" icon="fas fa-eraser" />
                                @endif
                            </form>
                            <br>
                            @if (isset($users))
                                <form action="{{ route('technicalSheet.createDevice', 'pc') }}" method="GET">
                                    <x-adminlte-select name="user_id" :label="'Resultados de la busqueda (' . $users->count() . ')'">
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}"
                                                {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                                {{ $user->employee->full_name }}</option>
                                        @endforeach
                                    </x-adminlte-select>
                                </form>
                                <x-adminlte-select name="location_id" label="Ubicacion">
                                    <option value="">Seleccione una ubicacion</option>
                                    <option value="1">Manaure</option>
                                    <option value="2">La paz</option>
                                    <option value="3">Becerril</option>
                                    <option value="4">La loma</option>
                                    <option value="5">Codazzi</option>
                                    <option value="6">El copey</option>
                                    <option value="7">Chimichagua</option>
                                    <option value="8">Astrea</option>
                                    <option value="9">Chiriguana</option>
                                    <option value="10">La jagua</option>
                                    <option value="11">Pueblo bello</option>
                                    <option value="12">Bosconia</option>
                                </x-adminlte-select>
                            @endif
                        </div>
                        <div class="tab-pane fade" id="peripherals" role="tabpanel" aria-labelledby="peripherals-tab">
                            <div class="col-md-12">
                                <form @submit.prevent="addperipheral">
                                    <x-adminlte-select name="peripheral_type_id" label="Tipo de Periferico">
                                        @foreach ($peripheralTypes as $peripheralType)
                                            <option value="{{ $peripheralType->id }}">{{ $peripheralType->name }}
                                            </option>
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
                            </div>

                            <hr>
                            <div x-show="peripherals.length > 0" class="col-md-12">
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
                            </div>
                        </div>
                        <div class="tab-pane fade" id="features" role="tabpanel" aria-labelledby="features-tab">
                            <div class="row">
                                <div class="col-md-12">
                                    <form @submit.prevent="addFeature">
                                        @csrf
                                        <input type="hidden" name="type" value="pc">

                                        <x-adminlte-select x-on:change="setAnswers" name="feature_id"
                                            label="Caracteristicas">
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
                                    </form>
                                </div>

                                <hr>
                                <div x-show="newFeatures.length > 0" class="col-md-12">
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
                                </div>


                            </div>


                        </div>

                        <div class="tab-pane fade" id="resume" role="tabpanel" aria-labelledby="resume-tab">
                            <div class="row">

                            </div>
                        </div>


                    </x-slot>

                </x-tab>
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
        $model = old('model', $technicalSheet?->technicalSheetable?->model ?? '');
        $serialNumber = old('serial_number', $technicalSheet?->technicalSheetable?->serial_number ?? '');
        $mac = old('mac', $technicalSheet?->technicalSheetable?->mac ?? '');
        $operationSystemId = old(
            'operation_system_id',
            $technicalSheet?->technicalSheetable?->operation_system_id ?? '',
        );
        $brandId = old('brand_id', $technicalSheet?->technicalSheetable?->brand_id ?? '');
        $code = old('code', $technicalSheet?->technicalSheetable?->code ?? '');
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

        function listen() {
            $watch('peripherals', (peripherals) => {
                localStorage.setItem('peripherals', JSON.stringify(peripherals));
            });
            $watch('newFeatures', (newFeatures) => {
                localStorage.setItem('newFeatures', JSON.stringify(newFeatures));
            });
            $watch('model', (model) => {
                localStorage.setItem('model', model);
            });
            $watch('serialNumber', (serialNumber) => {
                localStorage.setItem('serialNumber', serialNumber);
            });
            $watch('mac', (mac) => {
                localStorage.setItem('mac', mac);
            });
            $watch('operationSystemId', (operationSystemId) => {
                localStorage.setItem('operationSystemId', operationSystemId);
            });
            $watch('brandId', (brandId) => {
                localStorage.setItem('brandId', brandId);
            });
            $watch('code', (code) => {
                localStorage.setItem('code', code);
            });

        }

        function data() {
            let peripherals = @json($oldPeripherals);
            peripherals = peripherals.toString();
            peripherals = peripherals ? JSON.parse(peripherals) : [];
            let newFeatures = @json($oldFeatures);
            newFeatures = newFeatures.toString();
            newFeatures = newFeatures ? JSON.parse(newFeatures) : [];

            return {
                model: '{{ $model }}',
                serialNumber: '{{ $serialNumber }}',
                mac: '{{ $mac }}',
                operationSystemId: '{{ $operationSystemId }}',
                brandId: '{{ $brandId }}',
                code: '{{ $code }}',

                brands: @json($brands),
                answers: [],
                peripheralTypes: @json($peripheralTypes),
                peripherals,
                peripheralsStr: JSON.stringify(peripherals),
                operationSystems: @json($operatingSystems),
                fetures: @json($features),
                newFeaturesStr: JSON.stringify(newFeatures),
                newFeatures,



                nextTab(tab) {
                    document.getElementById(tab).click();
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
