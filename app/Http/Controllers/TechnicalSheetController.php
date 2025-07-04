<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTechnicalSheetRequest;
use App\Http\Requests\UpdateTechnicalSheetRequest;
use App\Models\TechnicalSheet;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TechnicalSheetController extends Controller
{
    public function index()
    {
        $technicalSheets = TechnicalSheet::paginate(5);
        return view('pages.technicalSheet.index', compact('technicalSheets'));
    }

    public function show(TechnicalSheet $technicalSheet)
    {
        return view('pages.technicalSheet.show', compact('technicalSheet'));
    }

    public function create()
    {
        return view('pages.technicalSheet.create');
    }

    public function edit(TechnicalSheet $technicalSheet)
    {
        return view('pages.technicalSheet.edit');
    }

    public function store(CreateTechnicalSheetRequest $request)
    {
        try {
            DB::beginTransaction();
            $request->createTechnicalSheet();
            DB::commit();
            return redirect()->route('technicalSheet.index')->with('success', 'La ficha tecnica se ha creado correctamente');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('technicalSheet.index')->with('error', 'Error al crear la ficha tecnica');
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
            return redirect()->route('technicalSheet.index')->with('error', 'Error al actualizar la ficha tecnica');
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
            return redirect()->route('technicalSheet.index')->with('error', 'Error al eliminar la ficha tecnica');
        }
    }
}
