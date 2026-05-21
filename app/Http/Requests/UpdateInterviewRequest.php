<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateInterviewRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     * 
     * Key difference from StoreInterviewRequest:
     * - scheduled_date does NOT use 'after_or_equal:today'
     *   because we might need to update details of a past interview
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
                // No 'after_or_equal:today' - can update past interviews
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
            'type.required' => 'The interview type is required.',
            'type.in' => 'The selected interview type is not valid.',

            'scheduled_date.required' => 'The interview date is required.',
            'scheduled_date.date' => 'The interview date must be a valid date.',

            'scheduled_time.required' => 'The interview time is required.',
            'scheduled_time.date_format' => 'The time must be in HH:MM format (e.g., 14:30).',

            'preparation_notes.string' => 'The preparation notes must be a text string.',

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
