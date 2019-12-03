
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

                                @include('shared._vote', [
                                    'model' => $answer
                                ])

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

                                        @include('shared._author', [
                                            'model' => $answer,
                                            'label' => 'Answered'
                                        ])

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