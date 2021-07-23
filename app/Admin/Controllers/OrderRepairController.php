<?php

namespace App\Admin\Controllers;

use App\Models\ActRepair;
use App\Models\Order;
use App\Models\Status;
use App\Models\StatusRepair;
use App\Notifications\StatusOrder;
use App\Notifications\StatusOrderRepair;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class OrderRepairController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Заказы на ремонт';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Order());

        $grid->model()
            ->where('type_order_id', 2)
            ->with('user','status','act_repair','act_repair.status_repair','user.profile','type_order','type_client','type_payment','service_office','history')
            ->orderBy('id', 'desc');
        $grid->column('id', 'ID')->sortable();
        $grid->column('1c_id', '1C ID')->sortable();
        $grid->column('type_order.name', 'Тип услуги');
        $grid->column('Тип клиента')->display(function (){
            return $this->type_client->name;
        });
        $grid->column('Клиент')->display(function (){
            return $this->user->profile->client_name;
        });

        $grid->column('act_repair.status_repair_id', 'Статус ремонта')->display(function(){
            if($this->type_order_id == 2 && $this->act_repair){
                return '<span class="badge" style="background-color: '.$this->act_repair->status_repair->color.'" >'.$this->act_repair->status_repair->name.'</span>';
            }
            return '';
        });
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

        $grid->disableCreateButton();
        $grid->actions(function($actions){
            $actions->disableDelete();
            // $actions->disableEdit();
        });


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
        $show = new Show(Order::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('1c_id', __('1c id'));
        $show->field('1cuser_id', __('1cuser id'));
        $show->field('user_id', __('User id'));
        $show->field('type_order_id', __('Type order id'));
        $show->field('type_client_id', __('Type client id'));
        $show->field('office_id', __('Office id'));
        $show->field('delivery_town', __('Delivery town'));
        $show->field('delivery_street', __('Delivery street'));
        $show->field('delivery_house', __('Delivery house'));
        $show->field('delivery_house_block', __('Delivery house block'));
        $show->field('delivery_office', __('Delivery office'));
        $show->field('type_payment_id', __('Type payment id'));
        $show->field('comment', __('Comment'));
        $show->field('status_id', __('Status id'));
        $show->field('date_end', __('Date end'));
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
        $form = new Form(new Order());

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
            $form->select('act_repair.status_repair_id', 'Статус ремонта')->options(StatusRepair::all()->pluck('name', 'id'))->rules('required');
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
           // if($status_new != $status_old){
            //    $order->notify(new StatusOrder($order, $status_name));
            //}

            $status_repair_new = $form->act_repair['status_repair_id'];
            @$status_repair_old = ActRepair::where('order_id', $order->id)->get()[0]['status_repair_id'];
            $status_repair_name = StatusRepair::find($status_repair_new)->name;
           // if(!isset($status_repair_old) || (isset($status_repair_old) && $status_repair_new != $status_repair_old)){
           //     $order->notify(new StatusOrderRepair($order, $status_repair_name));
           // }
        });

        return $form;
    }
}
