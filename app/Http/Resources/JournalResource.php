<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JournalResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'date'       => $this->date->format('Y-m-d'),
            'activity'   => $this->activity,
            'note'       => $this->note,
            'docs'       => $this->docs
                                ? asset('storage/' . $this->docs)
                                : null,
            'created_at' => $this->created_at,
        ];
    }
}
