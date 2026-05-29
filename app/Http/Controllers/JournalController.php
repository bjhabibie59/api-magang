<?php

namespace App\Http\Controllers;

use App\Helpers\Api;
use App\Http\Handlers\JournalHandler;
use App\Http\Requests\Journal\StoreJournalRequest;
use App\Http\Requests\Journal\UpdateJournalRequest;
use App\Http\Resources\JournalResource;
use Illuminate\Http\Request;

class JournalController extends Controller
{
    public function __construct(
        private readonly JournalHandler $handler
    ) {}

    public function index(Request $request)
    {
        $journals = $this->handler->getAll($request->user());

        return Api::success(
            data: JournalResource::collection($journals),
            message: 'Data jurnal berhasil diambil'
        );
    }

    public function show(Request $request, string $id)
    {
        $journal = $this->handler->findById($request->user(), $id);

        return Api::success(
            data: new JournalResource($journal),
            message: 'Detail jurnal berhasil diambil'
        );
    }

    public function store(StoreJournalRequest $request)
    {
        $journal = $this->handler->create($request->validated(), $request->user());

        return Api::created(
            data: new JournalResource($journal),
            message: 'Jurnal berhasil dibuat'
        );
    }

    public function update(UpdateJournalRequest $request, string $id)
    {
        $journal = $this->handler->update($request->validated(), $request->user(), $id);

        return Api::success(
            data: new JournalResource($journal),
            message: 'Jurnal berhasil diupdate'
        );
    }

    public function destroy(Request $request, string $id)
    {
        $this->handler->delete($request->user(), $id);

        return Api::success(
            data: null,
            message: 'Jurnal berhasil dihapus'
        );
    }
}
