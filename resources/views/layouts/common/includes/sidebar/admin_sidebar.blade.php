<div class="row">
    <!-- Left Sidebar start-->
    <div class="side-menu-fixed">
        <div class="scrollbar side-menu-bg">
            <ul class="nav navbar-nav side-menu" id="sidebarnav">
                <!-- Start Dashboard-->

                <li><a href="{{ route('admin.dashboard') }}">{{ trans('dashboard.dashboard') }}</a></li>
                <!-- End Dashboard-->

                <!-- Start CMS -->
                <li class="pl-4 mt-10 mb-10 font-medium text-muted menu-title">CMS Management</li>
                <li>
                    <a href="javascript:void(0);" data-toggle="collapse" data-target="#cms_managment">
                        <div class="pull-left">
                            <i class="fa fa-book"></i>
                            <span class="right-nav-text">CMS Management</span>
                        </div>
                        <div class="pull-right"><i class="ti-plus"></i></div>
                        <div class="clearfix"></div>
                    </a>
                    <ul id="cms_managment" class="collapse" data-parent="#sidebarnav">
                        <li><a href="{{route('service.index')}}">Services</a></li>
                        <li><a href="{{route('offer.index')}}">Offers</a></li>
                    </ul>
                </li>
                <!-- End CMS -->

                <!-- Start Admin Managment Menu-->
                <li class="pl-4 mt-10 mb-10 font-medium text-muted menu-title">Settings Management</li>
                <li>
                    <a href="javascript:void(0);" data-toggle="collapse" data-target="#setting_managment">
                        <div class="pull-left">
                            <i class="ti-palette"></i>
                            <span class="right-nav-text">Settings Management</span></div>
                        <div class="pull-right"><i class="ti-plus"></i></div>
                        <div class="clearfix"></div>
                    </a>
                    <ul id="setting_managment" class="collapse" data-parent="#sidebarnav">
                        <li><a href="{{route('mainSettings.index')}}">Main Settings</a></li>
                        <li><a href="{{route('sos.index')}}">Sos</a></li>
                        <a href="javascript:void(0);" data-toggle="collapse" data-target="#car_managment">
                            <div class="pull-left">
                                <i class="ti-car"></i>
                                <span class="right-nav-text">Car Management</span></div>
                            <div class="pull-right"><i class="ti-plus"></i></div>
                            <div class="clearfix"></div>
                        </a>
                        <ul id="car_managment" class="collapse" data-parent="#sidebarnavcar">
                            <li><a href="{{route('carMake.index')}}">Car-Make</a></li>
                            <li><a href="{{ route('carModel.index') }}">Car-Model</a></li>
                            <li><a href="{{route('carType.index')}}">Car-Type</a></li>
                            <li><a href="{{route('tripType.index')}}">Trip-Type</a></li>
                            <li><a href="{{route('carCategories.index')}}">Car-Categories</a></li>
                        </ul>
                        <!-- Start Bike & Scooter -->
                        <a href="javascript:void(0);" data-toggle="collapse" data-target="#scooter_managment">
                            <div class="pull-left">
                                <i class="fa fa-motorcycle"></i>
                                <span class="right-nav-text">Scooter Management</span>
                            </div>
                            <div class="pull-right"><i class="ti-plus"></i></div>
                            <div class="clearfix"></div>
                        </a>
                        <ul id="scooter_managment" class="collapse" data-parent="#sidebarnavcar">
                            <li><a href="{{ route('scooterMake.index') }}">Scooter-Make</a></li>
                            <li><a href="{{ route('scooterModel.index') }}">Scooter-Model</a></li>
                        </ul>
                        <!-- End Bike & Scooter -->
                        <!-- Start Tricycle -->
                        <a href="javascript:void(0);" data-toggle="collapse" data-target="#tricycle_managment">
                            <div class="pull-left">
                                <img src="{{asset('assets/images/cargo-bike.png')}}" alt="Tricycle cargo-bike" >
                                <span class="right-nav-text">Tricycle Management</span>
                            </div>
                            <div class="pull-right"><i class="ti-plus"></i></div>
                            <div class="clearfix"></div>
                        </a>
                        <ul id="tricycle_managment" class="collapse" data-parent="#sidebarnavcar">
                            <li><a href="{{ route('tricycleMake.index') }}">Tricycle-Make</a></li>
                            <li><a href="{{ route('tricycleModel.index') }}">Tricycle-Model</a></li>
                        </ul>
                        <!-- End Tricycle -->
                        <!-- Start Trunk -->
                        <a href="javascript:void(0);" data-toggle="collapse" data-target="#trunk_managment">
                            <div class="pull-left">
                                <i class="fa fa-truck"></i>
                                <span class="right-nav-text">Trunk Management</span>
                            </div>
                            <div class="pull-right"><i class="ti-plus"></i></div>
                            <div class="clearfix"></div>
                        </a>
                        <ul id="trunk_managment" class="collapse" data-parent="#sidebarnavcar">
                            <li><a href="{{ route('trunkMake.index') }}">Trunk-Make</a></li>
                            <li><a href="{{ route('trunkModel.index') }}">Trunk-Model</a></li>
                        </ul>
                        <!-- End Trunk -->
                    </ul>
                    <ul id="setting_managment" class="collapse" data-parent="#sidebarnav">
                        <a href="javascript:void(0);" data-toggle="collapse" data-target="#general_managment">
                            <div class="pull-left">
                                <i class="ti-car"></i>
                                <span class="right-nav-text">General Settings</span></div>
                            <div class="pull-right"><i class="ti-plus"></i></div>
                            <div class="clearfix"></div>
                        </a>
                        <ul id="general_managment" class="collapse" data-parent="#sidebarnavcar">
                            <li><a href="{{route('countries.index')}}">Countries</a></li>
                            <li><a href="{{route('states.index')}}">States</a></li>
                            <li><a href="{{route('cities.index')}}">Cities</a></li>
                        </ul>
                        <a href="javascript:void(0);" data-toggle="collapse" data-target="#section_managment">
                            <div class="pull-left">
                                <i class="ti-car"></i>
                                <span class="right-nav-text">Sections</span></div>
                            <div class="pull-right"><i class="ti-plus"></i></div>
                            <div class="clearfix"></div>
                        </a>
                        <ul id="section_managment" class="collapse" data-parent="#sidebarnavcar">
                            <li><a href="{{route('sections.index')}}">Sections</a></li>
                        </ul>
                        <a href="javascript:void(0);" data-toggle="collapse" data-target="#discount_managment">
                            <div class="pull-left">
                                <i class="ti-car"></i>
                                <span class="right-nav-text">Discount</span></div>
                            <div class="pull-right"><i class="ti-plus"></i></div>
                            <div class="clearfix"></div>
                        </a>
                        <ul id="discount_managment" class="collapse" data-parent="#sidebarnavcar">
                            <li><a href="{{route('discounts.index')}}">Discount</a></li>
                        </ul>
                        <a href="javascript:void(0);" data-toggle="collapse" data-target="#package_managment">
                            <div class="pull-left">
                                <i class="ti-car"></i>
                                <span class="right-nav-text">Packages</span></div>
                            <div class="pull-right"><i class="ti-plus"></i></div>
                            <div class="clearfix"></div>
                        </a>
                        <ul id="package_managment" class="collapse" data-parent="#sidebarnavcar">
                            <li><a href="{{route('packages.index')}}">Package</a></li>
                        </ul>
                        <!-- Start Hour -->
                        <a href="javascript:void(0);" data-toggle="collapse" data-target="#hour_managment">
                            <div class="pull-left">
                                <i class="ti-car"></i>
                                <span class="right-nav-text">Hours</span>
                            </div>
                            <div class="pull-right"><i class="ti-plus"></i></div>
                            <div class="clearfix"></div>
                        </a>
                        <ul id="hour_managment" class="collapse" data-parent="#sidebarnavcar">
                            <li><a href="{{route('hours.index')}}">Hours</a></li>
                        </ul>
                        <!-- End Hour -->
                    </ul>
                </li>
                <!-- End Admin Managment Menu-->



                <!-- Start Admin Managment Menu-->
                <li class="pl-4 mt-10 mb-10 font-medium text-muted menu-title">{{ trans('admins.admin_managment') }}</li>

                <li>
                    <a href="javascript:void(0);" data-toggle="collapse" data-target="#admins_managment">
                        <div class="pull-left">
                            <i class="ti-palette"></i>
                            <span class="right-nav-text">{{ trans('admins.admin_managment') }}</span></div>
                        <div class="pull-right"><i class="ti-plus"></i></div>
                        <div class="clearfix"></div>
                    </a>
                    <ul id="admins_managment" class="collapse" data-parent="#sidebarnav">
                        <li><a href="{{route('admins.index')}}">{{ trans('admins.admins') }}</a></li>

                        <li><a href="{{route('agents.index')}}">{{ trans('agents.agents') }}</a></li>
                        <li><a href="{{route('companies.index')}}">Company</a></li>
                        <li><a href="{{route('employees.index')}}">Employee</a></li>
                    </ul>
                </li>
                <!-- End Admin Managment Menu-->


                <!-- Start Call Center Management Menu -->
                <li class="pl-4 mt-10 mb-10 font-medium text-muted menu-title">Call-Center Managment</li>
                <li>
                    <a href="javascript:void(0);" data-toggle="collapse" data-target="#callcenters_managment">
                        <div class="pull-left">
                            <i class="ti-palette"></i>
                            <span class="right-nav-text">Call-Center Managment</span>
                        </div>
                        <div class="pull-right"><i class="ti-plus"></i></div>
                        <div class="clearfix"></div>
                    </a>
                    <ul id="callcenters_managment" class="collapse" data-parent="#sidebarnav">
                        <li><a href="{{route('callCenters.index')}}">Call-Centers</a></li>
                        <li><a href="{{route('callCenters.activity')}}">Call-Centers Activity</a></li>
                        <li><a href="{{route('attendances.index')}}">Call-Centers Attendance</a></li>
                    </ul>
                </li>
                <!-- End Call Center Management Menu -->


                <!-- Start Admin Managment Menu-->
                <li class="pl-4 mt-10 mb-10 font-medium text-muted menu-title">Captains</li>

                <li>
                    <a href="javascript:void(0);" data-toggle="collapse" data-target="#caption">
                        <div class="pull-left">
                            <i class="ti-palette"></i>
                            <span class="right-nav-text">Captains</span></div>
                        <div class="pull-right"><i class="ti-plus"></i></div>
                        <div class="clearfix"></div>
                    </a>
                    <ul id="caption" class="collapse" data-parent="#sidebarnav">
                        <li><a href="{{route('captains.index')}}">Captain</a></li>
                        <li><a href="{{route('captain-bouns.index')}}">Captain-Bouns</a></li>
                    </ul>
                </li>
                <!-- End Admin Managment Menu-->

                <!-- Start Subscriptions -->
                <li class="pl-4 mt-10 mb-10 font-medium text-muted menu-title">Subscriptions</li>
                <li>
                    <a href="javascript:void(0);" data-toggle="collapse" data-target="#subscription">
                        <div class="pull-left">
                            <i class="ti-palette"></i>
                            <span class="right-nav-text">Subscriptions</span>
                        </div>
                        <div class="pull-right"><i class="ti-plus"></i></div>
                        <div class="clearfix"></div>
                    </a>
                    <ul id="subscription" class="collapse" data-parent="#sidebarnav">
                        <li><a href="{{route('subscriptions.index')}}">Subscriptions</a></li>
                    </ul>
                </li>
                <!-- End Subscriptions -->

                <!-- Start Admin Managment Menu-->
                <li class="pl-4 mt-10 mb-10 font-medium text-muted menu-title">users</li>

                <li>
                    <a href="javascript:void(0);" data-toggle="collapse" data-target="#users">
                        <div class="pull-left">
                            <i class="ti-palette"></i>
                            <span class="right-nav-text">users</span></div>
                        <div class="pull-right"><i class="ti-plus"></i></div>
                        <div class="clearfix"></div>
                    </a>
                    <ul id="users" class="collapse" data-parent="#sidebarnav">
                        <li><a href="{{route('users.index')}}">{{ trans('users') }}</a></li>
                    </ul>
                </li>
                <!-- End Admin Managment Menu-->


                <!-- End Admin Managment Menu-->

                <!-- Start Admin Managment Menu-->
                <li class="pl-4 mt-10 mb-10 font-medium text-muted menu-title">Reposts</li>

                <li>
                    <a href="javascript:void(0);" data-toggle="collapse" data-target="#Reposts">
                        <div class="pull-left">
                            <i class="ti-palette"></i>
                            <span class="right-nav-text">Reposts</span></div>
                        <div class="pull-right"><i class="ti-plus"></i></div>
                        <div class="clearfix"></div>
                    </a>
                    <ul id="Reposts" class="collapse" data-parent="#sidebarnav">
                        <li><a href="">Reposts orders</a></li>
                        <li><a href="">Reposts users</a></li>
                        <li><a href="">Reposts Caption</a></li>
                        <li><a href="">Reposts agents</a></li>
                        <li><a href="">Reposts companies</a></li>
                        <li><a href="">Reposts employees</a></li>
                    </ul>
                </li>
                <!-- End Admin Managment Menu-->


                <!-- Start Orders Managment Menu-->
                <li class="pl-4 mt-10 mb-10 font-medium text-muted menu-title">orders</li>

                <li>
                    <a href="javascript:void(0);" data-toggle="collapse" data-target="#orders">
                        <div class="pull-left">
                            <i class="ti-palette"></i>
                            <span class="right-nav-text">orders</span>
                        </div>
                        <div class="pull-right"><i class="ti-plus"></i></div>
                        <div class="clearfix"></div>
                    </a>
                    <ul id="orders" class="collapse" data-parent="#sidebarnav">
                        <!-- Start Hour & Day Order -->
                        <a href="javascript:void(0);" data-toggle="collapse" data-target="#order_managment">
                            <div class="pull-left">
                                <i class="ti-car"></i>
                                <span class="right-nav-text">Order Hour & Day</span>
                            </div>
                            <div class="pull-right"><i class="ti-plus"></i></div>
                            <div class="clearfix"></div>
                        </a>
                        
                        <ul id="order_managment" class="collapse" data-parent="#sidebarnavcar">
                            <!-- Start Order Day -->
                            <a href="javascript:void(0);" data-toggle="collapse" data-target="#orderDay_managment">
                                <div class="pull-left">
                                    <i class="ti-car"></i>
                                    <span class="right-nav-text">Order Day</span>
                                </div>
                                <div class="pull-right"><i class="ti-plus"></i></div>
                                <div class="clearfix"></div>
                            </a>
                            <ul id="orderDay_managment" class="collapse" data-parent="#sidebarnavcar">
                                <li><a href="{{ route('orderDay.index') }}">Order Day</a></li>
                                <li><a href="{{ route('upcamingOrderDay.index') }}">Upcoming Order Day</a></li>
                            </ul>
                            <!-- End Order Day -->
                            <!-- Start Order Hour -->
                            <a href="javascript:void(0);" data-toggle="collapse" data-target="#orderHour_managment">
                                <div class="pull-left">
                                    <i class="ti-car"></i>
                                    <span class="right-nav-text">Order Hour</span>
                                </div>
                                <div class="pull-right"><i class="ti-plus"></i></div>
                                <div class="clearfix"></div>
                            </a>
                            <ul id="orderHour_managment" class="collapse" data-parent="#sidebarnavcar">
                                <li><a href="{{ route('orderHour.index') }}">Order Hour</a></li>
                                <li><a href="{{ route('upcamingOrderHour.index') }}">Upcoming Order Hour</a></li>
                            </ul>
                            <!-- End Order Hour -->
                        </ul>
                        <!-- End Hour & Day Order -->
                        <!-- Start Normal Order -->
                        <a href="javascript:void(0);" data-toggle="collapse" data-target="#order">
                            <div class="pull-left">
                                <i class="ti-car"></i>
                                <span class="right-nav-text">Orders</span>
                            </div>
                            <div class="pull-right"><i class="ti-plus"></i></div>
                            <div class="clearfix"></div>
                        </a>
                        <ul id="order" class="collapse" data-parent="#sidebarnavcar">
                            <li><a href="{{route('orders.index')}}">All orders</a></li>
                            <li><a href="{{ route('orders.index', ['status' => 'waiting']) }}">orders waiting</a></li>
                            <li><a href="{{ route('orders.index', ['status' => 'pending']) }}">orders pending</a></li>
                            <li><a href="{{ route('orders.index', ['status' => 'cancel']) }}">orders cancel</a></li>
                            <li><a href="{{ route('orders.index', ['status' => 'accepted']) }}">orders accepted</a></li>
                            <li><a href="{{ route('orders.index', ['status' => 'done']) }}">orders done</a></li>
                        </ul>
                        <!-- End Normal Order -->
                    </ul>
                </li>
                <!-- End Orders Managment Menu-->

                <!-- Start Admin Managment Menu-->
                <li class="pl-4 mt-10 mb-10 font-medium text-muted menu-title">Accounts</li>

                <li>
                    <a href="javascript:void(0);" data-toggle="collapse" data-target="#accounts">
                        <div class="pull-left">
                            <i class="ti-palette"></i>
                            <span class="right-nav-text">Accounts</span></div>
                        <div class="pull-right"><i class="ti-plus"></i></div>
                        <div class="clearfix"></div>
                    </a>
                    <ul id="accounts" class="collapse" data-parent="#sidebarnav">
                        <li><a href="">accounts</a></li>
                    </ul>
                </li>
                <!-- End Admin Managment Menu-->

                <!-- Start Admin Managment Menu-->
                <li class="pl-4 mt-10 mb-10 font-medium text-muted menu-title">integrations</li>

                <li>
                    <a href="javascript:void(0);" data-toggle="collapse" data-target="#integrations">
                        <div class="pull-left">
                            <i class="ti-palette"></i>
                            <span class="right-nav-text">Integrations</span></div>
                        <div class="pull-right"><i class="ti-plus"></i></div>
                        <div class="clearfix"></div>
                    </a>
                    <ul id="integrations" class="collapse" data-parent="#sidebarnav">
                        <li><a href="">my fatoorah</a></li>
                        <li><a href="">paypal</a></li>
                    </ul>
                </li>
                <!-- End Admin Managment Menu-->

            </ul>
        </div>
    </div>

    <!-- Left Sidebar End-->
</div>
