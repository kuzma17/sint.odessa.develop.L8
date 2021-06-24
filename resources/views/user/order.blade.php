@extends('user.app')
@section('profile')
    <div class="rcol-sm-6 col-md-9 col-lg-9">
        <h4>Заказ №{{ $order->id }}</h4>
        <ul class="nav nav-tabs">
            <li class="active"><a href="#tab-1" data-toggle="tab">Заказ</a></li>
            @if($order->type_order_id == 2 && $order->status_id != 1 && $order->act_repair)
                <li><a href="#tab-2" data-toggle="tab">Акт ремонта</a></li>
            @endif
            <li><a href="#tab-3" data-toggle="tab">История</a></li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane fade in active" id="tab-1">
                <table class="table table-striped">
                    <tbody>
                    <tr><td>№</td><td>{{ $order['1c_id'] or ''}}</td></tr>
                    <tr><td >Статус:</td><td>{{ $order->status->name_site }}</td></tr>
                    <tr><td width="200">Тип услуги:</td><td>{{ $order->type_order->name }}</td></tr>
                    <tr><td>Тип пользователя:</td><td>{{ $user->profile->type_client->name }}</td></tr>
                    <tr><td>@if( $user->profile->type_client_id == 2 )Компания: @else ФИО: @endif</td><td>{{ $user->profile->client_name }}</td></tr>
                    @if( $order->type_client_id == 2 )
                        <tr><td>ФИО представителя компании:</td><td>{{ $user->profile->user_company }}</td></tr>
                    @endif
                    <tr><td>Телефон:</td><td>{{ $user->profile->phone }}</td></tr>
                    <tr><td>Адрес доставки:</td><td>
                            @if(isset($order->delivery_town)) г. {{ $order->delivery_town}} @endif
                            @if(isset($order->delivery_street)) ул. {{ $order->delivery_street}} @endif
                            {{ $order->delivery_house or '' }} {{ $order->delivery_house_block or '' }}
                            @if(isset($order->delivery_office)) кв.{{ $order->delivery_office }} @endif
                        </td></tr>
                    <tr><td >E-mail</td><td>{{ $user->email }}</td></tr>
                    <tr><td >Офис обслуживания</td><td>{{ $user->profile->service_office->name or '' }}</td></tr>
                    @if( $user->profile->type_client_id == 2 )
                        <tr><td >Форма оплаты</td><td>{{ $order->type_payment->name }}</td></tr>
                        @if( $order->type_payment_id == 2 ||  $order->type_payment_id == 3)
                            <tr><td>Полное наименование организации:</td><td>{{ $user->profile->company_full }}</td></tr>
                            <tr><td>Код ЕГРПОУ:</td><td>{{ $user->profile->edrpou }}</td></tr>
                            @if($order->type_payment_id == 3)
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
                    <tr><td >Комментарий:</td><td>{{ $order->comment }}</td></tr>
                    </tbody>
                </table>
            </div>
            @if($order->type_order_id == 2 && $order->status_id != 1 && $order->act_repair)
            <div class="tab-pane fade" id="tab-2">
                <form name="repair" method="post" action="/user/order/repair_save">
                    {{ csrf_field() }}
                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                <table class="table table-striped">
                    <tbody>
                    <tr><td>Статус ремонта:</td><td>{{ $order->act_repair->status_repair->name_site or ''}}</td></tr>
                    <tr><td >Оборудование:</td><td>{{ $order->act_repair->device or ''}}</td></tr>
                    <tr><td width="200">Комплектация:</td><td>{{ $order->act_repair->set_device or ''}}</td></tr>
                    <tr><td>Описание неисправности<br>(со слов заказчика):</td><td>{{ $order->act_repair->text_defect or ''}}</td></tr>
                    <tr><td>Диагностика:</td><td>{{ $order->act_repair->diagnostic or '' }}</td></tr>
                    <tr><td>Стоимость работы:</td><td>{{ $order->act_repair->cost }}</td></tr>
                    <tr><td>Подтверждение:</td><td>
                            <select name="user_consent" class="form-control" @if(!$order->act_repair->is_open()) disabled @endif>
                                <option value="0">выберите вариант ответа</option>
                                @foreach(\App\UserConsent::all() as $consent)
                                    <option value="{{ $consent->id }}" @if($consent->id == $order->act_repair->user_consent_id) selected="selected" @endif>{{ $consent->name }}</option>
                                @endforeach
                            </select> </td></tr>
                    <tr><td >Комментарий:</td><td><textarea class="form-control" name="comment" @if(!$order->act_repair->is_open()) readonly @endif>{{ $order->act_repair->comment or ''}}</textarea></td></tr>
                    @if($order->act_repair->is_open())
                    <tr><td>Подтверждение:</td><td><input type="submit" class="btn btn-primary" value="Отправить"></td></tr>
                    @endif
                    </tbody>
                </table>
                </form>

            </div>
            @endif

                <div class="tab-pane fade" id="tab-3">
                    @php
                        $histories = $order->history;
                    @endphp
                    @if(count($histories) > 0)
                        <table class="table table-striped">
                            <tbody>
                            <tr>
                                <th>Дата:</th><th>Событие:</th><th>Коментарий</th>
                            </tr>
                            @foreach($histories as $history)
                                <tr>
                                    <td>{{ $history->created_at }}</td>
                                    <td>{{ $history->status_info }}</td>
                                    <td>{{ $history->comment or '' }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>

        </div>

    </div>
@endsection
