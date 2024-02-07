<?php

namespace App\Http\Controllers\Api;

use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\TopicResource;
use App\Http\Resources\TopicCollection;
use App\Http\Requests\TopicStoreRequest;
use App\Http\Requests\TopicUpdateRequest;

class TopicController extends Controller
{
    public function index(Request $request): TopicCollection
    {
        $this->authorize('view-any', Topic::class);

        $search = $request->get('search', '');

        $topics = Topic::search($search)
            ->latest()
            ->paginate();

        return new TopicCollection($topics);
    }

    public function store(TopicStoreRequest $request): TopicResource
    {
        $this->authorize('create', Topic::class);

        $validated = $request->validated();

        $topic = Topic::create($validated);

        return new TopicResource($topic);
    }

    public function show(Request $request, Topic $topic): TopicResource
    {
        $this->authorize('view', $topic);

        return new TopicResource($topic);
    }

    public function update(
        TopicUpdateRequest $request,
        Topic $topic
    ): TopicResource {
        $this->authorize('update', $topic);

        $validated = $request->validated();

        $topic->update($validated);

        return new TopicResource($topic);
    }

    public function destroy(Request $request, Topic $topic): Response
    {
        $this->authorize('delete', $topic);

        $topic->delete();

        return response()->noContent();
    }
}
