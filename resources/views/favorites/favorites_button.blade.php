@if (Auth::user()->is_favoriting($micropost->id))
        {{-- アンfavoボタンのフォーム --}}
        {!! Form::open(['route' => ['favorites.unfavorite', $micropost->id], 'method' => 'delete']) !!}
            {!! Form::submit('unfavorite', ['class' => "btn btn-light btn-sm"]) !!}
        {!! Form::close() !!}
@else
        {{-- favo（お気に入り）ボタンのフォーム --}}
        {!! Form::open(['route' => ['favorites.favorite', $micropost->id]]) !!}
            {!! Form::submit('favorite', ['class' => "btn btn-success btn-sm"]) !!}
        {!! Form::close() !!}
@endif