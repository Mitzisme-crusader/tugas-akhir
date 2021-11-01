<?php

namespace App\Repository\Eloquent;

use App\models\customer_model;
use App\modelS\service_model;
use App\models\dokumenSpk_model;
use App\models\port_model;
use App\models\dokumen_simpan_berjalan_model;
use App\Models\relasi_dokumenspk_extra_service_model;
use App\models\dokumen_so_model;
use App\Repository\admin_repository_interface;
use Database\Seeders\dokumen_simpan_berjalan_seeder;
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
       $id_dokumen = dokumenSpk_model::max('id_dokumen_so');
       if (is_null($id_dokumen)){
            $id_dokumen = 0;
       }
       dd($id_dokumen);
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

   public function get_dokumen_SPK($judul_dokumen){
       return dokumenSpk_model::where('judul_dokumen',$judul_dokumen)->first();
   }

   public function create_relasi_dokumenspk_extra_service($data_relasi)
   {
       return relasi_dokumenspk_extra_service_model::create($data_relasi);
   }
   //Dokumen Simpan Berjalan
   public function create_dokumen_simpan_berjalan($dokumen_simpan_berjalan)
   {
       return dokumen_simpan_berjalan_model::create($dokumen_simpan_berjalan);
   }

   public function update_dokumen_simpan_berjalan($dokumen_simpan_berjalan)
   {
       return dokumen_simpan_berjalan_model::where("id_dokumen_simpan_berjalan",$dokumen_simpan_berjalan['id_dokumen_simpan_berjalan'])->update($dokumen_simpan_berjalan);
   }
   public function get_all_dokumen_simpan_berjalan()
   {
       $lastmonth = now()->subMonth()->month;
       $month = now()->month;
       $year = now()->year;
       $date = 25;
       $lastdate = 26;
       return dokumen_simpan_berjalan_model::whereBetween('ETA',[$year.$lastmonth.$lastdate , $year.$month.$date])->get();
   }

   public function find_dokumen_simpan_berjalan($id_dokumen)
   {
       return dokumen_simpan_berjalan_model::find($id_dokumen);
   }

   public function search_dokumen_simpan_berjalan($query,$attribute,$month){
        $lastmonth = Carbon::parse($month)->month-1;
        $year = now()->year;
        $date = 25;
        $lastdate = 26;

        if($query != "" && $month != ""){
            $list_dokumen_simpan_berjalan = dokumen_simpan_berjalan_model::where($attribute, "LIKE", "%".$query."%")->whereBetween('ETA',[$year.$lastmonth.$lastdate,$year.Carbon::parse($month)->month.$date])->get();
        }
        else if($month == "" && $query != ""){
            $list_dokumen_simpan_berjalan = dokumen_simpan_berjalan_model::where($attribute, "LIKE", "%".$query."%")->get();
        }
        else if($month != "" && $query == ""){
            $list_dokumen_simpan_berjalan = dokumen_simpan_berjalan_model::whereBetween('ETA',[$year.$lastmonth.$lastdate,$year.Carbon::parse($month)->month.$date])->get();
        }
        else{
            $list_dokumen_simpan_berjalan = dokumen_simpan_berjalan_model::all();
        }


        return $list_dokumen_simpan_berjalan;
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
