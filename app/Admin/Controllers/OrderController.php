<?php

namespace App\Admin\Controllers;

use App\Models\History;
use App\Notifications\StatusOrder;
use App\Models\Order;
use App\Models\Status;
use App\Models\StatusRepairs;
use App\Models\TypeClient;
use App\Models\TypeOrder;
use App\Models\UserConsent;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class OrderController extends Controller
{
    use ModelForm;
    protected $status;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('Заказы');
            $content->description('');

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
            $content->description('');

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
            $content->description('');

            $content->body($this->form());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */

    protected function grid()
    {
        return Admin::grid(Order::class, function (Grid $grid) {

            $grid->model()
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
            $grid->column('status_id', 'Статус заказа')->display(function(){
                if ($this->status){
                    return '<span class="badge" style="background-color: '.$this->status->color.'">'.$this->status->name.'</span>';
                }
            });
            $grid->column('act_repair.status_repair_id', 'Статус ремонта')->display(function(){
                if($this->act_repair){
                    return '<span class="badge" style="background-color: '.$this->act_repair->status_repair->color.'" >'.$this->act_repair->status_repair->name.'</span>';
                }
                return '';
            });

            $grid->created_at();
            $grid->updated_at();
            $grid->disableCreateButton();
            $grid->actions(function($actions){
                $actions->disableDelete();
                $actions->disableEdit();
            });

            $grid->column('type_order_id', ' ')->display(function ($type) {
                if($type == 1){
                    $url = '/admin/orders/'.$this->id.'/edit';
                }else{
                    $url = '/admin/orderrepairs/'.$this->id.'/edit';
                }

                return '<a href="'.$url.'"><i class="fa fa-edit"></i></a>';

            });


            $grid->filter(function ($filter) {
                $filter->useModal();
                $filter->like('client_name', 'Клиент');
                $filter->is('type_order_id', 'Тип услуги')->select(TypeOrder::all()->pluck('name', 'id'));
                $filter->is('type_client_id', 'Тип клиента')->select(TypeClient::all()->pluck('name', 'id'));
                $filter->is('status_id', 'Статус заказа')->select(Status::all()->pluck('name', 'id'));
                $filter->is('act_repair.status_repair_id', 'Статус ремонта')->select(StatusRepairs::all()->pluck('name', 'id'));
            });
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
                    return '<div class="box box-solid box-default no-margin"><div class="box-body">'.$this->type_client->name.'</div></div>';
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
            })->tab('История', function($form){
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
            });
        });
    }
}
