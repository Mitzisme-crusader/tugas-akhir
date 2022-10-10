<?php

namespace App\Repository\Eloquent;

use App\Models\user_model;
use App\Repository\user_repository_interface;
use Illuminate\Support\Collection;

class user_repository extends base_repository implements user_repository_interface
{

   /**
    * UserRepository constructor.
    *
    * @param user_model $model
    */
   public function __construct(user_model $model)
   {
       parent::__construct($model);
   }

   /**
    * @return Collection
    */
   public function all(): Collection
   {
       return $this->model->all();
   }

   public function pengecekan_login($email, $password)
   {
       $result = $this->model->Where('email', $email)->Where('password', $password)->get();

       if(!$password){
           $result = $this->model->where('email', $email)->get();
           $result ? true : false ;
       }

       return $result;
   }
}
