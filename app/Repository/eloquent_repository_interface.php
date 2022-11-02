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
   public function create(array $attributes): Model;

   /**
    * @param $id
    * @return Model
    */
   public function find($id): ?Model;

   public function all();
}
