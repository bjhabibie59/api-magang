<?php

namespace App\Http\Requests\Attendance;

use App\Http\Requests\BaseRequest;
// use Illuminate\Foundation\Http\FormRequest;

class CheckOutRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'latitude'  => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
        ];
    }

    public function messages(): array
    {
        return [
            'latitude.required'   => 'Latitude wajib diisi.',
            'latitude.between'    => 'Latitude tidak valid.',
            'longitude.required'  => 'Longitude wajib diisi.',
            'longitude.between'   => 'Longitude tidak valid.',
        ];
    }
}
