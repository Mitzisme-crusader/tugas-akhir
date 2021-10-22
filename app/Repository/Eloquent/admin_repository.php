<?php

namespace App\Repository\Eloquent;

use App\models\customer_model;
use App\modelS\service_model;
use App\models\dokumenSpk_model;
use App\models\port_model;
use App\Repository\admin_repository_interface;
use Illuminate\Support\Carbon;
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
       $this->model->where('id_customer', $id_customer)->update(['status_aktif_customer' => 0]);
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

   //dokumenSPK
   public function get_id_dokumen_terbaru()
   {
       $id_dokumen = dokumenSpk_model::max('id_dokumen_spk');
       if (is_null($id_dokumen)){
            $id_dokumen = 0;
       }
       return $id_dokumen + 1;
   }

   public function create_dokumen_spk($dokumen_spk)
   {
        return dokumenSpk_model::create($dokumen_spk);
   }

   public function get_all_dokumen_SPK()
   {
       $list_dokumen_SPK = dokumenSpk_model::all();
       return $list_dokumen_SPK;
   }

   public function search_dokumen_SPK($query, $attribute, $date_awal, $date_akhir){
       if($query != "" && $date_awal != ""){
           $list_dokumen_SPK = dokumenSpk_model::where($attribute, "LIKE", "%".$query."%")->whereBetween("created_at",[$date_awal,Carbon::parse($date_akhir)->addDays(1)])->get();
       }
       else if($date_awal == "" && $query != ""){
           $list_dokumen_SPK = dokumenSpk_model::where($attribute, "LIKE", "%".$query."%")->get();
       }
       else if($date_awal != "" && $query == ""){
           $list_dokumen_SPK = dokumenSpk_model::whereBetween("created_at",[$date_awal,Carbon::parse($date_akhir)->addDays(1)])->get();
       }
       else{
           $list_dokumen_SPK = dokumenSpk_model::all();
       }


       return $list_dokumen_SPK;
   }
   //port
   public function get_port($target_kolom){
        $hasil = [];
        foreach($target_kolom as $kolom){
            $hasil["$kolom"] = port_model::select("$kolom")->get();
        }
        return $hasil;
   }

   public function find_port($id){
        return port_model::find($id);
   }
}
