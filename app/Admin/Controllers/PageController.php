<?php

namespace App\Admin\Controllers;

use App\Models\Page;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class PageController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Страницы';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Page());

        $grid->column('id', __('Id'));
        $grid->column('url', __('Url'));
        $grid->column('title', __('Title'));
        //$grid->column('keywords', __('Keywords'));
        //$grid->column('content', __('Content'));
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
        $show = new Show(Page::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('url', __('Url'));
        $show->field('title', __('Title'));
        //$show->field('keywords', __('Keywords'));
        //$show->field('content', __('Content'));
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
        $form = new Form(new Page());

        $form->text('title', 'Название')->rules('required');
        $form->text('keywords', 'Ключевые слова');
        //$form->textarea('content', __('Content'));
        $form->ckeditor('content', 'Текст страници')->rules('required');
        $form->text('url', 'url');

        return $form;
    }
}
