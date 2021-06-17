<?php
namespace App\Repository;

use App\Model\User;
use Illuminate\Support\Collection;

interface user_repository_interface
{
   public function all(): Collection;
   public function pengecekan_login($email, $password);
}
