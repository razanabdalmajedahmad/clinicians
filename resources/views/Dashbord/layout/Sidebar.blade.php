<aside id="sidebar" class="sidebar">


    <ul class="sidebar-nav" id="sidebar-nav">
        <li class="nav-item">
            <a class="nav-link {{ !(Route::currentRouteName() == 'home') ? 'collapsed' : '' }}"
                href="{{ route('home') }}">
                <i class="bi bi-grid"></i>
                <span>Home</span>
            </a>
        </li>
        @if (Auth::user()->isDoctor())


            <li class="nav-item">
                <a class="nav-link {{ !in_array(Route::currentRouteName(), ['user_list', 'user_createnew', 'user_update']) ? 'collapsed' : '' }}"
                    data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-menu-button-wide"></i><span>User</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="components-nav"
                    class="nav-content collapse {{ in_array(Route::currentRouteName(), ['user_list', 'user_createnew', 'user_update']) ? 'show' : '' }}"
                    data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ route('user_list') }}"
                            class="{{ Route::currentRouteName() == 'user_list' ? 'active' : '' }}">
                            <i class="bi bi-circle"></i><span>View All</span>
                        </a>
                    </li>

                </ul>
            </li>


            <li class="nav-item">
                <a class="nav-link {{ !in_array(Route::currentRouteName(), ['appointment_list', 'appointment_createnew', 'appointment_update']) ? 'collapsed' : '' }}"
                    data-bs-target="#components-nav1" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-menu-button-wide"></i><span>Appointments</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="components-nav1"
                    class="nav-content collapse {{ in_array(Route::currentRouteName(), ['appointment_list', 'appointment_createnew', 'appointment_update']) ? 'show' : '' }}"
                    data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ route('appointment_list') }}"
                            class="{{ Route::currentRouteName() == 'appointment_list' ? 'active' : '' }}">
                            <i class="bi bi-circle"></i><span>View All</span>
                        </a>
                    </li>

                </ul>
            </li>
        @endif
        <li class="nav-item">
            <a class="nav-link {{ !(Route::currentRouteName() == 'Calender') ? 'collapsed' : '' }}" href="{{route('Calender')}}">

                <span>Calender</span>
            </a>
        </li>


    </ul>

</aside>
