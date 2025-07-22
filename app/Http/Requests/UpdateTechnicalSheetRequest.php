<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Device;
use App\Models\Brand;
use App\Models\Computer;
use App\Models\Feature;
use App\Models\OperationSystem;
use App\Models\PeripheralType;
use App\Models\Printer;
use App\Models\Scanner;
use App\Models\TechnicalSheet;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdateTechnicalSheetRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'brand_id' => ['required', 'exists:' . Brand::class . ',id'],
            'features' => ['required', 'array', 'min:1'],
            'features.*.feature_id' => ['required', 'exists:' . Feature::class . ',id'],
            'features.*.value' => ['required', 'string', 'max:255'],
            'peripherals' => ['required_if:type,pc'],
            'peripherals.*.type_id' => ['required', 'exists:' . PeripheralType::class . ',id'],
            'peripherals.*.model' => ['required', 'string', 'max:100'],
            'peripherals.*.serial_number' => ['required', 'string', 'max:100'],
            'operation_system_id' => ['required_if:type,pc', 'exists:' . OperationSystem::class . ',id'],
            'model' => ['required', 'string', 'max:100'],
            'serial_number' => ['required', 'string', 'max:100'],
            'code' => ['required', 'numeric', 'min:1', 'unique:' . Device::class . ',code,' . $this->technical_sheet->technicalSheetable->id],
            'mac' => ['required', 'string', 'max:100', 'unique:' . Device::class . ',mac,' . $this->technical_sheet->technicalSheetable->id],
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'features' => array_values(array_map(fn($feature) => json_decode($feature, true), $this->features))[0],
            'peripherals' => $this->peripherals ? array_values(array_map(fn($peripheral) => json_decode($peripheral, true), $this->peripherals))[0] : [],
            'user_id' => Auth::id(),
        ]);
    }

    public function updateTechnicalSheet()
    {
        try {
            DB::beginTransaction();
            $this->handle();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e);
            throw $e;
        }
    }

    public function handle()
    {

        match ($this->type) {
            'pc' => $this->updatePc(),
            'printer' => $this->updatePrinter(),
            'scanner' => $this->updateScanner(),
        };

        $device = $this->technicalSheet->technicalSheetable;
        $device->brand_id = $this->brand_id;
        $device->model = $this->model;
        $device->serial_number = $this->serial_number;
        $device->code = $this->code;
        $device->mac = $this->mac;
        $device->featureValues()->delete();
        $device->featureValues()->createMany($this->features);
        $device->save();
    }


    public function updatePc(): Computer
    {
        $computer = $this->technical_sheet->technicalSheetable->deviceable;
        $computer->operation_system_id = $this->operation_system_id;
        $computer->peripherals()->delete();
        $computer->peripherals()->createMany($this->peripherals);
        $computer->save();
        return $computer;
    }

    public function updatePrinter(): Printer
    {
        $printer = $this->technical_sheet->technicalSheetable->deviceable;
        return $printer;
    }

    public function updateScanner(): Scanner
    {
        $scanner = $this->technical_sheet->technicalSheetable->deviceable;
        return $scanner;
    }
}
