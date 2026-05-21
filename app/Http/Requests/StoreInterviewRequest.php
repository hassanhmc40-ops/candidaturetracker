<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreInterviewRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * 
     * Authorization for parent application ownership
     * is handled by Policy in controller.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'type' => [
                'required',
                'string',
                'in:telephone,visioconference,technique,rh,presentiel,entretien_final',
            ],
            'scheduled_date' => [
                'required',
                'date',
                'after_or_equal:today',
            ],
            'scheduled_time' => [
                'required',
                'date_format:H:i',
            ],
            'preparation_notes' => [
                'nullable',
                'string',
            ],
            'result' => [
                'nullable',
                'string',
                'in:en_attente,reussi,echoue,annule',
            ],
        ];
    }

    /**
     * Get custom error messages for validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            // Type messages
            'type.required' => 'The interview type is required.',
            'type.in' => 'The selected interview type is not valid.',

            // Scheduled date messages
            'scheduled_date.required' => 'The interview date is required.',
            'scheduled_date.date' => 'The interview date must be a valid date.',
            'scheduled_date.after_or_equal' => 'The interview date must be today or a future date.',

            // Scheduled time messages
            'scheduled_time.required' => 'The interview time is required.',
            'scheduled_time.date_format' => 'The time must be in HH:MM format (e.g., 14:30).',

            // Preparation notes messages
            'preparation_notes.string' => 'The preparation notes must be a text string.',

            // Result messages
            'result.in' => 'The selected result is not valid.',
        ];
    }

    /**
     * Get custom attribute names for error messages.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'type' => 'interview type',
            'scheduled_date' => 'interview date',
            'scheduled_time' => 'interview time',
            'preparation_notes' => 'preparation notes',
            'result' => 'result',
        ];
    }
}