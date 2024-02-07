<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Topic;
use App\Models\Course;
use App\Models\Section;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\TopicStoreRequest;
use App\Http\Requests\TopicUpdateRequest;

class TopicController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Topic::class);

        $search = $request->get('search', '');

        $topics = Topic::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.topics.index', compact('topics', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Topic::class);

        $sections = Section::pluck('name', 'id');
        $courses = Course::pluck('name', 'id');
        $users = User::pluck('name', 'id');

        return view(
            'app.topics.create',
            compact('sections', 'courses', 'users')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TopicStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Topic::class);

        $validated = $request->validated();

        $topic = Topic::create($validated);

        return redirect()
            ->route('topics.edit', $topic)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Topic $topic): View
    {
        $this->authorize('view', $topic);

        return view('app.topics.show', compact('topic'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Topic $topic): View
    {
        $this->authorize('update', $topic);

        $sections = Section::pluck('name', 'id');
        $courses = Course::pluck('name', 'id');
        $users = User::pluck('name', 'id');

        return view(
            'app.topics.edit',
            compact('topic', 'sections', 'courses', 'users')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        TopicUpdateRequest $request,
        Topic $topic
    ): RedirectResponse {
        $this->authorize('update', $topic);

        $validated = $request->validated();

        $topic->update($validated);

        return redirect()
            ->route('topics.edit', $topic)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Topic $topic): RedirectResponse
    {
        $this->authorize('delete', $topic);

        $topic->delete();

        return redirect()
            ->route('topics.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
