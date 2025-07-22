@extends('layouts.app')

@section('title', 'Tipos de periféricos')


@section('header')
    <div class="d-flex flex-column align-items-start justify-content-center">

        <h1>Tipos de periféricos</h1>
    </div>
@endsection



@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            @foreach (['success', 'error', 'warning'] as $messageType)
                @if (session($messageType))
                    <x-adminlte-alert title="{{ __('messages.' . $messageType) }}" theme="{{ $messageType }}" dismissable>
                        {{ session($messageType) }}
                    </x-adminlte-alert>
                @endif
            @endforeach

            @if ($errors->any())
                <x-adminlte-alert theme="warning" dismissable>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </x-adminlte-alert>
            @endif
        </div>
        <div class="col-md-6">
            <x-adminlte-card title="Listado de tipos de periféricos" theme="light" icon="fas fa-clipboard-list">
                <x-slot name="toolsSlot">
                    <div class="d-flex justify-content-between align-items-center">
                        <form action="{{ route('peripheralType.index') }}" method="GET" class="form-inline">
                            <label for="limit" class="mr-2">Mostrar:</label>
                            <x-adminlte-select name="limit" class="form-control" onchange="this.form.submit()">
                                <option value="10" {{ request('limit') == 10 ? 'selected' : '' }}>10</option>
                                <option value="25" {{ request('limit') == 25 ? 'selected' : '' }}>25</option>
                                <option value="50" {{ request('limit') == 50 ? 'selected' : '' }}>50</option>
                                <option value="100" {{ request('limit') == 100 ? 'selected' : '' }}>100</option>
                            </x-adminlte-select>
                        </form>
                        <x-adminlte-button class="ml-2" data-toggle="modal" data-target="#createPeripheralTypeModal"
                            theme="primary" icon="fas fa-plus" label="Nuevo tipo de periférico" />
                    </div>
                </x-slot>

                <x-adminlte-modal id="createPeripheralTypeModal" title="Agregar Nuevo tipo de periférico" theme="primary"
                    size="lg">
                    <x-slot name="footerSlot">
                        <p class="text-muted">Asegúrate de que el nombre del tipo de periférico sea único.</p>
                    </x-slot>
                    <form action="{{ route('peripheralType.store') }}" method="POST">
                        @csrf
                        <x-adminlte-input name="name" label="Nombre del tipo de periférico"
                            placeholder="Ingrese el nombre del tipo de periférico" required />
                        <div class="modal-footer">
                            <x-adminlte-button type="submit" class="btn btn-primary" label="Agregar Tipo" />
                            <x-adminlte-button data-dismiss="modal" class="btn btn-secondary" label="Cancelar" />
                        </div>

                        <x-slot name="footerSlot">
                            <p class="text-muted">Asegúrate de que el nombre de la marca sea único.</p>
                        </x-slot>
                    </form>
                </x-adminlte-modal>

                <x-adminlte-datatable id="peripheralTypeTable" :heads="['ID', 'Nombre', 'Acciones']" striped hoverable>
                    @foreach ($peripheralTypes as $peripheralType)
                        <tr>
                            <td>{{ $peripheralType->id }}</td>
                            <td>{{ $peripheralType->name }}</td>
                            <td>
                                <x-adminlte-button class="btn btn-sm btn-primary" icon="fas fa-edit" data-toggle="modal"
                                    data-target="#editPeripheralTypeModal{{ $peripheralType->id }}" label="Editar" />
                                <x-adminlte-button class="btn btn-sm btn-danger" icon="fas fa-trash" data-toggle="modal"
                                    data-target="#deletePeripheralTypeModal{{ $peripheralType->id }}" label="Eliminar" />
                            </td>
                        </tr>
                        <x-adminlte-modal id="editPeripheralTypeModal{{ $peripheralType->id }}"
                            title="Editar tipo de periférico" theme="warning" size="lg">
                            <x-slot name="footerSlot">
                                <p class="text-muted">Asegúrate de que el nombre del tipo de periférico sea único.</p>
                            </x-slot>
                            <form action="{{ route('peripheralType.update', $peripheralType->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <x-adminlte-input name="name" label="Nombre del tipo de periférico"
                                    value="{{ $peripheralType->name }}"
                                    placeholder="Ingrese el nombre del tipo de periférico" required />
                                <div class="modal-footer">
                                    <x-adminlte-button type="submit" class="btn btn-warning" label="Actualizar Tipo" />
                                    <x-adminlte-button data-dismiss="modal" class="btn btn-secondary" label="Cancelar" />
                                </div>
                            </form>
                        </x-adminlte-modal>
                        <x-adminlte-modal id="deletePeripheralTypeModal{{ $peripheralType->id }}"
                            title="Eliminar tipo de periférico" theme="danger" size="lg">
                            <x-slot name="footerSlot">
                                <p class="text-muted">Esta acción no se puede deshacer. Asegúrate de que no haya periféricos
                                    asociados a este tipo.</p>
                            </x-slot>
                            <form action="{{ route('peripheralType.destroy', $peripheralType->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <p>¿Estás seguro de que deseas eliminar el tipo de periférico
                                    "{{ $peripheralType->name }}"?</p>
                                <div class="modal-footer">
                                    <x-adminlte-button type="submit" class="btn btn-danger" label="Eliminar Tipo" />
                                    <x-adminlte-button data-dismiss="modal" class="btn btn-secondary" label="Cancelar" />
                                </div>
                            </form>
                        </x-adminlte-modal>
                    @endforeach
                </x-adminlte-datatable>
            </x-adminlte-card>
            {{ $peripheralTypes->withQueryString()->links('custom.pagination') }}
        </div>
    </div>

@endsection
