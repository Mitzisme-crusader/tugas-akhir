<?php
namespace App\Repository;

use Illuminate\Support\Collection;

interface tagihan_repository_interface
{
   public function all(): Collection;
   //Nomor COA
   public function get_nomor_COA($nomor_COA);
   public function get_all_nomor_COA();
   public function add_COA($data_COA);
   public function tambah_total_COA($nominal, $nomor_rekening);
   public function kurangi_total_COA($nominal, $nomor_rekening);

   //rekening
   public function add_rekening($data_rekening);
   public function get_rekening($nomor_COA);
   public function tambah_total_rekening($nominal, $nomor_rekening);
   public function kurangi_total_rekening($nominal, $nomor_rekening);

   //input tagihan vendor
   public function add_tagihan_vendor($data_tagihan_vendor);
   public function get_tagihan_vendor($id_tagihan_vendor);
   public function get_all_tagihan_vendor();
   public function add_service_tagihan_vendor($data_service_tagihan_vendor);
   public function get_service_tagihan_vendor($id_tagihan_vendor);
   public function bayar_tagihan_vendor($nominal_pembayaran, $id_tagihan_vendor);
   //input tagihan customer
   public function add_tagihan_customer($data_tagihan_customer);
   public function add_service_tagihan_customer($data_service_tagihan_customer);
   public function get_tagihan_customer($id_tagihan_customer);
   public function get_service_tagihan_customer($id_tagihan_customer);
   public function terima_pembayaran_tagihan_customer($nominal_pembayaran, $id_tagihan_customer,$bank_pelunasan);
   public function get_all_tagihan_customer();
   //Jurnal Umum
   public function add_jurnal_umum($data_jurnal_umum);
   public function get_all_jurnal_umum();
}
