<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateApplicationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * 
     * Authorization handled by Policy in controller:
     * $this->authorize('update', $application);
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
            'company_name' => ['required', 'string', 'max:255'],
            'job_title' => ['required', 'string', 'max:255'],
            'job_url' => ['nullable', 'url', 'max:500'],
            'status' => ['required', 'string', 'in:en_attente,en_cours,entretien_planifie,offre_recue,refusee,acceptee'],
            'priority' => ['required', 'string', 'in:basse,moyenne,haute,urgente'],
            'notes' => ['nullable', 'string'],
            'application_date' => ['required', 'date'],
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
            'company_name.required' => 'The company name is required.',
            'company_name.string' => 'The company name must be a text string.',
            'company_name.max' => 'The company name cannot exceed 255 characters.',

            'job_title.required' => 'The job title is required.',
            'job_title.string' => 'The job title must be a text string.',
            'job_title.max' => 'The job title cannot exceed 255 characters.',

            'job_url.url' => 'The job URL must be a valid web address.',
            'job_url.max' => 'The job URL cannot exceed 500 characters.',

            'status.required' => 'The application status is required.',
            'status.in' => 'The selected status is not valid.',

            'priority.required' => 'The priority level is required.',
            'priority.in' => 'The selected priority is not valid.',

            'notes.string' => 'The notes must be a text string.',

            'application_date.required' => 'The application date is required.',
            'application_date.date' => 'The application date must be a valid date.',
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
            'company_name' => 'company name',
            'job_title' => 'job title',
            'job_url' => 'job URL',
            'status' => 'status',
            'priority' => 'priority',
            'notes' => 'notes',
            'application_date' => 'application date',
        ];
    }
}
