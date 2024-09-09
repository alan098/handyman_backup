<?php

namespace App\Providers;

use App\Models\Menu;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\ServiceProvider;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Dispatcher $events)
    {

        // Para agregar menus dinamicos
        // $events->listen(BuildingMenu::class, function (BuildingMenu $event) {
        //     $event->menu->add('MENU DE NAVEGACION');
        //     $subMenu[] = array(
        //                         'text' => 'SubMenu',
        //                         'url' => 'admin/lala'
        //                     );
        //     $event->menu->add([
        //         'text' => 'Blog',
        //         'url' => 'admin/blog',
        //         'submenu' => $subMenu
        //     ]);
        // });
    }

}
