<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Challenge extends Model
{
    use HasFactory;

    protected $primaryKey = 'challengeNo'; // Set the correct primary key

    protected $fillable = [
        'challengeName',
        'start_date',
        'end_date',
        'question_count',
        'duration'
    ];
}
