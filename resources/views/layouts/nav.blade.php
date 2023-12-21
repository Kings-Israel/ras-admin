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
                @role('admin')
                    <li class="nav-item @if(Route::is('vendors.*')) active open @endif"> <a href="{{ route('vendors.index') }}"><i class="material-icons">polymer</i><span>Vendor Management</span></a></li>
                @endrole
                @canany(['view order', 'view delivery'])
                    <li class="nav-item @if(Route::is('orders.*')) active open @endif"> <a href="{{ route('orders.index') }}"><i class="material-icons">layers</i><span>Order Management</span></a></li>
                @endcanany
                @can('view warehouse')
                    <li class="nav-item @if(Route::is('warehouses.*')) active @endif">
                        <a href="javascript:void(0);" class="menu-toggle"><i class="material-icons">local_convenience_store</i><span>Warehouse Management</span></a>
                        <ul class="ml-menu">
                            <li class="nav-item @if(Route::is('warehouses.index')) active open @endif">
                                <a href="{{ route('warehouses.index') }}"><span>Warehouses</span></a>
                            </li>
                            <li class="nav-item @if(Route::is('warehouses.orders.requests.buyers.*')) active open @endif">
                                <a href="{{ route('warehouses.orders.requests.buyers.index') }}"><span>Buyer Order Requests</span></a>
                            </li>
                            <li class="nav-item @if(Route::is('warehouses.orders.requests.vendors.*')) active open @endif">
                                <a href="{{ route('warehouses.orders.requests.vendors.index') }}"><span>Vendor Storage Requests</span></a>
                            </li>
                            <li class="nav-item @if(Route::is('warehouses.requests.release.*')) active open @endif">
                                <a href="{{ route('warehouses.index') }}"><span>Release Order Requests</span></a>
                            </li>
                        </ul>
                    </li>
                @endcan
                @role('warehouse manager')
                <li class="nav-item @if(Route::is('payments.*')) active open @endif">
                    <a href="{{ route('payments.index') }}"><i class="material-icons">payments</i><span>Payments</span></a>
                </li>
                @endrole
                @can('view product')
                    <li class="nav-item @if(Route::is('products.*')) active open @endif"> <a href="{{ route('products.index') }}"><i class="material-icons">shop</i><span>Stock Management</span></a></li>
                @endcan
                @can('view inspection report', 'view inspector')
                    <li class="nav-item @if(Route::is('inspection.*') || Route::is('inspectors.*')) active @endif">
                        <a href="javascript:void(0)" class="menu-toggle"><i class="material-icons">assignment_turned_in</i><span>Inspection Management</span></a>
                        <ul class="ml-menu">
                            @can('view inspector')
                                <li class="nav-item @if(Route::is('inspectors.index')) active open @endif">
                                    <a href="{{ route('inspectors.index') }}">Inspectors</a>
                                </li>
                            @endcan
                            @can('view inspection report')
                                <li class="nav-item @if(Route::is('inspection.requests.index') || Route::is('inspection.requests.show')) active open @endif">
                                    <a href="{{ route('inspection.requests.index') }}">Inspection Requests</a>
                                </li>
                            @endcan
                            @can('create inspection report')
                                <li class="nav-item @if(Route::is('inspection.requests.reports.pending') || Route::is('inspection.requests.reports.create')) active open @endif">
                                    <a href="{{ route('inspection.requests.reports.pending') }}">Pending Inspection Reports</a>
                                </li>
                            @endcan
                            @can('view inspection report')
                                <li class="nav-item @if(Route::is('inspection.requests.reports.completed')) active open @endif">
                                    <a href="{{ route('inspection.requests.reports.completed') }}">Completed Inspection Reports</a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('view insurance request')
                    <li class="nav-item @if(Route::is('insurance.*')) active @endif">
                        <a href="javascript:void(0)" class="menu-toggle"><i class="material-icons">assignment_late</i><span>Insurance Management</span></a>
                        <ul class="ml-menu">
                            @role('admin')
                                <li class="nav-item @if(Route::is('insurance.companies.*')) active open @endif">
                                    <a href="{{ route('insurance.companies.index') }}">Insurers</a>
                                </li>
                            @else
                                <li class="nav-item @if(Route::is('insurance.companies.*')) active open @endif">
                                    <a href="{{ route('insurance.companies.index') }}">Your Company</a>
                                </li>
                            @endrole
                            @can('view insurance request')
                                <li class="nav-item @if(Route::is('insurance.requests.*')) active open @endif">
                                    <a href="{{ route('insurance.requests.index') }}">Insurance Requests</a>
                                </li>
                            @endcan
                            @can('create insurance report')
                                <li class="nav-item @if(Route::is('insurance.reports.*')) active open @endif">
                                    <a href="{{ route('insurance.requests.index') }}">Pending Insurance Reports</a>
                                </li>
                            @endcan
                            @can('view insurance report')
                                <li class="nav-item @if(Route::is('insurance.reports.*')) active open @endif">
                                    <a href="{{ route('insurance.reports.index') }}">Completed Insurance Reports</a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('view logistics company', 'update logistics company', 'create logistics company', 'create stocklift request', 'update stocklift request', 'view stocklift request')
                    <li class="nav-item @if(Route::is('logistics.*') || Route::is('logistics-reports.*') || Route::is('deliveries.*')) active @endif">
                        <a href="javascript:void(0)" class="menu-toggle"><i class="material-icons">flight_takeoff</i><span>Logistics Management</span></a>
                        @can('view stocklift request', 'create stocklift request', 'update stocklift request')
                            <ul class="ml-menu">
                                @can('view logistics company', 'create logistics company', 'update logistics company')
                                    <li class="nav-item @if(Route::is('logistics.index')) active open @endif">
                                        <a href="{{ route('logistics.index') }}">Logistics Companies</a>
                                    </li>
                                @endcan
                                @can('create stocklift request', 'update stocklift request', 'view stocklift request')
                                    <li class="nav-item @if(Route::is('deliveries.requests.*')) active open @endif">
                                        <a href="{{ route('deliveries.requests.index') }}">Delivery Requests</a>
                                    </li>
                                @endcan
                                @can('view stocklift request')
                                    <li class="nav-item @if(Route::is('deliveries.reports.*')) active open @endif">
                                        <a href="#">Delivery Reports</a>
                                    </li>
                                @endcan
                            </ul>
                        @endcan
                    </li>
                @endcan
                @can('view financing request', 'view financier')
                    <li class="nav-item @if(Route::is('financing.*') || Route::is('financing-institutions.*')) active @endif">
                        <a href="javascript:void(0)" class="menu-toggle"><i class="material-icons">account_balance</i><span>Financing Management</span></a>
                        <ul class="ml-menu">
                            @can('view financing request', 'view financiers')
                                <li class="nav-item @if(Route::is('financing.institutions.*')) active open @endif">
                                <li class="nav-item @if(Route::is('financing.institutions.*')) active open @endif">
                                    <a href="{{ route('financing.institutions.index') }}">
                                        @role('admin')
                                            Financiers
                                        @else
                                            Your Institution
                                        @endrole
                                    </a>
                                </li>
                            @endcan
                            @can('view financing request')
                                <li class="nav-item @if(Route::is('financing.institutions.customers') || Route::is('financing.institutions.customer')) active open @endif">
                                    <a href="{{ route('financing.institutions.customers') }}">Customers</a>
                                </li>
                            @endcan
                            {{-- @if(!auth()->user()->hasRole('admin'))
                            @endif --}}
                            @can('view financing request')
                                <li class="nav-item @if(Route::is('financing.requests.*')) active open @endif">
                                    <a href="{{ route('financing.requests.index') }}">Financing Requests</a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @role('admin')
                    <li class="nav-item @if(Route::is('marketing.*')) active open @endif"> <a href="{{ route('marketing.index') }}"><i class="material-icons">extension</i><span>Marketing Management</span></a></li>
                @endrole
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
