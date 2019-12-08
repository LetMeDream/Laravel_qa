@if ($model instanceof App\Question)

        <div class="d-flex flex-column  media-left vote-controls">
            <a
            onclick = 'event.preventDefault(); document.getElementById("up-vote-question/{{ $model->id }}").submit();'
            title='This question is useful' class='vote-up {{ auth::guest() ? 'off' : '' }}'>
                <i class='fas fa-caret-up fa-2x'></i>
            </a> {{-- The UP Voting is over here --}}
            <form hidden id='up-vote-question/{{ $model->id }}' action='{{ route('vote.question', $model->id) }} ' method='POST' >
                @csrf
                <input name='vote' value='1' type='hidden'>
            </form>
            <span class='votes-count'> {{ $model->real_votes }} </span>
            <a title='This question is not useful' class='vote-down {{ auth::guest() ? 'off' : '' }}'
                onclick = 'event.preventDefault(); document.getElementById("down-vote-question/{{ $model->id }}").submit();'>
                <i class='fas fa-caret-down fa-2x'></i>
            </a>
            <form id='down-vote-question/{{ $model->id }}' action='{{ route('vote.question', $model->id) }} ' method='POST' >
                @csrf
                <input name='vote' value='-1' type='hidden'>
            </form>

        {{--   @include('shared._favorite',[
                'model' => $model
            ])
        --}}

            <favorite :question='{{ $model }}'></favorite>

        </div>

@elseif($model instanceof App\Answer)
    <div class="d-flex flex-column  media-left vote-controls">

        <a
        title='This question is useful' class='vote-up {{ auth::guest() ? 'off' : '' }}'>
            <i class='fas fa-caret-up fa-2x'></i>
        </a>
        <form action="/answers/{{ $model->id }}/vote" hidden class='vote-up-answer' method='post'>
            <input type='hidden' name='vote' value='1'>
            @csrf
        </form>

        <span class='votes-count'>{{ $model->real_votes }}</span>

        <a
        title='This question is not useful' class='vote-down {{ auth::guest() ? 'off' : '' }}'>
            <i class='fas fa-caret-down fa-2x'></i>
        </a>
        <form action="/answers/{{ $model->id }}/vote" hidden class='vote-down-answer' method='post'>
            <input type='hidden' name='vote' value='-1'>
            @csrf
        </form>

        {{-- @include('shared._accept', [
            'model' => $model
        ]) --}}

        <accept :answer='{{ $model }}'></accept>

    </div>
@endif
