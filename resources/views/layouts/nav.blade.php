<aside class="right_menu">
    <div id="leftsidebar" class="sidebar">
        <div class="menu">
            <ul class="list">
                <li>
                    <div class="user-info m-b-20">
                        <div class="detail m-t-10">
                            <h6>{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</h6>
                            <p class="m-b-0">{{ auth()->user()->email }}</p>
                        </div>
                    </div>
                </li>
                <li class="nav-item @if(Route::is('dashboard')) active open @endif"> <a href="{{ route('dashboard') }}"><i class="zmdi zmdi-home"></i><span>Dashboard</span></a></li>
                @role('admin')
                    <li class="nav-item @if(Route::is('users.*')) active @endif">
                        <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-swap-alt"></i><span>User Management</span></a>
                        <ul class="ml-menu">
                            <li class="nav-item @if(Route::is('users.buyers')) active open @endif">
                                <a href="{{ route('users.buyers') }}"><i class="material-icons">people</i><span>Customers</span></a>
                            </li>
                            <li class="nav-item @if(Route::is('users.vendors')) active open @endif" >
                                <a href="{{ route('users.vendors') }}"><i class="material-icons">people_outline</i><span>Vendors</span></a>
                            </li>
                            <li class="nav-item @if(Route::is('users.warehousemanagers')) active open @endif" >
                                <a href="{{ route('users.warehousemanagers') }}"><i class="material-icons">assignment</i><span>Warehouse Managers</span></a>
                            </li>
                            <li class="nav-item @if(Route::is('users.financiers')) active open @endif" >
                                <a href="{{ route('users.financiers') }}"><i class="material-icons">euro_symbol</i><span>Financiers</span></a>
                            </li>
                            <li class="nav-item @if(Route::is('users.inspectors')) active open @endif" >
                                <a href="{{ route('users.inspectors') }}"><i class="material-icons">gavel</i><span>Inspectors</span></a>
                            </li>
                            <li class="nav-item @if(Route::is('users.drivers')) active open @endif" >
                                <a href="{{ route('users.drivers') }}"><i class="material-icons">toys</i><span>Drivers</span></a>
                            </li>
                        </ul>
                    </li>
                @endrole
                @can('view order')
                    <li class="nav-item"> <a href="{{ route('dashboard') }}"><i class="material-icons">layers</i><span>Order Management</span></a></li>
                @endcan
                @can('view warehouse')
                    <li class="nav-item @if(Route::is('warehouses')) active open @endif"> <a href="{{ route('warehouses') }}"><i class="material-icons">local_convenience_store</i><span>Warehouse Management</span></a></li>
                @endcan
                @can('view product')
                    <li class="nav-item @if(Route::is('products')) active open @endif"> <a href="{{ route('products') }}"><i class="material-icons">shop</i><span>Stock Management</span></a></li>
                @endcan
                @can('view role')
                    <li class="nav-item @if(Route::is('permissions.*')) active open @endif"> <a href="{{ route('permissions.index') }}"><i class="material-icons">extension</i><span>Roles and Permissions</span></a></li>
                @endcan
                @can('view logs')
                    <li class="nav-item @if(Route::is('logs')) active open @endif"> <a href="{{ route('logs') }}"><i class="material-icons">dehaze</i><span>Activity Logs</span></a></li>
                @endcan
            </ul>
        </div>
    </div>
</aside>
