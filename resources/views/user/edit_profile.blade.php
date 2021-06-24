@extends('user.app')
@section('profile')
        <div class="rcol-sm-6 col-md-9 col-lg-9">
        <h4>Редактирование профиля</h4>
        <p>поля отмеченные звездочкой<span class="red">*</span> обязательны для заполнения</p>
            <form class="form-horizontal" role="form" method="POST" action="{{ route('user.profile.update') }}">
                {{ csrf_field() }}
                <div class="form-group{{ $errors->has('fio') ? ' has-error' : '' }}">
                    <label for="phone" class="col-md-4 control-label">Тип пользователя<span class="red">*</span></label>

                    <div class="col-md-8 form-inline">



                            @foreach($type_clients as $type_client)
                                <input type="radio" class="form-control type_user" name="type_client_id" @if(old('type_client_id', $user? $user->profile->type_client_id: 1) == $type_client->id) checked @endif
                                @if($user &&  $user->profile->type_client_id) disabled @endif
                                >
                                {{$type_client->name}}
                            @endforeach

                    </div>
                </div>
                <div class="form-group{{ $errors->has('client_name') ? ' has-error' : '' }}">
                    <label id="name_account" for="phone" class="col-md-3 control-label">@if($user->is_company(old('type_client'))) Компания @else ФИО @endif<span class="red">*</span></label>

                    <div class="col-md-9">
                        <input id="phone" type="text" class="form-control" name="client_name" value="@if(old()){{ old('client_name') }}@else{{ $user->profile? $user->profile->client_name: '' }}@endif" @if(isset($user->profile->client_name)) readonly @endif placeholder="@if(!old() && $user->is_company(old('type_client'))) Краткое наименование организации @else  Фамилия Имя Отчество @endif">

                        @if ($errors->has('client_name'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('client_name') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>
                <div class="form-group client_company{{ $errors->has('user_company') ? ' has-error' : '' }}" @if($user->is_person(old('type_client'))) style="display: none" @endif>
                    <label for="phone" class="col-md-3 control-label">Имя</label>

                    <div class="col-md-9">
                        <input id="phone" type="text" class="form-control" name="user_company" value="{{ old('user_company', $user->profile? $user->profile->user_company: '') }}" placeholder="Фамилия Имя Отчество контактного лица компании.">

                        @if ($errors->has('user_company'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('user_company') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label for="skype" class="col-md-3 control-label">E-mail<span class="red">*</span></label>

                    <div class="col-md-9">
                        <input id="skype" type="text" class="form-control" name="email" value="{{ $user->email? $user->email: ''}}" @if($user->email) readonly @endif>

                        @if ($errors->has('email'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                    <label for="phone" class="col-md-3 control-label">телефон<span class="red">*</span></label>

                    <div class="col-md-9">
                        <input id="phone" type="text" class="form-control" name="phone" value="@if(old()){{ old('phone') }}@else{{ $user->profile? $user->profile->phone: '' }}@endif" @if($user->is_person() && isset($user->profile->phone)) readonly @endif placeholder="номер мобильного телефона(050xxxxxxx)">

                        @if ($errors->has('phone'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label for="address" class="col-md-3 control-label">Адрес доставки</label>
                    <div class="col-md-9">
                        <div class="col-md-6" style=" padding:5px">
                            <input  type="text" class="form-control" name="delivery_town" value="@if(old()){{ old('delivery_town') }}@else{{ $user->profile? $user->profile->delivery_town: '' }}@endif" >
                        </div>
                        <label  class="control-label">город, населенный пункт</label>
                    </div>
                    <div class="col-md-3"></div>
                    <div class="col-md-9">
                        <div class="col-md-6" style=" padding:5px">
                            <input  type="text" class="form-control" name="delivery_street" value="@if(old()){{ old('delivery_street') }}@else{{ $user->profile? $user->profile->delivery_street: '' }}@endif" >
                            <label  class="control-label">улица</label>
                        </div>
                        <div class="col-md-2" style=" padding: 5px">
                            <input  type="text" class="form-control" name="delivery_house" value="@if(old()){{ old('delivery_house') }}@else{{ $user->profile? $user->profile->delivery_house: '' }}@endif" >
                            <label  class="control-label">дом</label>
                        </div>
                        <div class="col-md-2" style=" padding: 5px">
                            <input  type="text" class="form-no-control" name="delivery_house_block" value="@if(old()){{ old('delivery_house_block') }}@else{{ $user->profile? $user->profile->delivery_house_block: '' }}@endif">
                            <label>корпус</label>
                        </div>
                        <div class="col-md-2" style=" padding: 5px">
                            <input  type="text" class="form-no-control" name="delivery_office" value="@if(old()){{ old('delivery_office') }}@else{{ $user->profile? $user->profile->delivery_office: '' }}@endif">
                            <label>квартира</label>
                        </div>
                    </div>
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
                <div class="client_company" @if($user->is_person(old('type_client_id'))) style="display: none" @endif>
                    <div class="form-group{{ $errors->has('fio') ? ' has-error' : '' }}">
                        <label for="phone" class="col-md-3 control-label">Предпочтительная форма оплаты<span class="red">*</span></label>

                        <div class="col-md-9 form-inline">
                            <input type="radio" id="payment_nal" class="form-control" name="type_payment_id" value="1" @if($user->is_payment_nal(old('type_payment_id'))) checked @endif> наличный расчет
                            <input type="radio" id="payment_b_nal" class="form-control" name="type_payment_id" value="2" @if($user->is_payment_b_nal(old('type_payment_id'))) checked @endif> безналичный расчет
                            <input type="radio" id="payment_nds" class="form-control" name="type_payment_id" value="3" @if($user->is_payment_nds(old('type_payment_id'))) checked @endif> безналичный с НДС
                            <p class="order_info">Для безналичного расчета укажите, пожалуйста, реквизиты организации в расширенной форме заказа.
                                Обращаем Ваше внимание, что формирование счёта за услуги возможно только при наличии документов, подтверждающих государственную
                                регистрацию компании. После заполнения всех реквизитов редактирование будет доступно только через администратора на сайте или по
                                телефону офиса, который Вас обслуживает.”
                            </p>
                        </div>
                    </div>
                    <div class="form-group payment_b_nal{{ $errors->has('company_full') ? ' has-error' : '' }}" @if($user->is_payment_nal(old('type_payment_id'))) style="display: none" @endif>
                        <label for="phone" class="col-md-3 control-label">Компания<span class="red">*</span></label>

                        <div class="col-md-9">
                            <input id="phone" type="text" class="form-control" name="company_full" value="@if(old()){{ old('company_full') }}@else{{ $user->profile? $user->profile->company_full: '' }}@endif" @if(isset($user->profile->company_full)) readonly @endif placeholder="Полное наименование организации (согласно выписке из госреестра)">
                            @if ($errors->has('company_full'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('company_full') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group payment_b_nal{{ $errors->has('edrpou') ? ' has-error' : '' }}" @if($user->is_payment_nal(old('type_payment_id'))) style="display: none" @endif>
                        <label for="icq" class="col-md-3 control-label">Код ЕГРПОУ<span class="red">*</span></label>

                        <div class="col-md-9">
                            <input id="icq" type="text" class="form-control" name="edrpou" value="@if(old()){{ old('edrpou') }}@else{{ $user->profile? $user->profile->edrpou: '' }}@endif" @if(isset($user->profile->edrpou)) readonly @endif placeholder="Должен содержать 8 - 10 знаков">

                            @if ($errors->has('edrpou'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('edrpou') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group payment_nds{{ $errors->has('inn') ? ' has-error' : '' }}" @if(!$user->is_payment_nds(old('type_payment'))) style="display: none" @endif>
                        <label for="address" class="col-md-3 control-label">ИНН<span class="red">*</span></label>

                        <div class="col-md-9">
                            <input id="address" type="text" class="form-control" name="inn" value="@if(old()){{ old('inn') }}@else{{$user->profile? $user->profile->inn: '' }}@endif" @if(isset($user->profile->inn)) readonly @endif placeholder="Индивидуальный налоговый номер, должен содержать 10 знаков">

                            @if ($errors->has('inn'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('inn') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group payment_b_nal{{ $errors->has('code_index') ? ' has-error' : '' }}" @if($user->is_payment_nal(old('type_payment'))) style="display: none" @endif>
                        <label for="address" class="col-md-3 control-label">Индекс<span class="red">*</span></label>

                        <div class="col-md-9">
                            <input id="address" type="text" class="form-control" name="code_index" value="@if(old()){{ old('code_index') }}@else{{ $user->profile? $user->profile->code_index: '' }}@endif" @if(isset($user->profile->code_index)) readonly @endif placeholder="Почтовый индекс, должен содержать 5 знаков">

                            @if ($errors->has('code_index'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('code_index') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group payment_b_nal{{ $errors->has('region') ? ' has-error' : '' }}" @if($user->is_payment_nal(old('type_payment_id'))) style="display: none" @endif>
                        <label for="address" class="col-md-3 control-label">Регион</label>

                        <div class="col-md-9">
                            <input id="address" type="text" class="form-control" name="region" value="@if(old()){{ old('region') }}@else{{ $user->profile? $user->profile->region: '' }}@endif" @if(isset($user->profile->region)) readonly @endif>

                            @if ($errors->has('region'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('region') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group payment_b_nal{{ $errors->has('area') ? ' has-error' : '' }}" @if($user->is_payment_nal(old('type_payment_id'))) style="display: none" @endif>
                        <label for="address" class="col-md-3 control-label">Район</label>

                        <div class="col-md-9">
                            <input id="address" type="text" class="form-control" name="area" value="@if(old()){{ old('area') }}@else{{ $user->profile? $user->profile->area: '' }}@endif" @if(isset($user->profile->area)) readonly @endif>

                            @if ($errors->has('area'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('area') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group payment_b_nal{{ $errors->has('city') ? ' has-error' : '' }}" @if($user->is_payment_nal(old('type_payment_id'))) style="display: none" @endif>
                        <label for="address" class="col-md-3 control-label">Город<span class="red">*</span></label>

                        <div class="col-md-9">
                            <input id="address" type="text" class="form-control" name="city" value="@if(old()){{ old('city') }}@else{{ $user->profile? $user->profile->city: '' }}@endif" @if(isset($user->profile->city)) readonly @endif>

                            @if ($errors->has('city'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('city') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group payment_b_nal{{ $errors->has('street') ? ' has-error' : '' }}" @if($user->is_payment_nal(old('type_payment_id'))) style="display: none" @endif>
                        <label for="address" class="col-md-3 control-label">Улица<span class="red">*</span></label>

                        <div class="col-md-9">
                            <input id="address" type="text" class="form-control" name="street" value="@if(old()){{ old('street') }}@else{{ $user->profile? $user->profile->street: '' }}@endif" @if(isset($user->profile->street)) readonly @endif>

                            @if ($errors->has('street'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('street') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group payment_b_nal{{ $errors->has('house') ? ' has-error' : '' }}" @if($user->is_payment_nal(old('type_payment_id'))) style="display: none" @endif>
                        <label for="address" class="col-md-3 control-label">Дом<span class="red">*</span></label>

                        <div class="col-md-9">
                            <input id="address" type="text" class="form-control" name="house" value="@if(old()){{ old('house') }}@else{{ $user->profile? $user->profile->house: '' }}@endif" @if(isset($user->profile->house)) readonly @endif>

                            @if ($errors->has('house'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('house') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group payment_b_nal{{ $errors->has('house_block') ? ' has-error' : '' }}" @if($user->is_payment_nal(old('type_payment_id'))) style="display: none" @endif>
                        <label for="address" class="col-md-3 control-label">Корпус</label>

                        <div class="col-md-9">
                            <input id="address" type="text" class="form-control" name="house_block" value="@if(old()){{ old('house_block') }}@else{{ $user->profile? $user->profile->house_block: '' }}@endif" @if(isset($user->profile->house_block)) readonly @endif>

                            @if ($errors->has('house_block'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('house_block') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group payment_b_nal{{ $errors->has('office') ? ' has-error' : '' }}" @if($user->is_payment_nal(old('type_payment_id'))) style="display: none" @endif>
                        <label for="address" class="col-md-3 control-label">Квартира/офис</label>

                        <div class="col-md-9">
                            <input id="address" type="text" class="form-control" name="office" value="@if(old()){{ old('office') }}@else{{ $user->profile? $user->profile->office: '' }}@endif" @if(isset($user->profile->office)) readonly @endif>

                            @if ($errors->has('office'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('office') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-8 col-md-offset-4">
                        <button type="submit" class="btn btn-primary">
                            Сохранить
                        </button>
                    </div>
                </div>
            </form>
        </div>


@endsection
