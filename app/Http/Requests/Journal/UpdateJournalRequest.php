<?php

namespace App\Http\Requests\Journal;

use App\Http\Requests\BaseRequest;
// use Illuminate\Foundation\Http\FormRequest;

class UpdateJournalRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'date'     => 'sometimes|date',
            'activity' => 'sometimes|string|max:255',
            'note'     => 'nullable|string',
            'docs'     => 'nullable|file|mimes:pdf,doc,docx,png,jpg,jpeg|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'date.date'         => 'Format tanggal tidak valid.',
            'activity.max'      => 'Aktivitas maksimal 255 karakter.',
            'docs.mimes'        => 'File harus berformat pdf, doc, docx, png, jpg, atau jpeg.',
            'docs.max'          => 'Ukuran file maksimal 2MB.',
        ];
    }
}
