<?php

namespace App\Http\Controllers;

use App\Models\PeripheralType;
use Illuminate\Http\Request;

class PeripheralTypeController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $limit = $request->get('limit', 5);
        $peripheralTypes = PeripheralType::query()
            ->when($search, function ($query) use ($search) {
                return $query->where('name', 'like', "%{$search}%");
            })->paginate($limit);
        return view('pages.peripheralType.index', compact('peripheralTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50|unique:' . PeripheralType::class,
        ]);
        try {
            PeripheralType::create([
                'name' => $request->get('name'),
            ]);
            return redirect()->route('peripheralType.index')->with('success', 'El tipo de periferico se ha creado correctamente');
        } catch (\Throwable $th) {
            return redirect()->route('peripheralType.index')->with('warning', 'El tipo de periferico no se ha creado correctamente');
        }
    }

    public function update(Request $request, PeripheralType $peripheralType)
    {
        $request->validate([
            'name' => 'required|string|max:50|unique:' . PeripheralType::class . ',name,' . $peripheralType->id,
        ]);
        try {
            $peripheralType->update([
                'name' => $request->get('name'),
            ]);
            return redirect()->route('peripheralType.index')->with('success', 'El tipo de periferico se ha actualizado correctamente');
        } catch (\Throwable $th) {
            return redirect()->route('peripheralType.index')->with('warning', 'El tipo de periferico no se ha actualizado correctamente');
        }
    }

    public function destroy(PeripheralType $peripheralType)
    {
        try {
            $peripheralType->delete();
            return redirect()->route('peripheralType.index')->with('success', 'El tipo de periferico se ha eliminado correctamente');
        } catch (\Throwable $th) {
            return redirect()->route('peripheralType.index')->with('warning', 'El tipo de periferico no se ha eliminado correctamente');
        }
    }
}
