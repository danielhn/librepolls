<?php

namespace App\Http\Requests;

use App\Models\Poll;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreVoteRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'choices' => ['array', 'required', 'max:' . config('librepolls.choices.max_per_poll')],
            'choices.*' => ['integer', 'required',
                Rule::exists('App\Models\Choice', 'id')
                    ->where('poll_id', $this->poll->id)
            ]
        ];
    }
}
