<?php

namespace App\Http\Controllers;

use App\Http\Controllers\convert_number as ControllersConvert_number;
use App\Repository\admin_repository_interface;
use App\Repository\dokumen_SO_repository_interface;
use App\Repository\dokumen_simpan_berjalan_repository_interface;
use App\Repository\tagihan_repository_interface;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use numbertowordconverter;
use PDO;
use PhpOffice\PhpSpreadsheet\Calculation\TextData\Replace;
use Psy\CodeCleaner\EmptyArrayDimFetchPass;
use Throwable;

class admin_controller extends Controller
{
    private $admin_repository;
    private $dokumen_so_repository;
    private $dokumen_simpan_berjalan_repository;
    private $tagihan_repository;

    public function __construct(admin_repository_interface $admin_repository, dokumen_SO_repository_interface $dokumen_so_repository, dokumen_simpan_berjalan_repository_interface $dokumen_simpan_berjalan_repository, tagihan_repository_interface $tagihan_repository )
   {
       $this->admin_repository = $admin_repository;
       $this->dokumen_so_repository = $dokumen_so_repository;
       $this->dokumen_simpan_berjalan_repository = $dokumen_simpan_berjalan_repository;
       $this->tagihan_repository = $tagihan_repository;
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
            'list_metode_pengangkutan' => 'required_if:list_id_service,2',
            'jenis_pekerjaan_radio' => 'required',
            'origin' =>"required_if:list_id_service,2",
            'destination' =>"required_if:list_id_service,2"
        ]);

        $jenis_id_service = $_POST['list_id_service'];
        $jenis_service = $_POST['jenis_pekerjaan_radio'];
        $jenis_pengiriman = $_POST['jenis_pengiriman_radio'];
        $jenis_pengangkutan = $_POST['jenis_pengangkutan_radio'];

        $metode_pengirman = null;
        if($jenis_id_service == 2){
            $metode_pengirman = $_POST['list_metode_pengangkutan'];
        }

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
        $template->setValue('metode_pengiriman', ucfirst($metode_pengirman));
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
                'metode_pengiriman' => $metode_pengirman,
                'nama_port' => $port->nama_port,
                'origin' => $_POST['origin'],
                'destination' => $_POST['destination'],
                'container' => $_POST['list_container'],
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
            $list_harga_20_feet_extra_service = array_filter(explode(',',$_POST['hidden_harga_20_feet_extra_service']));
            $list_harga_40_feet_extra_service = array_filter(explode(',',$_POST['hidden_harga_40_feet_extra_service']));
            $list_harga_45_feet_extra_service = array_filter(explode(',',$_POST['hidden_harga_45_feet_extra_service']));

            for ($i=0; $i < count($list_nama_extra_service); $i++) {

                $data_extra_service[$i]['nama_extra_service'] = $i + 3 . ". " . $list_nama_extra_service[$i];

                if(!in_array("undefined",$list_harga_20_feet_extra_service) && !empty($list_harga_20_feet_extra_service)){
                    $data_extra_service[$i]['harga_20_feet'] = "Rp. " . number_format((float)$list_harga_20_feet_extra_service[$i], 0, ',', '.');
                    $data_relasi = [
                        'judul_dokumen' => $dokumen->judul_dokumen,
                        'nama_extra_service' => $list_nama_extra_service[$i],
                        'harga_extra_service' => $list_harga_20_feet_extra_service[$i],
                        'freight_location' => '1',
                        'container' => '20',
                    ];

                    $this->admin_repository->create_relasi_dokumenspk_extra_service($data_relasi);
                }
                if(!in_array("undefined",$list_harga_40_feet_extra_service) && !empty($list_harga_40_feet_extra_service)){
                    $data_extra_service[$i]['harga_40_feet'] = "Rp. " . number_format((float)$list_harga_40_feet_extra_service[$i], 0, ',', '.');
                    $data_relasi = [
                        'judul_dokumen' => $dokumen->judul_dokumen,
                        'nama_extra_service' => $list_nama_extra_service[$i],
                        'harga_extra_service' => $list_harga_40_feet_extra_service[$i],
                        'freight_location' => '1',
                        'container' => '40',
                    ];

                    $this->admin_repository->create_relasi_dokumenspk_extra_service($data_relasi);
                }
                if(!in_array("undefined",$list_harga_45_feet_extra_service) && !empty($list_harga_45_feet_extra_service)){
                    $data_extra_service[$i]['harga_45_feet'] = "Rp. " . number_format((float)$list_harga_45_feet_extra_service[$i], 0, ',', '.');
                    $data_relasi = [
                        'judul_dokumen' => $dokumen->judul_dokumen,
                        'nama_extra_service' => $list_nama_extra_service[$i],
                        'harga_extra_service' => $list_harga_45_feet_extra_service[$i],
                        'freight_location' => '1',
                        'container' => '45',
                    ];

                    $this->admin_repository->create_relasi_dokumenspk_extra_service($data_relasi);
                }

            }

            $all_nama_extra_service = array_map(function($data){return $data['nama_extra_service'];}, $data_extra_service);
            $all_harga_20_feet = array_map(function($data){return $data['harga_20_feet'];}, $data_extra_service);
            $all_harga_40_feet = array_map(function($data){return $data['harga_40_feet'];}, $data_extra_service);

            $template->setValue('nama_extra_service', implode('<w:br/>  &#160;&#160;', $all_nama_extra_service));
            $template->setValue('harga_20_feet',  implode('<w:br/> &#160;&#160;', $all_harga_20_feet));
            $template->setValue('harga_40_feet',  implode('<w:br/>  &#160;&#160;', $all_harga_40_feet));
        }
        else{
            $template->setValue('nama_extra_service', '');
            $template->setValue('harga_20_feet', '');
            $template->setValue('harga_40_feet', '');
        }

        //INPUT DATA EXTRA SERVICE FREIGHT
        if(count($list_nama_extra_service_freight_origin) > 0 || count($list_nama_extra_service_freight_destination) > 0){
            $list_harga_extra_service_freight_origin = array_filter(explode(',',$_POST['hidden_harga_extra_service_freight_origin']));
            $list_harga_extra_service_freight_destination = array_filter(explode(',',$_POST['hidden_harga_extra_service_freight_destination']));

            for ($i=0; $i < count($list_nama_extra_service_freight_origin); $i++) {
                $data_extra_service['nama_extra_service_origin'][$i] = $i + 1 . ". " . $list_nama_extra_service_freight_origin[$i];
                $data_extra_service['harga_extra_service_origin'][$i] = number_format((float)$list_harga_extra_service_freight_origin[$i], 0, ',', '.');

                $data_relasi = [
                    'judul_dokumen' => $dokumen->judul_dokumen,
                    'nama_extra_service' => $list_nama_extra_service_freight_origin[$i],
                    'harga_extra_service' => $list_harga_extra_service_freight_origin[$i],
                    'freight_location' => '1',
                ];

                $this->admin_repository->create_relasi_dokumenspk_extra_service($data_relasi);
            }

            for ($i=0; $i < count($list_nama_extra_service_freight_destination); $i++) {
                $data_extra_service['nama_extra_service_destination'][$i] = $i + 1 . ". " . $list_nama_extra_service_freight_destination[$i];
                $data_extra_service['harga_extra_service_destination'][$i] = number_format((float)$list_harga_extra_service_freight_destination[$i], 0, ',', '.');

                $data_relasi = [
                    'judul_dokumen' => $dokumen->judul_dokumen,
                    'nama_extra_service' => $list_nama_extra_service_freight_destination[$i],
                    'harga_extra_service' => $list_harga_extra_service_freight_destination[$i],
                    'freight_location' => '2',
                ];

                $this->admin_repository->create_relasi_dokumenspk_extra_service($data_relasi);
            }

            if(!empty($list_nama_extra_service_freight_origin)){
                $all_nama_extra_service_origin = array_map(function($data){return $data;}, $data_extra_service['nama_extra_service_origin']);
                $all_harga_extra_service_origin = array_map(function($data){return $data;}, $data_extra_service['harga_extra_service_origin']);
                $template->setValue('servis_origin', implode('<w:br/>  &#160;&#160;', $all_nama_extra_service_origin));
                $template->setValue('cost_origin', "Rp ." . implode('<w:br/>&#160;&#160;', $all_harga_extra_service_origin));
                // number_format($all_harga_extra_service_origin, 0, ',', '.');
            }
            else{
                $template->setValue('servis_origin', 'N/A');
                $template->setValue('cost_origin', 'N/A');
            }

            if(!empty($list_nama_extra_service_freight_destination)){
                $all_nama_extra_service_destination = array_map(function($data){return $data;}, $data_extra_service['nama_extra_service_destination']);
                $all_harga_extra_service_destination = array_map(function($data){return $data;}, $data_extra_service['harga_extra_service_destination']);
                $template->setValue('servis_destination', implode('<w:br/>  &#160;&#160;', $all_nama_extra_service_destination));
                $template->setValue('cost_destination', "Rp ." . implode('<w:br/>&#160;&#160;', $all_harga_extra_service_destination));
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

   public function pergi_ke_detail_dokumen_SPK(Request $request){
        $dokumen_SPK = $this->admin_repository->get_dokumen_SPK($_POST['judul_dokumen']);

        $array_data_SPK = array(
            'pengangkutan' => $dokumen_SPK->judul_dokumen[7],
            'service' => $dokumen_SPK->judul_dokumen[9],
            'shipment' => $dokumen_SPK->judul_dokumen[11]
        );

        if($dokumen_SPK->metode_pengiriman == null){
            $list_relasi_extra_service_SPK = $this->admin_repository->get_relasi_dokumen_spk_extra_service($_POST['judul_dokumen']);

            return view("pages.admin.detail_dokumen_SPK")->with('dokumen_SPK', $dokumen_SPK)->with('array_data_SPK', $array_data_SPK)->with('list_relasi_extra_service_SPK', $list_relasi_extra_service_SPK);
        }
        else{
            $list_relasi_extra_service_SPK_PPJK = $this->admin_repository->get_relasi_dokumen_spk_extra_service_freight_origin($_POST['judul_dokumen']);

            $list_relasi_extra_service_SPK_freight = $this->admin_repository->get_relasi_dokumen_spk_extra_service_freight_destination($_POST['judul_dokumen']);

            return view("pages.admin.detail_dokumen_SPK")->with('dokumen_SPK', $dokumen_SPK)->with('array_data_SPK', $array_data_SPK)->with('list_relasi_extra_service_SPK_PPJK', $list_relasi_extra_service_SPK_PPJK)->with('list_relasi_extra_service_SPK_freight', $list_relasi_extra_service_SPK_freight);
        }

        return view("pages.admin.detail_dokumen_SPK")->with('dokumen_SPK', $dokumen_SPK)->with('array_data_SPK', $array_data_SPK);
    }


   public function proses_download_dokumen_SPK(Request $request){

        $kode_dokumen = $_POST['judul_dokumen'];

        return response()->download(public_path("hasil_dokumen/$kode_dokumen.docx"));
    }

    //Dokumen Simpan Berjalan
   public function pergi_ke_make_dokumen_simpan_berjalan(Request $request){
       $list_dokumen_SO = $this->admin_repository->get_all_dokumen_SO();

       return view("pages.admin.make_dokumen_simpan_berjalan")->with('list_dokumen_SO', $list_dokumen_SO);
   }

   //dokumen simpan berjalan
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
            'party_20' => 'required_if:option_container,FCL',
            'berat_container' => 'required_if:option_container,LCL',
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

        $dokumen_spk = $this->dokumen_simpan_berjalan_repository->create_dokumen_simpan_berjalan($data_dokumen_simpan_berjalan);

        $request->session()->flash('message', 'add dokumen berhasil');
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

        $dokumen_simpan_berjalan = $this->admin_repository->update_dokumen_simpan_berjalan($data_dokumen_simpan_berjalan);

        $request->session()->flash('message', 'Dokumen berhasil diubah');
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

       //jika id service freight international
       if($dokumen_spk->id_service == 2){
           $list_relasi_extra_service_freight_origin = $this->admin_repository->get_relasi_dokumen_spk_extra_service_freight_origin($judul_dokumen);
           $list_relasi_extra_service_freight_destination = $this->admin_repository->get_relasi_dokumen_spk_extra_service_freight_destination($judul_dokumen);
           return response()->json(array('customer' => $customer, 'list_relasi_extra_service_freight_origin' => $list_relasi_extra_service_freight_origin,'list_relasi_extra_service_freight_destination' => $list_relasi_extra_service_freight_destination, 'dokumen_spk' => $dokumen_spk));
        }
       else{
           $list_extra_service = $this->admin_repository->get_relasi_dokumen_spk_extra_service($dokumen_spk->judul_dokumen);
           return response()->json(array('customer' => $customer, 'list_extra_service' => $list_extra_service, 'dokumen_spk' => $dokumen_spk));
       }
   }

   public function proses_add_dokumen_so(Request $request){
       $request->validate([
            'input_nama_service_PPJK.*' => 'required',
            'input_nama_service_freight.*' => 'required',
            'input_quantity_service_PPJK.*' => 'required',
            'input_quantity_service_freight.*' => 'required',
            'input_harga_service_PPJK.*' => 'required',
            'input_harga_service_freight.*' => 'required',
            'input_total_PPJK.*' => 'required|numeric|min:10000',
            'input_total_freight.*' => 'required|numeric|min:10000',
       ]);

       if($_POST['checkbox_status_service_PPJK'] == ""){
            $request->session()->flash('message', 'Dokumen SPK belum dpilih');
            return redirect()->back();
       }

       $list_service_dokumen_so_PPJK = array();

       $list_service_dokumen_so_freight = array();

       foreach ($_POST['checkbox_status_service_PPJK'] as $key) {
           $list_service_dokumen_so_PPJK[$key]['nama_service'] = $_POST['input_nama_service_PPJK'][$key];
           $list_service_dokumen_so_PPJK[$key]['quantity_service'] = $_POST['input_quantity_service_PPJK'][$key];

           if(isset($_POST['input_container_service_PPJK'])){
               $list_service_dokumen_so_PPJK[$key]['container_service'] = $_POST['input_container_service_PPJK'][$key];
           }
           $list_service_dokumen_so_PPJK[$key]['harga_service'] = $_POST['input_harga_service_PPJK'][$key];
           $list_service_dokumen_so_PPJK[$key]['diskon_service'] = $_POST['input_diskon_service_PPJK'][$key];
           $list_service_dokumen_so_PPJK[$key]['pajak_service'] = $_POST['input_pajak_service_PPJK'][$key];
           $list_service_dokumen_so_PPJK[$key]['total'] = $_POST['input_total_PPJK'][$key];
       }

       if(isset($_POST['checkbox_status_service_freight'])){
            foreach ($_POST['checkbox_status_service_freight'] as $key) {
                $list_service_dokumen_so_freight[$key]['nama_service'] = $_POST['input_nama_service_freight'][$key];
                $list_service_dokumen_so_freight[$key]['quantity_service'] = $_POST['input_quantity_service_freight'][$key];
                $list_service_dokumen_so_freight[$key]['harga_service'] = $_POST['input_harga_service_freight'][$key];
                $list_service_dokumen_so_freight[$key]['diskon_service'] = $_POST['input_diskon_service_freight'][$key];
                $list_service_dokumen_so_freight[$key]['pajak_service'] = $_POST['input_pajak_service_freight'][$key];
                $list_service_dokumen_so_freight[$key]['total'] = $_POST['input_total_freight'][$key];
            }
        }

       $data_dokumen_SO = [
           'nomor_so' => $_POST['Id_dokumen'],
           'tanggal_so' => $_POST['tanggal_SO'],
           'judul_dokumen_spk' => $_POST['option_dokumen_SPK'],
           'nama_customer' => $_POST['input_nama_customer'],
           'alamat_customer' => $_POST['input_alamat_customer'],
           'id_service' => $_POST['input_id_service'],
           'status_aktif_dokumen' => 1
       ];

       $dokumen_SO = $this->dokumen_so_repository->add_dokumen_SO($data_dokumen_SO);

       foreach ($list_service_dokumen_so_PPJK as $service_dokumen_so_PPJK) {
            if((isset($_POST['input_container_service_PPJK']))){
                $data_relasi_dokumen_so_extra_service_PPJK = [
                    'nomor_so' => $dokumen_SO->nomor_so,
                    'nama_service' => $service_dokumen_so_PPJK['nama_service'],
                    'judul_dokumen_spk' => $_POST['option_dokumen_SPK'],
                    'quantity_service' => $service_dokumen_so_PPJK['quantity_service'],
                    'container_service' => $service_dokumen_so_PPJK['container_service'],
                    'harga_service' => $service_dokumen_so_PPJK['harga_service'],
                    'diskon_service' => $service_dokumen_so_PPJK['diskon_service'],
                    'pajak_service' => $service_dokumen_so_PPJK['pajak_service'],
                    'freight_location' => 1,
                    'total_service' => $service_dokumen_so_PPJK['total'],
                ];
            }
            else{
                $data_relasi_dokumen_so_extra_service_PPJK = [
                    'nomor_so' => $dokumen_SO->nomor_so,
                    'nama_service' => $service_dokumen_so_PPJK['nama_service'],
                    'judul_dokumen_spk' => $_POST['option_dokumen_SPK'],
                    'quantity_service' => $service_dokumen_so_PPJK['quantity_service'],
                    'harga_service' => $service_dokumen_so_PPJK['harga_service'],
                    'diskon_service' => $service_dokumen_so_PPJK['diskon_service'],
                    'pajak_service' => $service_dokumen_so_PPJK['pajak_service'],
                    'freight_location' => 1,
                    'total_service' => $service_dokumen_so_PPJK['total'],
                ];
            }

            foreach ($data_relasi_dokumen_so_extra_service_PPJK as $element=>$key) {
                if($key == ""){
                    $data_relasi_dokumen_so_extra_service_PPJK[$element] = 0;
                }
            }

            $relasi = $this->dokumen_so_repository->add_relasi_dokumen_so_extra_service($data_relasi_dokumen_so_extra_service_PPJK);
       }

       if(count($list_service_dokumen_so_freight) > 0){
            $year = Carbon::now()->format('y');
            $month = Carbon::now()->format('m');
            $nomor_urut = $this->admin_repository->get_id_dokumenSO_terbaru();

            $nomor_dokumen_SO = "SO" . $year . $month . $nomor_urut;

            $data_dokumen_SO = [
                'nomor_so' => $nomor_dokumen_SO,
                'tanggal_so' => $_POST['tanggal_SO'],
                'judul_dokumen_spk' => $_POST['option_dokumen_SPK'],
                'nama_customer' => $_POST['input_nama_customer'],
                'alamat_customer' => $_POST['input_alamat_customer'],
                'id_service' => $_POST['input_id_service'],
                'status_aktif_dokumen' => 1
            ];

            $dokumen_SO = $this->admin_repository->add_dokumen_SO($data_dokumen_SO);

            foreach ($list_service_dokumen_so_freight as $service_dokumen_so_freight) {
                $data_relasi_dokumen_so_extra_service_freight = [
                    'nomor_so' => $dokumen_SO->nomor_so,
                    'nama_service' => $service_dokumen_so_freight['nama_service'],
                    'judul_dokumen_spk' => $_POST['option_dokumen_SPK'],
                    'quantity_service' => $service_dokumen_so_freight['quantity_service'],
                    'harga_service' => $service_dokumen_so_freight['harga_service'],
                    'diskon_service' => $service_dokumen_so_freight['diskon_service'],
                    'pajak_service' => $service_dokumen_so_freight['pajak_service'],
                    'freight_location' => 2,
                    'total_service' => $service_dokumen_so_freight['total'],
                ];

                foreach ($data_relasi_dokumen_so_extra_service_freight as $element=>$key) {
                    if($key == ""){
                        $data_relasi_dokumen_so_extra_service_freight[$element] = 0;
                    }
                }

                $relasi = $this->dokumen_so_repository->add_relasi_dokumen_so_extra_service($data_relasi_dokumen_so_extra_service_freight);
            }
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

       //1 = PPJK/Null, 2 = 'freight
       $list_relasi_dokumen_so_extra_service_PPJK = $this->admin_repository->get_relasi_dokumen_so_extra_service($dokumen_so->nomor_so, "1");

       $list_relasi_dokumen_so_extra_service_freight = $this->admin_repository->get_relasi_dokumen_so_extra_service($dokumen_so->nomor_so, "2");

       $list_relasi_dokumen_spk_extra_service = $this->admin_repository->get_relasi_dokumen_spk_extra_service($dokumen_so->judul_dokumen_spk);

       $list_service_uncheked_PPJK = array();

       $list_service_uncheked_freight = array();

       if(count($list_relasi_dokumen_so_extra_service_PPJK) > 0){
            foreach($list_relasi_dokumen_spk_extra_service as $relasi_dokumen_spk_extra_service){
                $boolean_in_dokumen_so = false;
                foreach($list_relasi_dokumen_so_extra_service_PPJK as $relasi_dokumen_so_extra_service){
                    if($relasi_dokumen_spk_extra_service->container !=null){
                        if($relasi_dokumen_spk_extra_service->nama_extra_service == $relasi_dokumen_so_extra_service->nama_service && $relasi_dokumen_spk_extra_service->container == $relasi_dokumen_so_extra_service->container_service ){
                            $boolean_in_dokumen_so = true;
                        }
                    }
                    else{
                        if($relasi_dokumen_spk_extra_service->nama_extra_service == $relasi_dokumen_so_extra_service->nama_service){
                            $boolean_in_dokumen_so = true;
                        }
                    }
                }

                if($boolean_in_dokumen_so == false && $relasi_dokumen_spk_extra_service->freight_location == "1"){
                    array_push($list_service_uncheked_PPJK, $relasi_dokumen_spk_extra_service);
                }
            }
        }

        if(count($list_relasi_dokumen_so_extra_service_freight) > 0){
            foreach($list_relasi_dokumen_spk_extra_service as $relasi_dokumen_spk_extra_service){
                $boolean_in_dokumen_so = false;
                foreach($list_relasi_dokumen_so_extra_service_freight as $relasi_dokumen_so_extra_service){
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

                if($boolean_in_dokumen_so == false && $relasi_dokumen_spk_extra_service->freight_location == "2"){
                    array_push($list_service_uncheked_freight, $relasi_dokumen_spk_extra_service);
                }
            }
        }

       return view('pages.admin.edit_dokumen_SO')->with('dokumen_so', $dokumen_so)->with('list_relasi_PPJK', $list_relasi_dokumen_so_extra_service_PPJK)->with('list_service_unchecked_PPJK', $list_service_uncheked_PPJK)->with('list_relasi_freight', $list_relasi_dokumen_so_extra_service_freight)->with('list_service_unchecked_freight', $list_service_uncheked_freight);
   }

   public function proses_edit_dokumen_so(Request $request){
       $request->validate([
            'input_nama_service_PPJK.*' => 'required',
            'input_nama_service_freight.*' => 'required',
            'input_quantity_service_PPJK.*' => 'required',
            'input_quantity_service_freight.*' => 'required',
            'input_harga_service_PPJK.*' => 'required',
            'input_harga_service_freight.*' => 'required',
            'input_total_PPJK.*' => 'required|numeric|min:10000',
            'input_total_freight.*' => 'required|numeric|min:10000',
       ]);
       $list_service_dokumen_so_PPJK = array();
       $list_service_dokumen_so_freight = array();

       if(isset($_POST['checkbox_status_service_PPJK'])){
            foreach ($_POST['checkbox_status_service_PPJK'] as $key) {
                $list_service_dokumen_so_PPJK[$key]['nama_service'] = $_POST['input_nama_service_PPJK'][$key];
                $list_service_dokumen_so_PPJK[$key]['quantity_service'] = $_POST['input_quantity_service_PPJK'][$key];

                if(isset($_POST['input_container_service_PPJK'])){
                    $list_service_dokumen_so_PPJK[$key]['container_service'] = $_POST['input_container_service_PPJK'][$key];
                }
                $list_service_dokumen_so_PPJK[$key]['harga_service'] = $_POST['input_harga_service_PPJK'][$key];
                $list_service_dokumen_so_PPJK[$key]['diskon_service'] = $_POST['input_diskon_service_PPJK'][$key];
                $list_service_dokumen_so_PPJK[$key]['pajak_service'] = $_POST['input_pajak_service_PPJK'][$key];
                $list_service_dokumen_so_PPJK[$key]['total'] = $_POST['input_total_PPJK'][$key];
            }
        }

        if(isset($_POST['checkbox_status_service_freight'])){
            foreach ($_POST['checkbox_status_service_freight'] as $key) {
                $list_service_dokumen_so_freight[$key]['nama_service'] = $_POST['input_nama_service_freight'][$key];
                $list_service_dokumen_so_freight[$key]['quantity_service'] = $_POST['input_quantity_service_freight'][$key];
                $list_service_dokumen_so_freight[$key]['harga_service'] = $_POST['input_harga_service_freight'][$key];
                $list_service_dokumen_so_freight[$key]['diskon_service'] = $_POST['input_diskon_service_freight'][$key];
                $list_service_dokumen_so_freight[$key]['pajak_service'] = $_POST['input_pajak_service_freight'][$key];
                $list_service_dokumen_so_freight[$key]['total'] = $_POST['input_total_freight'][$key];
            }
        }

       $this->admin_repository->delete_relasi_dokumen_so_extra_service($_POST['Id_dokumen']);

        foreach ($list_service_dokumen_so_PPJK as $service_dokumen_so_PPJK) {
            if((isset($_POST['input_container_service_PPJK']))){
                $data_relasi_dokumen_so_extra_service_PPJK = [
                    'nomor_so' => $_POST['Id_dokumen'],
                    'nama_service' => $service_dokumen_so_PPJK['nama_service'],
                    'judul_dokumen_spk' => $_POST['option_dokumen_SPK'],
                    'quantity_service' => $service_dokumen_so_PPJK['quantity_service'],
                    'container_service' => $service_dokumen_so_PPJK['container_service'],
                    'harga_service' => $service_dokumen_so_PPJK['harga_service'],
                    'diskon_service' => $service_dokumen_so_PPJK['diskon_service'],
                    'pajak_service' => $service_dokumen_so_PPJK['pajak_service'],
                    'freight_location' => 1,
                    'total_service' => $service_dokumen_so_PPJK['total'],
                ];
            }
            else{
                $data_relasi_dokumen_so_extra_service_PPJK = [
                    'nomor_so' => $_POST['Id_dokumen'],
                    'nama_service' => $service_dokumen_so_PPJK['nama_service'],
                    'judul_dokumen_spk' => $_POST['option_dokumen_SPK'],
                    'quantity_service' => $service_dokumen_so_PPJK['quantity_service'],
                    'harga_service' => $service_dokumen_so_PPJK['harga_service'],
                    'diskon_service' => $service_dokumen_so_PPJK['diskon_service'],
                    'pajak_service' => $service_dokumen_so_PPJK['pajak_service'],
                    'freight_location' => 1,
                    'total_service' => $service_dokumen_so_PPJK['total'],
                ];
            }

            foreach ($data_relasi_dokumen_so_extra_service_PPJK as $element=>$key) {
                if($key == ""){
                    $data_relasi_dokumen_so_extra_service_PPJK[$element] = 0;
                }
            }

            $relasi = $this->admin_repository->add_relasi_dokumen_so_extra_service($data_relasi_dokumen_so_extra_service_PPJK);
       }

       if(count($list_service_dokumen_so_freight) > 0){
            foreach ($list_service_dokumen_so_freight as $service_dokumen_so_freight) {
                $data_relasi_dokumen_so_extra_service_freight = [
                    'nomor_so' => $_POST['Id_dokumen'],
                    'nama_service' => $service_dokumen_so_freight['nama_service'],
                    'judul_dokumen_spk' => $_POST['option_dokumen_SPK'],
                    'quantity_service' => $service_dokumen_so_freight['quantity_service'],
                    'harga_service' => $service_dokumen_so_freight['harga_service'],
                    'diskon_service' => $service_dokumen_so_freight['diskon_service'],
                    'pajak_service' => $service_dokumen_so_freight['pajak_service'],
                    'freight_location' => 2,
                    'total_service' => $service_dokumen_so_freight['total'],
                ];

                foreach ($data_relasi_dokumen_so_extra_service_freight as $element=>$key) {
                    if($key == ""){
                        $data_relasi_dokumen_so_extra_service_freight[$element] = 0;
                    }
                }

                $relasi = $this->admin_repository->add_relasi_dokumen_so_extra_service($data_relasi_dokumen_so_extra_service_freight);
            }
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
           'input_nama_service.*' => 'required',
           'input_vendor_service.*' => 'required',
           'input_total.*' => 'required|numeric|gt:0',
       ]);
       $list_service_tagihan_vendor = array();

       $total_tagihan = 0;
       foreach ($_POST['checkbox_status_service'] as $key) {
            $list_service_tagihan_vendor[$key]['vendor_service'] = $_POST['input_vendor_service'][$key];
            $list_service_tagihan_vendor[$key]['nama_service'] = $_POST['input_nama_service'][$key];
            $list_service_tagihan_vendor[$key]['quantity_service'] = $_POST['input_quantity_service'][$key];

            if(isset($_POST['input_container_service'])){
                $list_service_tagihan_vendor[$key]['container_service'] = $_POST['input_container_service'][$key];
            }

            $list_service_tagihan_vendor[$key]['harga_service'] = $_POST['input_harga_service'][$key];
            $list_service_tagihan_vendor[$key]['diskon_service'] = $_POST['input_diskon_service'][$key];
            $list_service_tagihan_vendor[$key]['pajak_service'] = $_POST['input_pajak_service'][$key];
            $list_service_tagihan_vendor[$key]['keterangan_tagihan'] = $_POST['keterangan_tagihan'][$key];
            $list_service_tagihan_vendor[$key]['total'] = $_POST['input_total'][$key];

            $total_tagihan = $total_tagihan + $list_service_tagihan_vendor[$key]['total'];
       }

       $data_tagihan_vendor= [
            'nomor_so' => $_POST['option_dokumen_SO'],
            'total_service' => $total_tagihan,
            'hutang' =>$total_tagihan,
        ];

        $tagihan_vendor = $this->tagihan_repository->add_tagihan_vendor($data_tagihan_vendor);

       foreach ($list_service_tagihan_vendor as $service_tagihan_vendor) {
            $data_relasi_tagihan_vendor_service = [
                'id_tagihan_vendor' => $tagihan_vendor['id_tagihan_vendor'],
                'nama_service' => $service_tagihan_vendor['nama_service'],
                'quantity_service' => $service_tagihan_vendor['quantity_service'],
                'harga_service' => $service_tagihan_vendor['harga_service'],
                'diskon_service' => $service_tagihan_vendor['diskon_service'],
                'pajak_service' => $service_tagihan_vendor['pajak_service'],
                'total_service' => $service_tagihan_vendor['total'],
            ];


            if(isset($_POST['input_container_service'])){
                $data_relasi_tagihan_vendor_service['container_service'] =  $service_tagihan_vendor['container_service'];
            }

            foreach ($data_relasi_tagihan_vendor_service as $element=>$key) {
                if($key == ""){
                    $data_relasi_tagihan_vendor_service[$element] = null;
                }
            }

            $relasi_tagihan_vendor = $this->tagihan_repository->add_service_tagihan_vendor($data_relasi_tagihan_vendor_service);
        }

        $request->session()->flash('message', 'Input tagihan vendor berhasil');

        return redirect()->back();
   }

   public function pergi_ke_list_tagihan_vendor(Request $request){
       $list_tagihan_vendor = $this->admin_repository->get_all_tagihan_vendor();

       return view('pages.admin.list_tagihan_vendor')->with('list_tagihan_vendor', $list_tagihan_vendor);
   }

   public function pergi_ke_detail_tagihan_vendor(Request $request){

       $id_tagihan_vendor = $_GET['id_tagihan_vendor'];

       $tagihan_vendor = $this->admin_repository->get_tagihan_vendor($id_tagihan_vendor);

       $list_service_tagihan_vendor = $this->admin_repository->get_service_tagihan_vendor($tagihan_vendor['id_tagihan_vendor']);

       $dokumen_so = $this->admin_repository->get_dokumen_so_by_nomor_so($tagihan_vendor['nomor_so']);

       $list_nomor_COA = $this->admin_repository->get_all_nomor_COA();

       return view("pages.admin.detail_tagihan_vendor")->with('tagihan_vendor', $tagihan_vendor)->with('dokumen_so', $dokumen_so)->with('list_service_tagihan_vendor', $list_service_tagihan_vendor)->with('id_tagihan_vendor', $id_tagihan_vendor)->with('list_nomor_COA', $list_nomor_COA);
   }

   public function proses_bayar_tagihan_vendor(Request $request){
        $request->validate([
            'input_nominal_pembayaran' => 'required',
            'nomor_COA' => 'required',
            'nomor_rekening' => 'required',
        ]);

        $nominal_pembayaran = $_POST['input_nominal_pembayaran'];

        $id_tagihan_vendor = $_POST['Id_dokumen'];

        $nomor_rekening = $_POST['nomor_rekening'];

        $nomor_COA = $_POST['nomor_COA'];

        $tagihan_vendor = $this->tagihan_repository->bayar_tagihan_vendor($nominal_pembayaran, $id_tagihan_vendor);

        $total_rekening = $this->tagihan_repository->kurangi_total_rekening($nominal_pembayaran, $nomor_rekening);

        $total_COA = $this->tagihan_repository->kurangi_total_COA($nominal_pembayaran, $nomor_COA);

        $request->session()->flash('message', 'Input tagihan vendor berhasil');

        return redirect()->back();
    }

   //input Tagihan customer
   public function pergi_ke_input_tagihan_customer(Request $request){
       $list_dokumen_SO = $this->admin_repository->get_all_dokumen_SO();

       return view('pages.admin.input_tagihan_customer')->with('list_dokumen_SO', $list_dokumen_SO);
   }

   public function proses_input_tagihan_customer(Request $request){
       $request->validate([
           'input_nama_service.*' => 'required',
           'input_total.*' => 'required|numeric|min:10000',
       ]);

       $total_tagihan = 0;

       $nomor_urut = 0;

       $all_nomor_urut = array();
       $all_service_invoice = array();
       $all_qty_service = array();
       $all_unit_price_service = array();
       $all_total_service = array();
       $tax = array();
       $tax_all= 0;
       $stotal = 0;
       $final_total = 0;

       $list_tagihan_customer = array();

       $dokumen_so = $this->dokumen_so_repository->get_dokumen_so_by_nomor_so($_POST['option_dokumen_SO']);

        foreach ($_POST['checkbox_status_service'] as $key) {
           $list_service_tagihan_customer[$key]['nama_service'] = $_POST['input_nama_service'][$key];
           $list_service_tagihan_customer[$key]['quantity_service'] = $_POST['input_quantity_service'][$key];

           if(isset($_POST['input_container_service'])){
               $list_service_tagihan_customer[$key]['container_service'] = $_POST['input_container_service'][$key];
           }
           $list_service_tagihan_customer[$key]['harga_service'] = $_POST['input_harga_service'][$key];
           $list_service_tagihan_customer[$key]['diskon_service'] = $_POST['input_diskon_service'][$key];
           $list_service_tagihan_customer[$key]['pajak_service'] = $_POST['input_pajak_service'][$key];
           $list_service_tagihan_customer[$key]['total'] = $_POST['input_total'][$key];

           $total_tagihan = $total_tagihan + $list_service_tagihan_customer[$key]['total'];
        }

        $data_tagihan_customer = [
            'nomor_so' => $dokumen_so->nomor_so,
            'bank_pelunasan' => '',
            'piutang' => $total_tagihan,
            'total_service' => $total_tagihan,
        ];

        $tagihan_customer = $this->dokumen_so_repository->add_tagihan_customer($data_tagihan_customer);

        foreach ($list_service_tagihan_customer as $service_tagihan_customer) {
            $data_service_tagihan_customer= [
                'id_tagihan_customer' => $tagihan_customer->id_tagihan_customer,
                'nama_service' => $service_tagihan_customer['nama_service'],
                'quantity_service' => $service_tagihan_customer['quantity_service'],
                'harga_service' => $service_tagihan_customer['harga_service'],
                'diskon_service' => $service_tagihan_customer['diskon_service'],
                'pajak_service' => $service_tagihan_customer['pajak_service'],
                'total_service' => $service_tagihan_customer['total'],
                'hutang' =>$service_tagihan_customer['total'],
            ];

            if(isset($_POST['input_container_service'])){
                $data_tagihan_customer['container_service'] =  $service_tagihan_customer['container_service'];
            }

            foreach ($data_service_tagihan_customer as $element=>$key) {
                if($key == ""){
                    $data_service_tagihan_customer[$element] = null;
                }
            }

            $all_nomor_urut[$nomor_urut] = $nomor_urut + 1;
            $all_service_invoice[$nomor_urut] = $service_tagihan_customer['nama_service'];
            $all_qty_service[$nomor_urut] = $service_tagihan_customer['quantity_service'];
            $all_unit_price_service[$nomor_urut] = $service_tagihan_customer['harga_service'];
            $all_total_service[$nomor_urut] =  $all_qty_service[$nomor_urut] * $all_unit_price_service[$nomor_urut];
            $tax[$nomor_urut] = $service_tagihan_customer['pajak_service'];

            $tagihan_customer = $this->dokumen_so_repository->add_service_tagihan_customer($data_service_tagihan_customer);

            $stotal = $stotal + $all_total_service[$nomor_urut];

            if($service_tagihan_customer['pajak_service'] != 0){
                $tax_all = $tax_all + $service_tagihan_customer['total'] / $service_tagihan_customer['pajak_service'];
            }

            ++$nomor_urut;
        }

        $tax_all = floor($tax_all);

        $dokumen_simpan_berjalan = $this->dokumen_simpan_berjalan_repository->get_dokumen_simpan_berjalan_by_SO($dokumen_so->nomor_so);

        if(!isset($dokumen_simpan_berjalan)){
            $request->session()->flash('message', 'Dokumen Simpan Berjalan belum dibuat');
            return redirect()->back();
        }

        $dokumen_spk = $this->admin_repository->get_dokumen_SPK($dokumen_so->judul_dokumen_spk);

        $customer = $this->admin_repository->find_customer($dokumen_spk->id_customer);


        $template = new \PhpOffice\PhpWord\TemplateProcessor(public_path("template_dokumen/template_invoice.docx"));
        $template->setValue('nomor_so', $_POST['option_dokumen_SO']);
        $template->setValue('tanggal_invoice', Carbon::today()->format('d F y'));
        $template->setValue('nama_customer', $customer->nama_customer);
        $template->setValue('nama_perusahaan_customer', $customer->nama_perusahaan_customer);
        $template->setValue('alamat_customer', $customer->alamat_customer);
        $template->setValue('provinsi_customer', $customer->provinsi_customer);
        $template->setValue('negara_customer', $customer->negara_customer);
        $template->setValue('metode_pengiriman', ucfirst($dokumen_spk->metode_pengiriman));

        //data dokumen simpan berjalan
        $template->setValue('nopen', $dokumen_simpan_berjalan->nomor_surat_penjaluran . '/'. str_replace(' ','/',date("d F y", strtotime($dokumen_simpan_berjalan->tanggal_nopen))));
        $template->setValue('SPPB', $dokumen_simpan_berjalan->SPPB . '/'. str_replace(' ','/',date("d F y", strtotime($dokumen_simpan_berjalan->tanggal_SPPB))));
        $template->setValue('vessal', $dokumen_simpan_berjalan->vessal);
        $template->setValue('nomor_BL', $dokumen_simpan_berjalan->nomor_BL);
        $template->setValue('POL', $dokumen_simpan_berjalan->POL);
        $template->setValue('POD', $dokumen_simpan_berjalan->POD);
        $template->setValue('ETA', str_replace(' ','/',date("d F y", strtotime($dokumen_simpan_berjalan->ETD))) .'/'. str_replace(' ','/',date("d F y", strtotime($dokumen_simpan_berjalan->ETA))));
        $template->setValue('commodity', $dokumen_simpan_berjalan->commodity);

        if($dokumen_simpan_berjalan->option_container == 'FCL'){
            if($dokumen_simpan_berjalan->party_20 != ""){
                $template->setValue('total_party_20', $dokumen_spk->party_20. 'X 20" ' . "(" . $dokumen_simpan_berjalan->nomor_container . ")". '<w:br/>  &#160;&#160;');
            }
            else{
                $template->setValue('total_party_20', "");
            }

            if($dokumen_simpan_berjalan->party_40 != ""){
                $template->setValue('total_party_40', $dokumen_spk->party_40. 'X 40" ' . "(" . $dokumen_simpan_berjalan->nomor_container . ")". '<w:br/>  &#160;&#160;');
            }
            else{
                $template->setValue('total_party_40', "");
            }

            if($dokumen_simpan_berjalan->party_45 != ""){
                $template->setValue('total_party_45', $dokumen_spk->party_45. 'X 45" ' . "(" . $dokumen_simpan_berjalan->nomor_container . ")". '<w:br/>  &#160;&#160;' );
            }
            else{
                $template->setValue('total_party_45', "");
            }

            $template->setValue('LCL', "");
        }

        if($dokumen_simpan_berjalan->option_container == 'LCL'){
            $template->setValue('LCL', 'LCL ' . $dokumen_simpan_berjalan->LCL .' '. $dokumen_simpan_berjalan->berat_container .' '. $dokumen_simpan_berjalan->nomor_container);
            $template->setValue('total_party_45', "");
            $template->setValue('total_party_40', "");
            $template->setValue('total_party_20', "");
        }

        $template->setValue('nomor_urut', implode('<w:br/>  ', $all_nomor_urut));
        $template->setValue('service_invoice',  implode('<w:br/> ', $all_service_invoice));
        $template->setValue('qty_service',  implode('<w:br/>  ', $all_qty_service));
        $template->setValue('unit_price_service',  implode('<w:br/>  ', $all_unit_price_service));
        $template->setValue('qty_service',  implode('<w:br/>  ', $all_qty_service));
        $template->setValue('total_service',  implode('<w:br/>  ', $all_total_service));
        $template->setValue('tax',  implode('<w:br/>  ', $tax));
        $template->setValue('tax_all', number_format($tax_all));

        $final_total = $stotal - $tax_all;

        $class_num_converter = new ControllersConvert_number();

        $say = $class_num_converter->convert_number($final_total);

        $template->setValue('say', $say);

        $template->setValue('final_total', number_format($final_total));

        if($dokumen_so->id_service == 1){
            $template->setValue('tax_num', "11%");
        }
        else{
            $template->setValue('tax_num', "1%");
        }

        $template->setValue('stotal',  number_format($stotal));

        $request->session()->flash('message', 'Input Tagihan customer berhasil');

        $template->saveAs(public_path("hasil_dokumen/invoice_$dokumen_so->nomor_so.docx"));

        return response()->download(public_path("hasil_dokumen/invoice_$dokumen_so->nomor_so.docx"));
   }

   public function pergi_ke_list_tagihan_customer(Request $request){
       $list_tagihan_customer = $this->admin_repository->get_all_tagihan_customer();

       return view('pages.admin.list_tagihan_customer')->with('list_tagihan_customer', $list_tagihan_customer);
   }

   public function get_data_extra_service_SO(Request $request){
        $nomor_SO = $request->get('nomor_so');

        $dokumen_so = $this->admin_repository->get_dokumen_so_by_nomor_so($nomor_SO);

        //ambil semua relasi service-dokumen so
        $list_relasi_extra_service_SO = $this->admin_repository->get_relasi_dokumen_so_extra_service($nomor_SO, "all");

        return response()->json(array('list_extra_service' => $list_relasi_extra_service_SO, 'dokumen_so' => $dokumen_so));

   }

   public function proses_menerima_pembayaran_tagihan_customer(Request $request){
        $request->validate([
            'input_nominal_pembayaran' => 'required',
            'nomor_COA' => 'required',
            'nomor_rekening' => 'required',
        ]);

        $nominal_pembayaran = $_POST['input_nominal_pembayaran'];

        $bank_pelunasan = $_POST['input_nomor_rekening'];
        if($nominal_pembayaran > $_POST['input_total_tagihan']){
            $request->session()->flash('message', 'Nominal Pembayaran melebihi total');

            return redirect()->back();
        }

        $id_tagihan_customer = $_POST['Id_dokumen'];

        $nomor_rekening = $_POST['nomor_rekening'];

        $nomor_COA = $_POST['nomor_COA'];

        $tagihan_customer = $this->tagihan_repository->terima_pembayaran_tagihan_customer($nominal_pembayaran, $id_tagihan_customer, $bank_pelunasan);

        $tagihan_customer = $this->tagihan_repository->get_tagihan_customer($id_tagihan_customer);

        $total_rekening = $this->tagihan_repository->tambah_total_rekening($nominal_pembayaran, $nomor_rekening);

        $total_COA = $this->tagihan_repository->tambah_total_COA($nominal_pembayaran, $nomor_COA);

        $data_jurnal_umum = [
            'nomor_COA' => $_POST['input_nomor_COA'],
            'nama_rekening' => $_POST['input_nama_rekening'],
            'nomor_rekening' => $_POST['input_nomor_rekening'],
            'keterangan_tagihan' => $_POST['keterangan_tagihan'],
            'status_aktif' => '1',
            'total_debit' => $tagihan_customer->total_service,
            'hutang' => null,
            'piutang' => $tagihan_customer->piutang,
            'total_kredit' => $nominal_pembayaran,
        ];

        $jurnal_umum = $this->tagihan_repository->add_jurnal_umum($data_jurnal_umum);
        $request->session()->flash('message', 'Penerimaan pembayaran tagihan customer berhasil');

        return redirect()->back();
    }

   public function pergi_ke_detail_tagihan_customer(Request $request){

        $tagihan_customer = $this->tagihan_repository->get_tagihan_customer($_GET['id_tagihan_customer']);

        $list_service_tagihan_customer = $this->tagihan_repository->get_service_tagihan_customer($tagihan_customer->id_tagihan_customer);

        $dokumen_so = $this->dokumen_so_repository->get_dokumen_so_by_nomor_so($tagihan_customer->nomor_so);

        $list_nomor_COA = $this->tagihan_repository->get_all_nomor_COA();

        return view("pages.admin.detail_tagihan_customer")->with('tagihan_customer', $tagihan_customer)->with('dokumen_so', $dokumen_so)->with('list_service_tagihan_customer', $list_service_tagihan_customer)->with('id_tagihan_customer', $tagihan_customer->id_tagihan_customer)->with('list_nomor_COA', $list_nomor_COA);
    }

   //Jurnal Umum
   public function pergi_ke_list_jurnal_umum(Request $request){
        $list_jurnal_umum = $this->tagihan_repository->get_all_jurnal_umum();
        return view("pages.admin.list_jurnal_umum")->with('list_jurnal_umum', $list_jurnal_umum);
   }

   //Nomor COA
   public function get_data_COA(Request $request){
       $nomor_COA = $request->get('nomor_COA');

       $nomor_COA = $this->admin_repository->get_nomor_COA($nomor_COA);

       return response()->json(array('nomor_COA' => $nomor_COA));
   }

   //Rekening
   public function pergi_ke_daftarkan_rekening(Request $request){

        $list_nomor_COA = $this->admin_repository->get_all_nomor_COA();
        return view("pages.admin.daftar_rekening")->with('list_nomor_COA', $list_nomor_COA);
   }

   public function proses_add_rekening(Request $request){
        $request->validate([
            'input_nama_jenis_COA' => 'required',
            'input_total_COA' => 'required',
            'input_nomor_rekening' => 'required',
        ]);

        if(!$_POST['input_nama_rekening']){
            $_POST['input_nama_rekening'] = null;
        }

        if($_POST['option_nomor_COA']){
            $data_rekening = [
                'nama_rekening' => $_POST['input_nama_rekening'],
                'nomor_rekening' => $_POST['input_nomor_rekening'],
                'nomor_COA' => $_POST['option_nomor_COA'],
                'total_rekening' => 0,
                'status_aktif' => 1,
            ];

            $rekening = $this->admin_repository->add_rekening($data_rekening);

            $request->session()->flash('message', 'Input rekening berhasil');

            return redirect()->back();
        }

        if($_POST['input_nomor_COA']){

            $data_COA = [
                'nomor_COA' => $_POST['input_nomor_COA'],
                'nama_jenis_COA' => $_POST['input_nama_jenis_COA'],
                'total_COA' => $_POST['input_total_COA'],
                'status_aktif' => 1,
            ];

            $COA = $this->admin_repository->add_COA($data_COA);

            $data_rekening = [
                'nama_rekening' => $_POST['input_nama_rekening'],
                'nomor_rekening' => $_POST['input_nomor_rekening'],
                'nomor_COA' => $_POST['input_nomor_COA'],
                'total_rekening' => 0,
                'status_aktif' => 1,
            ];

            $rekening = $this->admin_repository->add_rekening($data_rekening);

            $request->session()->flash('message', 'Input rekening berhasil');

            return redirect()->back();
        }

        // $list_nomor_COA = $this->admin_repository->get_all_nomor_COA();
        // return view("pages.admin.daftar_rekening")->with('list_nomor_COA', $list_nomor_COA);
   }

   public function get_data_rekening(Request $request){
        $nomor_COA = $request->get('nomor_COA');

        $list_rekening = $this->admin_repository->get_rekening($nomor_COA);

        return response()->json(array('list_rekening' => $list_rekening));
    }
}
