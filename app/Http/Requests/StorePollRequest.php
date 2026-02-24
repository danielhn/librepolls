<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePollRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        // Remove unfilled fields, and any other unwanted key
        $filledChoices = [];
        foreach ($this->choices as $choice) {
            if ($choice['text']) {
                $filledChoices[] = ['text' => $choice['text']];
            }
        }

        $this->merge(['choices' => $filledChoices]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['string', 'max:' . config('librepolls.polls.title_max_length'), 'required'],
            'description' => ['string', 'max:' . config('librepolls.polls.description_max_length'), 'nullable'],
            'multiple-choices' => ['accepted', 'sometimes'],
            'voter-identifier' => ['in:ip,token,none', 'required'],
            'choices' => ['array', 'required', 'max:' . config('librepolls.choices.max_per_poll')],
            'choices.1.text' => ['required'],
            'choices.2.text' => ['required'],
            'choices.*.text' => ['nullable', 'max:' . config('librepolls.choices.max_text_length'), 'string']
        ];
    }
}
