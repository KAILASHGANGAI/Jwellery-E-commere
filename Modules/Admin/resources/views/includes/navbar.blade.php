<div class="sidebar" id="sidebar">
    <h5 class="text-center" ><a class="text-decoration-none text-center" href="{{ route('admin.dashboard') }}">My Store</a> </i></h5>
    <nav>
        <ul>
            <li class="bg-secondary text-white"><a class="text-white" href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-house"></i> Dashboard</a></li>
            
            <li class="dropdown" onclick="toggleDropdown(this)">
                <i class="fa-solid fa-cart-shopping"></i> Orders
                <ul class="dropdown-content">
                    <li><a href="{{ route('orders.index') }}" class="text-decoration-none"><i class="fa-solid fa-list"></i>All Orders</a></li>
                    <li><a href="{{ route('orders.index') }}"><i class="fa-solid fa-list"></i>Drafts Orders</a></li>
                </ul>   
            </li>
            <li class="dropdown" onclick="toggleDropdown(this)">
                <i class="fa-brands fa-product-hunt"></i> Products
                <ul class="dropdown-content">
                    <li><a href="{{ route('collections.index') }}"><i class="fa-solid fa-layer-group"></i>Collections</a></li>
                    <li><a href="{{ route('products.index') }}"><i class="fa-solid fa-list"></i>Products Lists</a></li>
                    {{-- <li>Inventory</li>
                    <li>Transfers</li> --}}
                </ul>
            </li>
            <li><a class="text-decoration-none" href="{{ route('customers.index') }}"><i class="fa-solid fa-users"></i> Customers</a></li>
            <li><a class="text-decoration-none" href="{{ route('discounts.index') }}"><i class="fa-solid fa-tag"></i> Discounts</a></li>
            <li><a class="text-decoration-none" href="{{ route('giftcards.index') }}"><i class="fa-solid fa-gift"></i> Gift Cards</a></li>
            <li><a class="text-decoration-none" href="{{ route('shipping.index') }}"><i class="fa-solid fa-truck-fast"></i>Shipping </a></li>
            <li><a class="text-decoration-none" href="{{ route('analytics') }}"><i class="fa-solid fa-chart-line"></i> Analytics</a></li>
            {{-- <li><a class="text-decoration-none" href="#">Marketing</a></li> --}}
            <hr>
            <li class="dropdown" onclick="toggleDropdown(this)">
                <i class="fa-solid fa-blog"></i>  Blog 
                <ul class="dropdown-content">
                    <li><a href="{{ route('blogs.index') }}"><i class="fa-solid fa-list"></i> Blogs List</a></li>
                    <li><a href="{{ route('blogcategory.index') }}"> <i class="fa-brands fa-blogger-b"></i>Blogs Category</a></li>
                   
                </ul>
            </li>
            <li class="dropdown" onclick="toggleDropdown(this)">
                <i class="fa-regular fa-user"></i> Admin Users 
                <ul class="dropdown-content">
                    <li><a href="{{ route('adminusers.index') }}"><i class="fa-solid fa-list"></i>Users List</a></li>
                    <li><a href="{{ route('adminroles.index') }}"><i class="fa-solid fa-list"></i> Roles Lists</a></li>
                    <li><a href="{{ route('adminpermissions.index') }}"><i class="fa-solid fa-list"></i>Permission Lists</a></li>
                    {{-- <li>Inventory</li>
                    <li>Transfers</li> --}}
                </ul>
            </li>
     
       
        </ul>
    </nav>
</div>