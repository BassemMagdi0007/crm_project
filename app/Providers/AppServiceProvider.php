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
            $event->menu->add(
                [
                    'text' => 'Home',
                    'url'  => 'home',
                    'icon' => 'fas fa-fw fa-home',
                ],
                ['header' => 'ACCOUNT PAGES'],
                [
                    'text' => 'Profile',
                    'url'  => route('user.data',\Auth::user()->id),
                    'icon' => 'fas fa-user fa-lg mr-1 my-2',
                ],
                [
                    'text' => 'change password',
                    'url'  => route('profile.change.form'),
                    'icon' => 'fas fa-fw fa-lock my-2',
                    
                ],
            );//end stable menu
        }//end of Auth::check
              if(\Auth::check()){
                if(\Auth::user()->role == 0)
                {
                    $event->menu->add('Admin');
                    $event->menu->add(
                        [
                            'text' => 'Add User',
                            'icon'=>'fas fa-fw fa-user-plus my-2',
                            'url' => route('user.create'),
                          ],
                      );//end of admin menu
                }//end of if (admin)
            }//end of Auth::check





        });//end of events->listen

    }
}
