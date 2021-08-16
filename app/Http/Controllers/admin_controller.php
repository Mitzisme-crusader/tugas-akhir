<?php

namespace App\Http\Controllers;

use App\Repository\admin_repository_interface;
use Illuminate\Http\Request;
use PDO;
use Throwable;

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
           'email_customer' => 'required|unique:customer,email_customer',
           'nama_perusahaan_customer' => 'required',
           'alamat_customer' => 'required',
           'provinsi_customer' => 'required',
           'npwp_customer' => 'required|numeric',
           'alamat_pajak_customer' => 'required',
           'kode_pos_customer' => 'required|numeric',
           'negara_customer' => 'required',
           'nomor_telepon_customer' => 'required|numeric'
        ]);

        $data_customer = [
            'nama_customer' => $_POST['nama_customer'],
            'email_customer' => $_POST['email_customer'],
            'nama_perusahaan_customer' => $_POST['nama_perusahaan_customer'],
            'alamat_customer' => $_POST['alamat_customer'],
            'provinsi_customer' => $_POST['provinsi_customer'],
            'npwp_customer' => $_POST['npwp_customer'],
            'alamat_pajak_customer' => $_POST['alamat_pajak_customer'],
            'kode_pos_customer' => $_POST['kode_pos_customer'],
            'negara_customer' => $_POST['negara_customer'],
            'nomor_telepon_customer' => $_POST['nomor_telepon_customer'],
            'status_aktif_customer' => '1'
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
        ]);

        $data_service = [
            'nama_service' => $_POST['nama_service'],
            'deskripsi_service' => $_POST['deskripsi_service'],
            'biaya_service' => $_POST['biaya_service'],
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

   //Dokumen
   public function pergi_ke_make_document_SPK(Request $request){
       $target_kolom = array('nama_perusahaan_customer', 'id_customer');
       $list_customer = $this->admin_repository->get_customer($target_kolom);

       $target_kolom = array('nama_service', 'id_service');
       $list_service = $this->admin_repository->get_service($target_kolom);
       return view("pages.admin.make_document")->with('list_customer', $list_customer)->with('list_service', $list_service);
   }

   public function proses_save_document_SPK(Request $request){
       $jenis_service = $_POST['jenis_pekerjaan_radio'];
       $jenis_pengiriman = $_POST['jenis_pengiriman_radio'];
       $jenis_pengangkutan = $_POST['jenis_pengangkutan_radio'];
       dd($jenis_service);
       $customer = $this->admin_repository->find_customer($_POST['list_id_customer']);
       $template = new \PhpOffice\PhpWord\TemplateProcessor(public_path('template_dokumen\template_SPK_grey.docx'));
       $template->setValue('nama_customer', $customer->nama_customer);
       $template->setValue('nama_perusahaan_customer', $customer->nama_perusahaan_customer);
       $template->setValue('alamat_customer', $customer->alamat_customer);
       $template->setValue('provinsi_customer', $customer->provinsi_customer);

        try{
            $template->saveAs(public_path('hasil_dokumen\user_1.docx'));
        }catch (Throwable $e){
            //handle exception
        }

        return response()->download(public_path('hasil_dokumen\user_1.docx'));
   }

   public function proses_logout(Request $request){
    return view('pages.login');
}
}
