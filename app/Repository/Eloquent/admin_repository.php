<?php

namespace App\Repository\Eloquent;

use App\models\customer_model;
use App\modelS\service_model;
use App\models\dokumenSpk_model;
use App\models\port_model;
use App\models\dokumen_simpan_berjalan_model;
use App\Models\relasi_dokumenspk_extra_service_model;
use App\models\dokumen_so_model;
use App\models\relasi_dokumen_so_extra_service_model;
use App\models\tagihan_customer_model;
use App\models\relasi_tagihan_customer_extra_service_model;
use App\models\relasi_tagihan_vendor_extra_service;
use App\models\tagihan_vendor_model;
use App\models\nomor_chart_of_account_model;
use App\models\nomor_rekening_model;
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

   //Dokumen Simpan Berjalan
   public function create_dokumen_simpan_berjalan($dokumen_simpan_berjalan)
   {
       return dokumen_simpan_berjalan_model::create($dokumen_simpan_berjalan);
   }

   public function update_dokumen_simpan_berjalan($dokumen_simpan_berjalan)
   {
       return dokumen_simpan_berjalan_model::where("id_dokumen_simpan_berjalan",$dokumen_simpan_berjalan['id_dokumen_simpan_berjalan'])->update($dokumen_simpan_berjalan);
   }

   public function get_dokumen_simpan_berjalan_by_SO($nomor_so){
       return dokumen_simpan_berjalan_model::where('nomor_so', $nomor_so)->first();
   }

   public function get_all_dokumen_simpan_berjalan()
   {
       $lastmonth = now()->subMonth()->month;
       $month = now()->month;
       $year = now()->year;
       $date = 25;
       $lastdate = 26;
       return dokumen_simpan_berjalan_model::whereBetween('ETA',[$year.'-'.$lastmonth.'-'.$lastdate , $year.'-'.$month.'-'.$date])->get();
   }

   public function find_dokumen_simpan_berjalan($id_dokumen)
   {
       return dokumen_simpan_berjalan_model::find($id_dokumen);
   }

   public function search_dokumen_simpan_berjalan($query,$attribute,$month){
        $lastmonth = Carbon::parse($month)->month-1;
        $year = Carbon::parse($month)->year;
        $date = 25;
        $lastdate = 26;

        if($query != "" && $month != ""){
            $list_dokumen_simpan_berjalan = dokumen_simpan_berjalan_model::where($attribute, "LIKE", "%".$query."%")->whereBetween('ETA',[$year.'-'.$lastmonth.'-'.$year.'-'.Carbon::parse($month)->month.'-'.$date])->get();
        }
        else if($month == "" && $query != ""){
            $list_dokumen_simpan_berjalan = dokumen_simpan_berjalan_model::where($attribute, "LIKE", "%".$query."%")->get();
        }
        else if($month != "" && $query == ""){
            $list_dokumen_simpan_berjalan = dokumen_simpan_berjalan_model::whereBetween('ETA',[$year.'-'.$lastmonth.'-'.$lastdate, $year.'-'.Carbon::parse($month)->month.'-'.$date])->get();
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

   //Tagihan
   //Tagihan Vendor

   public function add_tagihan_vendor($data_tagihan_vendor){
       return tagihan_vendor_model::create($data_tagihan_vendor);
   }

   public function get_tagihan_vendor($id_tagihan_vendor){
       return tagihan_vendor_model::where('id_tagihan_vendor', $id_tagihan_vendor)->first();
   }
   public function add_service_tagihan_vendor($data_service_tagihan_vendor){
       return relasi_tagihan_vendor_extra_service::create($data_service_tagihan_vendor);
   }
   public function get_all_tagihan_vendor(){
       return tagihan_vendor_model::all();
   }

   public function get_service_tagihan_vendor($id_tagihan_vendor){
       return relasi_tagihan_vendor_extra_service::where('id_tagihan_vendor', $id_tagihan_vendor)->get();
   }

   public function bayar_tagihan_vendor($nominal_pembayaran, $id_tagihan_vendor){
        $hutang = tagihan_vendor_model::where('id_tagihan_vendor', $id_tagihan_vendor)->max('hutang');
        $hutang = $hutang - $nominal_pembayaran;
        return tagihan_vendor_model::where('id_tagihan_vendor', $id_tagihan_vendor)->update(['hutang' => $hutang]);
   }

   //Tagihan customer

   public function add_tagihan_customer($data_tagihan_customer){
       return tagihan_customer_model::create($data_tagihan_customer);
   }

   public function add_service_tagihan_customer($data_service_tagihan_customer){
       return relasi_tagihan_customer_extra_service_model::create($data_service_tagihan_customer);
   }

   public function get_all_tagihan_customer(){
       return tagihan_customer_model::all();
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

   //Nomor COA
   public function get_nomor_COA($nomor_COA){
        return nomor_chart_of_account_model::where('nomor_COA', $nomor_COA)->first();
   }
   public function get_all_nomor_COA(){
        return nomor_chart_of_account_model::where('status_aktif', '1')->get();
   }

   public function tambah_total_COA($nominal, $nomor_COA){
        $total = nomor_chart_of_account_model::where('nomor_COA', $nomor_COA)->max('total_COA');

        $total = $total + $nominal;

        return nomor_chart_of_account_model::where('nomor_COA', $nomor_COA)->update(['total_COA' => $total]);
   }

    public function kurangi_total_COA($nominal, $nomor_COA){
        $total = nomor_chart_of_account_model::where('nomor_COA', $nomor_COA)->max('total_COA');

        $total = $total - $nominal;

        return nomor_chart_of_account_model::where('nomor_COA', $nomor_COA)->update(['total_COA'=> $total]);
   }

   public function add_COA($data_COA){
        return nomor_chart_of_account_model::create($data_COA);
   }

   //rekening
   public function add_rekening($data_rekening){
        return nomor_rekening_model::create($data_rekening);
   }

   public function get_rekening($nomor_COA){
        return nomor_rekening_model::where('status_aktif', 1)->where('nomor_COA', $nomor_COA)->get();
   }

   public function tambah_total_rekening($nominal, $nomor_rekening){
        $total = nomor_rekening_model::where('nomor_rekening', $nomor_rekening)->max('total_rekening');

        $total = $total + $nominal;

        return nomor_rekening_model::where('nomor_rekening', $nomor_rekening)->update(['total_rekening' => $total]);
   }

    public function kurangi_total_rekening($nominal, $nomor_rekening){
        $total = nomor_rekening_model::where('nomor_rekening', $nomor_rekening)->max('total_rekening');

        $total = $total - $nominal;

        return nomor_rekening_model::where('nomor_rekening', $nomor_rekening)->update(['total_rekening'=> $total]);
    }
}
