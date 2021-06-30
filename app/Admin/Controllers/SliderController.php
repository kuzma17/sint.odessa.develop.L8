<?php

namespace App\Admin\Controllers;

use App\Models\Slider;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class SliderController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Slider';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Slider());

        $grid->column('id', 'ID')->sortable();
        $grid->column('weight', 'Номер')->editable()->sortable();
        $grid->column('image', 'Картинка')->display(function ($img){
            return '<img src="/upload/'.$img.'" style="width:200px; height:60px">';
        });
        $grid->column('url', 'url');
        $grid->column('slogan_ru', 'Слоган')->editable();
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
        $show = new Show(Slider::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('active', __('Active'));
        $show->field('weight', __('Weight'));
        $show->field('image', __('Image'));
        $show->field('url', __('Url'));
        $show->field('slogan_ru', __('Slogan ru'));
        $show->field('slogan_ua', __('Slogan ua'));
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
        $form = new Form(new Slider());

        $form->display('id', 'ID');
        $form->image('image')->resize(965, 400)->uniqueName()->move('slider')->rules('required');
        $form->text('url', 'url')->rules('required');
        $form->text('slogan_ru', 'слоган ru');
        $form->text('slogan_ua', 'слоган ua');
        $form->number('weight', 'номер')->default(Slider::max('weight')+1);
        $form->switch('active')->states()->default(1);

        return $form;
    }
}
