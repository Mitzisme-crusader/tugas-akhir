<?php

namespace App\Repository\Eloquent;

use App\Models\dokumen_simpan_berjalan_model;
use App\Repository\dokumen_simpan_berjalan_repository_interface;
use App\Repository\user_repository_interface;
use Illuminate\Support\Collection;
use Illuminate\Support\Carbon;

class dokumen_simpan_berjalan_repository extends base_repository implements dokumen_simpan_berjalan_repository_interface
{

   /**
    * dokumen_simpan_berjalan constructor.
    *
    * @param dokumen_simpan_berjalan_model $model
    */
   public function __construct(dokumen_simpan_berjalan_model $model)
   {
       parent::__construct($model);
   }

   /**
    * @return Collection
    */
   public function all(): Collection
   {
        $lastmonth = now()->subMonth()->month;
        $month = now()->month;
        $year = now()->year;
        $date = 25;
        $lastdate = 26;
        return dokumen_simpan_berjalan_model::whereBetween('ETA',[$year.'-'.$lastmonth.'-'.$lastdate , $year.'-'.$month.'-'.$date])->get();
   }

   //Dokumen Simpan Berjalan
   public function create($dokumen_simpan_berjalan)
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
    //    $lastmonth = now()->subMonth()->month;
    //    $month = now()->month;
    //    $year = now()->year;
    //    $date = 25;
    //    $lastdate = 26;
    //    return dokumen_simpan_berjalan_model::whereBetween('ETA',[$year.'-'.$lastmonth.'-'.$lastdate , $year.'-'.$month.'-'.$date])->get();
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
}
