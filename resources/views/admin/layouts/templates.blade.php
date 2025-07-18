@include('admin.layouts.header')

    <!-- Page Wrapper -->
    <div id="wrapper">
        @include('admin.layouts.sidebar')
       
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                @include('admin.layouts.topbar')

                <!-- Begin Page Content -->
                @yield('content')
                
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->
@include('admin.layouts.footer')
          