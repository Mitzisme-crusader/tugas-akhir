<nav>
    <ul>
        <li><a href="{{ url('/admin/list_restoran') }}"><img src="{{ asset('images/logo.png') }}" alt="logo"></a></li>
        <li>
            <a href="{{ url('/admin/list_customer') }}"><span>Customer</span></a>
            <ul>
                <li><a href="{{ url('/admin/list_customer') }}"><span>List Customer</span></a></li>
                <li><a href="{{ url('/admin/add_customer') }}"><span>Add Customer</span></a></li>
            </ul>
        </li>
        <li>
            <a href="{{ url('/admin/list_vendor') }}"><span>Vendor</span></a>
            <ul>
                <li><a href="{{ url('/admin/list_vendor') }}"><span>List Vendor</span></a></li>
                <li><a href="{{ url('/admin/add_vendor') }}"><span>Add Vendor</span></a></li>
            </ul>
        </li>
        <li><a href="{{ url('/admin/logout') }}"><span>Logout</span></a></li>
    </ul>
</nav>
