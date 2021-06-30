@extends('layouts.container3')

@section('content')
    <div class="content-page search_list">
        <h3>@lang('main.search_results')</h3>

        @if(count($results) < 1)
            <p>@lang('main.on_request'): {{ $query }} @lang('main.no_found').</p>
        @else
            <p>@lang('main.on_request'): {{ $query }} @lang('main.documents_found').</p>
            @foreach($results as $result)
                <a href="@if($result->url == 'news' || $result->url == 'post'){{ url($result->url.'/'.$result->id) }}@else{{ url($result->url) }}@endif" >
                    <h5>{{ $result->title }}</h5></a>
                    {!! \Illuminate\Support\Str::words(strip_tags($result->content), 30) !!}
                <a href="@if($result->url == 'news' || $result->url == 'post'){{ url($result->url.'/'.$result->id) }}@else{{ url($result->url) }}@endif" ><h5>@lang('main.more_details')...</h5></a>
                <div class="clear"></div>
            @endforeach
        @endif
    </div>
@endsection
