<?php

namespace App\Admin\Controllers;

use App\Models\Office;
use App\Models\TypeClient;
use App\Models\TypePayment;
use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class UserController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Клиенты';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new User());

        $grid->model()->with('profile','profile.type_client')
            ->orderBy('id', 'desc');
        $grid->column('id', 'ID')->sortable();
        $grid->column('profile.1c_id', '1C_ID')->sortable();
        $grid->column('name', 'Ник');
        $grid->column('profile.client_name', 'Имя');
        $grid->column('email','Email');
        $grid->column('avatar.avatar', 'аватар')->display(function ($img){
            if($img) {
                return '<img src="/upload/' . $img . '" style="width:60px; height:60px">';
            }
            return '<img src="/images/no_img.png" style="width:60px; height:60px">';
        });
        $grid->column('profile.type_client_id', 'тип клиента')->display(function($id = 0){
            if($id != 0){
                $class = ["1"=>"label label-danger", "2"=>"label label-warning"];
                return '<span class="'.$class[$id].'">'.$this->profile->type_client->name.'</span>';
            }
            return "";
        });
        $grid->column('profile.phone', 'телефон');

        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(User::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('email', __('Email'));
        $show->field('password', __('Password'));
        $show->field('remember_token', __('Remember token'));
        $show->field('active', __('Active'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new User());

        $form->tab('Клиент/Компания', function(Form $form){

            $form->display('id', 'ID');
            $form->display('profile.1c_id', '1C_ID');
            $form->text('name', 'Ник');
            $form->text('profile.client_name', 'Имя');
            $form->email('email','Email');
            $form->image('avatar.avatar')->resize(160, 180)->uniqueName()->move('avatars');
            $form->password('password', 'Пароль');
            $form->select('profile.type_client_id', 'тип клиента')->options(TypeClient::all()->pluck('name', 'id'));
            $form->mobile('profile.phone', 'Телефон');
            $form->select('profile.office_id', 'офис обслуживания')->options(Office::all()->pluck('name', 'id'));
            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        })->tab('Адрес доставки', function(Form $form){
            $form->text('profile.delivery_town', 'город, населенный пункт');
            $form->text('profile.delivery_street', 'улица');
            $form->text('profile.delivery_house', 'дом');
            $form->text('profile.delivery_house_block', 'корпус');
            $form->text('profile.delivery_office', 'квартира');
        })->tab('Реквизиты компании', function(Form $form){
            $form->text('profile.user_company', 'представитель компании');
            $form->text('profile.company_full', 'Полное наименование организации');
            $form->select('profile.type_payment_id', 'тип оплаты')->options(TypePayment::all()->pluck('name', 'id'));
            $form->text('profile.edrpou', 'код ЕДРПОУ');
            $form->text('profile.inn', 'код ИНН');
        })->tab('Юридический адрес', function(Form $form){
            $form->text('profile.code_index', 'Почтовый индекс');
            $form->text('profile.region', 'Регион');
            $form->text('profile.area', 'Район');
            $form->text('profile.city', 'Город');
            $form->text('profile.street', 'Улица');
            $form->text('profile.house', 'Номер дома');
            $form->text('profile.house_block', 'Корпус');
            $form->text('profile.office', 'Офис/Квартира');
        });

        $form->saving(function (Form $form) { // Encryption and Save Password
            $form->password = bcrypt($form->password);
        });

        return $form;
    }
}
