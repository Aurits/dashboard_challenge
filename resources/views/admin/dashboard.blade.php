@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Administrator Dashboard</h1>

    <!-- Session Messages -->
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <!-- Quick Insights Cards -->
    <div class="row mb-4">
        <!-- Schools Card -->
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Schools</h5>
                    <p class="card-text">{{ \App\Models\School::count() }} schools registered</p>
                    <a href="#" class="btn btn-primary">View Schools</a>
                </div>
            </div>
        </div>

        <!-- Challenges Card -->
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Challenges</h5>
                    <p class="card-text">{{ \App\Models\Challenge::count() }} challenges created</p>
                    <a href="#" class="btn btn-primary">View Challenges</a>
                </div>
            </div>
        </div>

        <!-- Questions Card -->
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Questions</h5>
                    <p class="card-text">{{ \App\Models\Question::count() }} questions uploaded</p>
                    <a href="#" class="btn btn-primary">View Questions</a>
                </div>
            </div>
        </div>

        <!-- Answers Card -->
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Answers</h5>
                    <p class="card-text">{{ \App\Models\Answer::count() }} answers uploaded</p>
                    <a href="#" class="btn btn-primary">View Answers</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Tables for Schools, Challenges, Questions -->
    <!-- Schools Table -->
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-school"></i> Schools
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Reg No</th>
                            <th>Name</th>
                            <th>District</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Populate with schools data -->
                        @foreach($schools as $school)
                        <tr>
                            <td>{{ $school->schoolRegNo }}</td>
                            <td>{{ $school->name }}</td>
                            <td>{{ $school->district }}</td>
                            <td>
                                <!-- Add delete button with icon -->
                                <form action="{{ route('admin.deleteSchool', $school->schoolRegNo) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Challenges Table -->
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-trophy"></i> Challenges
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Populate with challenges data -->
                        @foreach($challenges as $challenge)
                        <tr>
                            <td>{{ $challenge->challengeName }}</td>
                            <td>{{ \Carbon\Carbon::parse($challenge->start_date)->format('M d, Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($challenge->end_date)->format('M d, Y') }}</td>
                            <td>
                                <!-- Add delete button with icon -->
                                <form action="{{ route('admin.deleteChallenge', $challenge->challengeNo) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Questions Table -->
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-question-circle"></i> Questions
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Challenge</th>
                            <th>Question</th>
                            <th>Marks</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Populate with questions data -->
                        @foreach($questions as $question)
                        <tr>
                            <td>{{ $question->challenge->challengeName }}</td>
                            <td>{{ $question->question_text }}</td>
                            <td>{{ $question->marks }}</td>
                            <td>
                                <!-- Add delete button with icon -->
                                <form action="{{ route('admin.deleteQuestion', $question->questionNo) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Triggers for Forms -->
    <button type="button" class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#schoolUploadModal">Upload
        School</button>
    <button type="button" class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#challengeCreationModal">Create Challenge</button>
    <button type="button" class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#questionUploadModal">Upload Question</button>
    <button type="button" class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#answerUploadModal">Upload
        Answer</button>

    <!-- Modal Structures -->

    <!-- School Upload Modal -->
    <div class="modal fade" id="schoolUploadModal" tabindex="-1" aria-labelledby="schoolUploadModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="schoolUploadModalLabel">Upload School</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.uploadSchool') }}" method="POST">
                        @csrf
                        <div class="row mb-3">
                            <div class="col">
                                <label for="schoolRegNo">School Registration Number</label>
                                <input type="text" class="form-control" id="schoolRegNo" name="schoolRegNo" required>
                            </div>
                            <div class="col">
                                <label for="name">School Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="district">District</label>
                            <input type="text" class="form-control" id="district" name="district" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Upload School</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Challenge Creation Modal -->
    <div class="modal fade" id="challengeCreationModal" tabindex="-1" aria-labelledby="challengeCreationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="challengeCreationModalLabel">Create Challenge</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.createChallenge') }}" method="POST">
                        @csrf
                        <div class="row mb-3">
                            <div class="col">
                                <label for="challengeName">Challenge Name</label>
                                <input type="text" class="form-control" id="challengeName" name="challengeName" required>
                            </div>
                            <div class="col">
                                <label for="start_date">Start Date</label>
                                <input type="date" class="form-control" id="start_date" name="start_date" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="end_date">End Date</label>
                                <input type="date" class="form-control" id="end_date" name="end_date" required>
                            </div>
                            <div class="col">
                                <label for="question_count">Question Count</label>
                                <input type="number" class="form-control" id="question_count" name="question_count" required>
                            </div>
                            <div class="col">
                                <label for="duration">Duration (in minutes)</label>
                                <input type="number" class="form-control" id="duration" name="duration" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Create Challenge</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Question Upload Modal -->
    <div class="modal fade" id="questionUploadModal" tabindex="-1" aria-labelledby="questionUploadModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="questionUploadModalLabel">Upload Question</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.uploadQuestions') }}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="challengeNo">Challenge</label>
                            <select class="form-control" id="challengeNo" name="challengeNo" required>
                                <option value="">Select Challenge</option>
                                @foreach($challenges as $challenge)
                                <option value="{{ $challenge->challengeNo }}">{{ $challenge->challengeName }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="question_text">Question Text</label>
                            <textarea class="form-control" id="question_text" name="question_text" required></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="marks">Marks</label>
                            <input type="number" class="form-control" id="marks" name="marks" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Upload Question</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Answer Upload Modal -->
    <div class="modal fade" id="answerUploadModal" tabindex="-1" aria-labelledby="answerUploadModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="answerUploadModalLabel">Upload Answer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.uploadAnswer') }}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="questionNo">Question</label>
                            <select class="form-control" id="questionNo" name="questionNo" required>
                                <option value="">Select Question</option>
                                @foreach($questions as $question)
                                <option value="{{ $question->questionNo }}">{{ $question->question_text }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="start_time">Start Time</label>
                                <input type="datetime-local" class="form-control" id="start_time" name="start_time" required>
                            </div>
                            <div class="col">
                                <label for="duration">Duration (in seconds)</label>
                                <input type="number" class="form-control" id="duration" name="duration" required>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="answer_text">Answer Text</label>
                            <textarea class="form-control" id="answer_text" name="answer_text" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Upload Answer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection


@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
@endsection