<?php

namespace App\Providers;
use Illuminate\Contracts\Events\Dispatcher;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;
use Illuminate\Support\ServiceProvider;
use App\User;
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
        $events->listen(BuildingMenu::class, function (BuildingMenu $event) {
            
              if(\Auth::check()){
                if(\Auth::user()->role == 0)
                {
                    $event->menu->add('Admin');
                    $event->menu->add(
                        [
                            'text' => 'Add User',
                            'icon'=>'fas fa-fw fa-user-plus my-2',
                            'url' => route('user.create'),
                            //'icon_color' => 'orange',
                          ],
                      );//end of event->menu
                }//end of admin
            }//end of Auth::check





        });//end of events->listen

    }
}
