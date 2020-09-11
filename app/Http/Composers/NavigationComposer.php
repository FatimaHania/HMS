<?php

namespace App\Http\Composers;

use Illuminate\View\View;

use App\Models\Navigation;

Class NavigationComposer
{


    public function compose(View $view){

        $navigation = new Navigation();

        $getMenu = $navigation->getMenu();

        $view->with('menus' , $getMenu);

    }


}