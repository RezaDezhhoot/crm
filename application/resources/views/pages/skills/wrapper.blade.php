@extends('layout.wrapper') @section('content')
<!-- main content -->
<div class="container-fluid">

    <!--page heading-->
    <div class="row page-titles">

        <!-- Page Title & Bread Crumbs -->
        @include('misc.heading-crumbs')
        <!--Page Title & Bread Crumbs -->


        <!-- action buttons -->
        @include('pages.departments.components.misc.list-page-actions')
        <!-- action buttons -->

    </div>
    <!--page heading-->

    <!-- page content -->
    <div class="row kanban-wrapper">
        <div class="col-12" id="departments-table-wrapper">
            @include('pages.departments.components.table.wrapper')
        </div>
    </div>
    <!--page content -->

</div>


<!--dynamic load lead lead (dynamic_trigger_dom)-->
<a href="javascript:void(0)" id="dynamic-lead-content"
    class="show-modal-button reset-card-modal-form js-ajax-ux-request js-ajax-ux-request" data-toggle="modal"
    data-target="#cardModal" data-url="{{ url('/departments/') }}"
    data-loading-target="main-top-nav-bar"></a>

@endsection