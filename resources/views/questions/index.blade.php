@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">All of the questions</div>

                <div class="card-body">
                    @foreach ($questions as $question)
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
