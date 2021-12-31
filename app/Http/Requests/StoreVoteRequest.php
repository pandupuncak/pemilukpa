<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVoteRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        $isIrv = false;
        if ($isIrv) {
            return [
                'president' => 'required', // IRV vote example: "1-2-3"
            ];
        } else {
            return [
                'president' => 'required|min:0|max:3', // 0 -> Abstain
            ];
        }
    }
}
