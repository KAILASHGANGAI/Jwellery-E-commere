<div class="sidebar" id="sidebar">
    <h2>Dashboard</h2>
    <nav>
        <ul>
            <li>Home</li>
            <li class="dropdown" onclick="toggleDropdown(this)">
                Orders
                <ul class="dropdown-content">
                    <li>All Orders</li>
                    <li>Drafts</li>
                    <li>Abandoned checkouts</li>
                </ul>   
            </li>
            <li class="dropdown" onclick="toggleDropdown(this)">
                Products
                <ul class="dropdown-content">
                    <li><a href="{{ route('collections.index') }}">Collections</a></li>
                    <li><a href="{{ route('products.index') }}">Products Lists</a></li>
                    <li>Inventory</li>
                    <li>Transfers</li>
                </ul>
            </li>
            <li>Customers</li>
            <li>Content</li>
            <li>Analytics</li>
            <li>Marketing</li>
            <li>Discounts</li>
        </ul>
    </nav>
</div>