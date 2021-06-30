@php
    $user = Auth::user();
    $type_order = \App\Models\TypeOrder::all();
    $offices = \App\Models\Office::all();
    $type_clients = \App\Models\TypeClient::all();
@endphp
<div id="orderModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content modal-order">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal">×</button>
                <h4 class="modal-title">Оформить заказ</h4>
            </div>

            <form name="order" method="POST" class="form-horizontal" action="{{ route('user.orders.store') }}">
                {{ csrf_field() }}
                <div class="form-group">
                    <label class="col-md-3 control-label">Тип услуги<span class="red">*</span></label>
                    <div class="col-md-9">
                        <select name="type_order_id" class="form-control" autofocus>
                            @foreach($type_order as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label">Тип пользователя<span class="red">*</span></label>

                    <div class="col-md-8 form-inline">
                            @foreach($type_clients as $type_client)
                                <input type="radio" class="form-control" name="type_client_id"
                                       @if((($user && $user->profile)? $user->profile->type_client_id:1) == $type_client->id) checked @endif
                                    @if($user && $user->profile &&  $user->profile->type_client_id) disabled @endif
                                       value="{{ $type_client->id }}"
                                >
                                {{$type_client->name}}
                            @endforeach
                    </div>
                </div>
                <div class="form-group{{ $errors->has('client_name') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label name_account">@if((isset($user->profile) && $user->profile->type_client_id == 2 ))
                            Компания @else ФИО @endif<span class="red">*</span></label>

                    <div class="col-md-9">
                        <input type="text" class="form-control" name="client_name"
                               value="{{ ($user && $user->profile)? $user->profile->client_name: '' }}"
                               @if(isset($user->profile->client_name)) readonly
                               @endif placeholder="@if(!old() && isset($order) && $order->order_type_client == 2) Краткое наименование организации @else Фамилия Имя Отчество @endif"
                               required autofocus>

                        @if ($errors->has('client_name'))
                            <span class="help-block">
                <strong>{{ $errors->first('client_name') }}</strong>
            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group client_company_order{{ $errors->has('user_company') ? ' has-error' : '' }}"
                     @if((isset($user->profile) && $user->profile->type_client_id == 1 ) || !isset($user->profile)) style="display: none" @endif>
                    <label for="phone" class="col-md-3 control-label">Контактное лицо</label>

                    <div class="col-md-9">
                        <input type="text" class="form-control" name="user_company"
                               value="{{ ($user && $user->profile)? $user->profile->user_company: '' }}"
                               placeholder="Фамилия Имя Отчество контактного лица компании.">

                        @if ($errors->has('user_company'))
                            <span class="help-block">
                <strong>{{ $errors->first('user_company') }}</strong>
            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label">E-mail<span class="red">*</span></label>

                    <div class="col-md-9">
                        <input type="text" class="form-control" name="email" value="{{ $user? $user->email: '' }}"
                               @if(isset($user->email)) readonly @endif required>

                        @if ($errors->has('email'))
                            <span class="help-block">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label">телефон<span class="red">*</span></label>

                    <div class="col-md-9">
                        <input type="text" class="form-control" name="phone"
                               value="{{ ($user && $user->profile)? $user->profile->phone: '' }}" placeholder="номер мобильного телефона (050xxxxxxx)" required>

                        @if ($errors->has('phone'))
                            <span class="help-block">
                                <strong>{{ $errors->first('phone') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label">Адрес доставки<span class="red">*</span></label>

                    <div class="col-md-9">
                        <div class="col-md-6" style=" padding:5px">
                            <input type="text" class="form-control" name="delivery_town"
                                   value="{{($user && $user->profile)? $user->profile->delivery_town: ''}}" required
                                   placeholder="город, населенный пункт">
                        </div>
                        <label class="control-label label1">город, населенный пункт<span class="red">*</span></label>
                    </div>
                    <div class="col-md-3"></div>
                    <div class="col-md-9">
                        <div class="col-md-6" style=" padding:5px">
                            <input type="text" class="form-control" name="delivery_street"
                                   value="{{($user && $user->profile)? $user->profile->delivery_street: ''}}" required placeholder="улица">
                            <label class="control-label label1">улица<span class="red">*</span></label>
                        </div>
                        <div class="col-md-2" style=" padding: 5px">
                            <input type="text" class="form-control" name="delivery_house"
                                   value="{{($user && $user->profile)? $user->profile->delivery_house: ''}}" required placeholder="номер">
                            <label class="control-label label1">дом<span class="red">*</span></label>
                        </div>
                        <div class="col-md-2" style=" padding: 5px">
                            <input type="text" class="form-control" name="delivery_house_block"
                                   value="{{($user && $user->profile)? $user->profile->delivery_house_block: ''}}" placeholder="корпус">
                            <label class="label1">корпус</label>
                        </div>
                        <div class="col-md-2" style=" padding: 5px">
                            <input type="text" class="form-control" name="delivery_office"
                                   value="{{($user && $user->profile)? $user->profile->delivery_office: ''}}" placeholder="квартира">
                            <label class="label1">квартира</label>
                        </div>
                        @if ($errors->has('address'))
                            <span class="help-block">
                                <strong>{{ $errors->first('address') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Офис обслуживания<span class="red">*</span></label>
                        <div class="col-md-9">

                            <select name="office_id" class="form-control" autofocus>
                                @foreach($offices as $office)
                                    <option value="{{ $office->id }}" @if(isset($user->profile) && $office->id == $user->profile->office_id) selected @endif>{{ $office->name }}</option>
                                @endforeach
                            </select>

                        </div>
                    </div>
                </div>
                <div class="client_company_order"
                     @if((isset($user->profile) && $user->profile->type_client_id== 1) || !isset($user->profile)) style="display: none" @endif>
                    <div class="form-group{{ $errors->has('fio') ? ' has-error' : '' }}">
                        <label class="col-md-3 control-label">Форма оплаты<span class="red">*</span></label>

                        <div class="col-md-9 form-inline">
                            <input type="radio" id="payment_nal" class="form-control" name="type_payment"
                                   value="1"
                                   @if((isset($user->profile) && $user->profile->type_payment_id == 1) || !isset($user->profile)) checked @endif>
                            наличный расчет
                            <input type="radio" id="payment_b_nal" class="form-control" name="type_payment"
                                   value="2"
                                   @if(isset($user->profile) && $user->profile->type_payment_id == 2) checked @endif>
                            безналичный расчет
                            <input type="radio" id="payment_nds" class="form-control" name="type_payment"
                                   value="3"
                                   @if(isset($user->profile) && $user->profile->type_payment_id == 3) checked @endif>
                            безналичный с НДС
                        </div>
                        <p class="order_info">Для безналичного расчета укажите, пожалуйста, реквизиты организации в
                            расширенной форме заказа. Обращаем Ваше внимание,
                            что формирование счёта за услуги возможно только при наличии документов, подтверждающих
                            государственную регистрацию компании.
                            После заполнения всех реквизитов редактирование будет доступно только через администратора
                            на сайте или по телефону офиса, который Вас обслуживает.
                        </p>
                    </div>
                </div>
                <div class="form-group{{ $errors->has('comment') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label">Комментарий</label>

                    <div class="col-md-9">
                        <textarea class="form-control" name="comment"
                                  placeholder="Например, укажите количество картриджей или описание неисправности техники"></textarea>

                        @if ($errors->has('comment'))
                            <span class="help-block">
                <strong>{{ $errors->first('comment') }}</strong>
            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-8 col-md-offset-4">
                        <input type="submit" name="add_order" class="btn btn-primary" value="Сохранить">
                        <input id="all_order" type="submit" name="all_order" class="btn btn-default"
                               value="Расширенный заказ"
                               @if(isset($user->profile) && $user->profile->type_client_id== 1 || !isset($user->profile)) style="display: none" @endif>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
