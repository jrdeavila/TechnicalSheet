<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Exception;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $limit = $request->get('limit', 5);
        $brands = Brand::query()
            ->when($search, function ($query) use ($search) {
                return $query->where('name', 'like', "%{$search}%");
            })->paginate($limit);
        return view('pages.brand.index', compact('brands'));
    }


    public function update(Brand $brand, Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50|unique:' . Brand::class . ',name,' . $brand->id,
        ]);
        try {
            $brand->name = $request->get('name');
            $brand->save();
            return redirect()->route('brand.index')->with('success', 'La marca se ha actualizado correctamente');
        } catch (Exception $e) {
            return redirect()->route('brand.index')->withError('Error al actualizar la marca');
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50|unique:' . Brand::class,
        ]);
        try {
            Brand::create($request->all());
            return redirect()->route('brand.index')->with('success', 'La marca se ha creado correctamente');
        } catch (Exception $e) {
            return redirect()->back()->withError('Error al crear la marca');
        }
    }

    public function destroy(Brand $brand)
    {
        try {
            $brand->delete();
            return redirect()->route('brand.index')->with('success', 'La marca se ha eliminado correctamente');
        } catch (Exception $e) {
            return redirect()->back()->withError('Error al eliminar la marca');
        }
    }
}
