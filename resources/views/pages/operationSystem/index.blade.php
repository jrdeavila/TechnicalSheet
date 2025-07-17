@extends('layouts.app')

@section('title', 'Sistemas operativos')

@section('header')
    <h1>Sistemas operativos</h1>
@stop

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
                <x-adminlte-alert theme="danger" dismissable>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </x-adminlte-alert>
            @endif
        </div>
        <div class="col-md-8">
            <x-adminlte-card title="Sistemas operativos" theme="light" icon="fas fa-clipboard-list">
                <x-slot name="toolsSlot">
                    <div class="d-flex justify-content-between items-align-center">
                        <form action="{{ route('operationSystem.index') }}" method="GET" class="form-inline">
                            <label for="limit" class="mr-2">Mostrar:</label>
                            <x-adminlte-select name="limit" class="form-control" onchange="this.form.submit()">
                                <option value="10" {{ request('limit') == 10 ? 'selected' : '' }}>10</option>
                                <option value="25" {{ request('limit') == 25 ? 'selected' : '' }}>25</option>
                                <option value="50" {{ request('limit') == 50 ? 'selected' : '' }}>50</option>
                                <option value="100" {{ request('limit') == 100 ? 'selected' : '' }}>100</option>
                            </x-adminlte-select>
                        </form>
                        <x-adminlte-button class="ml-2" theme="primary" icon="fas fa-plus" data-toggle="modal"
                            data-target="#addOperationSystemModal" label="Agregar sistema operativo" />
                    </div>
                </x-slot>
                <!-- Add Modal -->
                <x-adminlte-modal id="addOperationSystemModal" title="Agregar nuevo sistema operativo" theme="primary"
                    size="lg">
                    <form action="{{ route('operationSystem.store') }}" method="POST">
                        @csrf
                        <x-adminlte-input name="name" label="Nombre del sistema operativo"
                            placeholder="Ingrese el nombre del sistema operativo" required />

                        <div class="modal-footer">
                            <x-adminlte-button type="submit" class="btn btn-primary" label="Agregar Sistema Operativo" />
                            <x-adminlte-button data-dismiss="modal" class="btn btn-secondary" label="Cancelar" />
                        </div>

                        <x-slot name="footerSlot">
                            <p class="text-muted">Asegúrate de que el nombre del sistema operativo sea unico.</p>
                        </x-slot>
                    </form>
                </x-adminlte-modal>
                <x-adminlte-datatable id="operationSystemTable" :heads="['ID', 'Nombre', 'Acciones']" striped hoverable>
                    @foreach ($operationSystems as $operationSystem)
                        <tr>
                            <td>{{ $operationSystem->id }}</td>
                            <td>{{ $operationSystem->name }}</td>
                            <td>{{ $operationSystem->value }}</td>
                            <td class="text-center">
                                <x-adminlte-button class="btn-xs" icon="fas fa-edit" data-toggle="modal"
                                    data-target="#editOperationSystemModal{{ $operationSystem->id }}" title="Editar" />
                                <x-adminlte-button class="btn-xs" icon="fas fa-trash-alt" data-toggle="modal"
                                    data-target="#deleteOperationSystemModal{{ $operationSystem->id }}" title="Eliminar" />


                                <!-- Edit Modal -->
                                <x-adminlte-modal id="editOperationSystemModal{{ $operationSystem->id }}"
                                    title="Editar Sistema operativo: {{ $operationSystem->name }}" theme="primary"
                                    size="lg">
                                    <x-slot name="footerSlot">
                                        <p class="text-muted">Asegúrate de que el nombre del sistema operativo sea unico.
                                        </p>
                                    </x-slot>
                                    <form action="{{ route('operationSystem.update', $operationSystem) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <x-adminlte-input name="name" label="Nombre del sistema operativo"
                                            value="{{ $operationSystem->name }}"
                                            placeholder="Ingrese el nombre del sistema operativo" required />
                                        <div class="modal-footer">
                                            <x-adminlte-button type="submit" class="btn btn-primary"
                                                label="Guardar Cambios" />
                                            <x-adminlte-button data-dismiss="modal" class="btn btn-secondary"
                                                label="Cancelar" />
                                        </div>
                                    </form>
                                </x-adminlte-modal>
                                <!-- Delete Modal -->
                                <x-adminlte-modal id="deleteOperationSystemModal{{ $operationSystem->id }}"
                                    title="Eliminar Sistema operativo: {{ $operationSystem->name }}" theme="danger"
                                    size="lg">
                                    <x-slot name="footerSlot">
                                        <p class="text-muted">Esta acción no se puede deshacer.</p>
                                    </x-slot>
                                    <p>¿Estás seguro de que deseas eliminar el sistema operativo
                                        <strong>{{ $operationSystem->name }}</strong>?
                                    </p>
                                    <form action="{{ route('operationSystem.destroy', $operationSystem) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <div class="modal-footer">
                                            <x-adminlte-button type="submit" class="btn btn-danger" label="Eliminar" />
                                            <x-adminlte-button data-dismiss="modal" class="btn btn-secondary"
                                                label="Cancelar" />
                                        </div>
                                    </form>
                                </x-adminlte-modal>
                            </td>
                        </tr>
                    @endforeach
                </x-adminlte-datatable>

            </x-adminlte-card>
            {{ $operationSystems->withQueryString()->links('custom.pagination') }}
        </div>
    </div>
@stop
