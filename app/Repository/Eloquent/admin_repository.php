<?php

namespace App\Repository\Eloquent;

use App\models\customer_model;
use App\modelS\service_model;
use App\Repository\admin_repository_interface;
use Illuminate\Support\Collection;
use PDO;

class admin_repository extends base_repository implements admin_repository_interface
{

   /**
    * admin repository constructor.
    *
    *
    */
   public function __construct(customer_model $model)
   {
       parent::__construct($model);
   }

   /**
    * @return Collection
    */
   //Customer
   public function all(): Collection
   {
       return $this->model->all();
   }

   public function add_customer($data_customer)
   {
       $this->model->insert($data_customer);
   }

   public function delete_customer($id_customer){
       $this->model->where('id_customer', $id_customer)->update(['status_aktif' => 0]);
   }

   public function get_customer($target_kolom){
       $hasil = [];
       foreach($target_kolom as $kolom){
            $hasil["$kolom"] = $this->model->select("$kolom")->get();
       }
       return $hasil;
   }

   public function find_customer($id){
        return $this->model->find($id);
   }

   //Service
   public function add_service($data_service)
   {
       return service_model::insert($data_service);
   }

   public function get_service($target_kolom){
        $hasil = [];
        foreach($target_kolom as $kolom){
            $hasil["$kolom"] = service_model::select("$kolom")->get();
        }
        return $hasil;
   }

   public function all_service()
   {
       return service_model::all();
   }
}
