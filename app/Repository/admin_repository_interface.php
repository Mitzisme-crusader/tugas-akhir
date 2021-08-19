<?php
namespace App\Repository;

use App\Model\User;
use App\models\user_model;
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
   //Dokumen SPK
   public function get_id_dokumen_terbaru();
   public function create_dokumen_spk($dokumen_spk);
   public function get_all_dokumen_SPK();
   //port
   public function get_port($target_kolom);
   public function find_port($id);
}
