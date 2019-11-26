@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">



                    </div>


                </div>

                <div class="card-body">

                    <div class='media'>
                        <div class="media-body">
                            <div class="d-flex align-items-center">
                            <div>
                                    <h1>{{ $question->title }}</h1>
                            </div>
                                <div class="ml-auto">
                                    @if(Gate::allows('edit-question', $question))
                                        <a href='{{ route("questions.edit", $question->id) }}' class='btn btn-sm btn-outline-info'>Edit</a>
                                    @endif
                                    @if(Gate::allows('delete-question', $question))
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
                                    {{-- {{ $question->body }} --}}

                                    {!! $question->body_html !!}
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


                </div>
            </div>
        </div>
    </div>
</div>
@endsection
