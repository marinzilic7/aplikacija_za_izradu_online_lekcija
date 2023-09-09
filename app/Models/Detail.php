<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detail extends Model
{
    protected $fillable = [
        'lesson_id', 'tema', 'lekcija', 'image','video'
    ];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class,'lesson_id');
    }

    use HasFactory;
}
