<?php

namespace App\Repository;

use Illuminate\Database\Eloquent\Model;

/**
* Interface eloquent_repository_interface
* @package App\Repositories
*/
interface eloquent_repository_interface
{
   /**
    * @param array $attributes
    * @return Model
    */
   public function create($attributes);

   /**
    * @param $id
    * @return Model
    */
   public function find($id);

   public function all();
}
