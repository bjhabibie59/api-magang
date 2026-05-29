<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'date'       => $this->date->format('Y-m-d'),
            'check_in'   => $this->check_in?->format('H:i:s'),
            'check_out'  => $this->check_out?->format('H:i:s'),
            'latitude'   => $this->latitude,
            'longitude'  => $this->longitude,
            'status'     => $this->status,
            'created_at' => $this->created_at,
        ];
    }
}
