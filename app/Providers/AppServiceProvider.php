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
            if(\Auth::check())
            {
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

                if(\Auth::user()->role == 0)
                {
                    $event->menu->add('Admin');
                    $event->menu->add(
                        [
                            'text' => 'Add User',
                            'icon'=>'fas fa-fw fa-user-plus my-2',
                            'url' => route('user.create'),
                          ],
                          [
                            'text' => 'Users',
                            'icon'    => 'fas fa-fw fa-users my-2',
                            'submenu' => 
                            [
                              [
                                
                                  'text' => 'Admins',
                                  'icon' => 'fas fa-fw fa-user-circle',
                                  'url'  => route('user.all',0),
                              ],
                              [
                                'text' => 'Employees',
                                'icon'=>'fas fa-fw fa-user-circle',
                                'url'  => route('user.all',1),
                              ],
                              [
                                'text' => 'Customers',
                                'icon'=>'fas fa-fw fa-user-circle',
                                'url'  => route('user.all',2),
                              ],
                            ]
                          ],
                      );//end of admin menu
                }//end of if (admin)
                elseif(\Auth::user()->role == 2)
                {
                    $event->menu->add('CUSTOMER');
                    $event->menu->add(
                    [
                        'text' => 'Create Complian',  
                        'url' => route('complain.create'),
                        'icon'=>'fas fa-fw fa-plus',
                        //'icon_color' => 'orange',
                    ],
                    
                    );
                }//end of customer menu
        }//end of Auth::check





        });//end of events->listen

    }
}
