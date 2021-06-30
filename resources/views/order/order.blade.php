@extends('layouts.container3')

@section('content')


    <div class="content-page">
        <h3>Оформление заказа</h3>
        <form name="order" method="post" class="form-horizontal" action="{{ route('user.orders.store') }}">
            {{ csrf_field() }}
            <div class="form-group">
                <label  class="col-md-3 control-label">Тип услуги<span class="red">*</span></label>

                <div class="col-md-9">
                    <select name="type_order_id" class="form-control">
                        @foreach($type_order as $type)
                            <option value="{{ $type->id }}" @if($type->id == old('type_order_id')) selected="selected" @endif>{{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group{{ $errors->has('fio') ? ' has-error' : '' }}">
                <label  class="col-md-4 control-label">Тип пользователя<span class="red">*</span></label>

                <div class="col-md-8 form-inline">

                    @foreach($type_clients as $type_client)
                            <input type="radio" class="form-control type_user" name="type_client_id" @if(old('type_client', $user? $user->profile->type_client_id: 1) == $type_client->id) checked @endif
                            @if($user &&  $user->profile->type_client_id) disabled @endif
                            value="{{ $type_client->id }}"
                            >
                            {{$type_client->name}}
                        @endforeach

                </div>
            </div>
            <div class="form-group{{ $errors->has('client_name') ? ' has-error' : '' }}">
                <label class="col-md-3 control-label name_account">@if(old('type_client', $user? $user->profile->type_client_id: 0) == 2) Компания @else ФИО @endif<span class="red">*</span></label>

                <div class="col-md-9">
                    <input placeholder="Фамилия Имя Отчество" type="text" class="form-control" name="client_name" value="{{ old('client_name', isset($user)? $user->profile->client_name: '') }}" @if(isset($user->profile->client_name)) readonly @endif autofocus>

                    @if ($errors->has('client_name'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('client_name') }}</strong>
                                    </span>
                    @endif
                </div>
            </div>
            <div class="form-group client_company_order{{ $errors->has('user_company') ? ' has-error' : '' }}" @if(old('type_client', $user? $user->profile->type_client_id:0) == 1) style="display: none" @endif>
                <label  class="col-md-3 control-label">Контактное лицо</label>

                <div class="col-md-9">
                    <input placeholder="Фамилия Имя Отчество контактного лица компании." id="user_company" type="text" class="form-control" name="user_company" value="{{ old('user_company', $user? $user->profile->user_company: '') }}" >


                    @if ($errors->has('user_company'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('user_company') }}</strong>
                                    </span>
                    @endif
                </div>
            </div>
            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <label  class="col-md-3 control-label">E-mail<span class="red">*</span></label>

                <div class="col-md-9">
                    <input id="skype" type="text" class="form-control" name="email" value="{{ old('email', $user? $user->email:'') }}" @if(isset($user->email)) readonly @endif >

                    @if ($errors->has('email'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                    @endif
                </div>
            </div>
            <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                <label  class="col-md-3 control-label">телефон<span class="red">*</span></label>

                <div class="col-md-9">
                    <input  type="text" class="form-control" name="phone" value="{{ old('phone', isset($user)? $user->profile->phone: '') }}" placeholder="номер мобильного телефона (050xxxxxxx)">

                    @if ($errors->has('phone'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                    @endif
                </div>
            </div>
            <div class="form-group{{ $errors->has('delivery_town') || $errors->has('delivery_street') || $errors->has('delivery_house') ? ' has-error' : '' }}">
                <label  class="col-md-3 control-label">Адрес доставки<span class="red">*</span></label>
                <div class="col-md-9">
                    <div class="col-md-6" style=" padding:5px">
                        <input type="text" class="form-control" name="delivery_town" value="{{ old('delivery_town', isset($user)? $user->profile->delivery_town: '') }}" placeholder="город, населенный пункт">
                    </div>
                        <label  class="control-label label1">город, населенный пункт<span class="red">*</span></label>
                </div>
                <div class="col-md-3"></div>
                <div class="col-md-9">
                    <div class="col-md-6" style=" padding:5px">
                        <input type="text" class="form-control" name="delivery_street" value="{{ old('delivery_street', $user? $user->profile->delivery_street: '') }}" placeholder="улица">
                        <label class="control-label label1">улица<span class="red">*</span></label>
                    </div>
                    <div class="col-md-2" style=" padding: 5px">
                        <input type="text" class="form-control" name="delivery_house" value="{{ old('delivery_house', $user? $user->profile->delivery_house: '') }}" placeholder="номер">
                        <label class="control-label label1">дом<span class="red">*</span></label>
                    </div>
                    <div class="col-md-2" style=" padding: 5px">
                        <input type="text" class="form-no-control" name="delivery_house_block" value="{{ old('delivery_house_block', $user? $user->profile->delivery_house_block: '') }}" placeholder="корпус">
                        <label class="label1">корпус</label>
                    </div>
                    <div class="col-md-2" style=" padding: 5px">
                        <input type="text" class="form-no-control" name="delivery_office" value="{{ old('delivery_office', $user? $user->profile->delivery_office: '') }}" placeholder="квартира">
                        <label class="label1">квартира</label>
                    </div>
                    @if ($errors->has('delivery_town') || $errors->has('delivery_street') || $errors->has('delivery_house'))
                       <div class="clear"></div>
                        <span class="help-block">
                <strong>Поля обязательные для заполнения.</strong>
            </span>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label">Офис обслуживания<span class="red">*</span></label>
                <div class="col-md-9">
                    <select name="office_id" class="form-control" autofocus>
                        @foreach($offices as $office)
                            <option value="{{ $office->id }}" @if(old('service_office', $user? $user->profile->service_office_id:0) == $office->id) selected @endif>{{ $office->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="client_company_order" @if(old('type_client', $user? $user->profile->type_client_id: 0) == 1))  style="display: none" @endif>
                <div class="form-group{{ $errors->has('fio') ? ' has-error' : '' }}">
                    <label  class="col-md-3 control-label">Форма оплаты<span class="red">*</span></label>

                    <div class="col-md-9 form-inline">
                        <input type="radio" id="payment_nal" class="form-control" name="type_payment" value="1" @if(old('type_payment', $user? $user->profile->type_payment_id:0 ) == 1) checked @endif> наличный расчет
                        <input type="radio" id="payment_b_nal" class="form-control" name="type_payment" value="2" @if(old('type_payment', $user? $user->profile->type_payment_id: 0) == 2) checked @endif> безналичный расчет
                        <input type="radio" id="payment_nds" class="form-control" name="type_payment" value="3" @if(old('type_payment', $user? $user->profile->type_payment_id: 0) == 3) checked @endif> безналичный с НДС
                        <p class="order_info">Для безналичного расчета укажите, пожалуйста, реквизиты организации в расширенной форме заказа. Обращаем Ваше внимание, что формирование счёта за услуги возможно только при наличии документов, подтверждающих государственную регистрацию компании.
                            После заполнения всех реквизитов редактирование будет доступно только через администратора на сайте или по телефону офиса, который Вас обслуживает.
                        </p>
                    </div>
                </div>
                <div class="form-group payment_b_nal{{ $errors->has('company_full') ? ' has-error' : '' }}" @if(old('type_payment', $user? $user->profile->type_payment_id: 0) == 1)) style="display: none" @endif>
                    <label  class="col-md-3 control-label">Компания<span class="red">*</span></label>

                    <div class="col-md-9">
                        <input placeholder="Полное наименование (согласно выписке из государственного реестра)" type="text" class="form-control" name="company_full" value="{{ old('company_full', $user? $user->profile->company_full: '') }}" @if(isset($user->profile->company_full)) readonly @endif>

                        @if ($errors->has('company_full'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('company_full') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>
                <div class="form-group payment_b_nal{{ $errors->has('edrpou') ? ' has-error' : '' }}" @if(old('type_payment', $user? $user->profile->type_payment_id: 0) == 1) style="display: none" @endif>
                    <label class="col-md-3 control-label">Код ЕГРПОУ<span class="red">*</span></label>

                    <div class="col-md-9">
                        <input placeholder="Должен содержать 8 - 10 знаков" type="text" class="form-control" name="edrpou" value="{{ old('edrpou', $user? $user->profile->edrpou: '') }}" @if(isset($user->profile->edrpou)) readonly @endif>


                        @if ($errors->has('edrpou'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('edrpou') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>
                <div class="form-group payment_nds{{ $errors->has('inn') ? ' has-error' : '' }}" @if(old('type_payment', $user? $user->profile->type_payment_id: 0) != 3) style="display: none" @endif>
                    <label  class="col-md-3 control-label">ИНН<span class="red">*</span></label>

                    <div class="col-md-9">
                        <input placeholder="Индивидуальный налоговый номер, должен содержать 10 знаков" type="text" class="form-control" name="inn" value="{{ old('inn', $user? $user->profile->inn: '') }}" @if(isset($user->profile->inn)) readonly @endif>


                        @if ($errors->has('inn'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('inn') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>
                <div class="form-group payment_b_nal{{ $errors->has('code_index') ? ' has-error' : '' }}" @if(old('type_payment', $user? $user->profile->type_payment_id: 0) == 1) style="display: none" @endif>
                    <label  class="col-md-3 control-label">Индекс<span class="red">*</span></label>

                    <div class="col-md-9">
                        <input  type="text" class="form-control" name="code_index" value="{{ old('code_index', $user? $user->profile->code_index: '') }}" @if(isset($user->profile->code_index)) readonly @endif placeholder="Почтовый индекс, должен содержать 5 знаков">


                        @if ($errors->has('code_index'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('code_index') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>
                <div class="form-group payment_b_nal{{ $errors->has('region') ? ' has-error' : '' }}" @if(old('type_payment', $user? $user->profile->type_payment_id: 0) == 1) style="display: none" @endif>
                    <label  class="col-md-3 control-label">Регион</label>

                    <div class="col-md-9">
                        <input  type="text" class="form-control" name="region" value="{{ old('region', $user? $user->profile->region: '') }}" @if(isset($user->profile->region)) readonly @endif>

                        @if ($errors->has('region'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('region') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>
                <div class="form-group payment_b_nal{{ $errors->has('area') ? ' has-error' : '' }}" @if(old('type_payment', $user? $user->profile->type_payment_id: 0) == 1) style="display: none" @endif>
                    <label  class="col-md-3 control-label">Район</label>

                    <div class="col-md-9">
                        <input  type="text" class="form-control" name="area" value="{{ old('area', $user? $user->profile->area: '') }}" @if(isset($user->profile->area)) readonly @endif>

                        @if ($errors->has('area'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('area') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>
                <div class="form-group payment_b_nal{{ $errors->has('city') ? ' has-error' : '' }}" @if(old('type_payment', $user? $user->profile->type_payment_id: 0) == 1) style="display: none" @endif>
                    <label  class="col-md-3 control-label">Город<span class="red">*</span></label>

                    <div class="col-md-9">
                        <input  type="text" class="form-control" name="city" value="{{ old('city', $user? $user->profile->city: '') }}" @if(isset($user->profile->city)) readonly @endif>

                        @if ($errors->has('city'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('city') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>
                <div class="form-group payment_b_nal{{ $errors->has('street') ? ' has-error' : '' }}" @if(old('type_payment', $user? $user->profile->type_payment_id: 0) == 1) style="display: none" @endif>
                    <label  class="col-md-3 control-label">Улица<span class="red">*</span></label>

                    <div class="col-md-9">
                        <input  type="text" class="form-control" name="street" value="{{ old('street', $user? $user->profile->street: '') }}" @if(isset($user->profile->street)) readonly @endif>

                        @if ($errors->has('street'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('street') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>
                <div class="form-group payment_b_nal{{ $errors->has('house') ? ' has-error' : '' }}" @if(old('type_payment', $user? $user->profile->type_payment_id: 0) == 1) style="display: none" @endif>
                    <label  class="col-md-3 control-label">Дом<span class="red">*</span></label>

                    <div class="col-md-9">
                        <input  type="text" class="form-control" name="house" value="{{ old('house', $user? $user->profile->house: '') }}" @if(isset($user->profile->house)) readonly @endif>

                        @if ($errors->has('house'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('house') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>
                <div class="form-group payment_b_nal{{ $errors->has('house_block') ? ' has-error' : '' }}" @if(old('type_payment', $user? $user->profile->type_payment_id: 0) == 1) style="display: none" @endif>
                    <label  class="col-md-3 control-label">Корпус</label>

                    <div class="col-md-9">
                        <input  type="text" class="form-control" name="house_block" value="{{ old('house_block', $user? $user->profile->house_block: '') }}" @if(isset($user->profile->house_block)) readonly @endif>

                        @if ($errors->has('house_block'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('house_block') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>
                <div class="form-group payment_b_nal{{ $errors->has('office') ? ' has-error' : '' }}" @if(old('type_payment', $user? $user->profile->type_payment_id: 0) == 1) style="display: none" @endif>
                    <label  class="col-md-3 control-label">Квартира/офис</label>

                    <div class="col-md-9">
                        <input  type="text" class="form-control" name="office" value="{{ old('office', $user? $user->profile->office: '') }}" @if(isset($user->profile->office)) readonly @endif>

                        @if ($errors->has('office'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('office') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="form-group{{ $errors->has('comment') ? ' has-error' : '' }}">
                <label  class="col-md-3 control-label">Комментарий</label>

                <div class="col-md-9">
                    <textarea class="form-control" name="comment" placeholder="Например, укажите количество картриджей или описание неисправности техники).">{{ old('comment', $user? $user->profile->comment: '') }}</textarea>

                    @if ($errors->has('comment'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('comment') }}</strong>
                                    </span>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-8 col-md-offset-4">
                    <input type="submit" class="btn btn-primary" name="add_all_order" value="Сохранить">
                </div>
            </div>
        </form>

    </div>
@endsection
