@extends('layouts.app')

@section('content')

<div class="page-wrapper">

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">{{trans('lang.deleted_document_plural')}}</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">{{trans('lang.dashboard')}}</a></li>
                <li class="breadcrumb-item active">{{trans('lang.document_table')}}</li>
            </ol>
        </div>
        <div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-body">
                        <div id="data-table_processing" class="dataTables_processing panel panel-default"
                            style="display: none;">{{trans('lang.processing')}}</div>

                        <div class="table-responsive m-t-10">
                            <table id="taxTable"
                                class="display nowrap table table-hover table-striped table-bordered table table-striped"
                                cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>{{trans('lang.document_title')}}</th>
                                        <th>{{trans('lang.reinstate')}}</th>
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
        var database = firebase.firestore();
        var offest = 1;
        var pagesize = 10;
        var end = null;
        var endarray = [];
        var start = null;
        var user_number = [];
        var ref = database.collection('documents').where('isDeleted', '==', true);
        var alldriver = database.collection('driver_users');
        var append_list = '';
        var deleteMsg = "{{trans('lang.delete_alert')}}";
        var deleteSelectedRecordMsg = "{{trans('lang.selected_delete_alert')}}";
        var setLanguageCode=getCookie('setLanguage');
        var defaultLanguageCode=getCookie('defaultLanguage');

        $(document).ready(function () {
            $(document.body).on('click', '.redirecttopage', function () {
                var url = $(this).attr('data-url');
                window.location.href = url;
            });
            var inx = parseInt(offest) * parseInt(pagesize);
            jQuery("#overlay").show();
            append_list = document.getElementById('append_list1');
            append_list.innerHTML = '';
            ref.get().then(async function (snapshots) {
                console.log(snapshots.docs.length);
                html = '';
                if (snapshots.docs.length > 0) {
                    html = await buildHTML(snapshots);
                }
                if (html != '') {
                    append_list.innerHTML = html;
                    start = snapshots.docs[snapshots.docs.length - 1];
                    endarray.push(snapshots.docs[0]);
                    if (snapshots.docs.length < pagesize) {
                        jQuery("#data-table_paginate").hide();
                    }
                }
                setTimeout(function () {
                    $('#taxTable').DataTable({
                        columnDefs: [{ orderable: false, targets: [1] }],
                        order: [[0, 'asc']],
                        "language": {
                            "zeroRecords": "{{trans("lang.no_record_found")}}",
                            "emptyTable": "{{trans("lang.no_record_found")}}"
                        }
                    });
                });
                jQuery("#overlay").hide();
            });
        });

        async function buildHTML(snapshots) {
            var html = '';
            await Promise.all(snapshots.docs.map(async (listval) => {
                var val = listval.data();
                var getData = await getListData(val);
                html += getData;
            }));
            return html;
        }

        async function getListData(val) {
            var html = '';
            html = html + '<tr>';
            var id = val.id;
            var route1 = '{{route("documents.save", ":id")}}';
            route1 = route1.replace(':id', id);
            var documentTitle='';
            if(Array.isArray(val.title)) {
                var foundItem=val.title.find(item => item.type===setLanguageCode);
                if(foundItem&&foundItem.title!='') {
                    documentTitle=foundItem.title;
                } else {
                    var foundItem=val.title.find(item => item.type===defaultLanguageCode);
                    if(foundItem&&foundItem.title!='') {
                        documentTitle=foundItem.title;
                    } else {
                        var foundItem=val.title.find(item => item.type==='en');
                        documentTitle=foundItem.title;
                    }
                }

            }
            html = html + '<td><a href="' + route1 + '">' + documentTitle + '</a></td>';
            html = html + '<td class="action-btn"><a id="' + val.id + '" class="doc-revert" name="revoke-data" href="javascript:void(0)"><i class="fa fa-undo"></i></a></td>';
            html = html + '</tr>';
            return html;
        }

        $("#is_active").click(function () {
            $("#taxTable .is_open").prop('checked', $(this).prop('checked'));
        });

        function prev() {

            if (endarray.length == 1) {
                return false;
            }
            end = endarray[endarray.length - 2];

            if (end != undefined || end != null) {

                if (jQuery("#selected_search").val() === 'title' && jQuery("#search").val() !== '') {
                    listener = ref.orderBy('title').startAt(jQuery("#search").val()).endAt(jQuery("#search").val() + '\uf8ff').limit(pagesize).startAt(end).get();

                } else {
                    listener = ref.orderBy('id', 'desc').startAt(end).limit(pagesize).get();
                }

                listener.then((snapshots) => {
                    html = '';
                    html = buildHTML(snapshots);

                    if (html != '') {
                        append_list.innerHTML = html;
                        start = snapshots.docs[snapshots.docs.length - 1];
                        endarray.splice(endarray.indexOf(endarray[endarray.length - 1]), 1);
                    } else {
                        html += '<tr><td colspan="2" class="text-center font-weight-bold">{{trans("lang.no_record_found")}}</td></tr>';
                        append_list.innerHTML = html;

                    }
                });
            }
        }

        function next() {

            if (start != undefined || start != null) {

                if (jQuery("#selected_search").val() == 'title' && jQuery("#search").val() != '') {

                    listener = ref.orderBy('title').limit(pagesize).startAt(jQuery("#search").val()).endAt(jQuery("#search").val() + '\uf8ff').startAfter(start).get();

                } else {
                    listener = ref.orderBy('id', 'desc').startAfter(start).limit(pagesize).get();
                }
                listener.then((snapshots) => {

                    html = '';
                    html = buildHTML(snapshots);

                    if (html != '') {
                        append_list.innerHTML = html;
                        start = snapshots.docs[snapshots.docs.length - 1];


                        if (endarray.indexOf(snapshots.docs[0]) != -1) {
                            endarray.splice(endarray.indexOf(snapshots.docs[0]), 1);
                        }
                        endarray.push(snapshots.docs[0]);
                    } else {
                        html += '<tr><td colspan="2" class="text-center font-weight-bold">{{trans("lang.no_record_found")}}</td></tr>';
                        append_list.innerHTML = html;

                    }
                });
            }
        }

        function searchclear() {
            jQuery("#search").val('');
            jQuery('#selected_search').val("title").trigger('change');
            searchtext();
        }

        $('#search').keypress(function (e) {
            if (e.which == 13) {
                $('.search_button').click();
            }
        });

        function searchtext() {

            append_list.innerHTML = '';

            if (jQuery("#selected_search").val() === 'title' && jQuery("#search").val() !== '') {

                wherequery = ref.orderBy('title').limit(pagesize).startAt(jQuery("#search").val()).endAt(jQuery("#search").val() + '\uf8ff').get();

            } else {

                wherequery = ref.orderBy('id', 'desc').limit(pagesize).get();
            }

            wherequery.then((snapshots) => {

                html = '';
                html = buildHTML(snapshots);

                if (html != '') {
                    append_list.innerHTML = html;
                    start = snapshots.docs[snapshots.docs.length - 1];
                    endarray.push(snapshots.docs[0]);
                    console.log(endarray);

                    if (snapshots.docs.length < pagesize) {

                        jQuery("#data-table_paginate").hide();
                    } else {

                        jQuery("#data-table_paginate").show();
                    }
                } else {
                    html += '<tr><td colspan="2" class="text-center font-weight-bold">{{trans("lang.no_record_found")}}</td></tr>';
                    append_list.innerHTML = html;

                }
            });
        }

        $(document).on("click", "a[name='revoke-data']", function (e) {
            var id = $(this).attr('id');
            jQuery("#overlay").show();
            database.collection('documents').doc(id).update({
                'isDeleted': false,
            }).then(function (result) {
                window.location.href = '{{ url()->current() }}';
            });
        });
    </script>

    @endsection