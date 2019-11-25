@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">All of the questions</div>

                <div class="card-body">
                    @foreach ($questions as $question)
                    <div class='media'>
                        <div class="media-body">
                            <p class='lead'>
                                Asked By
                                <a href=' {{ $question->user->url }} '> {{ $question->user->name }} </a>
                                <small class='text-muted'> {{ $question->created_date }} </small>
                            </p>

                            <div>
                                <h5><a href='{{ $question->url }}' >{{ $question->title }}</a></h5>
                            </div>
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
                                            {{ $question->answers }}
                                        </strong>
                                        {{ Str::plural('answer', $question->answers) }}
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
