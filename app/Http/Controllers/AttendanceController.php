<?php

namespace App\Http\Controllers;

use App\Helpers\Api;
use App\Http\Handlers\AttendanceHandler;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function __construct(
        private readonly AttendanceHandler $handler
    ) {}

    public function checkIn(Request $request)
    {
        $validated = $request->validate([
            'latitude'  => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
        ]);

        $attendance = $this->handler->checkIn($validated, $request->user());

        return Api::created(
            data: $attendance,
            message: 'Check-in berhasil'
        );
    }

    public function checkOut(Request $request)
    {
        $validated = $request->validate([
            'latitude'  => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
        ]);

        $attendance = $this->handler->checkOut($validated, $request->user());

        return Api::success(
            data: $attendance,
            message: 'Check-out berhasil'
        );
    }

    public function index(Request $request)
    {
        $attendances = $this->handler->myAttendance($request->user());

        return Api::success(
            data: $attendances,
            message: 'Data absensi berhasil diambil'
        );
    }
}
