@extends('user.app')
@section('profile')

    <div class="rcol-sm-6 col-md-9 col-lg-9">
        <h4>Параметры профиля</h4>
        <table class="table table-striped">
            <tbody>

            <tr><td>@if( isset($user->profile) && $user->profile->type_client_id == 2 ) Компания: @else ФИО: @endif</td><td>{{ $user->profile? $user->profile->client_name :''}}</td></tr>
            @if( isset($user->profile) && $user->profile->type_client_id == 2 )
                <tr><td>ФИО представителя компании:</td><td>{{ $user->profile->user_company }}</td></tr>
            @endif
            <tr><td>Телефон:</td><td>{{ $user->profile? $user->profile->phone: '' }}</td></tr>
            <tr><td>Адрес доставки:</td><td>
                    @if(isset($user->profile->delivery_town)) г. {{ $user->profile->delivery_town}} @endif
                    @if(isset($user->profile->delivery_street)) ул. {{ $user->profile->delivery_street}} @endif
                    {{ $user->profile? $user->profile->delivery_house: '' }} {{ $user->profile? $user->profile->delivery_house_block: '' }}
                    @if(isset($user->profile->delivery_office)) кв.{{ $user->profile->delivery_office }} @endif </td></tr>
            <tr><td >E-mail:</td><td>{{ $user->email }}</td></tr>
            <tr><td >Офис обслуживания</td><td>{{ ($user->profile && $user->profile->service_office)? $user->profile->service_office->name: ''}}</td></tr>
            @if(isset($user->profile) && $user->profile->type_client_id == 2 )
                <tr><td >Предпочтительная форма оплаты:</td><td>{{ $user->profile? $user->profile->type_payment->name: '' }}</td></tr>
                @if(isset($user->profile) && $user->profile->type_payment_id == 2 ||  $user->profile->type_payment_id == 3)
                    <tr><td>Полное наименование организации:</td><td>{{ $user->profile->company_full }}</td></tr>
                    <tr><td>Код ЕГРПОУ:</td><td>{{ $user->profile->edrpou }}</td></tr>
                    @if(isset($user->profile) && $user->profile->type_payment_id == 3)
                        <tr><td>ИНН:</td><td>{{ $user->profile->inn }}</td></tr>
                    @endif
                    <tr><td>Почтовый индекс:</td><td>{{ $user->profile->code_index }}</td></tr>
                    <tr><td >Регион:</td><td>{{ $user->profile->region }}</td></tr>
                    <tr><td>Район:</td><td>{{ $user->profile->area }}</td></tr>
                    <tr><td>Город:</td><td>{{ $user->profile->city }}</td></tr>
                    <tr><td >Улица:</td><td>{{ $user->profile->street }}</td></tr>
                    <tr><td>Дом:</td><td>{{ $user->profile->house }}</td></tr>
                    <tr><td>Корпус:</td><td>{{ $user->profile->house_block }}</td></tr>
                    <tr><td >Квартира/офис:</td><td>{{ $user->profile->office }}</td></tr>
                @endif
            @endif
            </tbody>
        </table>
    </div>
@endsection
