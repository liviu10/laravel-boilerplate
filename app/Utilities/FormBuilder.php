<?php

namespace App\Utilities;

use App\Utilities\FormBuilderInputTypes;
use App\Utilities\FormBuilderInterface;
use App\Utilities\FormBuilderMethods;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Support\Facades\Route;

class FormBuilder implements FormBuilderInterface
{
    /**
     * Create a new class instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the form builder.
     *
     * @return array
     */
    public function handleFormBuilder(array $inputs): array
    {
        return [];
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

    private function buildDateTimeLocalInput(): array
    {
        return [];
    }

    private function buildEmailInput(): array
    {
        return [];
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

    private function buildNumberInput(): array
    {
        return [];
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

    private function buildTelInput(): array
    {
        return [];
    }

    private function buildTextInput(): array
    {
        return [];
    }

    private function buildTimeInput(): array
    {
        return [];
    }

    private function buildUrlInput(): array
    {
        return [];
    }

    private function buildWeekInput(): array
    {
        return [];
    }
}
