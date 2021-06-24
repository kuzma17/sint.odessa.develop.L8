@php
    $menu = \App\Models\Menu::where('active', 1)->orderBy('weight', 'asc')->get();
@endphp
<nav class="navbar navbar-default navbar-inverse" style="margin-top: 10px">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
    </div>
    <div class="col-sm-12 col-md-9 collapse navbar-collapse" id="collapse">
        <ul class="nav navbar-nav">
            @foreach($menu as $link)
            <li class="menu_site @if(Request::path() == $link->url) active_menu @endif"><a href="{{ url($link->url) }}">{{ $link->title }}</a></li>
            @endforeach
        </ul>
    </div>
    <div class="col-sm-12 col-md-3 navbar-right ">
        <form class="navbar-form" role="search" method="post" name="search_site" action="{{ url('/search') }}">
            {{ csrf_field() }}
            <div class="input-group" style="margin-left:70px">
                <input type="search" name="search" class="form-control" placeholder="поиск по сайту">
                <div class="input-group-btn">
                    <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                </div>
            </div>
        </form>
    </div>
</nav>
