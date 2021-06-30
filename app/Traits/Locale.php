<?php

namespace App\Traits;


use Illuminate\Support\Facades\Lang;

trait Locale
{
    public function lang(){
        return Lang::locale();
    }

    public function getSlugAttribute(){
        $column = "slug_" . $this->lang();
        return $this->{$column};
    }

    public function getNameAttribute(){
        $column = "name_" . $this->lang();
        return $this->{$column};
    }

    public function getContentAttribute(){
        $column = "content_" . $this->lang();
        return $this->{$column};
    }

    public function getTitleAttribute(){
        $column = "title_" . $this->lang();
        return $this->{$column};
    }

    public function getDescriptionAttribute(){
        $column = "description_" . $this->lang();
        return $this->{$column};
    }

    public function getKeywordsAttribute(){
        $column = "keywords_" . $this->lang();
        return $this->{$column};
    }

    public function getAttributesAttribute(){
        $column = "attributes_" . $this->lang();
        return $this->{$column};
    }

    public function getTextAttribute(){
        $column = "text_" . $this->lang();
        return $this->{$column};
    }

    public function getSloganAttribute(){
        $column = "slogan_" . $this->lang();
        return $this->{$column};
    }
}