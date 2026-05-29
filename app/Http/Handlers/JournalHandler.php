<?php

namespace App\Http\Handlers;

use App\Interfaces\JournalInterface;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Helpers\Api;

class JournalHandler
{
    public function __construct(
        private readonly JournalInterface $journalRepository
    ) {}

    public function getAll($user): mixed
    {
        $user->loadMissing('student');

        return $this->journalRepository->findByStudent($user->student->id);
    }

    public function findById($user, string $id): mixed
    {
        $user->loadMissing('student');

        return $this->journalRepository->findByStudentAndId($user->student->id, $id);
    }

    public function create(array $data, $user): mixed
    {
        $user->loadMissing('student');

        // Cek jurnal di tanggal yang sama - PAKAI METHOD BARU
        $exists = $this->journalRepository->existsByStudentAndDate(
            $user->student->id,
            $data['date']
        );

        if ($exists) {
            throw new HttpResponseException(
                Api::error(
                    message: 'Jurnal untuk tanggal ini sudah ada.',
                    statusCode: 409
                )
            );
        }

        // Handle upload file docs jika ada
        if (isset($data['docs'])) {
            $data['docs'] = $data['docs']->store('journals/docs', 'public');
        }

        return $this->journalRepository->create([
            'student_id' => $user->student->id,
            'date'       => $data['date'],
            'activity'   => $data['activity'],
            'note'       => $data['note'] ?? null,
            'docs'       => $data['docs'] ?? null,
        ]);
    }

    public function update(array $data, $user, string $id): mixed
    {
        $user->loadMissing('student');

        // Pastikan jurnal milik student yang login
        $journal = $this->journalRepository->findByStudentAndId($user->student->id, $id);

        // CEK JIKA TANGGAL DIUBAH DAN SUDAH ADA JURNAL LAIN DI TANGGAL TERSEBUT
        if (isset($data['date']) && $data['date'] !== $journal->date) {
            $exists = $this->journalRepository->existsByStudentAndDate(
                $user->student->id,
                $data['date']
            );

            if ($exists) {
                throw new HttpResponseException(
                    Api::error(
                        message: 'Jurnal untuk tanggal ini sudah ada.',
                        statusCode: 409
                    )
                );
            }
        }

        // Handle upload file docs jika ada
        if (isset($data['docs'])) {
            // Hapus file lama jika ada
            if ($journal->docs) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($journal->docs);
            }
            $data['docs'] = $data['docs']->store('journals/docs', 'public');
        }

        return $this->journalRepository->update($id, [
            'date'     => $data['date'] ?? $journal->date,
            'activity' => $data['activity'] ?? $journal->activity,
            'note'     => $data['note'] ?? $journal->note,
            'docs'     => $data['docs'] ?? $journal->docs,
        ]);
    }

    public function delete($user, string $id): bool
    {
        $user->loadMissing('student');

        $journal = $this->journalRepository->findByStudentAndId($user->student->id, $id);

        // Hapus file docs jika ada
        if ($journal->docs) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($journal->docs);
        }

        return $this->journalRepository->delete($id);
    }
}
