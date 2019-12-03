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

                            @include('shared._vote', [
                                'model' => $question
                            ])

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
                                            @include('shared._author', [
                                            'model' => $question,
                                            'label' => 'Asked'
                                        ])
                                    </div>
                            </div>
                        </div>
                        <div class="d-flex flex-column counters media-right">

                                <div class="votes">
                                    <strong>
                                        {{ $question->real_votes }}
                                    </strong>
                                    {{ Str::plural('vote', $question->real_votes) }}
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
