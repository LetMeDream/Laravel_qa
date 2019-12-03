
<script
			  src="https://code.jquery.com/jquery-3.4.1.min.js"
			  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
              crossorigin="anonymous"></script>
<script type="text/javascript" src="{!! asset('js/votingAnswers.js') !!}"></script>
<div class="row mt-4">

        <div class="col-md-12">

            <div class="card">

                <div class="card-header">

                    <div class="card-title">
                        <h2>{{ $answersCount . ' ' . str::plural('Answer', $answersCount) }}</h2>
                    </div>

                </div>

                <div class="card-body">

                    @foreach ($answers as $answer)

                        <div class="media mt-2">
                            <!-- Vote controls -->
                            <div class="d-flex flex-column  media-left vote-controls">

                                    <a
                                    title='This question is useful' class='vote-up'>
                                        <i class='fas fa-caret-up fa-2x'></i>
                                    </a>
                                    <form action="/questions/{{ $answer->question->id }}/answer/{{ $answer->id }}/vote" hidden class='vote-up-answer' method='post'>
                                        <input type='hidden' name='vote' value='1'>
                                        @csrf
                                    </form>

                                    <span class='votes-count'>{{ $answer->real_votes }}</span>

                                    <a
                                    title='This question is not useful' class='vote-down off'>
                                        <i class='fas fa-caret-down fa-2x'></i>
                                    </a>
                                    <form action="/questions/{{ $answer->question->id }}/answer/{{ $answer->id }}/vote" hidden class='vote-down-answer' method='post'>
                                        <input type='hidden' name='vote' value='-1'>
                                        @csrf
                                    </form>

                                    @can('accept_answer', $answer)

                                        <a title='Mark this as best answer'
                                        onclick="event.preventDefault(); document.getElementById('accept-answer-{{$answer->id}}').submit();"
                                            class='mt-2 {{ $answer->status }}'>
                                            <i class='fas fa-check fa-2x'></i>
                                        </a>
                                        <form id='accept-answer-{{$answer->id}}' action='{{ route('answers.accept', $answer->id) }}' method='POST' style='display:none;'>
                                            @csrf
                                        </form>
                                    @else
                                        @if($answer->is_best)
                                            <a title='The question owner accepted this answer as the BEST'
                                                class='mt-2 {{ $answer->status }}'>
                                                <i class='fas fa-check fa-2x'></i>
                                            </a>
                                        @endif

                                    @endcan



                            </div>
                            <!-- Vote controls -->
                            <div class="media-body">
                                    {!! $answer->body_html !!}

                                <div class="row">
                                    <div class="col-4">
                                        <!-- Delete and updte stuff -->
                                        <div class='float-left'>
                                                @if (Gate::allows('update', $answer))
                                                    <a href='{{ route("questions.answers.edit", [$question->id ,$answer->id]) }}' class='btn btn-sm btn-outline-info'>Edit</a>
                                                @endif
                                                @if (Gate::allows('delete', $answer))
                                                    <form action='{{ route("questions.answers.destroy", [$question->id, $answer->id]) }}' method='post' class='d-inline'>
                                                        @method('delete')
                                                        @csrf
                                                        <button class='btn btn-outline-danger btn-sm' onclick="return confirm('Are you sure?')" type='submit'>Delete</button>
                                                    </form>
                                                @endif
                                        </div>
                                        <!-- Delete and updte stuff -->
                                    </div>
                                    <div class="col-5"></div>
                                    <div class="col-3">
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
                        </div>
                        <hr>
                    @endforeach

                </div>

            </div>

        </div>

</div>