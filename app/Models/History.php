<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class History extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'prompt',
        'json',
        'markdown',
        'html',
        'topic_id',
        'section_id',
        'course_id',
        'user_id',
    ];

    protected $searchableFields = ['*'];

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

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
}
