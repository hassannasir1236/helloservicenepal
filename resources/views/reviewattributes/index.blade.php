@extends('layouts.app')

@section('content')

<div class="page-wrapper">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">{{trans('lang.reviewattribute_plural')}}</h3>
        </div>

        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">{{trans('lang.dashboard')}}</a></li>
                <li class="breadcrumb-item active">{{trans('lang.reviewattribute_plural')}}</li>
            </ol>
        </div>

        <div>

        </div>

    </div>
    <div class="container-fluid">
        <div id="data-table_processing" class="dataTables_processing panel panel-default" style="display: none;">{{trans('lang.processing')}}</div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <ul class="nav nav-tabs align-items-end card-header-tabs w-100">
                            <li class="nav-item">
                                <a class="nav-link active" href="{!! url()->current() !!}"><i
                                        class="fa fa-list mr-2"></i>{{trans('lang.reviewattribute_table')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{!! route('reviewattributes.create') !!}"><i
                                        class="fa fa-plus mr-2"></i>{{trans('lang.reviewattribute_create')}}</a>
                            </li>
                        </ul>
                    </div>

                    <div class="card-body">

                        
                    <div class="table-responsive m-t-10">

                        <table id="example24"
                            class="display nowrap table table-hover table-striped table-bordered table table-striped"
                            cellspacing="0" width="100%">

                            <thead>

                                <tr>

                                    <th>{{trans('lang.reviewattribute_name')}}</th>

                                    <th>{{trans('lang.actions')}}</th>

                                </tr>

                            </thead>

                            <tbody id="append_list1">


                            </tbody>

                        </table>
                    </div>
                </div>
            </div>




        </div>
    </div>
</div>

@endsection

@section('scripts')

<script type="text/javascript">
    var user_permissions = '<?php echo @session('user_permissions') ?>';

    user_permissions = JSON.parse(user_permissions);

    var checkDeletePermission = false;

    if ($.inArray('review.attributes.delete', user_permissions) >= 0) {
        checkDeletePermission = true;
    }
    var database = firebase.firestore();
    var offest = 1;
    var pagesize = 10;
    var end = null;
    var endarray = [];
    var start = null;
    var user_number = [];

    var ref = database.collection('review_attributes');
    var append_list = '';

    $(document).ready(function () {

        var inx = parseInt(offest) * parseInt(pagesize);
        jQuery("#data-table_processing").show();

        append_list = document.getElementById('append_list1');
        append_list.innerHTML = '';
        ref.get().then(async function (snapshots) {
            html = '';

            html = buildHTML(snapshots);
            jQuery("#data-table_processing").hide();
            if (html != '') {
                append_list.innerHTML = html;
                start = snapshots.docs[snapshots.docs.length - 1];
                endarray.push(snapshots.docs[0]);
                if (snapshots.docs.length < pagesize) {
                    jQuery("#data-table_paginate").hide();
                }
            }
            $('#example24').DataTable({
                
                order: [],
                columnDefs: [
                    {orderable: false, targets: [1]},
                ],
                order: [0,"asc"],
                "language": {
                    "zeroRecords": "{{trans("lang.no_record_found")}}",
                    "emptyTable": "{{trans("lang.no_record_found")}}"
                },
                responsive: true,
            });
        });

    });

    function buildHTML(snapshots) {
        var html = '';
        var alldata = [];
        var number = [];
        snapshots.docs.forEach((listval) => {
            var datas = listval.data();
            alldata.push(datas);
        });

        var count = 0;
        alldata.forEach((listval) => {

            var val = listval;

            html = html + '<tr>';
            newdate = '';

            var id = val.id;
            var route1 = '{{route("reviewattributes.edit",":id")}}';
            route1 = route1.replace(':id', id);

            html = html + '<td>' + val.title + '</td>';
            html = html + '<td class="action-btn"><a href="' + route1 + '"><i class="fa fa-edit"></i></a>';
            if(checkDeletePermission){
                html=html+'<a id="' + val.id + '" name="reviewattribute-delete" class="delete-btn" href="javascript:void(0)"><i class="fa fa-trash"></i></a>';
            }
            html=html+'</td>';


            html = html + '</tr>';
            count = count + 1;
        });
        return html;
    }

   
    $(document).on("click", "a[name='reviewattribute-delete']", function (e) {
        var id = this.id;
        database.collection('review_attributes').doc(id).delete().then(function (result) {
            window.location.href = '{{ route("reviewattributes")}}';
        });
    });

</script>

@endsection