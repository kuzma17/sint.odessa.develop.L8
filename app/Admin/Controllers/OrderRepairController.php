<?php

namespace App\Admin\Controllers;

use App\Models\ActRepair;
use App\Notifications\StatusOrder;
use App\Notifications\StatusOrderRepair;
use App\Models\Order;

use App\Models\Status;
use App\Models\StatusRepairs;
use App\Models\UserConsent;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class OrderRepairController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('Заказы');
            $content->description('на ремонт');

            $content->body($this->grid());
        });
    }

    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('Заказы');
            $content->description('на ремонт');

            $content->body($this->form()->edit($id));
        });
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        return Admin::content(function (Content $content) {

            $content->header('Заказы');
            $content->description('на ремонт');

            $content->body($this->form());
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Order::class, function (Form $form) {

            $form->tab('Клиент/Компания', function(Form $form) {;

                $form->display('id', 'ID');
                $form->display('1c_id', '1C ID');
                $form->select('status_id', 'Статус заказа')->options(Status::all()->pluck('name', 'id'));
                $form->display('user.name', 'ник заказчика');
                $form->display('type_order.name', 'тип заказа');
                $form->html( function (){
                    return '<div class="box box-solid box-default no-margin"><div class="box-body">'.$this->type_client_id.'</div></div>';
                }, 'тип клиента');
                $form->html( function (){
                    return '<div class="box box-solid box-default no-margin"><div class="box-body">'.$this->user->profile->client_name.'</div></div>';
                }, 'ФИО заказчика/Название компании');
                $form->html( function (){
                    return '<div class="box box-solid box-default no-margin"><div class="box-body">'.$this->user->profile->phone.'</div></div>';
                }, 'телефон');
                $form->html( function (){
                    return '<div class="box box-solid box-default no-margin"><div class="box-body">'.$this->service_office->name.'</div></div>';
                }, 'офис обслуживания');
                $form->display('comment', 'комментарий');
                $form->display('created_at', 'Created At');
                $form->display('updated_at', 'Updated At');
            })->tab('Адрес доставки', function(Form $form){
                $form->display('delivery_town', 'город, населенный пункт');
                $form->display('delivery_street', 'улицаt');
                $form->display('delivery_house', 'дом');
                $form->display('delivery_house_block', 'корпус');
                $form->display('delivery_office', 'квартира');
            })->tab('Параметры ремонта', function (Form $form) {
                $form->select('act_repair.status_repair_id', 'Статус ремонта')->options(StatusRepairs::all()->pluck('name', 'id'))->rules('required');
                $form->text('act_repair.device', 'ремонтируемое устройство')->rules('required');
                $form->text('act_repair.set_device', 'комплектация')->rules('required');
                $form->textarea('act_repair.text_defect', 'описание деффекта')->rules('required');
                $form->textarea('act_repair.diagnostic', 'диагностика')->rules('required');
                $form->text('act_repair.cost', 'стоимость')->rules('required');
                $form->textarea('act_repair.comment', 'комментарий');
                //$form->select('act_repair.user_consent_id', 'Ответ заказчика')->options(UserConsent::all()->pluck('name', 'id'))->readOnly();
                $form->html( function (){
                    $val = '';
                    @$val = $this->act_repair->user_consent->name;
                    return '<div class="box box-solid box-default no-margin"><div class="box-body">'.$val.'</div></div>';
                }, 'Ответ заказчика');
            })->tab('История', function(Form $form){
                $form->html(function($form){
                    return view('admin.history', ['histories' => $form->model()->history]);
                });

            })->saving(function(Form $form){
                $order = $form->model();
                $status_new = $form->status_id;
                $status_old = Order::find($order->id)->status_id;
                $status_name = Status::find($status_new)->name;
                if($status_new != $status_old){
                    $order->notify(new StatusOrder($order, $status_name));
                }

                $status_repair_new = $form->act_repair['status_repair_id'];
                @$status_repair_old = ActRepair::where('order_id', $order->id)->get()[0]['status_repair_id'];
                $status_repair_name = StatusRepairs::find($status_repair_new)->name;
                if(!isset($status_repair_old) || (isset($status_repair_old) && $status_repair_new != $status_repair_old)){
                    $order->notify(new StatusOrderRepair($order, $status_repair_name));
                }
            });
        });
    }
}
