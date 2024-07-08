<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\Challenge;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Models\Answer;

class AdminController extends Controller
{
    public function index()
    {
        $schools = School::all();
        $challenges = Challenge::all();
        $questions = Question::with('challenge')->get(); // Eager load challenge relation
        return view('admin.dashboard', compact('schools', 'challenges', 'questions'));
    }

    public function uploadSchool(Request $request)
    {
        $request->validate([
            'schoolRegNo' => 'required|unique:schools',
            'name' => 'required',
            'district' => 'required'
        ]);

        School::create($request->all());

        return back()->with('success', 'School uploaded successfully!');
    }

    public function createChallenge(Request $request)
    {

        try {
            $request->validate([
                'challengeName' => 'required',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after:start_date',
                'question_count' => 'required|integer',
                'duration' => 'required|integer'
            ]);

            Challenge::create($request->all());

            return back()->with('success', 'Challenge created successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Error creating challenge! ', $e);
        }
    }

    public function uploadQuestions(Request $request)
    {
        $request->validate([
            'challengeNo' => 'required|exists:challenges,challengeNo',
            'question_text' => 'required',
            'marks' => 'required|integer'
        ]);

        Question::create($request->all());

        return back()->with('success', 'Question uploaded successfully!');
    }

    public function uploadAnswer(Request $request)
    {
        $request->validate([
            'questionNo' => 'required|exists:questions,questionNo',
            'start_time' => 'required|date',
            'duration' => 'required|integer',
            'answer_text' => 'required'
        ]);

        Answer::create($request->all());

        return back()->with('success', 'Answer uploaded successfully!');
    }

    public function deleteSchool($schoolRegNo)
    {
        $school = School::findOrFail($schoolRegNo);
        $school->delete();
        return back()->with('success', 'School deleted successfully!');
    }

    public function deleteChallenge($challengeNo)
    {
        $challenge = Challenge::findOrFail($challengeNo);
        $challenge->delete();
        return back()->with('success', 'Challenge deleted successfully!');
    }

    public function deleteQuestion($questionNo)
    {
        $question = Question::findOrFail($questionNo);
        $question->delete();
        return back()->with('success', 'Question deleted successfully!');
    }
}
