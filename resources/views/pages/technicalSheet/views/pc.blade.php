@props(['technicalSheet' => null])

@extends('layouts.app')

@section('title', 'Ficha Tecnica')

@section('header')

@stop

@section('content')

    <div x-data="data()">
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
                            <a class="nav-link active disabled" id="info-tab" data-toggle="pill" href="#info"
                                aria-controls="info" aria-selected="true">
                                <span class="fas fa-info-circle"></span>
                                <span>Detalles del equipo</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link disabled" id="user-tab" data-toggle="pill" href="#user"
                                aria-controls="user" aria-selected="false">
                                <span class="fas fa-user"></span>
                                <span>Responsable y ubicacion</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link disabled" id="peripherals-tab" data-toggle="pill" href="#peripherals"
                                aria-controls="peripherals" aria-selected="false">
                                <span class="fas fa-laptop"></span>
                                <span>Perifericos</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link disabled" id="features-tab" data-toggle="pill" href="#features"
                                aria-controls="features" aria-selected="false">
                                <span class="fas fa-laptop"></span>
                                <span>Caracteristicas</span>
                            </a>
                        </li>

                        <li x-show="brandId || model || serialNumber || mac ||code || peripherals.length > 0 || newFeatures.length > 0 || operationSystemId"
                            class="nav-item">
                            <a class="nav-link disabled" id="resume-tab" data-toggle="pill" href="#resume"
                                aria-controls="resume" aria-selected="false">
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
                                            '{{ old('brand_id', $technicalSheet?->technicalSheetable->brand_id) }}'"
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
                                            '{{ old('operation_system_id', $technicalSheet?->technicalSheetable->operation_system_id) }}'"
                                        x-text="operatingSystem.name">
                                    </option>
                                </template>
                            </x-adminlte-select>
                            <div class="row justify-content-between">
                                <x-adminlte-button label="Regresar" theme="primary" icon="fas fa-arrow-left"
                                    x-on:click="nextTab('info-tab')" />
                                <x-adminlte-button label="Siguiente" theme="primary" icon="fas fa-arrow-right"
                                    x-on:click="nextTab('user-tab')" />
                            </div>
                        </div>
                        <div class="tab-pane fade" id="user" role="tabpanel" aria-labelledby="user-tab">
                            <div class="row">
                                <div class="col-md-6">
                                    <x-adminlte-select x-on:change="(e) => console.log(e.target.value)" x-model="userId"
                                        id="user_id" name="user_id" label="Responsable" style="width: 100%"
                                        class="select2">
                                        <template x-for="user in users" :key="user.id">
                                            <option x-bind:value="user.id"
                                                x-bind:selected="user.id ==
                                                    '{{ old('user_id', $technicalSheet?->technicalSheetable->user_id) }}'"
                                                x-text="user.employee.full_name">
                                            </option>
                                        </template>
                                    </x-adminlte-select>
                                </div>
                                <div class="col-md-6">
                                    <x-adminlte-select x-model="selectedLocation" name="location" label="Ubicacion"
                                        style="width: 100%;" class="select2">
                                        <option value="">Seleccione una ubicacion</option>
                                        <template x-for="location in locations" :key="location">
                                            <option x-bind:value="location"
                                                x-bind:selected="location ==
                                                    '{{ old('place', $technicalSheet?->place) }}'"
                                                x-text="location">
                                            </option>
                                        </template>
                                    </x-adminlte-select>
                                </div>
                            </div>
                            <div class="row justify-content-between">
                                <x-adminlte-button label="Regresar" theme="primary" icon="fas fa-arrow-left"
                                    x-on:click="nextTab('info-tab')" />
                                <x-adminlte-button label="Siguiente" theme="primary" icon="fas fa-arrow-right"
                                    x-on:click="nextTab('peripherals-tab')" />
                            </div>
                        </div>
                        <div class="tab-pane fade" id="peripherals" role="tabpanel" aria-labelledby="peripherals-tab">
                            <div class="col-md-12">
                                <form @submit.prevent="addperipheral">
                                    <x-adminlte-select name="peripheral_type_id" label="Tipo de Periferico"
                                        style="width: 100%">
                                        @foreach ($peripheralTypes as $peripheralType)
                                            <option value="{{ $peripheralType->id }}">
                                                {{ $peripheralType->name }}
                                            </option>
                                        @endforeach
                                    </x-adminlte-select>

                                    <x-adminlte-select name="peripheral_brand_id" label="Marca" style="width: 100%">
                                        @foreach ($brands as $brand)
                                            <option value="{{ $brand->id }}">{{ $brand->name }}
                                            </option>
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
                                            <td x-text="brands.find(b => b.id == peripheral.brand_id).name">
                                            </td>
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
                            <div class="row justify-content-between">
                                <x-adminlte-button label="Regresar" theme="primary" icon="fas fa-arrow-left"
                                    x-on:click="nextTab('user-tab')" />
                                <x-adminlte-button label="Siguiente" theme="primary" icon="fas fa-arrow-right"
                                    x-on:click="nextTab('features-tab')" />
                            </div>
                        </div>
                        <div class="tab-pane fade" id="features" role="tabpanel" aria-labelledby="features-tab">
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <form @submit.prevent="addFeature">
                                        @csrf
                                        <input type="hidden" name="type" value="pc">

                                        <x-adminlte-select x-on:change="setAnswers" name="feature_id"
                                            label="Caracteristicas" style="width: 100%">
                                            @foreach ($features as $feature)
                                                <option value="{{ $feature->id }}">
                                                    {{ $feature->name }}</option>
                                            @endforeach
                                        </x-adminlte-select>

                                        <div x-show="answers.length > 0">
                                            <x-adminlte-select name="feature_value" id="feature_value"
                                                label="Respuestas de la Caracteristica" style="width: 100%">
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
                                                <td x-text="fetures.find(f => f.id == feature.feature_id).name">
                                                </td>
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
                            <div class="row justify-content-between">
                                <x-adminlte-button label="Regresar" theme="primary" icon="fas fa-arrow-left"
                                    x-on:click="nextTab('peripherals-tab')" />
                                <x-adminlte-button label="Siguiente" theme="primary" icon="fas fa-arrow-right"
                                    x-on:click="nextTab('resume-tab')" />
                            </div>

                        </div>

                        <div class="tab-pane fade" id="resume" role="tabpanel" aria-labelledby="resume-tab">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div x-show="brandId != null" class="col-md-6">
                                            <span class="text-bold">Marca:</span>
                                            <span x-text="brands.find(b => b.id == brandId)?.name"></span>
                                        </div>
                                        <div x-show="model != null" class="col-md-6">
                                            <span class="text-bold">Modelo:</span>
                                            <span x-text="model"></span>
                                        </div>
                                        <div x-show="serialNumber != null" class="col-md-6">
                                            <span class="text-bold">Numero de serie:</span>
                                            <span x-text="serialNumber"></span>
                                        </div>
                                        <div x-show="mac != null" class="col-md-6">
                                            <span class="text-bold">Direccion MAC:</span>
                                            <span x-text="mac"></span>
                                        </div>
                                        <div x-show="code != null" class="col-md-6">
                                            <span class="text-bold">Sticker:</span>
                                            <span x-text="code"></span>
                                        </div>
                                        <div x-show="operationSystemId != null" class="col-md-6">
                                            <span class="text-bold">Sistema Operativo:</span>
                                            <span
                                                x-text="operationSystems.find(o => o.id == operationSystemId)?.name"></span>
                                        </div>
                                        <div x-show="selectedLocation != null" class="col-md-6">
                                            <span class="text-bold">Ubicacion:</span>
                                            <span x-text="selectedLocation"></span>
                                        </div>
                                        <div x-show="userId != null" class="col-md-6">
                                            <span class="text-bold">Responsable:</span>
                                            <span x-text="users.find(u => u.id == userId)?.employee.full_name"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div x-show="peripherals.length > 0" class="col-md-12">
                                            <x-adminlte-datatable id="peripheralsTable" :heads="['Periferico']"
                                                :config="[
                                                    'searching' => false,
                                                    'paging' => false,
                                                    'info' => false,
                                                ]">
                                                <template x-for="peripheral in peripherals" :key="peripheral.id">
                                                    <tr>
                                                        <td>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <span class="text-bold">Modelo:</span>
                                                                    <span x-text="peripheral.model"></span>
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <span class="text-bold">Serial:</span>
                                                                    <span x-text="peripheral.serial_number"></span>
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <span class="text-bold">Marca:</span>
                                                                    <span
                                                                        x-text="brands.find(b => b.id == peripheral.brand_id)?.name"></span>
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <span class="text-bold">Tipo:</span>
                                                                    <span
                                                                        x-text="peripheralTypes.find(pt => pt.id == peripheral.type_id)?.name"></span>
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <span class="text-bold">Sistema Operativo:</span>
                                                                    <span
                                                                        x-text="operationSystems.find(os => os.id == peripheral.operation_system_id)?.name"></span>
                                                                </div>

                                                            </div>
                                                        </td>

                                                    </tr>
                                                </template>
                                            </x-adminlte-datatable>
                                        </div>
                                        <div x-show="newFeatures.length > 0" class="col-md-12">
                                            <x-adminlte-datatable id="featuresTable" :heads="['Caracteristica', 'Valor']" :config="[
                                                'searching' => false,
                                                'paging' => false,
                                                'info' => false,
                                            ]">
                                                <template x-for="feature in newFeatures" :key="feature.feature_id">
                                                    <tr>
                                                        <td x-text="fetures.find(f => f.id == feature.feature_id).name">
                                                        </td>
                                                        <td x-text="feature.value"></td>
                                                    </tr>
                                                </template>
                                            </x-adminlte-datatable>
                                        </div>
                                    </div>
                                </div>


                            </div>
                            <div class="row justify-content-between">
                                <x-adminlte-button label="Regresar" theme="primary" icon="fas fa-arrow-left"
                                    x-on:click="nextTab('features-tab')" />
                                <form
                                    action="{{ $technicalSheet ? route('technicalSheet.update', $technicalSheet) : route('technicalSheet.store') }}"
                                    method="POST">
                                    @csrf
                                    @if ($technicalSheet)
                                        @method('PUT')
                                        <input type="hidden" name="id" value="{{ $technicalSheet->id }}">
                                    @endif
                                    <input type="hidden" name="type" value="pc" />
                                    <input type="hidden" name="peripherals[]" x-bind:value="peripheralsStr" />
                                    <input type="hidden" name="features[]" x-bind:value="newFeaturesStr" />
                                    <input type="hidden" name="assigned_to" x-bind:value="userId">
                                    <input type="hidden" name="place" x-bind:value="selectedLocation">
                                    <input type="hidden" name="model" x-bind:value="model">
                                    <input type="hidden" name="serial_number" x-bind:value="serialNumber">
                                    <input type="hidden" name="brand_id" x-bind:value="brandId">
                                    <input type="hidden" name="operation_system_id" x-bind:value="operationSystemId">
                                    <input type="hidden" name="mac" x-bind:value="mac">
                                    <input type="hidden" name="code" x-bind:value="code">

                                    <x-adminlte-button label="Guardar" theme="success" icon="fas fa-save"
                                        type="submit" />
                                </form>
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
    {{-- Datatable --}}
    {{-- <script src="{{ asset('vendor/datatables/js/jquery.dataTables.min.js') }}"></script> --}}
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
            $technicalSheet?->technicalSheetable?->operation_system_id ?? 1,
        );
        $brandId = old('brand_id', $technicalSheet?->technicalSheetable?->brand_id ?? 1);
        $code = old('code', $technicalSheet?->technicalSheetable?->code);
        $userId = old('user_id', $technicalSheet?->assigned_to ?? 1);
        $location = old('place', $technicalSheet?->place ?? config('locations')[0]);

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


            return {
                model: "{{ $model }}",
                serialNumber: "{{ $serialNumber }}",
                mac: "{{ $mac }}",
                operationSystemId: "{{ $operationSystemId }}",
                brandId: "{{ $brandId }}",
                code: "{{ $code }}",
                userId: "{{ $userId }}",

                users: @json($users),
                locations: @json($locations),
                selectedLocation: "{{ $location }}",
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
                    $(`#${tab}`).removeClass('disabled');
                    $(`#${tab}`).click();
                    $(`#${tab}`).addClass('disabled');
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
