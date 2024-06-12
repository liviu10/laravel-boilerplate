<?php

namespace App\Utilities;

use App\Utilities\FormBuilderInputTypes;
use App\Utilities\FormBuilderInterface;
use App\Utilities\FormBuilderMethods;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Exception;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Support\Facades\Route;

class FormBuilder implements FormBuilderInterface
{
    protected $methodMapping;

    /**
     * Create a new class instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->methodMapping = [
            'checkbox' => 'buildCheckboxInput',
            'date' => 'buildDateInput',
            'datetime-local' => 'buildDateTimeLocalInput',
            'email' => 'buildEmailInput',
            'file' => 'buildFileInput',
            'month' => 'buildMonthInput',
            'number' => 'buildNumberInput',
            'password' => 'buildPasswordInput',
            'radio' => 'buildRadioInput',
            'reset' => 'buildResetInput',
            'submit' => 'buildSubmitInput',
            'tel' => 'buildTelInput',
            'text' => 'buildTextInput',
            'time' => 'buildTimeInput',
            'week' => 'buildWeekInput',
            'select' => 'buildSelectInput',
            'textarea' => 'buildTextareaInput',
        ];
    }

    /**
     * Handle the form builder.
     *
     * @return array
     */
    public function handleFormBuilder(array $inputs): array
    {
        $builtInputs = [];

        foreach ($inputs as $input) {
            $type = $input['type'];

            if (isset($this->methodMapping[$type])) {
                $method = $this->methodMapping[$type];
                $builtInputs[] = $this->$method($input);
            } else {
                throw new Exception("Unknown input type: $type");
            }
        }

        return [
            'inputs' => $builtInputs
        ];
    }

    /**
     * Handle populate inputs.
     *
     * @return array
     */
    public function handlePopulateInput(Collection|Exception $selectedRecord, array $inputs): array
    {
        try {
            foreach ($inputs as &$result) {
                foreach ($result as &$item) {
                    foreach ($selectedRecord->toArray()[0] as $recordKey => $recordValue) {
                        if ($item['key'] === $recordKey) {
                            $item['value'] = $recordValue;
                        }
                    }
                }
            }
        } catch (Exception $exception) {
            foreach ($inputs as &$result) {
                foreach ($result as &$item) {
                    if ($item['value'] === '') {
                        $item['value'] = '';
                    } elseif ($item['value'] === null) {
                        $item['value'] = null;
                    }
                }
            }
        }

        return $inputs;
    }

    private function buildCheckboxInput(array $input): array
    {
        return [
            'id' => $input['id'],
            'key' => $input['key'],
            'placeholder' => $this->handlePlaceholder($input['key']),
            'type' => 'checkbox',
            'value' => '',
            'is_filter' => $input['is_filter'],
            'is_create' => $input['is_create'],
            'is_edit' => $input['is_edit'],
        ];
    }

    private function buildDateInput(array $input): array
    {
        return [
            'id' => $input['id'],
            'key' => $input['key'],
            'min' => Carbon::now()->startOfYear()->toDateTimeLocalString(),
            'name' => $input['key'],
            'placeholder' => $this->handlePlaceholder($input['key']),
            'type' => 'date',
            'value' => '',
            'is_filter' => $input['is_filter'],
            'is_create' => $input['is_create'],
            'is_edit' => $input['is_edit'],
        ];
    }

    private function buildDateTimeLocalInput(array $input): array
    {
        return [
            'id' => $input['id'],
            'key' => $input['key'],
            'min' => Carbon::now()->startOfYear()->toDateTimeLocalString(),
            'name' => $input['key'],
            'placeholder' => $this->handlePlaceholder($input['key']),
            'type' => 'datetime-local',
            'value' => '',
            'is_filter' => $input['is_filter'],
            'is_create' => $input['is_create'],
            'is_edit' => $input['is_edit'],
        ];
    }

    private function buildEmailInput(array $input): array
    {
        return [
            'id' => $input['id'],
            'key' => $input['key'],
            'maxlength' => 255,
            'minlength' => 1,
            'name' => $input['key'],
            'placeholder' => $this->handlePlaceholder($input['key']),
            'type' => 'email',
            'value' => '',
            'is_filter' => $input['is_filter'],
            'is_create' => $input['is_create'],
            'is_edit' => $input['is_edit'],
        ];
    }

    private function buildFileInput(array $input): array
    {
        return [
            'id' => $input['id'],
            'key' => $input['key'],
            'name' => $input['key'],
            'placeholder' => $this->handlePlaceholder($input['key']),
            'type' => 'file',
            'value' => '',
            'is_filter' => $input['is_filter'],
            'is_create' => $input['is_create'],
            'is_edit' => $input['is_edit'],
        ];
    }

    private function buildMonthInput(array $input): array
    {
        return [
            'id' => $input['id'],
            'key' => $input['key'],
            'min' => Carbon::now()->startOfYear()->toDateTimeLocalString(),
            'name' => $input['key'],
            'placeholder' => $this->handlePlaceholder($input['key']),
            'type' => 'month',
            'value' => '',
            'is_filter' => $input['is_filter'],
            'is_create' => $input['is_create'],
            'is_edit' => $input['is_edit'],
        ];
    }

    private function buildNumberInput(array $input): array
    {
        return [
            'id' => $input['id'],
            'key' => $input['key'],
            'max' => $input['max'],
            'min' => $input['min'],
            'name' => $input['key'],
            'placeholder' => $this->handlePlaceholder($input['key']),
            'type' => 'number',
            'value' => null,
            'is_filter' => $input['is_filter'],
            'is_create' => $input['is_create'],
            'is_edit' => $input['is_edit'],
        ];
    }

    private function buildPasswordInput(array $input): array
    {
        return [
            'id' => $input['id'],
            'key' => $input['key'],
            'maxlength' => 20,
            'minlength' => 8,
            'name' => $input['key'],
            'placeholder' => $this->handlePlaceholder($input['key']),
            'type' => 'password',
            'value' => '',
            'is_filter' => $input['is_filter'],
            'is_create' => $input['is_create'],
            'is_edit' => $input['is_edit'],
        ];
    }

    private function buildRadioInput(array $input): array
    {
        return [
            'id' => $input['id'],
            'key' => $input['key'],
            'name' => $input['key'],
            'placeholder' => $this->handlePlaceholder($input['key']),
            'type' => 'radio',
            'value' => '',
            'is_filter' => $input['is_filter'],
            'is_create' => $input['is_create'],
            'is_edit' => $input['is_edit'],
        ];
    }

    private function buildResetInput(array $input): array
    {
        return [
            'id' => $input['id'],
            'key' => $input['key'],
            'name' => $input['key'],
            'placeholder' => $this->handlePlaceholder($input['key']),
            'type' => 'reset',
            'value' => '',
            'is_filter' => $input['is_filter'],
            'is_create' => $input['is_create'],
            'is_edit' => $input['is_edit'],
        ];
    }

    private function buildSubmitInput(array $input): array
    {
        return [
            'id' => $input['id'],
            'key' => $input['key'],
            'name' => $input['key'],
            'placeholder' => $this->handlePlaceholder($input['key']),
            'type' => 'submit',
            'value' => '',
            'is_filter' => $input['is_filter'],
            'is_create' => $input['is_create'],
            'is_edit' => $input['is_edit'],
        ];
    }

    private function buildTelInput(array $input): array
    {
        return [
            'id' => $input['id'],
            'key' => $input['key'],
            'maxlength' => 14,
            'minlength' => 3,
            'name' => $input['key'],
            'placeholder' => $this->handlePlaceholder($input['key']),
            'type' => 'tel',
            'value' => '',
            'is_filter' => $input['is_filter'],
            'is_create' => $input['is_create'],
            'is_edit' => $input['is_edit'],
        ];
    }

    private function buildTextInput(array $input): array
    {
        return [
            'id' => $input['id'],
            'key' => $input['key'],
            'maxlength' => 255,
            'minlength' => 1,
            'name' => $input['key'],
            'placeholder' => $this->handlePlaceholder($input['key']),
            'type' => 'text',
            'value' => '',
            'is_filter' => $input['is_filter'],
            'is_create' => $input['is_create'],
            'is_edit' => $input['is_edit'],
        ];
    }

    private function buildTimeInput(array $input): array
    {
        return [
            'id' => $input['id'],
            'key' => $input['key'],
            'max' => '23:59',
            'min' => '00:00',
            'name' => $input['key'],
            'placeholder' => $this->handlePlaceholder($input['key']),
            'type' => 'time',
            'value' => '',
            'is_filter' => $input['is_filter'],
            'is_create' => $input['is_create'],
            'is_edit' => $input['is_edit'],
        ];
    }

    private function buildWeekInput(array $input): array
    {
        return [
            'id' => $input['id'],
            'key' => $input['key'],
            'min' => Carbon::now()->startOfYear()->toDateTimeLocalString(),
            'name' => $input['key'],
            'placeholder' => $this->handlePlaceholder($input['key']),
            'type' => 'week',
            'value' => '',
            'is_filter' => $input['is_filter'],
            'is_create' => $input['is_create'],
            'is_edit' => $input['is_edit'],
        ];
    }

    private function buildSelectInput(array $input): array
    {
        return [
            'id' => $input['id'],
            'key' => $input['key'],
            'name' => $input['key'],
            'options' => $this->handleOptions($input['options']),
            'placeholder' => $this->handlePlaceholder($input['key']),
            'type' => $input['type'],
            'value' => null,
            'is_filter' => $input['is_filter'],
            'is_create' => $input['is_create'],
            'is_edit' => $input['is_edit'],
        ];
    }

    private function buildTextareaInput(array $input): array
    {
        return [
            'id' => $input['id'],
            'key' => $input['key'],
            'name' => $input['key'],
            'placeholder' => $this->handlePlaceholder($input['key']),
            'type' => $input['type'],
            'value' => '',
            'is_filter' => $input['is_filter'],
            'is_create' => $input['is_create'],
            'is_edit' => $input['is_edit'],
        ];
    }

    private function handleOptions(array $options): array
    {
        return $options;
    }

    private function handlePlaceholder(string $placeholder): string
    {
        return ucfirst(str_replace('_', ' ', $placeholder));
    }
}
