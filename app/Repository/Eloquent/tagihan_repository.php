<?php

namespace App\Repository\Eloquent;

use App\Models\tagihan_customer_model;
use App\Models\tagihan_vendor_model;
use App\Models\nomor_chart_of_account_model;
use App\Models\nomor_rekening_model;
use App\Models\relasi_tagihan_vendor_extra_service_model;
use App\Models\relasi_tagihan_customer_extra_service_model;
use App\Models\jurnal_umum_model;
use App\Repository\tagihan_repository_interface;
use Illuminate\Support\Collection;
use Illuminate\Support\Carbon;

class tagihan_repository extends base_repository implements tagihan_repository_interface
{

   /**
    * tagihan constructor.
    *
    * @param tagihan_customer_model $model
    */
   public function __construct(tagihan_customer_model $model)
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

   //Tagihan
   //Tagihan Vendor

    public function add_tagihan_vendor($data_tagihan_vendor){
        return tagihan_vendor_model::create($data_tagihan_vendor);
    }

    public function get_tagihan_vendor($id_tagihan_vendor){
        return tagihan_vendor_model::where('id_tagihan_vendor', $id_tagihan_vendor)->first();
    }
    public function add_service_tagihan_vendor($data_service_tagihan_vendor){
        return relasi_tagihan_vendor_extra_service_model::create($data_service_tagihan_vendor);
    }
    public function get_all_tagihan_vendor(){
        return tagihan_vendor_model::all();
    }

    public function get_service_tagihan_vendor($id_tagihan_vendor){
        return relasi_tagihan_vendor_extra_service_model::where('id_tagihan_vendor', $id_tagihan_vendor)->get();
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

    public function get_tagihan_customer($id_tagihan_customer)
    {
        return tagihan_customer_model::where('id_tagihan_customer', $id_tagihan_customer)->first();
    }

    public function get_service_tagihan_customer($id_tagihan_customer)
    {
        return relasi_tagihan_customer_extra_service_model::where('id_tagihan_customer', $id_tagihan_customer)->get();
    }

    public function terima_pembayaran_tagihan_customer($nominal_pembayaran, $id_tagihan_customer,$bank_pelunasan)
    {
        $piutang = tagihan_customer_model::where('id_tagihan_customer', $id_tagihan_customer)->max('piutang');
        $piutang = $piutang - $nominal_pembayaran;
        return tagihan_customer_model::where('id_tagihan_customer', $id_tagihan_customer)->update(['piutang' => $piutang, 'bank_pelunasan' => $bank_pelunasan]);
    }

    public function get_all_tagihan_customer(){
        return tagihan_customer_model::all();
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

    //Jurnal Umum
    public function add_jurnal_umum($data_jurnal_umum)
    {
        return jurnal_umum_model::create($data_jurnal_umum);
    }

    public function get_all_jurnal_umum(){
        $lastmonth = now()->subMonth()->month;
        $month = now()->month;
        $year = now()->year;
        $date = 25;
        $lastdate = 26;
        return jurnal_umum_model::whereBetween('created_at',[$year.'-'.$lastmonth.'-'.$lastdate , $year.'-'.$month.'-'.$date])->get();
    }
}
