<?php

namespace App\Http\Controllers;

use App\Models\Feature;
use Exception;
use Illuminate\Http\Request;

class FeatureController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $limit = $request->get('limit', 5);
        $features = Feature::query()
            ->when($search, function ($query) use ($search) {
                return $query->where('name', 'like', "%{$search}%");
            })->paginate($limit);
        return view('pages.feature.index', compact('features'));
    }

    public function update(Feature $feature, Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50|unique:' . Feature::class . ',name,' . $feature->id,
        ]);
        try {
            $feature->name = $request->get('name');
            $feature->save();
            return redirect()->route('feature.index')->with('success', 'La caracteristica se ha actualizado correctamente');
        } catch (Exception $e) {
            return redirect()->route('fearture.index')->with('warning', 'Error al actualizar la caracteristica');
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50|unique:' . Feature::class,
        ]);
        try {
            Feature::create([
                'name' => $request->get('name'),
            ]);
            return redirect()->route('operationSystem.index')->with('success', 'La caracteristica se ha creado correctamente');
        } catch (Exception $e) {
            return redirect()->back()->with('warning', 'Error al crear la Caracteristica: ' . $e->getMessage());
        }
    }

    public function destroy(Feature $feature)
    {
        try {
            $feature->delete();
            return redirect()->route('feature.index')->with('success', 'La caracteristica se ha eliminado correctamente');
        } catch (Exception $e) {
            return redirect()->back()->with('warning', 'Error al eliminar la caracteristica');
        }
    }
}
