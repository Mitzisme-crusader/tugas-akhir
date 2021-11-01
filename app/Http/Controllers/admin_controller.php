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

   //Dokumen SPK
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

   public function search_SPK(Request $request){

       $list_dokumen_SPK = $this->admin_repository->search_dokumen_SPK($_GET["query_search"], $_GET["list_option_table"], $_GET["range_date_search_awal"], $_GET["range_date_search_akhir"]);

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
            'origin' =>"required_if:list_id_service,2",
            'destination' =>"required_if:list_id_service,2"
        ]);

        $jenis_id_service = $_POST['list_id_service'];
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

        $template = new \PhpOffice\PhpWord\TemplateProcessor(public_path("template_dokumen/template_SPK_$jenis_id_service.docx"));
        $template->setValue('port', $port->nama_port);
        $template->setValue('kode_dokumen', $kode_dokumen);
        $template->setValue('tanggal_pembuatan', Carbon::today()->format('d F y'));
        $template->setValue('nama_customer', $customer->nama_customer);
        $template->setValue('nama_perusahaan_customer', $customer->nama_perusahaan_customer);
        $template->setValue('alamat_customer', $customer->alamat_customer);
        $template->setValue('provinsi_customer', $customer->provinsi_customer);
        $template->setValue('jenis_pengiriman', $jenis_pengiriman);
        $template->setValue('origin', $_POST['origin']);
        $template->setValue('destination', $_POST['destination']);

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

        $list_nama_extra_service_freight_origin = array_filter(explode(',', $_POST['hidden_nama_extra_service_freight_origin']));

        if(count($list_nama_extra_service) > 0){
            $list_harga_20_feet_extra_service = array_filter(explode(',', $_POST['hidden_harga_20_feet_extra_service']));
            $list_harga_40_feet_extra_service = array_filter(explode(',', $_POST['hidden_harga_40_feet_extra_service']));
            $list_harga_45_feet_extra_service = array_filter(explode(',', $_POST['hidden_harga_45_feet_extra_service']));

            for ($i=0; $i < count($list_nama_extra_service); $i++) {

                $harga_extra_service = "";

                $data_extra_service[$i]['nama_extra_service'] = $i + 3 . ". " . $list_nama_extra_service[$i];

                if(!in_array("undefined",$list_harga_20_feet_extra_service) && !empty($list_harga_20_feet_extra_service)){
                    $data_extra_service[$i]['harga_20_feet'] = "Rp. " . $list_harga_20_feet_extra_service[$i];
                    $harga_extra_service = $harga_extra_service . "Rp.".$list_harga_20_feet_extra_service[$i].'/20" ';
                }
                if(!in_array("undefined",$list_harga_40_feet_extra_service) && !empty($list_harga_40_feet_extra_service)){
                    $data_extra_service[$i]['harga_40_feet'] = "Rp. " . $list_harga_40_feet_extra_service[$i];
                    $harga_extra_service = $harga_extra_service . ", Rp.".$list_harga_40_feet_extra_service[$i].'/40" ';
                }
                if(!in_array("undefined",$list_harga_45_feet_extra_service) && !empty($list_harga_45_feet_extra_service)){
                    $data_extra_service[$i]['harga_45_feet'] = "Rp. " . $list_harga_45_feet_extra_service[$i];
                    $harga_extra_service = $harga_extra_service . ", Rp.".$list_harga_45_feet_extra_service[$i].'/45" ';
                }

                $data_relasi = [
                    'id_dokumen_spk' => $dokumen->id_dokumen_spk,
                    'nama_extra_service' => $list_nama_extra_service[$i],
                    'harga_extra_service' => $harga_extra_service,
                ];

                $this->admin_repository->create_relasi_dokumenspk_extra_service($data_relasi);

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

        if(count($list_nama_extra_service_freight_origin) > 0){
            $list_nama_extra_service_freight_destination = array_filter(explode(',', $_POST['hidden_nama_extra_service_freight_destination']));
            $list_harga_extra_service_freight_origin = array_filter(explode(',', $_POST['hidden_harga_extra_service_freight_origin']));
            $list_harga_extra_service_freight_destination = array_filter(explode(',', $_POST['hidden_harga_extra_service_freight_destination']));

            for ($i=0; $i < count($list_nama_extra_service_freight_origin); $i++) {
                $data_extra_service[$i]['nama_extra_service_origin'] = $i + 1 . ". " . $list_nama_extra_service_freight_origin[$i];
                $data_extra_service[$i]['harga_extra_service_origin'] = $list_harga_extra_service_freight_origin[$i];
                $data_extra_service[$i]['nama_extra_service_destination'] = $i + 1 . ". " . $list_nama_extra_service_freight_destination[$i];
                $data_extra_service[$i]['harga_extra_service_destination'] = $list_harga_extra_service_freight_destination[$i];
            }

            $all_nama_extra_service_origin = array_map(function($data){return $data['nama_extra_service_origin'];}, $data_extra_service);
            $all_harga_extra_service_origin = array_map(function($data){return $data['harga_extra_service_origin'];}, $data_extra_service);
            $all_nama_extra_service_destination = array_map(function($data){return $data['nama_extra_service_destination'];}, $data_extra_service);
            $all_harga_extra_service_destination = array_map(function($data){return $data['harga_extra_service_destination'];}, $data_extra_service);

            $template->setValue('servis_origin', implode('<w:br/>  &#160;&#160;', $all_nama_extra_service_origin));
            $template->setValue('cost_origin', implode('<w:br/> &#160;&#160;', $all_harga_extra_service_origin));
            $template->setValue('servis_destination', implode('<w:br/>  &#160;&#160;', $all_nama_extra_service_destination));
            $template->setValue('cost_destination', implode('<w:br/>  &#160;&#160;', $all_harga_extra_service_destination));
        }
        else{

        }

        $template->saveAs(public_path("hasil_dokumen/$kode_dokumen.docx"));

        $request->session()->flash('message', 'add dokumen berhasil');
        return response()->download(public_path("hasil_dokumen/$kode_dokumen.docx"));
   }

   //Dokumen simpan berjalan

   public function pergi_ke_make_dokumen_simpan_berjalan(Request $request){
       return view("pages.admin.make_dokumen_simpan_berjalan");
   }

   public function proses_add_dokumen_simpan_berjalan(Request $request){
        $request->validate([
            'nomor_SO' => 'required',
            'nomor_aju' => 'required',
            'consignee' => 'required',
            'notify_party' => 'required',
            'customer' => 'required',
            'verification_order' => 'required',
            'commodity' => 'required',
            'destination' =>"required_if:list_id_service,2",
            'option_pengiriman' => 'required',
            'POL' => 'required',
            'POD' => 'required',
            'option_container' => 'required',
            'party_20' => 'required_if:option_pengiriman,FCL|required_without_all:party_40,party_45',
            'berat_container' => 'required_if:option_pengiriman,LCL',
            'nomor_container' => 'required',
            'nomor_invoice' => 'required',
            'vessal' => 'required',
            'nomor_BL' => 'required',
            'list_surat_penjaluran' => 'required_with:tanggal_nopen',
            'nomor_surat_penjaluran' => 'required_with:tanggal_nopen',
            'option_asal_asuransi' => 'required',
            'nama_asuransi' => 'required',
            'harga_asuransi' => 'required',
        ]);


        $data_dokumen_simpan_berjalan = [
            'nomor_SO' => $_POST['nomor_SO'],
            'nomor_aju' => $_POST['nomor_aju'],
            'consignee' => $_POST['consignee'],
            'notify_party' => $_POST['notify_party'],
            'nama_customer' => $_POST['customer'],
            'verification_order' => $_POST['verification_order'],
            'commodity' => $_POST['commodity'],
            'option_pengiriman' => $_POST['option_pengiriman'],
            'POL' => $_POST['POL'],
            'POD' => $_POST['POD'],
            'option_container' => $_POST['option_container'],
            'party_20' => $_POST['party_20'],
            'party_40' => $_POST['party_40'],
            'party_45' => $_POST['party_45'],
            'berat_container' => $_POST['berat_container'],
            'nomor_container' => $_POST['nomor_container'],
            'nomor_invoice' => $_POST['nomor_invoice'],
            'vessal' => $_POST['vessal'],
            'nomor_BL' => $_POST['nomor_BL'],
            'ETD' => $_POST['ETD'],
            'ETA' => $_POST['ETA'],
            'tanggal_terima_dokumen' => $_POST['tanggal_terima_dokumen'],
            'sending' => $_POST['sending'],
            'tanggal_nopen' => $_POST['tanggal_nopen'],
            'opsi_surat_penjaluran' => $_POST['list_surat_penjaluran'],
            'nomor_surat_penjaluran' => $_POST['nomor_surat_penjaluran'],
            'jumlah_PIB' => $_POST['jumlah_PIB'],
            'jumlah_notul' => $_POST['jumlah_notul'],
            'tanggal_pemeriksaan_barang' => $_POST['tanggal_pemeriksaan_barang'],
            'tanggal_DNP' => $_POST['DNP'],
            'tanggal_SPPB' => $_POST['tanggal_SPPB'],
            'SPPB' => $_POST['SPPB'],
            'tempat_penimbunan' => $_POST['tempat_penimbunan'],
            'tanggal_pengiriman' => $_POST['tanggal_kirim'],
            'alamat_pembongkaran' => $_POST['alamat_pembongkaran'],
            'pemilik_trucking' => $_POST['pemilik_trucking'],
            'nopol_supir' => $_POST['nopol_supir'],
            'balik_depo' => $_POST['balik_depo'],
            'tanggal_depo_kembali' => $_POST['tanggal_depo_kembali'],
            'harga_trucking' => $_POST['harga_trucking'],
            'opsi_asal_asuransi' => $_POST['option_asal_asuransi'],
            'nama_asuransi' => $_POST['nama_asuransi'],
            'harga_asuransi' => $_POST['harga_asuransi'],
        ];

        foreach ($data_dokumen_simpan_berjalan as $element=>$key) {
            if($key == ""){
                $data_dokumen_simpan_berjalan[$element] = null;
            }
        }

        $dokumen_spk = $this->admin_repository->create_dokumen_simpan_berjalan($data_dokumen_simpan_berjalan);

        return redirect()->back();
   }

   public function proses_update_dokumen_simpan_berjalan(Request $request){
        $request->validate([
            'nomor_SO' => 'required',
            'nomor_aju' => 'required',
            'consignee' => 'required',
            'notify_party' => 'required',
            'customer' => 'required',
            'verification_order' => 'required',
            'commodity' => 'required',
            'destination' =>"required_if:list_id_service,2",
            'option_pengiriman' => 'required',
            'POL' => 'required',
            'POD' => 'required',
            'option_container' => 'required',
            'party_20' => 'required_if:option_pengiriman,FCL|required_without_all:party_40,party_45',
            'berat_container' => 'required_if:option_pengiriman,LCL',
            'nomor_container' => 'required',
            'nomor_invoice' => 'required',
            'vessal' => 'required',
            'nomor_BL' => 'required',
            'list_surat_penjaluran' => 'required_with:tanggal_nopen',
            'nomor_surat_penjaluran' => 'required_with:tanggal_nopen',
            'option_asal_asuransi' => 'required',
            'nama_asuransi' => 'required',
            'harga_asuransi' => 'required',
        ]);

        $data_dokumen_simpan_berjalan = [
            'id_dokumen_simpan_berjalan' => $_POST['id_dokumen'],
            'nomor_SO' => $_POST['nomor_SO'],
            'nomor_aju' => $_POST['nomor_aju'],
            'consignee' => $_POST['consignee'],
            'notify_party' => $_POST['notify_party'],
            'nama_customer' => $_POST['customer'],
            'verification_order' => $_POST['verification_order'],
            'commodity' => $_POST['commodity'],
            'option_pengiriman' => $_POST['option_pengiriman'],
            'POL' => $_POST['POL'],
            'POD' => $_POST['POD'],
            'option_container' => $_POST['option_container'],
            'party_20' => $_POST['party_20'],
            'party_40' => $_POST['party_40'],
            'party_45' => $_POST['party_45'],
            'berat_container' => $_POST['berat_container'],
            'nomor_container' => $_POST['nomor_container'],
            'nomor_invoice' => $_POST['nomor_invoice'],
            'vessal' => $_POST['vessal'],
            'nomor_BL' => $_POST['nomor_BL'],
            'ETD' => $_POST['ETD'],
            'ETA' => $_POST['ETA'],
            'tanggal_terima_dokumen' => $_POST['tanggal_terima_dokumen'],
            'sending' => $_POST['sending'],
            'tanggal_nopen' => $_POST['tanggal_nopen'],
            'opsi_surat_penjaluran' => $_POST['list_surat_penjaluran'],
            'nomor_surat_penjaluran' => $_POST['nomor_surat_penjaluran'],
            'jumlah_PIB' => $_POST['jumlah_PIB'],
            'jumlah_notul' => $_POST['jumlah_notul'],
            'tanggal_pemeriksaan_barang' => $_POST['tanggal_pemeriksaan_barang'],
            'tanggal_DNP' => $_POST['DNP'],
            'tanggal_SPPB' => $_POST['tanggal_SPPB'],
            'SPPB' => $_POST['SPPB'],
            'tempat_penimbunan' => $_POST['tempat_penimbunan'],
            'tanggal_pengiriman' => $_POST['tanggal_kirim'],
            'alamat_pembongkaran' => $_POST['alamat_pembongkaran'],
            'pemilik_trucking' => $_POST['pemilik_trucking'],
            'nopol_supir' => $_POST['nopol_supir'],
            'balik_depo' => $_POST['balik_depo'],
            'tanggal_depo_kembali' => $_POST['tanggal_depo_kembali'],
            'harga_trucking' => $_POST['harga_trucking'],
            'opsi_asal_asuransi' => $_POST['option_asal_asuransi'],
            'nama_asuransi' => $_POST['nama_asuransi'],
            'harga_asuransi' => $_POST['harga_asuransi'],
        ];

        foreach ($data_dokumen_simpan_berjalan as $element=>$key) {
            if($key == ""){
                $data_dokumen_simpan_berjalan[$element] = null;
            }
        }

        $dokumen_spk = $this->admin_repository->update_dokumen_simpan_berjalan($data_dokumen_simpan_berjalan);

        return redirect()->back();
   }

   public function pergi_ke_list_dokumen_simpan_berjalan(Request $request){
       $list_dokumen_simpan_berjalan = $this->admin_repository->get_all_dokumen_simpan_berjalan();

       return view("pages.admin.list_dokumen_simpan_berjalan")->with('list_dokumen_simpan_berjalan', $list_dokumen_simpan_berjalan)->with('range_month',"");
   }

   public function search_dokumen_simpan_berjalan(Request $request){
        $list_dokumen_simpan_berjalan = $this->admin_repository->search_dokumen_simpan_berjalan($_GET['query_search'], $_GET['list_option_table'],$_GET['range_month']);

        return view("pages.admin.list_dokumen_simpan_berjalan")->with('list_dokumen_simpan_berjalan', $list_dokumen_simpan_berjalan)->with('range_month', $_GET['range_month']);
   }

   public function pergi_ke_detail_dokumen_simpan_berjalan(Request $request){
       $dokumen_simpan_berjalan = $this->admin_repository->find_dokumen_simpan_berjalan($_GET['id_dokumen']);

       return view("pages.admin.edit_dokumen_simpan_berjalan")->with('dokumen_simpan_berjalan', $dokumen_simpan_berjalan);
   }

   //Dokumen SO
   public function pergi_ke_make_dokumen_SO(Request $request){
       $list_dokumen_SPK = $this->admin_repository->get_all_dokumen_SPK();

       $year = Carbon::now()->format('y');
       $month = Carbon::now()->format('m');
       $nomor_urut = $this->admin_repository->get_id_dokumenSO_terbaru();

       $nomor_dokumen_SO = "SO" . $year . $month . $nomor_urut;

       return view('pages.admin.make_dokumen_SO')->with('list_dokumen_SPK', $list_dokumen_SPK)->with('nomor_dokumen_so', $nomor_dokumen_SO);
   }

   public function get_data_customer(Request $request){
       $judul_dokumen = $request->get('judul_dokumen');

       $dokumen_spk = $this->admin_repository->get_dokumen_SPK($judul_dokumen);

       $customer = $this->admin_repository->find_customer($dokumen_spk->id_customer);

       return response()->json(array('nama' => $customer->nama_customer, 'alamat'=> $customer->alamat_customer,'provinsi'=>$customer->provinsi_customer, 'negara'=>$customer->negara_customer));
   }

   public function proses_logout(Request $request){
       return view('pages.login');
   }
}
