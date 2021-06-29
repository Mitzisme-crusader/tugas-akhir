<?php
namespace App\Repository;

use App\Model\User;
use Illuminate\Support\Collection;

interface admin_repository_interface
{
   public function all(): Collection;
   public function add_customer($data_customer);
}
