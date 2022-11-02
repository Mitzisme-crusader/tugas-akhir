<?php

namespace App\Repository\Eloquent;

use App\Models\customer_model;
use App\Models\service_model;
use App\Models\dokumenSpk_model;
use App\Models\port_model;
use App\Models\dokumen_simpan_berjalan_model;
use App\Models\relasi_dokumenspk_extra_service_model;
use App\Models\dokumen_so_model;
use App\Models\relasi_dokumen_so_extra_service_model;
use App\Models\tagihan_customer_model;
use App\Models\relasi_tagihan_customer_extra_service_model;
use App\Models\relasi_tagihan_vendor_extra_service_model;
use App\Models\tagihan_vendor_model;
use App\Models\nomor_chart_of_account_model;
use App\Models\nomor_rekening_model;
use App\Repository\admin_repository_interface;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use PDO;
use PhpOffice\PhpSpreadsheet\Calculation\DateTimeExcel\Month;

class admin_repository extends base_repository implements admin_repository_interface
{

   /**
    * admin repository constructor.
    *
    *@param customer_model $model
    */
   public function __construct(customer_model $model)
   {
       parent::__construct($model);
   }

//    /**
//     * @return Collection
//     */
//    //Customer
//    public function all(): Collection
//    {
//        return $this->model->all();
//    }

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

   public function get_dokumen_SPK($judul_dokumen){
       return dokumenSpk_model::where('judul_dokumen',$judul_dokumen)->first();
   }

   public function create_relasi_dokumenspk_extra_service($data_relasi)
   {
       return relasi_dokumenspk_extra_service_model::create($data_relasi);
   }

   public function get_relasi_dokumen_spk_extra_service($judul_dokumen)
   {
       return relasi_dokumenspk_extra_service_model::where("judul_dokumen", $judul_dokumen)->get();
   }
   public function get_relasi_dokumen_spk_extra_service_freight_origin($judul_dokumen)
   {
       return relasi_dokumenspk_extra_service_model::where("judul_dokumen", $judul_dokumen)->where("freight_location","1")->get();
   }
   public function get_relasi_dokumen_spk_extra_service_freight_destination($judul_dokumen)
   {
       return relasi_dokumenspk_extra_service_model::where("judul_dokumen", $judul_dokumen)->where("freight_location","2")->get();
   }

}
