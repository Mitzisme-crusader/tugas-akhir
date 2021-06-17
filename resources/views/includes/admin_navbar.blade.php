<nav>
    <ul>
        <li><a href="{{ url('/admin/list_restoran') }}"><img src="{{ asset('images/logo.jpg') }}" alt="logo"></a></li>
        <li>
            <a href="{{ url('/admin/list_restoran') }}"><span>Restaurant</span></a>
            <ul>
                <li><a href="{{ url('/admin/list_restoran') }}"><span>Restaurant List</span></a></li>
                <li><a href="{{ url('/admin/tambah_restoran') }}"><span>Add Restaurant</span></a></li>
            </ul>
        </li>
        <li>
            <a href="{{ url('/admin/list_resep') }}"><span>Recipe</span></a>
            <ul>
                <li><a href="{{ url('/admin/list_resep') }}"><span>Recipe List</span></a></li>
                <li><a href="{{ url('/admin/tambah_resep') }}"><span>Add Recipes</span></a></li>
            </ul>
        </li>
        <li>
            <a href="{{ url('/admin/list_food_blogger') }}"><span>Food Blogger</span></a>
            <ul>
                <li><a href="{{ url('/admin/list_food_blogger') }}"><span>Food Blogger List</span></a></li>
                <li><a href="{{ url('/admin/tambah_food_blogger') }}"><span>Add Food Blogger</span></a></li>
            </ul>
        </li>
        <li><a href="{{ url('/admin/logout') }}"><span>Logout</span></a></li>
    </ul>
</nav>
