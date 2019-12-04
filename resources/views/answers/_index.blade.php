
<script
			  src="https://code.jquery.com/jquery-3.4.1.min.js"
			  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
              crossorigin="anonymous"></script>
<script type="text/javascript" src="{!! asset('js/votingAnswers.js') !!}"></script>
<div class="row mt-4">

        <div class="col-md-12">

            <div class="card">
                @if ($answersCount > 0)
                    <div class="card-header">

                        <div class="card-title">
                            <h2>{{ $answersCount . ' ' . str::plural('Answer', $answersCount) }}</h2>
                        </div>

                    </div>

                    <div class="card-body">

                        @foreach ($answers->sortByDesc('real_votes') as $answer)

                            @include('answers.answers', ['answer' => $answer])

                        @endforeach

                    </div>

                @endif

            </div>

        </div>

</div>