@extends('layout.HUdefault')
@section('title')
    Student details
@stop
@section('content')
    <?php
    use App\Student;
use App\WorkplaceLearningPeriod;

/* @var Student $student */
    ?>
    <div class="container-fluid">
        <div class="row">
            <!-- Profile Info -->
            <div class="col-md-4">

                <div class="panel panel-default">

                    <div class="panel-body">
                        <h3>Details</h3>

                        <div>
                            <p>
                                <strong>Studentnumber:</strong><br/>
                                {{ $student->studentnr }}

                            </p>
                            <p>
                                <strong>Name: </strong><br/>
                                {{ $student->firstname }}  {{ $student->lastname }}
                            </p>
                            <p>
                                <strong>E-mail:</strong><br/>
                                {{ $student->email }}
                            </p>

                            <p>
                                <strong>Canvas:</strong><br/>
                                @if($student->isCoupledToCanvasAccount())
                                    <span class="label label-success">Canvas attached</span>
                                @else
                                    <span class="label label-danger">No canvas</span>
                                @endif
                                @if($student->isRegisteredThroughCanvas())
                                    <span class="label label-info">Registered through canvas</span>
                                @else
                                    <span class="label label-info">Normal registration</span>
                                @endif
                            </p>


                            <hr/>


                                {{ Form::open() }}

                                <div class="form-group">
                                    <label for="user_level">User level</label>
                                    <br/>
                                    <select class="select form-control" id="user_level" name="user_level">
                                        <option value="student" @if($student->userlevel === 0) selected @endif>Student</option>
                                        <option value="teacher" @if($student->userlevel === 1) selected @endif>Teacher</option>
                                        <option value="admin" @if($student->userlevel === 2) selected @endif>Admin</option>
                                    </select>

                                    <br/>

                                    <button class="btn btn-success">Apply user level</button>

                                </div>

                                {{ Form::close() }}


                            <hr/>

                            <p>
                                @if($student->student_id !== Auth::user()->student_id)
                                    <a class="student-delete-link"
                                       data-url="{{ route('admin-student-delete', ['student' => $student]) }}">
                                        Delete student
                                    </a>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>


            </div>

            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-body">

                        <h3>Workplace learning periods</h3>

                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>Period</th>
                                    <th>Days</th>
                                    <th>Place</th>
                                    <th>Activities</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                /** @var WorkplaceLearningPeriod $wplp */
                                ?>
                                @foreach($student->workplaceLearningPeriods as $wplp)
                                    <tr>
                                        <td>{{ $wplp->startdate->format('d-m-Y') }}
                                            - {{ $wplp->enddate->format('d-m-Y') }}</td>
                                        <td>{{ $wplp->nrofdays }}</td>
                                        <td>{{ $wplp->workplace->wp_name }}</td>
                                        <td>
                                            @if($student->educationProgram->educationprogramType->isActing())
                                                {{ $wplp->learningActivityActing->count() }}
                                            @else
                                                {{ $wplp->learningActivityProducing->count() }}
                                            @endif
                                        </td>
                                        <td>
                                            <a class="wplp-delete-link"
                                               data-url="{{ route('admin-student-delete-wplp', ['student' => $student, 'workplacelearningperiod' => $wplp]) }}">
                                                Delete
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>

                </div>
            </div>


        </div>


    </div>
@stop



@section('scripts')
    <script>

        $('.wplp-delete-link').on('click', function () {
            if (confirm('This action will delete the workplace learning period and all its related entities, such as activities and user-created entities bound to these activities.')) {
                window.location.href = $(this).data('url');
            }
        });

        $('.student-delete-link').on('click', function () {
            if (confirm('This action will delete the student and all its related entities, such as workplaces, learning periods, activities and user-created entities bound to these.')) {
                window.location.href = $(this).data('url');
            }
        });

    </script>

@endsection


