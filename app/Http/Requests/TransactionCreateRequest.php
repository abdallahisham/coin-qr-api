<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransactionCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $sender = request()->user();

        return 0 !== $sender->balance;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'phone' => ['required'],
            'amount' => ['required'],
        ];
    }

    public function prepared()
    {
        return [
            request('phone'),
            request('amount'),
        ];
    }
}
