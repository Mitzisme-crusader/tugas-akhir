<?php

namespace App\Http\Controllers;

use App\Repository\admin_repository_interface;
use Illuminate\Http\Request;

class admin_controller extends Controller
{
    private $admin_repository;

    public function __construct(admin_repository_interface $admin_repository)
   {
       $this->admin_repository = $admin_repository;
   }

   //Customer
   public function proses_add_customer(Request $request){
       $request->validate([
           'nama_customer' => 'required',
           'email_customer' => 'required|unique:customer,email',
           'npwp_customer' => 'required|numeric',
           'alamat_pajak_customer' => 'required',
           'kode_pos_customer' => 'required|numeric',
           'negara_customer' => 'required',
           'nomor_telepon_customer' => 'required|numeric'
        ]);

        $data_customer = [
            'nama' => $_POST['nama_customer'],
            'email' => $_POST['email_customer'],
            'npwp' => $_POST['npwp_customer'],
            'alamat_pajak' => $_POST['alamat_pajak_customer'],
            'kode_pos' => $_POST['kode_pos_customer'],
            'negara' => $_POST['negara_customer'],
            'nomor_telepon' => $_POST['nomor_telepon_customer'],
            'status_aktif' => '1'
        ];

        $this->admin_repository->add_customer($data_customer);

        $request->session()->flash('message', 'add customer berhasil');
        return redirect()->back();
   }

   public function proses_delete_customer(Request $request){
        $id_customer = $_POST['id_customer'];

        $this->admin_repository->delete_customer($id_customer);

        $request->session()->flash('message', 'Customer telah di non-aktifkan');
        return redirect()->back();
   }

   public function pergi_ke_list_customer(Request $request){
       $list_customer = $this->admin_repository->all();
       return view("pages.admin.list_customer")->with('list_customer', $list_customer);
   }

   public function pergi_ke_add_customer(Request $request){
       return view("pages.admin.add_customer");
   }

   //Service
   public function proses_add_service(Request $request){
        $request->validate([
           'nama_service' => 'required',
           'deskripsi_service' => 'required',
           'biaya_service' => 'required|numeric',
           'detail_biaya' => 'required',
        ]);

        $data_service = [
            'nama_service' => $_POST['nama_service'],
            'deskripsi_service' => $_POST['deskripsi_service'],
            'biaya_service' => $_POST['biaya_service'],
            'detail_biaya' => $_POST['detail_biaya'],
            'status_aktif' => '1'
        ];

        $this->admin_repository->add_service($data_service);

        $request->session()->flash('message', 'add service berhasil');
        return redirect()->back();
    }

   public function pergi_ke_list_service(Request $request){
       $list_service = $this->admin_repository->all_service();
       return view("pages.admin.list_service")->with('list_service', $list_service);
   }

   public function pergi_ke_add_service(Request $request){
       return view("pages.admin.add_service");
   }
   public function proses_logout(Request $request){
       return view('pages.login');
   }

   //Dokumen

   public function pergi_ke_make_document(Request $request){
       return view("pages.admin.add_service");
   }
}
