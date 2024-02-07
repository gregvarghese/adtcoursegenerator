<?php

namespace App\Http\Controllers\Api;

use App\Models\History;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\HistoryResource;
use App\Http\Resources\HistoryCollection;
use App\Http\Requests\HistoryStoreRequest;
use App\Http\Requests\HistoryUpdateRequest;

class HistoryController extends Controller
{
    public function index(Request $request): HistoryCollection
    {
        $this->authorize('view-any', History::class);

        $search = $request->get('search', '');

        $histories = History::search($search)
            ->latest()
            ->paginate();

        return new HistoryCollection($histories);
    }

    public function store(HistoryStoreRequest $request): HistoryResource
    {
        $this->authorize('create', History::class);

        $validated = $request->validated();

        $history = History::create($validated);

        return new HistoryResource($history);
    }

    public function show(Request $request, History $history): HistoryResource
    {
        $this->authorize('view', $history);

        return new HistoryResource($history);
    }

    public function update(
        HistoryUpdateRequest $request,
        History $history
    ): HistoryResource {
        $this->authorize('update', $history);

        $validated = $request->validated();

        $history->update($validated);

        return new HistoryResource($history);
    }

    public function destroy(Request $request, History $history): Response
    {
        $this->authorize('delete', $history);

        $history->delete();

        return response()->noContent();
    }
}
