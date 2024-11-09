
<div class="header">
    <nav class="navbar navbar-expand-lg navbar-light fixed-top " style="display: contents">
        <div class="container-fluid">
            <div class="collapse navbar-collapse" id="navbarNav">
                <h5>
                    Hi !, {{ Auth::guard('admin')->user()->name }}
                    @php
                      
                        $hour = date('H');
                        if ($hour >= 6 && $hour < 12) {
                            $greeting = 'Good Morning';
                            $color = 'color: #FFA500;'; // Orange for morning
                        } elseif ($hour >= 12 && $hour < 18) {
                            $greeting = 'Good Afternoon';
                            $color = 'color: #00BFFF;'; // Light blue for afternoon
                        } else {
                            $greeting = 'Good Evening';
                            $color = 'color: #8A2BE2;'; // Purple for evening
                        }
                    @endphp
                    <span style="{{ $color }}">{{ $greeting }}</span>
                    
                        
                </h5>
                <ul class="navbar-nav ms-auto">
                    <li><a href="#" class="nav-link"><span> {{ date('l jS \of F Y') }}</span></a></li>
                    <li>
                        <a href="{{ route('home') }}" target="blank" title="View Site" class="nav-link">
                            <i class="fa-solid fa-eye">
                            </i>
                        </a>
                    </li>
                    @auth('admin')
                        <li class="nav-item dropdown">
                            <!-- Admin's name as dropdown trigger -->
                            <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-user"></i> {{ Auth::guard('admin')->user()->name }}
                            </a>
                            <!-- Dropdown Menu -->
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="adminDropdown">
                                <li><a class="dropdown-item" href="#">Profile</a></li>
                                <li><a class="dropdown-item" href="#">Settings</a></li>
                                <li>
                                    <!-- Logout form -->
                                    <form method="POST" action="{{ route('admin.logout') }}">
                                        @csrf
                                        <button class="dropdown-item" type="submit">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

</div>  
