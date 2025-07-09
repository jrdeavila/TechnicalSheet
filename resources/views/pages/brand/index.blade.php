@extends('layouts.app')

@section('title', 'Marcas')

@section('header')
    <h1>Marcas</h1>
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
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </x-adminlte-alert>
            @endif
        </div>
        <div class="col-md-8">
            <x-adminlte-card title="Marcas" theme="primary" icon="fas fa-clipboard-list">
                <x-slot name="toolsSlot">
                    <x-adminlte-button class="btn-flat" theme="primary" icon="fas fa-plus" data-toggle="modal"
                        data-target="#addBrandModal" label="Agregar Marca" />
                </x-slot>
                <!-- Add Modal -->
                <x-adminlte-modal id="addBrandModal" title="Agregar Nueva Marca" theme="primary" size="lg">
                    <form action="{{ route('brand.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Nombre de la Marca</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="modal-footer">
                            <x-adminlte-button type="submit" class="btn btn-primary" label="Agregar Marca" />
                            <x-adminlte-button data-dismiss="modal" class="btn btn-secondary" label="Cancelar" />
                        </div>

                        <x-slot name="footerSlot">
                            <p class="text-muted">Asegúrate de que el nombre de la marca sea único.</p>
                        </x-slot>
                    </form>
                </x-adminlte-modal>
                <x-adminlte-datatable id="brandsTable" :heads="['ID', 'Nombre', 'Acciones']" striped hoverable>
                    @foreach ($brands as $brand)
                        <tr>
                            <td>{{ $brand->id }}</td>
                            <td>{{ $brand->name }}</td>
                            <td class="text-center">
                                <x-adminlte-button class="btn-xs" icon="fas fa-edit" data-toggle="modal"
                                    data-target="#editBrandModal{{ $brand->id }}" title="Editar" />
                                <x-adminlte-button class="btn-xs" icon="fas fa-trash-alt" data-toggle="modal"
                                    data-target="#deleteBrandModal{{ $brand->id }}" title="Eliminar" />
                            </td>
                        </tr>

                        <!-- Edit Modal -->
                        <x-adminlte-modal id="editBrandModal{{ $brand->id }}" title="Editar Marca: {{ $brand->name }}"
                            theme="primary" size="lg">
                            <form action="{{ route('brand.update', $brand->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="name">Nombre de la Marca</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        value="{{ $brand->name }}" required>
                                </div>
                                <div class="modal-footer">
                                    <x-adminlte-button type="submit" class="btn btn-primary" label="Guardar Cambios" />
                                    <x-adminlte-button data-dismiss="modal"
                                        class="btn btn-secondary
                                    " label="Cancelar" />
                                </div>
                            </form>
                        </x-adminlte-modal>
                        <!-- Delete Modal -->
                        <x-adminlte-modal id="deleteBrandModal{{ $brand->id }}"
                            title="Eliminar Marca: {{ $brand->name }}" theme="danger" size="lg">
                            <p>¿Estás seguro de que deseas eliminar la marca <strong>{{ $brand->name }}</strong>?</p>
                            <form action="{{ route('brand.destroy', $brand->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <div class="modal-footer">
                                    <x-adminlte-button type="submit" class="btn btn-danger" label="Eliminar" />
                                    <x-adminlte-button data-dismiss="modal" class="btn btn-secondary" label="Cancelar" />
                                </div>
                            </form>
                        </x-adminlte-modal>
                    @endforeach
                </x-adminlte-datatable>

            </x-adminlte-card>
        </div>
    </div>
@stop
