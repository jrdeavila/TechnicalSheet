<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTechnicalSheetRequest;
use App\Http\Requests\UpdateTechnicalSheetRequest;
use App\Models\Brand;
use App\Models\Feature;
use App\Models\OperationSystem;
use App\Models\PeripheralType;
use App\Models\TechnicalSheet;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TechnicalSheetController extends Controller
{
    public function index(Request $request)
    {
        $technicalSheets = TechnicalSheet::paginate(5);
        $brands = Brand::all();
        return view('pages.technicalSheet.index', compact('technicalSheets', 'brands'));
    }

    public function show(TechnicalSheet $technicalSheet)
    {
        return view('pages.technicalSheet.show', compact('technicalSheet'));
    }

    public function createDevice(string $type, Request $request)
    {
        $users = User::with('employee')->get();

        $brands = Brand::all();
        $features = Feature::all();
        $brands = Brand::all();
        $locations = config('locations');
        $params = ['users', 'brands', 'features', 'locations'];
        switch ($type) {
            case 'pc':
                $peripheralTypes = PeripheralType::all();
                $operatingSystems = OperationSystem::all();
                $params = array_merge($params, ['peripheralTypes', 'operatingSystems']);
                $params = compact(...$params);
                return view('pages.technicalSheet.views.pc', $params);
            case 'printer':
                $params = compact(...$params);
                return view('pages.technicalSheet.views.printer', $params);
            case 'scanner':
                $params = compact(...$params);
                return view('pages.technicalSheet.views.scanner', $params);
            default:
                throw new Exception('Invalid type');
        }
    }


    public function create(Request $request)
    {
        return view('pages.technicalSheet.create');
    }

    public function edit(TechnicalSheet $technicalSheet, Request $request)
    {
        $type = $request->get('type');
        $features = Feature::all();
        $brands = Brand::all();
        $users = User::with('employee')->get();
        $locations = config('locations');
        $params = ['users', 'brands', 'features', 'locations', 'technicalSheet'];
        switch ($type) {
            case 'pc':
                $peripheralTypes = PeripheralType::all();
                $operatingSystems = OperationSystem::all();
                $params = array_merge($params, ['peripheralTypes', 'operatingSystems']);
                $params = compact(...$params);
                return view('pages.technicalSheet.views.pc', $params);
            case 'printer':
                $params = compact(...$params);
                return view('pages.technicalSheet.views.printer', $params);
            case 'scanner':
                $params = compact(...$params);
                return view('pages.technicalSheet.views.scanner', $params);
            default:
                throw new Exception('Invalid type');
        }
    }

    public function store(CreateTechnicalSheetRequest $request)
    {
        try {
            DB::beginTransaction();
            $request->createTechnicalSheet();
            DB::commit();
            return redirect()->route('technicalSheet.index')->with('success', 'La ficha tecnica se ha creado correctamente');
        } catch (Exception $e) {
            Log::error($e);
            DB::rollBack();
            return redirect()->back()->withInput()->with('warning', 'Error al crear la ficha tecnica');
        }
    }

    public function update(TechnicalSheet $technicalSheet, UpdateTechnicalSheetRequest $request)
    {
        try {
            DB::beginTransaction();
            $request->updateTechnicalSheet($technicalSheet);
            DB::commit();
            return redirect()->route('technicalSheet.index')->with('success', 'La ficha tecnica se ha actualizado correctamente');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('warning', 'Error al actualizar la ficha tecnica');
        }
    }

    public function destroy(TechnicalSheet $technicalSheet)
    {
        try {
            DB::beginTransaction();
            $technicalSheet->delete();
            DB::commit();
            return redirect()->route('technicalSheet.index')->with('success', 'La ficha tecnica se ha eliminado correctamente');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('warning', 'Error al eliminar la ficha tecnica');
        }
    }
}
