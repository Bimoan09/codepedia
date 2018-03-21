@if(!empty($articles))
    @foreach($articles as $article)
        <h1>{{ $articles->title }} </h1>
    @endforeach
@endif
