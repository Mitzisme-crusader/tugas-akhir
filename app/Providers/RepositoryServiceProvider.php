<?php

namespace App\Providers;

use App\Repository\eloquent_repository_interface;
use App\Repository\user_repository_interface;
use App\Repository\admin_repository_interface;
use App\Repository\dokumen_simpan_berjalan_repository_interface;
use App\Repository\dokumen_SO_repository_interface;
use App\Repository\tagihan_repository_interface;
use App\Repository\Eloquent\user_repository;
use App\Repository\Eloquent\admin_repository;
use App\Repository\Eloquent\base_repository;
use App\Repository\Eloquent\dokumen_simpan_berjalan_repository;
use App\Repository\Eloquent\dokumen_SO_repository;
use App\Repository\Eloquent\tagihan_repository;
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
       $this->app->bind(admin_repository_interface::class, admin_repository::class);
       $this->app->bind(dokumen_simpan_berjalan_repository_interface::class, dokumen_simpan_berjalan_repository::class);
       $this->app->bind(dokumen_SO_repository_interface::class, dokumen_SO_repository::class);
       $this->app->bind(tagihan_repository_interface::class, tagihan_repository::class);
    }
}
