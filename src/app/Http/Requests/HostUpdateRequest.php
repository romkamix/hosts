<?php

namespace Romkamix\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class HostUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => [
                'required',
                Rule::unique('hosts')
                    ->ignore($this->id)
                    ->where(fn ($query) => $query->where('user_id', $this->user_id))
            ],
            'host' => 'required',
            'port' => 'nullable|integer',
        ];
    }
}
