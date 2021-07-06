@extends('layouts.container2')
@section('content')
    <?php if(isset(Auth::user()->avatar)){$avatar = Auth::user()->avatar->avatar;} ?>
    <h3>Личный кабинет пользователя</h3>
    @if (count($errors) > 0)
        <div class="alert alert-warning alert-message">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
            </div>
    @endif

    <div class="rcol-sm-6 col-md-3 col-lg-3">
        <div class="avatar" style="width:162px; border: 1px #cccccc solid;">
            @if(isset($avatar))
            <img src="{{ url('/upload/'.$avatar) }}" style="width: 160px; height: 160px">
            @else
                <img src="{{ url('/images/no_image.png') }}" style="width: 160px; height: 160px">
            @endif
            <div class="edit_panel" style="position: absolute; margin-top:-30px;z-index: 100; border: 1px #cccccc solid;width:162px; height: 30px; text-align: center; background-color: black; opacity: 0.7; ">
                @if(isset($avatar))
                    <a href="{{ url('/user/avatar') }}" style="color: white">обновить фото</a><br>
                @else
                    <a href="{{ url('/user/avatar') }}" style="color: white">добавить фото</a>
                @endif
            </div>
        </div>
        <ul class="user_menu">
            <li><a href="{{ url('/user') }}" ><i class="fa fa-address-card-o"></i> Параметры профиля</a></li>
            <li><a href="{{ url('/user/edit') }}" ><i class="fa fa-pencil-square-o"></i> Редактировать профиль</a></li>
            <li><a href="{{ url('/user/password') }}" ><i class="fa fa-key"></i> Изменить пароль</a></li>
            <li><a href="#" @if(URL::current() != url('/order')) data-toggle="modal" data-target="#orderModal" @endif><i class="fa fa-cart-plus"></i> Сделать заказ</a></li>
            <li><a href="{{ route('user.orders.index') }}" ><i class="fa fa-shopping-basket"></i> Мои заказы</a></li>
            <li><a href="{{ url('/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fa fa-sign-out"></i> Выход
                </a></li>
        </ul>
    </div>
       @yield('profile')
@endsection
