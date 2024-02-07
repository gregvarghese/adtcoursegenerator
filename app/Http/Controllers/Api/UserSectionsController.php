<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SectionResource;
use App\Http\Resources\SectionCollection;

class UserSectionsController extends Controller
{
    public function index(Request $request, User $user): SectionCollection
    {
        $this->authorize('view', $user);

        $search = $request->get('search', '');

        $sections = $user
            ->sections()
            ->search($search)
            ->latest()
            ->paginate();

        return new SectionCollection($sections);
    }

    public function store(Request $request, User $user): SectionResource
    {
        $this->authorize('create', Section::class);

        $validated = $request->validate([
            'name' => ['required', 'max:255', 'string'],
            'description' => ['required', 'max:255', 'string'],
            'course_id' => ['required', 'exists:courses,id'],
        ]);

        $section = $user->sections()->create($validated);

        return new SectionResource($section);
    }
}
