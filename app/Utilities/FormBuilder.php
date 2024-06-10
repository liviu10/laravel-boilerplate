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
            // 'button' => 'buildButtonInput',
            // 'checkbox' => 'buildCheckboxInput',
            // 'color' => 'buildColorInput',
            // 'date' => 'buildDateInput',
            'datetime-local' => 'buildDateTimeLocalInput',
            'email' => 'buildEmailInput',
            // 'file' => 'buildFileInput',
            // 'hidden' => 'buildHiddenInput',
            // 'image' => 'buildImageInput',
            // 'month' => 'buildMonthInput',
            'number' => 'buildNumberInput',
            // 'password' => 'buildPasswordInput',
            // 'radio' => 'buildRadioInput',
            'range' => 'buildRangeInput',
            // 'reset' => 'buildResetInput',
            // 'search' => 'buildSearchInput',
            // 'submit' => 'buildSubmitInput',
            'tel' => 'buildTelInput',
            'text' => 'buildTextInput',
            'time' => 'buildTimeInput',
            // 'url' => 'buildUrlInput',
            // 'week' => 'buildWeekInput',
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

    private function buildButtonInput(): array
    {
        return [];
    }

    private function buildCheckboxInput(): array
    {
        return [];
    }

    private function buildColorInput(): array
    {
        return [];
    }

    private function buildDateInput(): array
    {
        return [];
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
        ];
    }

    private function buildFileInput(): array
    {
        return [];
    }

    private function buildHiddenInput(): array
    {
        return [];
    }

    private function buildImageInput(): array
    {
        return [];
    }

    private function buildMonthInput(): array
    {
        return [];
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
        ];
    }

    private function buildPasswordInput(): array
    {
        return [];
    }

    private function buildRadioInput(): array
    {
        return [];
    }

    private function buildRangeInput(): array
    {
        return [];
    }

    private function buildResetInput(): array
    {
        return [];
    }

    private function buildSearchInput(): array
    {
        return [];
    }

    private function buildSubmitInput(): array
    {
        return [];
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
        ];
    }

    private function buildUrlInput(): array
    {
        return [];
    }

    private function buildWeekInput(): array
    {
        return [];
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
            'value' => null
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
            'value' => ''
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
