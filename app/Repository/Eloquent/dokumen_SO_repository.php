<?php

namespace App\Repository\Eloquent;

use App\Models\dokumen_so_model;
use App\Models\relasi_dokumen_so_extra_service_model;
use App\Models\relasi_tagihan_customer_extra_service_model;
use App\Models\tagihan_customer_model;
use App\Repository\dokumen_SO_repository_interface;
use Illuminate\Support\Collection;
use Illuminate\Support\Carbon;

class dokumen_SO_repository extends base_repository implements dokumen_SO_repository_interface
{

   /**
    * dokumen_so constructor.
    *
    * @param dokumen_so_model $model
    */
   public function __construct(dokumen_so_model $model)
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

   //Dokumen SO
   public function get_id_dokumenSO_terbaru()
   {
       $id_dokumen = dokumen_so_model::max('id_dokumen_so');
       if (is_null($id_dokumen)){
           $id_dokumen = 0;
       }

       return $id_dokumen + 1;
   }

   public function add_dokumen_SO($data_dokumen_SO){
       return dokumen_so_model::create($data_dokumen_SO);
   }

   public function add_relasi_dokumen_so_extra_service($data_relasi)
   {
       return relasi_dokumen_so_extra_service_model::create($data_relasi);
   }

   public function get_relasi_dokumen_so_extra_service($nomor_so, $freight_location)
   {
       if($freight_location == "1"){
           return relasi_dokumen_so_extra_service_model::where('nomor_so', $nomor_so)->where('freight_location', "1")->get();
       }
       elseif($freight_location == "2"){
           return relasi_dokumen_so_extra_service_model::where('nomor_so', $nomor_so)->where('freight_location', "2")->get();
       }
       else{
           return relasi_dokumen_so_extra_service_model::where('nomor_so', $nomor_so)->get();
       }
   }

   public function delete_relasi_dokumen_so_extra_service($id_dokumen_SO)
   {
       return relasi_dokumen_so_extra_service_model::where('nomor_so', $id_dokumen_SO)->delete();
   }

   public function get_dokumen_so_by_nomor_so($nomor_so)
   {
       return dokumen_so_model::where('nomor_so', $nomor_so)->first();
   }

   public function get_all_dokumen_SO(){
       return dokumen_so_model::all();
   }

   public function find_dokumen_SO($id_dokumen_SO){
       return dokumen_so_model::find($id_dokumen_SO);
   }

   //tagihan pelanggan
    public function add_tagihan_customer($data_tagihan_customer){
        return tagihan_customer_model::create($data_tagihan_customer);
    }

    public function add_service_tagihan_customer($data_service_tagihan_customer){
        return relasi_tagihan_customer_extra_service_model::create($data_service_tagihan_customer);
    }
}
