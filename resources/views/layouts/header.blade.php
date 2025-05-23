<div class="header-holder header-holder-desktop sticky-header" id="sticky-header-desktop">
    <div class="header-container container-fluid">
        <div class="header-wrap header-wrap-block">

        </div>
        <div class="header-wrap">
            <!-- BEGIN Dropdown -->
            <div class="dropdown">
                <button class="btn btn-label-primary btn-icon" data-toggle="dropdown">
                    <i class="far fa-bell"></i>
                    <div class="btn-marker">
                        <i class="marker marker-dot text-success"></i>
                    </div>
                </button>
                <div
                    class="dropdown-menu dropdown-menu-right dropdown-menu-wide dropdown-menu-animated overflow-hidden py-0">
                    <!-- BEGIN Portlet -->
                    @include('layouts.notification')
                    <!-- END Portlet -->
                </div>
            </div>
            <!-- END Dropdown -->

            <!-- BEGIN Dropdown -->
            <div class="dropdown ml-2">
                <button class="btn btn-flat-primary widget13" data-toggle="dropdown">
                    <div class="widget13-text"> Hi <strong>{{ Auth::guard('admin')->user()->username }}</strong>
                    </div>
                    <!-- BEGIN Avatar -->
                    <div class="avatar avatar-info widget13-avatar">
                        <div class="avatar-display">
                            <i class="fa fa-user-alt"></i>
                        </div>
                    </div>
                    <!-- END Avatar -->
                </button>
                <div
                    class="dropdown-menu dropdown-menu-wide dropdown-menu-right dropdown-menu-animated overflow-hidden py-0">
                    <!-- BEGIN Portlet -->
                    <div class="portlet border-0">
                        <div class="portlet-header bg-primary rounded-0">
                            <!-- BEGIN Rich List Item -->
                            <div class="rich-list-item w-100 p-0">
                                <div class="rich-list-prepend">
                                    <!-- BEGIN Avatar -->
                                    <div class="avatar avatar-circle">
                                        <div class="avatar-display">
                                            @if (Auth::guard('admin')->user()->image)
                                                <img src="{{ asset('storage/' . $admin->image) }}" alt="Avatar image"
                                                    style="width:40px; height:40px; object-fit:cover; border-radius:50%;">
                                            @else
                                                <i class="fa fa-user-alt"></i>
                                            @endif
                                        </div>
                                    </div>
                                    <!-- END Avatar -->
                                </div>
                                <div class="rich-list-content">
                                    <h3 class="rich-list-title text-white">{{ Auth::guard('admin')->user()->username }}</h3>
                                    <span
                                        class="rich-list-subtitle text-white">{{ Auth::guard('admin')->user()->level }}</span>
                                </div>
                            </div>
                            <!-- END Rich List Item -->
                        </div>
                        <div class="portlet-footer portlet-footer-bordered rounded-0">
                            <form action="{{ route('logout-admin') }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-label-danger">Sign out</button>
                            </form>
                        </div>
                    </div>
                    <!-- END Portlet -->
                </div>
            </div>
            <!-- END Dropdown -->
        </div>
    </div>
</div>
