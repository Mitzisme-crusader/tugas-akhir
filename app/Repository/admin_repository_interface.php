<?php
namespace App\Repository;

use App\Model\User;
use Illuminate\Support\Collection;

interface admin_repository_interface
{
   public function all(): Collection;
   public function all_service();
   public function add_customer($data_customer);
   public function add_service($data_service);
   public function delete_customer($id_customer);
}
