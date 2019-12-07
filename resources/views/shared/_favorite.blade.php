{{-- <a
onclick = 'event.preventDefault(); document.getElementById("favoriteQuestion/{{ $model->id }}").submit();'
title='Click to mark as favorite (click again to undo)' class='mt-2 favorite {{ Auth::guest() ? 'off' : ($model->beenFavorited ? 'favorited' : '') }}'>
    <i class='fas fa-star fa-2x'></i>
</a>
<span class='favorites-count'>{{$model->isFavoritedCount}}</span>
<form id='favoriteQuestion/{{ $model->id }}' action='{{ route('favorite.question', $model->id) }} ' method='POST' >
    @csrf
</form>
 --}}