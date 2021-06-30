<?php

namespace App\Http\Controllers;


class LocaleController
{
    public function changeLocal($locale){
        app()->setLocale($locale);
        session(['locale' => $locale]);
        return redirect()->back();
    }
}
