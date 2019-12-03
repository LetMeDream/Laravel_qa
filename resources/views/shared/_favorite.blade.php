@auth
    <a
    onclick = 'event.preventDefault(); document.getElementById("favoriteQuestion/{{ $model->id }}").submit();'
    title='Click to mark as favorite (click again to undo)' class='mt-2 favorite {{ $model->beenFavorited }}'>
        <i class='fas fa-star fa-2x'></i>
    </a>
    <form id='favoriteQuestion/{{ $model->id }}' action='{{ route('favorite.question', $model->id) }} ' method='POST' >
        @csrf
    </form>
@else
    <a
    onclick = 'event.preventDefault(); document.getElementById("favoriteQuestion/{{ $model->id }}").submit();'
    title='Click to mark as favorite (click again to undo)' class='mt-2 favorite'>
        <i class='fas fa-star fa-2x'></i>
    </a>
    <form id='favoriteQuestion/{{ $model->id }}' action='{{ route('favorite.question', $model->id) }} ' method='POST' >
        @csrf
    </form>
@endauth
<span class='favorites-count'>{{$model->isFavoritedCount}}</span>