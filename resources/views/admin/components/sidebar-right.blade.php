<div class="sidebar sidebar-right sidebar-animate">
    <div class="panel panel-primary card mb-0 shadow-none border-0">
        <div class="tab-menu-heading border-0 d-flex p-3">
            <div class="card-title mb-0"></div>
            <div class="card-options ms-auto">
                <a href="#" class="sidebar-icon text-end float-end me-1" data-bs-toggle="sidebar-right" data-target=".sidebar-right"><i class="fe fe-x text-white"></i></a>
            </div>
        </div>
        <div class="panel-body tabs-menu-body latest-tasks p-0 border-0">
            <div class="tabs-menu border-bottom">
                <!-- Tabs -->
                <ul class="nav panel-tabs">
                    <li class=""><a href="#side1" class="active" data-bs-toggle="tab"><i class="fe fe-user me-1"></i> Profile</a></li>
                </ul>
            </div>
            <div class="tab-content">
                <div class="tab-pane active" id="side1">
                    <div class="card-body text-center">
                        <div class="dropdown user-pro-body">
                            <div class="">
                                <img alt="user-img" class="avatar avatar-xl brround mx-auto text-center" src="{{ asset('admin/assets/images/faces/6.jpg') }}"><span class="avatar-status profile-status bg-green"></span>
                            </div>
                            <div class="user-info mg-t-20">
                                <h6 class="fw-semibold  mt-2 mb-0">Mintrona Pechon</h6>
                                <span class="mb-0 text-muted fs-12">Premium Member</span>
                            </div>
                        </div>
                    </div>
                    <form action="{{ route('admin.logout') }}" method="POST">
                        @csrf

                        <button
                            type="submit"
                            class="dropdown-item d-flex border-bottom w-100 text-start
                                border-0 bg-red-50 text-red-600" style="background-color: #fff5f5;">
                            <div class="d-flex">
                                <i class="fe fe-power me-3 tx-20 text-red-500"></i>

                                <div class="pt-1">
                                    <h6 class="mb-0 text-red-600">Sign Out</h6>
                                    <p class="tx-12 mb-0 text-red-400">Account Signout</p>
                                </div>
                            </div>
                        </button>
                    </form>
                </div>
                <div class="tab-pane" id="side3">
                    <a class="dropdown-item bg-gray-100 pd-y-10" href="#">
                        Account Settings
                    </a>
                    <div class="card-body">
                        <div class="form-group mg-b-10">
                            <label class="custom-switch ps-0">
                                <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input" checked>
                                <span class="custom-switch-indicator"></span>
                                <span class="custom-switch-description mg-l-10">Updates Automatically</span>
                            </label>
                        </div>
                        <div class="form-group mg-b-10">
                            <label class="custom-switch ps-0">
                                <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input">
                                <span class="custom-switch-indicator"></span>
                                <span class="custom-switch-description mg-l-10">Allow Location Map</span>
                            </label>
                        </div>
                        <div class="form-group mg-b-10">
                            <label class="custom-switch ps-0">
                                <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input" checked>
                                <span class="custom-switch-indicator"></span>
                                <span class="custom-switch-description mg-l-10">Show Contacts</span>
                            </label>
                        </div>
                        <div class="form-group mg-b-10">
                            <label class="custom-switch ps-0">
                                <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input" checked>
                                <span class="custom-switch-indicator"></span>
                                <span class="custom-switch-description mg-l-10">Show Notication</span>
                            </label>
                        </div>
                        <div class="form-group mg-b-10">
                            <label class="custom-switch ps-0">
                                <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input">
                                <span class="custom-switch-indicator"></span>
                                <span class="custom-switch-description mg-l-10">Show Tasks Statistics</span>
                            </label>
                        </div>
                        <div class="form-group mg-b-10">
                            <label class="custom-switch ps-0">
                                <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input" checked>
                                <span class="custom-switch-indicator"></span>
                                <span class="custom-switch-description mg-l-10">Show Email Notification</span>
                            </label>
                        </div>
                    </div>
                    <a class="dropdown-item bg-gray-100 pd-y-10" href="#">
                        General Settings
                    </a>
                    <div class="card-body">
                        <div class="form-group mg-b-10">
                            <label class="custom-switch ps-0">
                                <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input" checked>
                                <span class="custom-switch-indicator"></span>
                                <span class="custom-switch-description mg-l-10">Show User Online</span>
                            </label>
                        </div>
                        <div class="form-group mg-b-10">
                            <label class="custom-switch ps-0">
                                <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input">
                                <span class="custom-switch-indicator"></span>
                                <span class="custom-switch-description mg-l-10">Website Notication</span>
                            </label>
                        </div>
                        <div class="form-group mg-b-10">
                            <label class="custom-switch ps-0">
                                <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input">
                                <span class="custom-switch-indicator"></span>
                                <span class="custom-switch-description mg-l-10">Show Recent activity</span>
                            </label>
                        </div>
                        <div class="form-group mg-b-10">
                            <label class="custom-switch ps-0">
                                <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input">
                                <span class="custom-switch-indicator"></span>
                                <span class="custom-switch-description mg-l-10">Logout Automatically</span>
                            </label>
                        </div>
                        <div class="form-group mg-b-10">
                            <label class="custom-switch ps-0">
                                <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input" checked>
                                <span class="custom-switch-indicator"></span>
                                <span class="custom-switch-description mg-l-10">Aloow All Notifications</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>