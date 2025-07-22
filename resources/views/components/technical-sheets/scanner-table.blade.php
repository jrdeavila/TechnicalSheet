@props([
    'scanners' => [],
])


<x-adminlte-datatable id="table1" :heads="['ID', 'Sticker', 'Tipo', 'Marca', 'Modelo', 'Acciones']" striped hoverable>
    @foreach ($scanners as $technicalSheet)
        <tr>
            <td>{{ $technicalSheet->id }}</td>
            <td>{{ $technicalSheet->technicalSheetable->code }}</td>
            <td>
                <i class="fas fa-camera"></i> Escáner
            </td>
            <td>{{ $technicalSheet->technicalSheetable->brand->name }}</td>
            <td>{{ $technicalSheet->technicalSheetable->model }}</td>
            <td>
                <div class="btn-group">
                    <x-adminlte-button class="btn btn-info" icon="fas fa-eye"
                        onclick="window.location.href='{{ route('technicalSheet.show', $technicalSheet->id) }}'" />
                    <form action="{{ route('technicalSheet.edit', $technicalSheet->id) }}" method="GET"
                        style="display: inline;">
                        @csrf
                        <input type="hidden" name="type" value="scanner" />
                        <x-adminlte-button class="btn btn-primary" icon="fas fa-edit" type="submit" />
                    </form>
                    <form action="{{ route('technicalSheet.destroy', $technicalSheet->id) }}" method="POST"
                        style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <x-adminlte-button class="btn btn-danger" icon="fas fa-trash"
                            onclick="return confirm('¿Estás seguro de eliminar esta ficha técnica?')" />
                    </form>
                </div>
            </td>
        </tr>
    @endforeach
</x-adminlte-datatable>
