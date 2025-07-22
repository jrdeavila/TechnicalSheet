<?php

namespace App\Http\Requests;

use App\Models\Brand;
use App\Models\Computer;
use App\Models\Device;
use App\Models\Feature;
use App\Models\OperationSystem;
use App\Models\PeripheralType;
use App\Models\Printer;
use App\Models\Scanner;
use App\Models\TechnicalSheet;
use Exception;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateTechnicalSheetRequest extends FormRequest
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
            'code' => ['required', 'numeric', 'min:1', 'unique:' . Device::class . ',code'],
            'mac' => ['required', 'string', 'max:100', 'unique:' . Device::class . ',mac'],
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

    public function createTechnicalSheet()
    {
        try {
            DB::beginTransaction();
            $this->handle();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function handle()
    {

        $deviceable = match ($this->type) {
            'pc' => $this->createPc(),
            'printer' => $this->createPrinter(),
            'scanner' => $this->createScanner(),
        };

        $device = Device::make($this->all());
        $device->deviceable()->associate($deviceable);
        $device->save();
        $device->featureValues()->createMany($this->features);

        $ts = TechnicalSheet::make($this->all());
        $ts->technicalSheetable()->associate($device);
        $ts->save();
    }


    public function createPc(): Computer
    {
        $computer = Computer::create($this->all());
        $computer->peripherals()->createMany($this->peripherals);
        return $computer;
    }

    public function createPrinter(): Printer
    {
        $printer = Printer::create();
        return $printer;
    }

    public function createScanner(): Scanner
    {
        $scanner = Scanner::create();
        return $scanner;
    }
}
