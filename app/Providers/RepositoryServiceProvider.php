<?php

namespace App\Providers;

use App\Repository\eloquent_repository_interface;
use App\Repository\user_repository_interface;
use App\Repository\Eloquent\user_repository;
use App\Repository\Eloquent\base_repository;
use Illuminate\Support\ServiceProvider;

/**
* Class RepositoryServiceProvider
* @package App\Providers
*/
class RepositoryServiceProvider extends ServiceProvider
{
   /**
    * Register services.
    *
    * @return void
    */
   public function register()
   {
       $this->app->bind(eloquent_repository_interface::class, base_repository::class);
       $this->app->bind(user_repository_interface::class, user_repository::class);
   }
}
