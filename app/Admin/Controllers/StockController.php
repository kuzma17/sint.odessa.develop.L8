<?php

namespace App\Admin\Controllers;

use App\Models\Stock;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class StockController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Акции';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Stock());

        $grid->column('id', 'ID')->sortable();
        $grid->column('title', 'title');
        $grid->column('banner', 'баннер')->display(function ($img){
            return '<img src="/upload/'.$img.'" style="width:200px; height:60px">';
        });
        $grid->column('from', 'Дата начала');
        $grid->column('to', 'Дата окончания');
        $grid->column('active', 'Статус')->switch();
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
        $show = new Show(Stock::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('title', __('Title'));
        $show->field('banner', __('Banner'));
        $show->field('content', __('Content'));
        $show->field('from', __('From'));
        $show->field('to', __('To'));
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
        $form = new Form(new Stock());

        $form->display('id', 'ID');
        $form->text('title', 'Название')->rules('required');
        $form->ckeditor('content', 'Текст')->rules('required');
        $form->image('banner', 'баннер')->uniqueName()->move('banners');
        $form->date('from', 'Дата начала');
        $form->date('to', 'Дата окончания');
        $form->switch('active')->states()->default(1);

        return $form;
    }
}
