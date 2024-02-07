<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use App\Models\Section;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\SectionStoreRequest;
use App\Http\Requests\SectionUpdateRequest;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Section::class);

        $search = $request->get('search', '');

        $sections = Section::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.sections.index', compact('sections', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Section::class);

        $courses = Course::pluck('name', 'id');
        $users = User::pluck('name', 'id');

        return view('app.sections.create', compact('courses', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SectionStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Section::class);

        $validated = $request->validated();

        $section = Section::create($validated);

        return redirect()
            ->route('sections.edit', $section)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Section $section): View
    {
        $this->authorize('view', $section);

        return view('app.sections.show', compact('section'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Section $section): View
    {
        $this->authorize('update', $section);

        $courses = Course::pluck('name', 'id');
        $users = User::pluck('name', 'id');

        return view(
            'app.sections.edit',
            compact('section', 'courses', 'users')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        SectionUpdateRequest $request,
        Section $section
    ): RedirectResponse {
        $this->authorize('update', $section);

        $validated = $request->validated();

        $section->update($validated);

        return redirect()
            ->route('sections.edit', $section)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        Section $section
    ): RedirectResponse {
        $this->authorize('delete', $section);

        $section->delete();

        return redirect()
            ->route('sections.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
