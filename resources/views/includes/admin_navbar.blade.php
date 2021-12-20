<nav>
    <ul>
        <li><a href="{{ url('/admin/list_customer') }}"><img src="{{ asset('images/logo.png') }}" alt="logo"></a></li>
        <li>
            <a href="{{ url('/admin/list_customer') }}"><span>Customer</span></a>
            <ul>
                <li><a href="{{ url('/admin/list_customer') }}"><span>List Customer</span></a></li>
                <li><a href="{{ url('/admin/add_customer') }}"><span>Add Customer</span></a></li>
            </ul>
        </li>
        {{-- <li>
            <a href="{{ url('/admin/list_vendor') }}"><span>Vendor</span></a>
            <ul>
                <li><a href="{{ url('/admin/list_vendor') }}"><span>List Vendor</span></a></li>
                <li><a href="{{ url('/admin/add_vendor') }}"><span>Add Vendor</span></a></li>
            </ul>
        </li> --}}
        <li>
            <a href="{{ url('/admin/list_service') }}"><span>VTLC's service</span></a>
            <ul>
                <li><a href="{{ url('/admin/list_service') }}"><span>List Service</span></a></li>
                <li><a href="{{ url('/admin/add_service') }}"><span>Add Service</span></a></li>
            </ul>
        </li>
        <li>
            <a href="{{ url('/admin/list_SPK') }}"><span>List Document</span></a>
            <ul>
                <li><a href="{{ url('/admin/list_SPK') }}"><span>SPK</span></a></li>
                <li><a href="{{ url('/admin/list_dokumen_simpan_berjalan') }}"><span>Dokumen Simpan Berjalan</span></a></li>
                <li><a href="{{ url('/admin/list_SO') }}"><span>SO</span></a></li>
            </ul>
        </li>
        <li>
            <a href="{{ url('/admin/make_document_SPK') }}"><span>Make Document</span></a>
            <ul>
                <li><a href="{{ url('/admin/make_document_SPK') }}"><span>SPK</span></a></li>
                <li><a href="{{ url('/admin/make_dokumen_simpan_berjalan') }}"><span>Dokumen Simpan_Berjalan</span></a></li>
                <li><a href="{{ url('/admin/make_dokumen_SO') }}"><span>SO</span></a></li>
            </ul>
        </li>
        <li>
            <a href="{{ url('/admin/input_tagihan_vendor') }}"><span>Tagihan</span></a>
            <ul>
                <li><a href="{{ url('/admin/input_tagihan_vendor') }}"><span>Input Tagihan</span></a></li>
                <li><a href="{{ url('/admin/list_dokumen_SO_untuk_tagihan') }}"><span>List Tagihan</span></a></li>
            </ul>
        </li>
        <li style="margin-left: auto"><a href="{{ url('/admin/logout') }}"><span>Logout</span></a></li>
    </ul>
</nav>
