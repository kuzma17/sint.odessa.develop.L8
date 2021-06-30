<?php

namespace App\Admin\Controllers;

use App\Models\News;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class NewsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Новости';



    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new News());

        $grid->column('id', __('Id'));
        $grid->column('title_ru', __('Title'));
        $grid->column('published_at', __('Published at'));
        $grid->column('published', __('Published'))->switch();
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
        $show = new Show(News::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('url', __('Url'));
        $show->field('title_ru', __('Title ru'));
        $show->field('title_ua', __('Title ua'));
        $show->field('content_ru', __('Content ru'));
        $show->field('content_ua', __('Content ua'));
        $show->field('image', __('Image'));
        $show->field('published_at', __('Published at'));
        $show->field('published', __('Published'));
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
        $form = new Form(new News());

        $form->display('id', 'ID');
        $form->text('title_ru', 'Название ru')->rules('required');
        $form->text('title_ua', 'Название ua')->rules('required');
        $form->ckeditor('content_ru', 'Текст страници ru')->rules('required');
        $form->ckeditor('content_ua', 'Текст страници ua')->rules('required');
        $form->image('image', 'image')->resize(300, 200)->uniqueName()->move('images');
        $form->date('published_at', 'Дата');
        $form->switch('published')->default(1);

        $form->display('created_at', 'Created At');
        $form->display('updated_at', 'Updated At');

        return $form;
    }
}
