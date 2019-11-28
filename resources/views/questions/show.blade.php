<link href="{{ asset('css/app.css') }}" rel="stylesheet">
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                {{-- <div class="card-body"></div> --}}
                <div class="card-header">
                    <div class="d-flex align-items-center">

                            <div>
                                    <h1>{{ $question->title }}</h1>
                            </div>
                            <div class="ml-auto">
                                @can ('update', $question)
                                    <a href='{{ route("questions.edit", $question->id) }}' class='btn btn-sm btn-outline-info'>Edit</a>
                                @endcan
                                @can('delete', $question)
                                    <form action='{{ route("questions.destroy", $question->id) }}' method='post' class='d-inline'>
                                        @method('delete')
                                        @csrf
                                        <button class='btn btn-outline-danger btn-sm' onclick="return confirm('Are you sure?')" type='submit'>Delete</button>
                                    </form>
                                @endcan
                            </div>

                    </div>


                </div>

                <div class="card-body">

                    <div class='media'>
                        <!-- Vote controls -->
                        <div class="d-flex flex-column  media-left vote-controls">
                            <a title='This question is useful' class='vote-up'>
                                <i class='fas fa-caret-up fa-2x'></i>
                            </a>
                            <span class='votes-count'>1230</span>
                            <a title='This question is not useful' class='vote-down off'>
                                <i class='fas fa-caret-down fa-2x'></i>
                            </a>
                            <a title='Click to mark as favorite (click again to undo)' class='mt-2 favorite favorited'>
                                <i class='fas fa-star'></i>
                            </a>
                            <span class='favorites-count'>123</span>
                        </div>
                        <!-- Vote controls -->


                        <div class="media-body">
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
                                            {{ $question->answers_count }}
                                        </strong>
                                        {{ Str::plural('answer', $question->answers_count) }}
                                </div>
                                <div class="views">

                                    {{ $question->views . ' ' . Str::plural('view', $question->views) }}
                                </div>
                        </div>

                    </div>
                    <div class="float-right">
                            <span class='text-muted'>{{$question->created_date}}</span>
                            <div class="media mt-1">
                                <a href='{{ $question->user->url }}' class='pr-2' >
                                    <img src=' {{ $question->user->avatar }} '>
                                </a>
                                <div class="media-body mt-1">
                                    <a href='{{ $question->user->url }}' class='pr-2' >
                                         {{ $question->user->name }}
                                    </a>
                                </div>
                            </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">

        <div class="col-md-12">

            <div class="card">

                <div class="card-header">

                    <div class="card-title">
                        <h2>{{ $question->answers_count . ' ' . str::plural('Answer', $question->answers_count) }}</h2>
                    </div>

                </div>

                <div class="card-body">

                    @foreach ($question->answers as $answer)

                        <div class="media mt-2">
                            <!-- Vote controls -->
                            <div class="d-flex flex-column  media-left vote-controls">
                                <a title='This question is useful' class='vote-up'>
                                    <i class='fas fa-caret-up fa-2x'></i>
                                </a>
                                <span class='votes-count'>123</span>
                                <a title='This question is not useful' class='vote-down off'>
                                    <i class='fas fa-caret-down fa-2x'></i>
                                </a>
                                <a title='Mark this as best answer' class='mt-2 vote-accept'>
                                    <i class='fas fa-check fa-2x'></i>
                                </a>
                                {{-- <span class='favorites-count'>13</span> --}}
                            </div>
                            <!-- Vote controls -->
                            <div class="media-body">
                                    {!! $answer->body_html !!}
                                <div class="float-right">
                                    <span class='text-muted'>{{$answer->created_date}}</span>
                                    <div class="media mt-1">
                                        <a href='{{ $answer->user->url }}' class='pr-2' >
                                            <img src=' {{ $answer->user->avatar }} '>
                                        </a>
                                        <div class="media-body mt-1">
                                            <a href='{{ $answer->user->url }}' class='pr-2' >
                                                 {{ $answer->user->name }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                    @endforeach

                </div>

            </div>

        </div>

    </div>
</div>
@endsection
