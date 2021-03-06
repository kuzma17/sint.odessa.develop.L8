<?php

namespace App\Admin\Controllers;

use App\Models\Menu;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Encore\Admin\Tree;

class MenuController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Меню';

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->title($this->title)
            ->body($this->tree());
    }

    /**
     * Make a grid builder.
     *
     * @return Tree
     */
    protected function tree()
    {
        return Menu::tree(function (Tree $tree) {
            $tree->branch(function ($branch) {
                if ($branch['active'] == 1){
                    $swith = '<div class="bootstrap-switch bootstrap-switch-small" style="position: absolute;right: 100px">
		                        <span class="bootstrap-switch-handle-on bootstrap-switch-success" style="width: 40px;">ON</span>
                                </div>';
                }else{
                    $swith = '<div class="bootstrap-switch bootstrap-switch-small" style="position: absolute;right: 100px">
		                        <span class="bootstrap-switch-handle-off bootstrap-switch-danger" style="width: 40px;">OFF</span>
                                </div>';
                }
                return "{$branch['id']} - {$branch['title_ru']} ({$branch['title_ua']}) <span style='position:absolute;right:50%'> {$branch['url']} </span> {$swith}";
            });
        });
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Menu::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('parent_id', __('Parent id'));
        $show->field('url', __('Url'));
        $show->field('title_ru', __('Title ru'));
        $show->field('title_ua', __('Title ua'));
        $show->field('weight', __('Weight'));
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
        $form = new Form(new Menu());

        $form->number('parent_id', __('Parent id'));
        $form->text('url', __('Url'));
        $form->text('title_ru', 'Название ru')->rules('required');
        $form->text('title_ua', 'Название ua')->rules('required');
        $form->select('parent_id', 'Родитель')->options($this->getSelectMenuItems());
        $form->number('weight', 'Номер')->default(Menu::all()->max('weight'));
        $form->switch('active')->states()->default(1);


        return $form;
    }

    protected function getSelectMenuItems(){

        return Menu::active()
            ->order()
            ->get()
            ->prepend(['title_ru'=>'корень', 'id'=>0])
            ->pluck('title_ru', 'id');
    }
}
