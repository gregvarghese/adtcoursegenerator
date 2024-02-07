<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Topic extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'title',
        'prompt',
        'json',
        'markdown',
        'html',
        'complete',
        'section_id',
        'course_id',
        'user_id',
    ];

    protected $searchableFields = ['*'];

    protected $casts = [
        'complete' => 'boolean',
    ];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function histories()
    {
        return $this->hasMany(History::class);
    }
}
