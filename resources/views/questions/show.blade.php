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

                                <a href='{{ route("questions.index") }}' class='btn btn-outline-secondary'>Back to all questions</a>

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
                            @auth
                                <a
                                onclick = 'event.preventDefault(); document.getElementById("favoriteQuestion/{{ $question->id }}").submit();'
                                title='Click to mark as favorite (click again to undo)' class='mt-2 favorite {{ $question->beenFavorited }}'>
                                    <i class='fas fa-star fa-2x'></i>
                                </a>
                                <form id='favoriteQuestion/{{ $question->id }}' action='{{ route('favorite.question', $question->id) }} ' method='POST' >
                                    @csrf
                                </form>
                            @else
                                <a
                                onclick = 'event.preventDefault(); document.getElementById("favoriteQuestion/{{ $question->id }}").submit();'
                                title='Click to mark as favorite (click again to undo)' class='mt-2 favorite'>
                                    <i class='fas fa-star fa-2x'></i>
                                </a>
                                <form id='favoriteQuestion/{{ $question->id }}' action='{{ route('favorite.question', $question->id) }} ' method='POST' >
                                    @csrf
                                </form>
                            @endauth
                            <span class='favorites-count'>{{$question->isFavoritedCount}}</span>
                        </div>
                        <!-- Vote controls -->


                        <div class="media-body">
                            <div>
                                <p>
                                    {{-- {{ $question->body }} --}}

                                    {!! $question->body_html !!}
                                </p>
                            </div>
                            <div class="row">
                                    <div class="col-4">
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
                                    <div class="col-5"></div>
                                    <div class="col-3">
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

                </div>
            </div>
        </div>
    </div>

    @include('layouts._messages')

    @include('answers._index', [
        'answersCount' => $question->answers_count,
        'answers' => $question->answers
    ])

    @include('answers._create')
</div>
@endsection
