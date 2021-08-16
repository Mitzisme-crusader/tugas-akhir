<?php
namespace App\Repository;

use App\Model\User;
use Illuminate\Support\Collection;

interface admin_repository_interface
{
   //Customer
   public function all(): Collection;
   public function add_customer($data_customer);
   public function delete_customer($id_customer);
   public function get_customer($target_kolom);
   public function find_customer($id);
   //Service
   public function add_service($data_service);
   public function get_service($target_kolom);
   public function all_service();
}
