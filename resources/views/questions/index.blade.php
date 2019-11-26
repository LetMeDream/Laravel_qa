@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                            <h2>All of the questions</h2>
                            <div class="ml-auto">
                                <a class='btn btn-outline-secondary' href='{{route("questions.create")}}'>Ask a question</a>
                            </div>
                    </div>


                </div>

                <div class="card-body">
                    @include('layouts._messages')
                    @foreach ($questions as $question)
                    <div class='media'>
                        <div class="media-body">
                            <div class="d-flex align-items-center">
                            <div>
                                    <h5><a href='{{ $question->url }}' >{{ $question->title }}</a></h5>
                            </div>

                                <div class="ml-auto">
                                    @if (Gate::allows('update', $question))
                                        <a href='{{ route("questions.edit", $question->id) }}' class='btn btn-sm btn-outline-info'>Edit</a>
                                    @endif
                                    @if (Gate::allows('delete', $question))
                                        <form action='{{ route("questions.destroy", $question->id) }}' method='post' class='d-inline'>
                                            @method('delete')
                                            @csrf
                                            <button class='btn btn-outline-danger btn-sm' onclick="return confirm('Are you sure?')" type='submit'>Delete</button>
                                        </form>
                                    @endif
                                </div>


                        </div>
                            <p class='lead'>
                                Asked By
                                <a href=' {{ $question->user->url }} '> {{ $question->user->name }} </a>
                                <small class='text-muted'> {{ $question->created_date }} </small>
                            </p>
                            <div>
                                <p>
                                    {{ Str::limit($question->body, 200) }}
                                </p>
                            </div>
                        </div>
                        <div class="d-flex flex-column counters media-right">

                                <div class="votes">
                                    <strong>
                                        {{ $question->votes }}
                                    </strong>
                                    {{ Str::plural('vote', $question->votes) }}
                                </div>
                                <div class="status {{ $question->status }} ">
                                        <strong>
                                            {{ $question->answers_count }}
                                        </strong>
                                        {{ Str::plural('answer', $question->answers_count) }}
                                </div>
                                <div class="views">

                                    {{ $question->views . ' ' . Str::plural('view', $question->views) }}
                                </div>
                        </div>
                    </div>
                    <hr>
                    @endforeach

                    <div class="mx-auto" style='display:block;width:140px;'>
                        {{ $questions->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
