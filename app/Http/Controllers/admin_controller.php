<?php

namespace App\Http\Controllers;

use App\Repository\admin_repository_interface;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
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

        $target_kolom = array('nama_port', 'id_port');
        $list_port = $this->admin_repository->get_port($target_kolom);

        $target_kolom = array('nama_service', 'id_service');
        $list_service = $this->admin_repository->get_service($target_kolom);
        return view("pages.admin.make_document")->with('list_customer', $list_customer)->with('list_service', $list_service)->with('list_port', $list_port);
   }

   public function pergi_ke_list_SPK(Request $request){
       $list_dokumen_SPK = $this->admin_repository->get_all_dokumen_SPK();

       return view("pages.admin.list_dokumen_SPK")->with('list_dokumen_SPK', $list_dokumen_SPK);
   }
   public function proses_save_document_SPK(Request $request){
        $request->validate([
            'list_id_customer' => 'required',
            'list_id_service' => 'required',
            'list_id_port' => 'required',
            'list_container' => 'required',
            'jenis_pengiriman_radio' => 'required',
            'jenis_pengangkutan_radio' => 'required|in:export,import',
            'jenis_pekerjaan_radio' => 'required',
        ]);

        $jenis_service = $_POST['jenis_pekerjaan_radio'];
        $jenis_pengiriman = $_POST['jenis_pengiriman_radio'];
        $jenis_pengangkutan = $_POST['jenis_pengangkutan_radio'];

        $customer = $this->admin_repository->find_customer($_POST['list_id_customer']);
        $port = $this->admin_repository->find_port($_POST['list_id_port']);

        $kode_dokumen = str_pad($this->admin_repository->get_id_dokumen_terbaru(),3,"0",STR_PAD_LEFT);
        $kode_dokumen = $kode_dokumen.'/SP-'.strtoupper($jenis_pengangkutan[0]);
        if($jenis_service == "all in"){
            $kode_dokumen = $kode_dokumen.'/AI-'.strtoupper($jenis_pengiriman[0]);
        }
        else{
            $kode_dokumen = $kode_dokumen.'/'.strtoupper($jenis_service[0]).'-'.strtoupper($jenis_pengiriman[0]);
        }
        $kode_bulan = Carbon::now()->month;
        $map = array('X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1);
        $returnValue = '';
        while ($kode_bulan > 0) {
            foreach ($map as $roman => $int) {
                if($kode_bulan >= $int) {
                    $kode_bulan -= $int;
                    $returnValue .= $roman;
                        break;
                }
            }
        }
        $kode_dokumen = $kode_dokumen . '/' . $returnValue . '/' . Carbon::now()->year;

        $template = new \PhpOffice\PhpWord\TemplateProcessor(public_path("template_dokumen/template_SPK_$jenis_service.docx"));
        $template->setValue('port', $port->nama_port);
        $template->setValue('kode_dokumen', $kode_dokumen);
        $template->setValue('tanggal_pembuatan', Carbon::today()->format('d F y'));
        $template->setValue('nama_customer', $customer->nama_customer);
        $template->setValue('nama_perusahaan_customer', $customer->nama_perusahaan_customer);
        $template->setValue('alamat_customer', $customer->alamat_customer);
        $template->setValue('provinsi_customer', $customer->provinsi_customer);

        $kode_dokumen = str_replace('/','-',$kode_dokumen);

        try{
            $dokumen_spk = [
                'judul_dokumen' => $kode_dokumen,
                'id_customer' => $customer->id_customer,
                'nama_customer' => $customer->nama_customer,
                'nama_perusahaan_customer' => $customer->nama_perusahaan_customer,
                'negara_customer' => $customer->negara_customer,
                'status_aktif_dokumen' => 1,
            ];
            $dokumen = $this->admin_repository->create_dokumen_spk($dokumen_spk);

        }catch (Throwable $e){
            $request->session()->flash('message', "fail to safe");
            return redirect()->back();
        }

        $list_nama_extra_service = array_filter(explode(',', $_POST['hidden_nama_extra_service']));
        if(count($list_nama_extra_service) > 0){

            $list_harga_20_feet_extra_service = array_filter(explode(',', $_POST['hidden_harga_20_feet_extra_service']));
            $list_harga_40_feet_extra_service = array_filter(explode(',', $_POST['hidden_harga_40_feet_extra_service']));
            $list_harga_45_feet_extra_service = array_filter(explode(',', $_POST['hidden_harga_45_feet_extra_service']));

            for ($i=0; $i < count($list_nama_extra_service); $i++) {

                $data_extra_service[$i]['nama_extra_service'] = $i + 3 . ". " . $list_nama_extra_service[$i];

                echo(empty($list_harga_45_feet_extra_service));
                if(!in_array("undefined",$list_harga_20_feet_extra_service) && !empty($list_harga_20_feet_extra_service))
                    $data_extra_service[$i]['harga_20_feet'] = "RP. " . $list_harga_20_feet_extra_service[$i];
                if(!in_array("undefined",$list_harga_40_feet_extra_service) && !empty($list_harga_40_feet_extra_service))
                    $data_extra_service[$i]['harga_40_feet'] = "RP. " . $list_harga_40_feet_extra_service[$i];
                if(!in_array("undefined",$list_harga_45_feet_extra_service) && !empty($list_harga_45_feet_extra_service))
                    $data_extra_service[$i]['harga_45_feet'] = "RP. " . $list_harga_45_feet_extra_service[$i];
            }

            $all_nama_extra_service = array_map(function($data){return $data['nama_extra_service'];}, $data_extra_service);
            $all_harga_20_feet = array_map(function($data){return $data['harga_20_feet'];}, $data_extra_service);
            $all_harga_40_feet = array_map(function($data){return $data['harga_40_feet'];}, $data_extra_service);

            $template->setValue('nama_extra_service', implode('<w:br/>  &#160;&#160;', $all_nama_extra_service));
            $template->setValue('harga_20_feet', implode('<w:br/> &#160;&#160;', $all_harga_20_feet));
            $template->setValue('harga_40_feet', implode('<w:br/>  &#160;&#160;', $all_harga_40_feet));
        }
        else{
            $template->setValue('nama_extra_service', '');
            $template->setValue('harga_20_feet', '');
            $template->setValue('harga_40_feet', '');
        }


        $template->saveAs(public_path("hasil_dokumen/$kode_dokumen.docx"));

        $request->session()->flash('message', 'add dokumen berhasil');
        return response()->download(public_path("hasil_dokumen/$kode_dokumen.docx"));
   }

    public function proses_logout(Request $request){
        return view('pages.login');
    }
}
