<?php

namespace App\Http\Requests;

use App\Models\Brand;
use App\Models\Computer;
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
            'peripherals' => ['required_if:type,pc', 'array', 'min:1'],
            'peripherals.*.type_id' => ['required', 'exists:' . PeripheralType::class . ',id'],
            'peripherals.*.model' => ['required', 'string', 'max:100'],
            'peripherals.*.serial_number' => ['required', 'string', 'max:100'],
            'operation_system_id' => ['required_if:type,pc', 'exists:' . OperationSystem::class . ',id'],
            'model' => ['required_if:type,pc', 'string', 'max:100'],
            'serial_number' => ['required_if:type,pc', 'string', 'max:100'],
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
        switch ($this->type) {
            case 'pc':
                $this->createPc();
                break;
            case 'printer':
                $this->createPrinter();
                break;
            case 'scanner':
                $this->createScanner();
                break;
            default:
                throw new Exception('El tipo de dispositivo no es valido');
        }
    }

    public function createPc()
    {
        $computer = Computer::create($this->all());
        $computer->peripherals()->createMany($this->peripherals);
        // Morph To Many
        $computer->featureValues()->createMany($this->features);
        $ts = TechnicalSheet::make($this->all());
        $ts->technicalSheetable()->associate($computer);
        $ts->save();
    }

    public function createPrinter()
    {
        $printer = Printer::create($this->all());
        $printer->featureValues()->createMany($this->features);
        $ts = TechnicalSheet::make($this->all());
        $ts->technicalSheetable()->associate($printer);
        $ts->save();
    }

    public function createScanner()
    {
        $scanner = Scanner::create($this->all());
        $scanner->featureValues()->createMany($this->features);
        $ts = TechnicalSheet::make($this->all());
        $ts->technicalSheetable()->associate($scanner);
        $ts->save();
    }
}
