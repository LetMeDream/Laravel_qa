
<script
			  src="https://code.jquery.com/jquery-3.4.1.min.js"
			  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
              crossorigin="anonymous"></script>
<script type="text/javascript" src="{!! asset('js/votingAnswers.js') !!}"></script>
@if ($answersCount > 0)
    <div class="row mt-4">

            <div class="col-md-12">

                <div class="card" v-cloak >

                        <div class="card-header" {{-- v-cloak is for this instance to wait until other have loaded completely. --}}>

                            <div class="card-title">
                                <h2>{{ $answersCount . ' ' . str::plural('Answer', $answersCount) }}</h2>
                            </div>

                        </div>

                        <div class="card-body">

                            @foreach ($answers->sortByDesc('real_votes') as $answer)

                                @include('answers._answer', ['answer' => $answer])

                            @endforeach

                        </div>



                </div>

            </div>

    </div>
@endif