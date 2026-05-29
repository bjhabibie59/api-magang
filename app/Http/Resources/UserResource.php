<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'       => $this->id,
            'name'     => $this->name,
            'username' => $this->username,
            'email'    => $this->email,
            'role'     => $this->getRole(),
            'profile'  => $this->whenLoaded('teacher', fn() => [
                'nip'   => $this->teacher->nip,
                'phone' => $this->teacher->phone,
            ]) ?? $this->whenLoaded('student', fn() => [
                'nis'     => $this->student->nis,
                'class'   => $this->student->class,
                'phone'   => $this->student->phone,
                'address' => $this->student->address,
            ]),
            'created_at' => $this->created_at,
        ];
    }
}
