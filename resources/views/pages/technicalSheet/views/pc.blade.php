@extends('layouts.app')

@section('title', 'Ficha Tecnica')

@section('header')

@stop

@section('content')
    <div x-data="data()">

        <form action="{{ route('technicalSheet.store') }}">
            <div class="row justify-content-center mt-4">
                <div class="col-md-4">
                    <x-adminlte-card title="Crear Ficha Tecnica de Computadora" theme="primary" icon="fas fa-desktop">
                        <form action="{{ route('technicalSheet.store') }}" method="POST">
                            @csrf

                            <input type="hidden" name="type" value="pc">
                            <x-adminlte-select name="brand_id" label="Marca">
                                @foreach ($brands as $brand)
                                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                @endforeach
                            </x-adminlte-select>

                            <input type="hidden" name="peripherals[]" x-model="pheripherals">

                            <x-adminlte-input name="name" label="Nombre del Equipo"
                                placeholder="Ingrese el nombre del equipo" />
                            <x-adminlte-input name="model" label="Modelo" placeholder="Ingrese el modelo" />
                            <x-adminlte-input name="serial_number" label="Numero de serie"
                                placeholder="Ingrese el numero de serie" />
                            <x-adminlte-input name="state" label="Estado" placeholder="Ingrese el estado" />
                            <x-adminlte-input name="operating_system" label="Sistema Operativo"
                                placeholder="Ingrese el sistema operativo" />
                            <div class="row justify-content-center">
                                <x-adminlte-button type="submit" label="Guardar" theme="primary" icon="fas fa-save" />
                            </div>

                        </form>
                    </x-adminlte-card>
                </div>
                <div class="col-md-4">
                    <div class="row">
                        <div x-show="pheripherals.length > 0" class="col-md-12">
                            <x-adminlte-card title="Perifericos Agregados" theme="info" icon="fas fa-list">
                                <x-adminlte-datatable id="pheripheralTable" :heads="['Tipo', 'Marca', 'Modelo', 'Numero de Serie', 'Acciones']" :config="[
                                    'searching' => false,
                                    'paging' => false,
                                    'info' => false,
                                ]">
                                    <template x-for="pheripheral in pheripherals" :key="pheripheral.serial_number">
                                        <tr>
                                            <td x-text="peripheralTypes.find(pt => pt.id == pheripheral.type_id).name">
                                            </td>
                                            <td x-text="brands.find(b => b.id == pheripheral.brand_id).name"></td>
                                            <td x-text="pheripheral.model"></td>
                                            <td x-text="pheripheral.serial_number"></td>
                                            <td>
                                                <x-adminlte-button class="btn-xs" theme="danger" icon="fas fa-trash"
                                                    @click="removePheripheral(pheripheral.serial_number)" />
                                            </td>
                                        </tr>
                                    </template>
                                </x-adminlte-datatable>
                            </x-adminlte-card>
                        </div>  

                        <div class="col-md-12">
                            <x-adminlte-card title="Perifericos" theme="primary" icon="fas fa-mouse">
                                <form @submit.prevent="addPheripheral">
                                    <x-adminlte-select name="pheripheral_type_id" label="Tipo de Periferico">
                                        @foreach ($peripheralTypes as $peripheralType)
                                            <option value="{{ $peripheralType->id }}">{{ $peripheralType->name }}</option>
                                        @endforeach
                                    </x-adminlte-select>

                                    <x-adminlte-select name="pheripheral_brand_id" label="Marca">
                                        @foreach ($brands as $brand)
                                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                        @endforeach
                                    </x-adminlte-select>

                                    <x-adminlte-input name="pheripheral_model" label="Modelo"
                                        placeholder="Ingrese el modelo del periferico" />
                                    <x-adminlte-input name="pheripheral_serial_number" label="Numero de serie"
                                        placeholder="Ingrese el numero de serie del periferico" />

                                    <x-adminlte-button type="submit" label="Agregar Periferico" theme="success"
                                        icon="fas fa-plus" />
                                </form>
                            </x-adminlte-card>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <x-adminlte-card title="Caracteristicas del Equipo" theme="secondary" icon="fas fa-cogs">
                        <form @submit.prevent="addFeature">
                            @csrf
                            <input type="hidden" name="type" value="pc">

                            <x-adminlte-select name="feature_id" label="Caracteristicas" x-model="selectFeature">
                                @foreach ($features as $feature)
                                    <option value="{{ $feature->id }}">{{ $feature->name }}</option>
                                @endforeach
                            </x-adminlte-select>

                            <x-adminlte-input name="feature_value" label="Valor de la Caracteristica"
                                placeholder="Ingrese el valor de la caracteristica" />


                            <div class="row justify-content-center">
                                <x-adminlte-button type="submit" label="Agregar Caracteristicas" theme="success"
                                    icon="fas fa-plus" />
                            </div>
                    </x-adminlte-card>
                </div>

            </div>
        </form>

    </div>

@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
        function data() {
            return {
                brands: @json($brands),
                peripheralTypes: @json($peripheralTypes),
                pheripherals: [],
                removePheripheral(serialNumber) {
                    this.pheripherals = this.pheripherals.filter(p => p.serial_number !== serialNumber);
                },
                addPheripheral(e) {
                    e.preventDefault();
                    const pheripheralTypeId = document.querySelector('select[name="pheripheral_type_id"]').value;
                    const pheripheralBrandId = document.querySelector('select[name="pheripheral_brand_id"]').value;
                    const pheripheralModel = document.querySelector('input[name="pheripheral_model"]').value;
                    const pheripheralSerialNumber = document.querySelector('input[name="pheripheral_serial_number"]')
                        .value;

                    const pheripheral = {
                        type_id: pheripheralTypeId,
                        brand_id: pheripheralBrandId,
                        model: pheripheralModel,
                        serial_number: pheripheralSerialNumber
                    };

                    if (this.pheripherals.some(p => p.serial_number === pheripheral.serial_number)) {
                        alert('El periferico con este numero de serie ya ha sido agregado.');
                        return;
                    } else {
                        this.pheripherals.push(pheripheral);
                        document.querySelector('input[name="pheripheral_model"]').value = '';
                        document.querySelector('input[name="pheripheral_serial_number"]').value = '';
                    }

                }
            }
        }



    </script>

@endsection
