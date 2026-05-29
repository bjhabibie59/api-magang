<?php

namespace App\Http\Requests\Journal;

use App\Http\Requests\BaseRequest;
// use Illuminate\Foundation\Http\FormRequest;

class StoreJournalRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'date'     => 'required|date',
            'activity' => 'required|string|max:255',
            'note'     => 'nullable|string',
            'docs'     => 'nullable|file|mimes:pdf,doc,docx,png,jpg,jpeg|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'date.required'     => 'Tanggal wajib diisi.',
            'date.date'         => 'Format tanggal tidak valid.',
            'activity.required' => 'Aktivitas wajib diisi.',
            'activity.max'      => 'Aktivitas maksimal 255 karakter.',
            'docs.mimes'        => 'File harus berformat pdf, doc, docx, png, jpg, atau jpeg.',
            'docs.max'          => 'Ukuran file maksimal 2MB.',
        ];
    }
}
