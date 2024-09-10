<div class="sidebar" id="sidebar">
    <h2 ><a class="text-decoration-none" href="/">Dashboard</a></h2>
    <nav>
        <ul>
            <li class="bg-secondary text-white"><a class="text-white" href="{{ route('home') }}">View Site</a></li>
            <li class="dropdown" onclick="toggleDropdown(this)">
                Orders
                <ul class="dropdown-content">
                    <li><a href="{{ route('orders.index') }}" class="text-decoration-none">All Orders</a></li>
                    <li><a href="{{ route('orders.index') }}">Drafts Orders</a></li>
                  
                </ul>   
            </li>
            <li class="dropdown" onclick="toggleDropdown(this)">
                Products
                <ul class="dropdown-content">
                    <li><a href="{{ route('collections.index') }}">Collections</a></li>
                    <li><a href="{{ route('products.index') }}">Products Lists</a></li>
                    {{-- <li>Inventory</li>
                    <li>Transfers</li> --}}
                </ul>
            </li>
            <li><a class="text-decoration-none" href="{{ route('customers.index') }}">Customers</a></li>
            <li><a class="text-decoration-none" href="#">Discounts</a></li>
            <li><a class="text-decoration-none" href="#">Analytics</a></li>
            <li><a class="text-decoration-none" href="#">Marketing</a></li>
     
       
        </ul>
    </nav>
</div>