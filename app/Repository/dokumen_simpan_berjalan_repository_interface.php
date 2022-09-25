<?php
namespace App\Repository;

use Illuminate\Support\Collection;

interface dokumen_simpan_berjalan_repository_interface
{
   public function all(): Collection;
   //Dokumen Simpan Berjalan
   public function create_dokumen_simpan_berjalan($dokumen_simpan_berjalan);
   public function update_dokumen_simpan_berjalan($dokumen_simpan_berjalan);
   public function find_dokumen_simpan_berjalan($id_dokumen);
   public function search_dokumen_simpan_berjalan($query,$attribute,$month);
   public function get_dokumen_simpan_berjalan_by_SO($nomor_so);
   public function get_all_dokumen_simpan_berjalan();
}
