<?php

namespace App\Admin\Controllers;

use App\Models\Status;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class StatusController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Статусы заказов';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Status());

        $grid->column('id_1c', 'ID')->sortable();
        $grid->column('name', "status");
        $grid->column('name_site', "status site");
        $grid->column('color', "color")->display(function($color){
            return '<span class="badge" style="background-color: '.$color.'">'.$color.'</span>';
        });
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
        $show = new Show(Status::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('id_1c', __('Id 1c'));
        $show->field('name', __('Name'));
        $show->field('name_site', __('Name site'));
        $show->field('color', __('Color'));
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
        $form = new Form(new Status());

        $form->number('id_1c', 'ID')->rules('required');
        $form->text('name', 'status')->rules('required');
        $form->text('name_site', 'status site')->rules('required');
        $form->color('color', 'color');

        return $form;
    }
}
