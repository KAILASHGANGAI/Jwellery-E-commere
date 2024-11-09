<header class="header_area header_black">
    <!-- header top starts -->
    <div class="header_top">
        <div class="container mt-2">
            <div class="row align-items-center">
                <div class="col-8">
                    <div class="social_icone">
                        <ul>
                            <li><a href="#"><i class="ion-social-facebook"></i></a></li>
                            <li><a href="#"><i class="ion-social-twitter"></i></a></li>
                            <li><a href="#"><i class="ion-social-instagram"></i></a></li>
                            <li><a href="#"><i class="ion-social-linkedin"></i></a></li>
                            <li><a href="#"><i class="ion-social-youtube"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-4">
                    <div class="top_right text-right">
                        <ul>
                            @auth
                                <li class="top_links">
                                    <a href="#">My Account <i class="ion-chevron-down"></i></a>
                                    <ul class="dropdown_links">
                                        <li><a href="#">My Account</a></li>
                                        <li><a href="{{ route('shopping-cart') }}">Shopping Cart</a></li>
                                        <li><a href="{{ route('checkout') }}">Checkout</a></li>
                                        <li><a href="{{ route('wishlist') }}">Wishlist</a></li>
                                        <li><a href="{{ route('logout') }}">Logout</a></li>
                                    </ul>
                                </li>
                            @else
                                <li><a href="{{ route('login') }}">Login</a></li>
                                <li><a href="{{ route('register') }}">Register</a></li>
                            @endauth
                            {{-- <li class="language">
                                <a href="#">English <i class="ion-chevron-down"></i></a>
                                <ul class="dropdown_language">
                                    <li><a href="#">French</a></li>
                                    <li><a href="#">Germany</a></li>
                                    <li><a href="#">Hindi</a></li>
                                </ul>
                            </li>
                            <li class="currency">
                                <a href="#">INR <i class="ion-chevron-down"></i></a>
                                <ul class="dropdown_currency">
                                    <li><a href="#">USD - Dollar</a></li>
                                    <li><a href="#">EUR - Euro</a></li>
                                    <li><a href="#">GBP - British Pound</a></li>
                                </ul>
                            </li> --}}

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- header top ends -->

    <!-- header middle starts -->
    <div class="header_middel">
        <div class="container">
            <div class="row align-items-center">

                <div class="col-lg-5 d-none d-lg-block d-md-block">
                    <div class="home_contact">
                        <div class="contact_icone">
                            <img src="images/icon/icon_phone.png" alt="">
                        </div>
                        <div class="contact_box">
                            <p> Helpline : <a href="tel: 1234567894">1234567894</a></p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-2 col-md-3 col-6 ">
                    <div class="logo d-none d-lg-block">
                        <a href="index.html">
                            {{-- <img src="images/logo/logo-ash.png" alt=""> --}} logo
                        </a>
                    </div>
                </div>

                <div class="col-lg-5 col-md-7 col-6">
                    <div class="middel_right">
                        <div class="search_btn">
                            <a href="#"><i class="ion-ios-search-strong"></i></a>
                            <div class="dropdown_search">
                                <form action="{{ route('search') }}" method="GET">

                                    <input type="text" name="search" placeholder="Search Product ....">
                                    <button type="submit"><i class="ion-ios-search-strong"></i></button>
                                </form>
                            </div>
                        </div>
                        <div class="wishlist_btn">
                            <a href="{{ route('wishlist') }}"><i class="ion-heart"></i></a>

                        </div>
                        <div class="cart_link">
                            <a href="#" class="d-flex"><i class="ion-android-cart"></i><span
                                    class="cart_text_quantity" id="cart-total">0</span><i
                                    class="ion-chevron-down"></i></a>
                            <span class="cart_quantity" id="cart-quantity">0</span>

                            <!-- mini cart -->
                            <div class="mini_cart">
                                <div class="cart_close">
                                    <div class="cart_text">
                                        <h3>cart</h3>
                                    </div>
                                    <div class="mini_cart_close">
                                        <a href="javascript:void(0)"><i class="ion-android-close"></i></a>
                                    </div>
                                </div>
                                <div id="card-items" class="card-items">

                                    <!-- mini cart will be inserted here -->

                                </div>
                                <div class="cart_total">
                                    <span>Subtotal : </span>
                                    <span id="total-amount"></span>
                                </div>
                                <div class="mini_cart_footer">
                                    <div class="cart_button view_cart">
                                        <a href="{{ route('shopping-cart') }}">View Cart</a>
                                    </div>
                                    <div class="cart_button checkout">
                                        <a href="{{ route('checkout') }}" class="active">Checkout</a>
                                    </div>
                                </div>
                            </div>
                            <!-- mini cart ends  -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- header middle ends -->

    <!-- header bottom starts -->

    <div class="header_bottom sticky-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="main_menu_inner">
                        <div class="logo_sticky">
                            <a href="#">
                                JWELLERY
                                {{-- <img src="images/logo/logo-ash.png" alt="logo"> --}}
                            </a>
                        </div>
                        
                        <div class="main_menu" id="mainmenu">
                            
                        </div>
                        <div class="hem float-right d-lg-none d-md-none ">
                            <div class="col-lg-5 col-md-7 col-6">
                                <div class="middel_right">
                                    <div class="cart_link_hem">
                                        <a href="#" class="d-flex hem-icon text-white float-right">
                                            <i class="ion-navicon-round text-dark"></i>
                                        </a>
                                        <!-- Sidebar -->
                                        <!-- Sidebar -->
                                        <div class="mini_cart_hem">
                                            <div class="cart_close">
                                                <div class="cart_text">
                                                    <h3>Menu</h3>
                                                </div>
                                                <div class="mini_cart_close_hem">
                                                    <a href="javascript:void(0)" class="close-hem"><i
                                                            class="ion-android-close"></i></a>
                                                </div>
                                            </div>
                                            <!-- Add your menu items here -->
                                            <ul id="sidebarMenu" class="sidebar_menu">
                                                <!-- Dynamic menu will be inserted here -->
                                            </ul>
                                        </div>
                                        <!-- Sidebar ends -->

                                        <!-- Sidebar ends -->
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- header bottom ends -->
</header>
<style>
    /* Basic styles for the sidebar */
    .mini_cart_hem {
        position: fixed;
        top: 0;
        right: -300px;
        /* Start off-screen */
        width: 300px;
        height: 100%;
        background-color: #333;
        color: #fff;
        z-index: 1000;
        transition: right 0.3s ease;
        padding: 20px;
        display: flex;
        flex-direction: column;
    }

    /* Sidebar when visible */
    .mini_cart_hem.active {
        right: 0;
        /* Move it into view */
    }

    /* Close button styling */
    .mini_cart_close_hem {
        margin-left: auto;
    }

    /* Sidebar menu items */
    .sidebar_menu {
        list-style: none;
        padding: 0;
        margin-top: 20px;
    }

    .sidebar_menu li {
        margin-bottom: 15px;
    }

    .sidebar_menu li a {
        color: #fff;
        text-decoration: none;
        font-size: 18px;
    }

    /* Hamburger icon */
    .hem-icon i {
        font-size: 24px;
        color: #000;
        /* Change as per your design */
        cursor: pointer;
    }

    /* Ensure the close icon is inside the sidebar */
    .mini_cart_close_hem i {
        font-size: 24px;
        cursor: pointer;
        color: #fff;
    }

    /* Hide the sidebar on large screens */
    @media (min-width: 992px) {
        .mini_cart_hem {
            display: none;
        }

        
    }
    

    /* Hide dropdown menu by default */
    .dropdown_menu {
        display: none;
        list-style: none;
        padding-left: 20px;
        /* Indentation for the dropdown */
        margin: 10px 0 0 0;
    }

    /* Show dropdown menu when active */
    .sidebar_menu li.active>.dropdown_menu {
        display: block;
    }

    /* Dropdown toggle icon */
    .dropdown-toggle i {
        margin-left: 5px;
        font-size: 16px;
        color: #ccc;
    }
</style>
<script>
    document.querySelectorAll('.dropdown-toggle').forEach(function(dropdownToggle) {
        dropdownToggle.addEventListener('click', function(e) {
            e.preventDefault();
            const parentLi = this.parentElement;
            // Toggle the active class
            console.log(parentLi);
            parentLi.classList.toggle('active');
        });
    });

    var collectionUrl = '{{ route('all-collections') }}';

    async function fetchData(searchTerm = '', filter = 'all') {
        try {
            const response = await fetch(
                `${collectionUrl}`
            );
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            const data = await response.json();
            displayData(data);
            displaySidebarMenu(data);

        } catch (error) {
            console.error('There was a problem with the fetch operation:', error);
            // Handle the error (e.g., display an error message to the user)
        }
    }

    function displayData(collection) {
        const tableBody = document.getElementById('mainmenu');
        tableBody.innerHTML = ''; // Clear the existing content

        let row = `<nav>
                    <ul>
                        <li class="active">
                            <a href="{{ route('home') }}">Home</a>
                        </li>`;

        collection.forEach(coll => {
            row += `
            <li>
                <a href="#">${coll.title} <i class="ion-chevron-down"></i></a>
                <ul class="sub_menu pages">`;

            coll.children.forEach(child => {
                var childUrl = '{{ url('collection') }}/' + child.slug;

                row += `
                <li><a href="${childUrl}">${child.title}</a></li>`;
            });

            row += `</ul>
            </li>`;
        });

        row += `
        <li><a href="{{ route('blogs') }}">Blogs</a></li>
        <li><a href="{{ route('about') }}">About Us</a></li>
        <li><a href="{{ route('contact') }}">Contact Us</a></li>
        </ul>
        </nav>`;

        // Append the generated menu to the tableBody
        tableBody.innerHTML = row;
    }

    function displaySidebarMenu(collection) {
        const sidebarMenu = document.getElementById('sidebarMenu');
        sidebarMenu.innerHTML = ''; // Clear the existing content

        // Static links that are always present
        let menuHtml = `<li><a href="{{ route('home') }}">Home</a></li>`;

        collection.forEach(coll => {
            menuHtml += `
            <li class="has-dropdown">
                <a href="javascript:void(0)" class="dropdown-toggle">${coll.title} </a>
                <ul class="dropdown_menu" style="display: none;">`;

            coll.children.forEach(child => {
                let childUrl = '{{ url('collection') }}/' + child.slug;
                menuHtml += `
                <li><a href="${childUrl}">${child.title}</a></li>`;
            });

            menuHtml += `
                </ul>
            </li>`;
        });

        // Add static links for 'About Us' and 'Contact'
        menuHtml += `
        <li><a href="{{ route('blogs') }}">Blogs</a></li>
        <li><a href="{{ route('about') }}">About Us</a></li>
        <li><a href="{{ route('contact') }}">Contact</a></li>
           
        `;

        // Insert the generated menu into the sidebar
        sidebarMenu.innerHTML = menuHtml;

        // Add event listeners for dropdown functionality
        const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
        dropdownToggles.forEach(toggle => {
            toggle.addEventListener('click', function() {
                const dropdownMenu = this.nextElementSibling;
                if (dropdownMenu.style.display === 'none' || dropdownMenu.style.display === '') {
                    dropdownMenu.style.display = 'block'; // Show the dropdown
                } else {
                    dropdownMenu.style.display = 'none'; // Hide the dropdown
                }
            });
        });
    }


    fetchData();
</script>
