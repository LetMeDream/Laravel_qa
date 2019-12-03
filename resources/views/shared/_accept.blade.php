@can('accept_answer', $model)

    <a title='Mark this as best answer'
    onclick="event.preventDefault(); document.getElementById('accept-answer-{{$model->id}}').submit();"
        class='mt-2 {{ $model->status }}'>
        <i class='fas fa-check fa-2x'></i>
    </a>
    <form id='accept-answer-{{$model->id}}' action='{{ route('answers.accept', $model->id) }}' method='POST' style='display:none;'>
        @csrf
    </form>
@else
    @if($model->is_best)
        <a title='The question owner accepted this answer as the BEST'
            class='mt-2 {{ $model->status }}'>
            <i class='fas fa-check fa-2x'></i>
        </a>
    @endif

@endcan