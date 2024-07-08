<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $primaryKey = 'questionNo'; // Set the correct primary key

    protected $fillable = [
        'challengeNo',
        'question_text',
        'marks'
    ];


    // Define the relationship to Challenge
    public function challenge()
    {
        return $this->belongsTo(Challenge::class, 'challengeNo', 'challengeNo');
    }
}
