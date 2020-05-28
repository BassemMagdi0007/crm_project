<?php

namespace App\Providers;
use Illuminate\Contracts\Events\Dispatcher;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;
use Illuminate\Support\ServiceProvider;
use App\User;
use App\CustomerActiveReply;
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
            // if(\Auth::user()->role==2)
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
                          [
                            'text' => 'Complains',
                            'icon'    => 'fas fa-fw fa-th my-2',
                            'submenu' => 
                            [
                                [
                                    'text' => 'Unassign Complians',
                                    'icon'=>'fas fa-fw fa-exclamation',
                                    'url'=> route('complain.all',0),
                                  ],
                                  [
                                    'text' => 'Assign Complians',
                                    'icon' => 'fas fa-fw fa-check',
                                    'url'=> route('complain.all',1),
                                  ],
                                  [
                                    'text' => 'History Complians',  
                                    'url' => route('complain.all' , 2),
                                    'icon'=>'fas fa-fw fa-history',
                                ],
                            ]
                          ],
                      );//end of admin menu
                }//end of if (admin)
                elseif(\Auth::user()->role == 2)
                {
                    // $user = User::find(\Auth::user()->id);
                    $event->menu->add('CUSTOMER');
                    $event->menu->add(
                    [
                        'text' => 'Create Complian',  
                        'url' => route('complain.create'),
                        'icon'=>'fas fa-fw fa-plus',
                        //'icon_color' => 'orange',
                    ],
                    [
                        'text' => 'Active Complians',  
                        'url' => route('complain.all',1),
                        'icon'=>'fas fa-briefcase',
                    ],
                    [
                        'text' => 'History of Complians',  
                        'url' => route('complain.all' , 2),
                        'icon'=>'fas fa-fw fa-history',
                    ],
                );
                $active=CustomerActiveReply::where('user_id',\Auth::user()->id)->get();
                if(count($active) && $active[0]->number_active_replies >0)
                $event->menu->add(
                    [
                        'text' => 'Active Replies',  
                        'url' => route('reply.active'),
                        'icon'=>'far fa-comment-alt mr-1',
                        'label'=> $active[0]->number_active_replies,
                        'label_color' => 'success',
                    ],
                );
                $event->menu->add(
                    [
                        'text' => 'Replies History',  
                        'url' => route('reply.history'),
                        'icon'=>'fas fa-fw fa-history',
                    ],
                );
                }//end of customer menu
                elseif(\Auth::user()->role ==1)
                {
                    $event->menu->add('EMPLOYEE');
                    $event->menu->add(
                    [
                        'text' => 'Complians',  
                        'url' => route('complain.all',1),
                        'icon'=>'fas fa-fw fa-th',
                        //'icon_color' => 'orange',
                    ],
                    
                    );
                }//end of customer menu
            }//end of Auth::check





        });//end of events->listen

    }
}
