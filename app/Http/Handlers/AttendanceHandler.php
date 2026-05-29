<?php

namespace App\Http\Handlers;

use App\Helpers\Enum\AttendanceStatusEnum;
use App\Helpers\GeoHelper;
use App\Interfaces\AttendanceInterface;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Helpers\Api;

class AttendanceHandler
{
    // Radius maksimal dari lokasi internship dalam meter
    private const ALLOWED_RADIUS = 100;

    public function __construct(
        private readonly AttendanceInterface $attendanceRepository
    ) {}

    public function checkIn(array $data, $user): mixed
    {
        $student    = $user->student;
        $internship = $student->internship;

        // Validasi radius
        $isWithin = GeoHelper::isWithinRadius(
            lat1: $data['latitude'],
            lon1: $data['longitude'],
            lat2: $internship->latitude,
            lon2: $internship->longitude,
            radiusInMeters: self::ALLOWED_RADIUS
        );

        if (!$isWithin) {
            $distance = GeoHelper::distanceInMeters(
                $data['latitude'], $data['longitude'],
                $internship->latitude, $internship->longitude
            );

            throw new HttpResponseException(
                Api::error(
                    message: 'Anda berada di luar radius absensi. ' .
                              'Jarak Anda: ' . round($distance) . ' meter ' .
                              '(Maksimal: ' . self::ALLOWED_RADIUS . ' meter)',
                    statusCode: 422
                )
            );
        }

        // Cek sudah check-in hari ini
        $existing = $this->attendanceRepository->findTodayByStudent($student->id);

        if ($existing) {
            throw new HttpResponseException(
                Api::error(message: 'Anda sudah melakukan check-in hari ini.', statusCode: 409)
            );
        }

        return $this->attendanceRepository->create([
            'student_id' => $student->id,
            'date'       => today(),
            'check_in'   => now()->toTimeString(),
            'latitude'   => $data['latitude'],
            'longitude'  => $data['longitude'],
            'status'     => AttendanceStatusEnum::BELUM_CHECKOUT->value,
        ]);
    }

    public function checkOut(array $data, $user): mixed
    {
        $student = $user->student;

        $attendance = $this->attendanceRepository->findTodayByStudent($student->id);

        if (!$attendance) {
            throw new HttpResponseException(
                Api::error(message: 'Anda belum melakukan check-in hari ini.', statusCode: 404)
            );
        }

        if ($attendance->check_out) {
            throw new HttpResponseException(
                Api::error(message: 'Anda sudah melakukan check-out hari ini.', statusCode: 409)
            );
        }

        return $this->attendanceRepository->update($attendance->id, [
            'check_out' => now()->toTimeString(),
            'status'    => AttendanceStatusEnum::HADIR->value,
        ]);
    }

    public function myAttendance($user): mixed
    {
        return $this->attendanceRepository->findByStudent(
            studentId: $user->student->id,
            relations: []
        );
    }
}
