<?php

namespace App\Http\Controllers;

use App\Repository\admin_repository_interface;
use App\Repository\Eloquent\admin_repository;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use PDO;
use Psy\CodeCleaner\EmptyArrayDimFetchPass;
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
           'email_customer' => 'required|unique:customer,email_customer|email',
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
            'list_container' => 'required_if:list_id_service,1',
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
                'id_service' => $jenis_id_service,
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

        $list_nama_extra_service_freight_destination = array_filter(explode(',', $_POST['hidden_nama_extra_service_freight_destination']));

        //INPUT DATA EXTRA SERVICE PPJK
        if(count($list_nama_extra_service) > 0){
            $list_harga_20_feet_extra_service = array_filter(explode(',', $_POST['hidden_harga_20_feet_extra_service']));
            $list_harga_40_feet_extra_service = array_filter(explode(',', $_POST['hidden_harga_40_feet_extra_service']));
            $list_harga_45_feet_extra_service = array_filter(explode(',', $_POST['hidden_harga_45_feet_extra_service']));

            for ($i=0; $i < count($list_nama_extra_service); $i++) {

                $data_extra_service[$i]['nama_extra_service'] = $i + 3 . ". " . $list_nama_extra_service[$i];

                if(!in_array("undefined",$list_harga_20_feet_extra_service) && !empty($list_harga_20_feet_extra_service)){
                    $data_extra_service[$i]['harga_20_feet'] = "Rp. " . $list_harga_20_feet_extra_service[$i];
                    $data_relasi = [
                        'judul_dokumen' => $dokumen->judul_dokumen,
                        'nama_extra_service' => $list_nama_extra_service[$i],
                        'harga_extra_service' => $list_harga_20_feet_extra_service[$i],
                        'container' => '20',
                    ];

                    $this->admin_repository->create_relasi_dokumenspk_extra_service($data_relasi);
                }
                if(!in_array("undefined",$list_harga_40_feet_extra_service) && !empty($list_harga_40_feet_extra_service)){
                    $data_extra_service[$i]['harga_40_feet'] = "Rp. " . $list_harga_40_feet_extra_service[$i];
                    $data_relasi = [
                        'judul_dokumen' => $dokumen->judul_dokumen,
                        'nama_extra_service' => $list_nama_extra_service[$i],
                        'harga_extra_service' => $list_harga_40_feet_extra_service[$i],
                        'container' => '40',
                    ];

                    $this->admin_repository->create_relasi_dokumenspk_extra_service($data_relasi);
                }
                if(!in_array("undefined",$list_harga_45_feet_extra_service) && !empty($list_harga_45_feet_extra_service)){
                    $data_extra_service[$i]['harga_45_feet'] = "Rp. " . $list_harga_45_feet_extra_service[$i];
                    $data_relasi = [
                        'judul_dokumen' => $dokumen->judul_dokumen,
                        'nama_extra_service' => $list_nama_extra_service[$i],
                        'harga_extra_service' => $list_harga_45_feet_extra_service[$i],
                        'container' => '45',
                    ];

                    $this->admin_repository->create_relasi_dokumenspk_extra_service($data_relasi);
                }

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

        //INPUT DATA EXTRA SERVICE FREIGHT
        if(count($list_nama_extra_service_freight_origin) > 0 || count($list_nama_extra_service_freight_destination) > 0){
            $list_harga_extra_service_freight_origin = array_filter(explode(',', $_POST['hidden_harga_extra_service_freight_origin']));
            $list_harga_extra_service_freight_destination = array_filter(explode(',', $_POST['hidden_harga_extra_service_freight_destination']));

            for ($i=0; $i < count($list_nama_extra_service_freight_origin); $i++) {
                $data_extra_service['nama_extra_service_origin'][$i] = $i + 1 . ". " . $list_nama_extra_service_freight_origin[$i];
                $data_extra_service['harga_extra_service_origin'][$i] = $list_harga_extra_service_freight_origin[$i];

                $data_relasi = [
                    'judul_dokumen' => $dokumen->judul_dokumen,
                    'nama_extra_service' => $list_nama_extra_service_freight_origin[$i],
                    'harga_extra_service' => $list_harga_extra_service_freight_origin[$i],
                ];

                $this->admin_repository->create_relasi_dokumenspk_extra_service($data_relasi);
            }

            for ($i=0; $i < count($list_nama_extra_service_freight_destination); $i++) {
                $data_extra_service['nama_extra_service_destination'][$i] = $i + 1 . ". " . $list_nama_extra_service_freight_destination[$i];
                $data_extra_service['harga_extra_service_destination'][$i] = $list_harga_extra_service_freight_destination[$i];

                $data_relasi = [
                    'judul_dokumen' => $dokumen->judul_dokumen,
                    'nama_extra_service' => $list_nama_extra_service_freight_destination[$i],
                    'harga_extra_service' => $list_harga_extra_service_freight_destination[$i],
                ];

                $this->admin_repository->create_relasi_dokumenspk_extra_service($data_relasi);
            }

            if(!empty($list_nama_extra_service_freight_origin)){
                $all_nama_extra_service_origin = array_map(function($data){return $data;}, $data_extra_service['nama_extra_service_origin']);
                $all_harga_extra_service_origin = array_map(function($data){return $data;}, $data_extra_service['harga_extra_service_origin']);
                $template->setValue('servis_origin', implode('<w:br/>  &#160;&#160;', $all_nama_extra_service_origin));
                $template->setValue('cost_origin', implode('<w:br/>&#160;&#160;', $all_harga_extra_service_origin));
            }
            else{
                $template->setValue('servis_origin', 'N/A');
                $template->setValue('cost_origin', 'N/A');
            }

            if(!empty($list_nama_extra_service_freight_destination)){
                $all_nama_extra_service_destination = array_map(function($data){return $data;}, $data_extra_service['nama_extra_service_destination']);
                $all_harga_extra_service_destination = array_map(function($data){return $data;}, $data_extra_service['harga_extra_service_destination']);
                $template->setValue('servis_destination', implode('<w:br/>  &#160;&#160;', $all_nama_extra_service_destination));
                $template->setValue('cost_destination', implode('<w:br/>&#160;&#160;', $all_harga_extra_service_destination));
            }
            else{
                $template->setValue('servis_destination', 'N/A');
                $template->setValue('cost_destination', 'N/A');
            }

        }
        else{
            $template->setValue('servis_origin', 'N/A');
            $template->setValue('cost_origin', 'N/A');
            $template->setValue('servis_destination', 'N/A');
            $template->setValue('cost_destination', 'N/A');
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

       $list_extra_service = $this->admin_repository->get_relasi_dokumen_spk_extra_service($dokumen_spk->judul_dokumen);

       $customer = $this->admin_repository->find_customer($dokumen_spk->id_customer);

       return response()->json(array('customer' => $customer, 'list_extra_service' => $list_extra_service, 'dokumen_spk' => $dokumen_spk));
   }

   public function proses_add_dokumen_so(Request $request){
       $request->validate([
            'input_nama_service.*' => 'required',
            'input_quantity_service.*' => 'required',
            'input_harga_service.*' => 'required',
            'input_total.*' => 'required|numeric|min:10000',
       ]);
       $list_service_dokumen_so = array();

       foreach ($_POST['checkbox_status_service'] as $key) {
           $list_service_dokumen_so[$key]['nama_service'] = $_POST['input_nama_service'][$key];
           $list_service_dokumen_so[$key]['quantity_service'] = $_POST['input_quantity_service'][$key];

           if(isset($_POST['input_container_service'])){
               $list_service_dokumen_so[$key]['container_service'] = $_POST['input_container_service'][$key];
           }

           $list_service_dokumen_so[$key]['harga_service'] = $_POST['input_harga_service'][$key];
           $list_service_dokumen_so[$key]['diskon_service'] = $_POST['input_diskon_service'][$key];
           $list_service_dokumen_so[$key]['pajak_service'] = $_POST['input_pajak_service'][$key];
           $list_service_dokumen_so[$key]['total'] = $_POST['input_total'][$key];
       }

       $data_dokumen_SO = [
           'nomor_so' => $_POST['Id_dokumen'],
           'tanggal_so' => $_POST['tanggal_SO'],
           'judul_dokumen_spk' => $_POST['option_dokumen_SPK'],
           'nama_customer' => $_POST['input_nama_customer'],
           'alamat_customer' => $_POST['input_alamat_customer'],
           'status_aktif_dokumen' => 1
       ];

       $dokumen_SO = $this->admin_repository->add_dokumen_SO($data_dokumen_SO);

       foreach ($list_service_dokumen_so as $service_dokumen_so) {
            $data_relasi_dokumen_so_extra_service = [
                'nomor_so' => $dokumen_SO->nomor_so,
                'nama_service' => $service_dokumen_so['nama_service'],
                'judul_dokumen_spk' => $_POST['option_dokumen_SPK'],
                'quantity_service' => $service_dokumen_so['quantity_service'],
                'harga_service' => $service_dokumen_so['harga_service'],
                'diskon_service' => $service_dokumen_so['diskon_service'],
                'pajak_service' => $service_dokumen_so['pajak_service'],
                'total_service' => $service_dokumen_so['total'],
            ];

            if(isset($_POST['input_container_service'])){
                $data_relasi_dokumen_so_extra_service['container_service'] =  $service_dokumen_so['container_service'];
            }

            foreach ($data_relasi_dokumen_so_extra_service as $element=>$key) {
                if($key == ""){
                    $data_relasi_dokumen_so_extra_service[$element] = 0;
                }
            }

            $relasi = $this->admin_repository->add_relasi_dokumen_so_extra_service($data_relasi_dokumen_so_extra_service);
       }

       $request->session()->flash('message', 'add dokumen berhasil');
       return redirect()->back();
   }

   public function pergi_ke_list_dokumen_SO(Request $request){
       $list_dokumen_SO = $this->admin_repository->get_all_dokumen_SO();

       return view('pages.admin.list_dokumen_so')->with('list_dokumen_SO', $list_dokumen_SO);
   }

   public function pergi_ke_edit_so(Request $request){
       $id_dokumen_so = $_GET['id_dokumen_so'];

       $dokumen_so = $this->admin_repository->find_dokumen_SO($id_dokumen_so);

       $list_relasi_dokumen_so_extra_service = $this->admin_repository->get_relasi_dokumen_so_extra_service($dokumen_so->nomor_so);

       $list_relasi_dokumen_spk_extra_service = $this->admin_repository->get_relasi_dokumen_spk_extra_service($dokumen_so->judul_dokumen_spk);

       $list_service_uncheked = array();

       foreach($list_relasi_dokumen_spk_extra_service as $relasi_dokumen_spk_extra_service){
           $boolean_in_dokumen_so = false;
           foreach($list_relasi_dokumen_so_extra_service as $relasi_dokumen_so_extra_service){
               if($relasi_dokumen_spk_extra_service->container !=null){
                    if($relasi_dokumen_spk_extra_service->nama_extra_service == $relasi_dokumen_so_extra_service->nama_service && $relasi_dokumen_spk_extra_service->container == $relasi_dokumen_so_extra_service->container_service){
                        $boolean_in_dokumen_so = true;
                    }
               }
               else{
                    if($relasi_dokumen_spk_extra_service->nama_extra_service == $relasi_dokumen_so_extra_service->nama_service){
                        $boolean_in_dokumen_so = true;
                    }
               }
           }

           if($boolean_in_dokumen_so == false){
               array_push($list_service_uncheked, $relasi_dokumen_spk_extra_service);
           }
       }

       return view('pages.admin.edit_dokumen_SO')->with('dokumen_so', $dokumen_so)->with('list_relasi', $list_relasi_dokumen_so_extra_service)->with('list_service_unchecked', $list_service_uncheked);
   }

   public function proses_edit_dokumen_so(Request $request){
       $request->validate([
           'input_nama_service.*' => 'required',
           'input_quantity_service.*' => 'required',
           'input_harga_service.*' => 'required',
           'input_total.*' => 'required|numeric|min:10000',
       ]);
       $list_service_dokumen_so = array();

       foreach ($_POST['checkbox_status_service'] as $key) {
           $list_service_dokumen_so[$key]['nama_service'] = $_POST['input_nama_service'][$key];
           $list_service_dokumen_so[$key]['quantity_service'] = $_POST['input_quantity_service'][$key];
           $list_service_dokumen_so[$key]['container_service'] = $_POST['input_container_service'][$key];
           $list_service_dokumen_so[$key]['harga_service'] = $_POST['input_harga_service'][$key];
           $list_service_dokumen_so[$key]['diskon_service'] = $_POST['input_diskon_service'][$key];
           $list_service_dokumen_so[$key]['pajak_service'] = $_POST['input_pajak_service'][$key];
           $list_service_dokumen_so[$key]['total'] = $_POST['input_total'][$key];
       }

       $this->admin_repository->delete_relasi_dokumen_so_extra_service($_POST['Id_dokumen']);

       foreach ($list_service_dokumen_so as $service_dokumen_so) {
            $data_relasi_dokumen_so_extra_service = [
               'nomor_so' => $_POST['Id_dokumen'],
               'nama_service' => $service_dokumen_so['nama_service'],
               'judul_dokumen_spk' => $_POST['option_dokumen_SPK'],
               'quantity_service' => $service_dokumen_so['quantity_service'],
               'container_service' => $service_dokumen_so['container_service'],
               'harga_service' => $service_dokumen_so['harga_service'],
               'diskon_service' => $service_dokumen_so['diskon_service'],
               'pajak_service' => $service_dokumen_so['pajak_service'],
               'total_service' => $service_dokumen_so['total'],
            ];

            foreach ($data_relasi_dokumen_so_extra_service as $element=>$key) {
                if($key == ""){
                    $data_relasi_dokumen_so_extra_service[$element] = 0;
                }
            }

            $relasi = $this->admin_repository->add_relasi_dokumen_so_extra_service($data_relasi_dokumen_so_extra_service);
        }

    $request->session()->flash('message', 'Edit dokumen berhasil');
    return redirect()->back();
   }

   public function proses_logout(Request $request){
       return view('pages.login');
   }

   //Tagihan

   //Input Tagihan Vendor

   public function pergi_ke_input_tagihan_vendor(Request $request){
       $list_dokumen_SO = $this->admin_repository->get_all_dokumen_SO();

       return view('pages.admin.input_tagihan_vendor')->with('list_dokumen_SO', $list_dokumen_SO);
   }

   public function proses_input_tagihan_vendor(Request $request){
       $request->validate([
           'input_vendor_service.*' => 'required',
           'input_total.*' => 'required|numeric|min:10000',
       ]);
       $list_tagihan_dokumen_SO = array();

       foreach ($_POST['checkbox_status_service'] as $key) {
            $list_tagihan_dokumen_SO[$key]['vendor_service'] = $_POST['input_vendor_service'][$key];
            $list_tagihan_dokumen_SO[$key]['nama_service'] = $_POST['input_nama_service'][$key];
            $list_tagihan_dokumen_SO[$key]['quantity_service'] = $_POST['input_quantity_service'][$key];

            if(isset($_POST['input_container_service'])){
                $list_tagihan_dokumen_SO[$key]['container_service'] = $_POST['input_container_service'][$key];
            }

            $list_tagihan_dokumen_SO[$key]['harga_service'] = $_POST['input_harga_service'][$key];
            $list_tagihan_dokumen_SO[$key]['diskon_service'] = $_POST['input_diskon_service'][$key];
            $list_tagihan_dokumen_SO[$key]['pajak_service'] = $_POST['input_pajak_service'][$key];
            $list_tagihan_dokumen_SO[$key]['keterangan_tagihan'] = $_POST['keterangan_tagihan'][$key];
            $list_tagihan_dokumen_SO[$key]['total'] = $_POST['input_total'][$key];
       }

       foreach ($list_tagihan_dokumen_SO as $tagihan_dokumen_SO) {
            $data_tagihan_dokumen_SO= [
                'nomor_so' => $_POST['option_dokumen_SO'],
                'keterangan_tagihan' =>$tagihan_dokumen_SO['keterangan_tagihan'],
                'vendor_service' => $tagihan_dokumen_SO['vendor_service'],
                'nama_service' => $tagihan_dokumen_SO['nama_service'],
                'quantity_service' => $tagihan_dokumen_SO['quantity_service'],
                'harga_service' => $tagihan_dokumen_SO['harga_service'],
                'diskon_service' => $tagihan_dokumen_SO['diskon_service'],
                'pajak_service' => $tagihan_dokumen_SO['pajak_service'],
                'total_service' => $tagihan_dokumen_SO['total'],
                'hutang' =>$tagihan_dokumen_SO['total'],
            ];

            if(isset($_POST['input_container_service'])){
                $data_tagihan_dokumen_SO['container_service'] =  $tagihan_dokumen_SO['container_service'];
            }

            foreach ($data_tagihan_dokumen_SO as $element=>$key) {
                if($key == ""){
                    $data_tagihan_dokumen_SO[$element] = null;
                }
            }

            $tagihan_dokumen_SO = $this->admin_repository->add_tagihan_vendor($data_tagihan_dokumen_SO);
        }

        return redirect()->back();

   }

   public function pergi_ke_list_dokumen_SO_untuk_tagihan(Request $request){
       $list_dokumen_SO = $this->admin_repository->get_all_dokumen_SO_with_total_hutang();

       return view('pages.admin.list_dokumen_SO_untuk_tagihan')->with('list_dokumen_SO', $list_dokumen_SO);
   }

   public function pergi_ke_detail_tagihan_vendor(Request $request){
       dd($_GET);
   }
   public function get_data_extra_service_SO(Request $request){
        $nomor_SO = $request->get('nomor_so');

        $list_relasi_extra_service_SO = $this->admin_repository->get_relasi_dokumen_so_extra_service($nomor_SO);

        return response()->json(array('list_extra_service' => $list_relasi_extra_service_SO));
   }
}
