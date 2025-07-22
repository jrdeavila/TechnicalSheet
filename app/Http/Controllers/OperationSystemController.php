<?php

namespace App\Http\Controllers;

use App\Models\OperationSystem;
use Exception;
use Illuminate\Http\Request;

class OperationSystemController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $limit = $request->get('limit', 5);
        $operationSystems = OperationSystem::query()
            ->when($search, function ($query) use ($search) {
                return $query->where('name', 'like', "%{$search}%");
            })->paginate($limit);
        return view('pages.operationSystem.index', compact('operationSystems'));
    }

    public function update(OperationSystem $operationSystem, Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50|unique:' . OperationSystem::class . ',name,' . $operationSystem->id,
        ]);
        try {
            $operationSystem->name = $request->get('name');
            $operationSystem->save();
            return redirect()->route('operationSystem.index')->with('success', 'El sistema operativo se ha actualizado correctamente');
        } catch (Exception $e) {
            return redirect()->route('operationSystem.index')->with('warning', 'Error al actualizar el sistema operativo');
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50|unique:' . OperationSystem::class,
        ]);
        try {
            OperationSystem::create([
                'name' => $request->get('name'),
            ]);
            return redirect()->route('operationSystem.index')->with('success', 'El sitema operativo se ha creado correctamente');
        } catch (Exception $e) {
            return redirect()->back()->with('warning', 'Error al crear el sistema operativo: ' . $e->getMessage());
        }
    }

    public function destroy(OperationSystem $operationSystem)
    {
        try {
            $operationSystem->delete();
            return redirect()->route('operationSystem.index')->with('success', 'El sistema operativo se ha eliminado correctamente');
        } catch (Exception $e) {
            return redirect()->back()->with('warning', 'Error al eliminar el sistema operativo');
        }
    }
}
