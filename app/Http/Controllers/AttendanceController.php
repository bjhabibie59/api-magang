<?php

namespace App\Http\Controllers;

use App\Helpers\Api;
use App\Http\Handlers\AttendanceHandler;
use App\Http\Requests\Attendance\CheckInRequest;
use App\Http\Requests\Attendance\CheckOutRequest;
use App\Http\Resources\AttendanceResource;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function __construct(
        private readonly AttendanceHandler $handler
    ) {}

    public function index(Request $request)
    {
        $attendances = $this->handler->myAttendance($request->user());

        return Api::success(
            data: AttendanceResource::collection($attendances),
            message: 'Data absensi berhasil diambil'
        );
    }

    public function checkIn(CheckInRequest $request)
    {
        $attendance = $this->handler->checkIn($request->validated(), $request->user());

        return Api::created(
            data: new AttendanceResource($attendance),
            message: 'Check-in berhasil'
        );
    }

    public function checkOut(CheckOutRequest $request)
    {
        $attendance = $this->handler->checkOut($request->validated(), $request->user());

        return Api::success(
            data: new AttendanceResource($attendance),
            message: 'Check-out berhasil'
        );
    }
}
