@extends('layouts.app')

@section('content')

<div class="page-wrapper">

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">{{trans('lang.deleted_driver_rule_plural')}}</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">{{trans('lang.dashboard')}}</a></li>
                <li class="breadcrumb-item active">{{trans('lang.driver_rule_table')}}</li>
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
                            style="display: none;">{{trans('lang.processing')}}
                        </div>
                        <div class="table-responsive m-t-10">
                            <table id="taxTable"
                                class="display nowrap table table-hover table-striped table-bordered table table-striped"
                                cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>{{trans('lang.name')}}</th>
                                        <th>{{trans('lang.image')}}</th>
                                        <th>{{trans('lang.reinstate')}}</th>
                                        <th>{{trans('lang.permanent_delete')}}</th>
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
</div>

@endsection

@section('scripts')


<script type="text/javascript">
    var database=firebase.firestore();
    var offest=1;
    var pagesize=10;
    var end=null;
    var endarray=[];
    var start=null;
    var user_number=[];
    var setLanguageCode=getCookie('setLanguage');
    var defaultLanguageCode=getCookie('defaultLanguage');

    var ref=database.collection('driver_rules').where('isDeleted','==',true);

    var append_list='';

    var deleteMsg="{{trans('lang.delete_alert')}}";
    var deleteSelectedRecordMsg="{{trans('lang.selected_delete_alert')}}";

    $(document).ready(function() {
        $(document.body).on('click','.redirecttopage',function() {
            var url=$(this).attr('data-url');
            window.location.href=url;
        });
        var inx=parseInt(offest)*parseInt(pagesize);
        jQuery("#overlay").show();
        append_list=document.getElementById('append_list1');
        append_list.innerHTML='';
        ref.get().then(async function(snapshots) {
            html='';
            if(snapshots.docs.length>0) {
                html=await buildHTML(snapshots);
            }
            if(html!='') {
                append_list.innerHTML=html;
                start=snapshots.docs[snapshots.docs.length-1];
                endarray.push(snapshots.docs[0]);
                if(snapshots.docs.length<pagesize) {
                    jQuery("#data-table_paginate").hide();
                }
            }
            $('#taxTable').DataTable({
                order: [[0,'asc']],
                columnDefs: [
                    {orderable: false,targets: [1,2,3]},
                ],
                "language": {
                    "zeroRecords": "{{trans("lang.no_record_found")}}",
                    "emptyTable": "{{trans("lang.no_record_found")}}"
                },
                responsive: true
            });
            jQuery("#overlay").hide();
        });
    });

    async function buildHTML(snapshots) {
        var html='';
        await Promise.all(snapshots.docs.map(async (listval) => {
            var val=listval.data();
            var getData=await getListData(val);
            html+=getData;
        }));
        return html;
    }

    async function getListData(val) {
        var html='';
        html=html+'<tr>';
        newdate='';
        var id=val.id;
        var name='';
        if(Array.isArray(val.name)) {
            var foundItem=val.name.find(item => item.type===setLanguageCode);
            if(foundItem&&foundItem.name!='') {
                name=foundItem.name;
            } else {
                var foundItem=val.name.find(item => item.type===defaultLanguageCode);
                if(foundItem&&foundItem.name!='') {
                    name=foundItem.name;
                } else {
                    var foundItem=val.name.find(item => item.type==='en');
                    name=foundItem.name;

                }
            }

        }

        html=html+'<td>'+name+'</td>';
        if(val.image=='') {
            html=html+'<td><img class="rounded" style="width:50px" src="'+defaultImg+'" alt="image"></td>';
        } else {
            html=html+'<td><img class="rounded" style="width:50px" src="'+val.image+'" alt="image"></td>';
        }
        html=html+'<td class="action-btn"><a id="'+val.id+'"    name="revoke-data" href="javascript:void(0)"><i class="fa fa-undo"></i></span></td>';
        html=html+'<td class="action-btn"><a id="'+val.id+'" class="permanent-delete" name="permanent-delete" href="javascript:void(0)"><i class="fa fa-trash"></i></a></td>';
        html=html+'</tr>';
        return html;
    }

    $("#is_active").click(function() {
        $("#taxTable .is_open").prop('checked',$(this).prop('checked'));
    });

    function prev() {
        jQuery("#overlay").show();

        if(endarray.length==1) {
            jQuery("#overlay").hide();

            return false;
        }
        end=endarray[endarray.length-2];

        if(end!=undefined||end!=null) {
            if(jQuery("#selected_search").val()=='name'&&jQuery("#search").val().trim()!='') {
                listener=ref.orderBy('name').startAt(end).limit(pagesize).startAt(jQuery("#search").val()).endAt(jQuery("#search").val()+'\uf8ff').get();
            } else {
                listener=ref.startAt(end).limit(pagesize).get();
            }
            listener.then((snapshots) => {
                html='';
                html=buildHTML(snapshots);
                jQuery("#overlay").hide();

                if(html!='') {
                    append_list.innerHTML=html;
                    start=snapshots.docs[snapshots.docs.length-1];
                    endarray.splice(endarray.indexOf(endarray[endarray.length-1]),1);
                } else {
                    append_list.innerHTML='<tr><td colspan="3" class="text-center font-weight-bold">{{trans("lang.no_record_found")}}</td></tr>';

                }
            });
        } else {
            jQuery("#overlay").hide();

        }
    }

    function next() {
        jQuery("#overlay").show();

        if(start!=undefined||start!=null) {
            if(jQuery("#selected_search").val()=='name'&&jQuery("#search").val().trim()!='') {
                listener=ref.orderBy('name').startAfter(start).limit(pagesize).startAt(jQuery("#search").val()).endAt(jQuery("#search").val()+'\uf8ff').get();
            } else {
                listener=ref.startAfter(start).limit(pagesize).get();
            }
            listener.then((snapshots) => {

                html='';
                html=buildHTML(snapshots);
                jQuery("#overlay").hide();

                if(html!='') {
                    append_list.innerHTML=html;
                    start=snapshots.docs[snapshots.docs.length-1];


                    if(endarray.indexOf(snapshots.docs[0])!=-1) {
                        endarray.splice(endarray.indexOf(snapshots.docs[0]),1);
                    }
                    endarray.push(snapshots.docs[0]);
                } else {
                    append_list.innerHTML='<tr><td colspan="3" class="text-center font-weight-bold">{{trans("lang.no_record_found")}}</td></tr>';

                }
            });
        } else {
            jQuery("#overlay").hide();

        }
    }

    function searchclear() {
        jQuery("#search").val('');
        searchtext();
    }

    $('#search').keypress(function(e) {
        if(e.which==13) {
            $('.search_button').click();
        }
    });

    function searchtext() {

        jQuery("#overlay").show();

        append_list.innerHTML='';
        if(jQuery("#selected_search").val()=='name'&&jQuery("#search").val().trim()!='') {
            wherequery=ref.orderBy('name').limit(pagesize).startAt(jQuery("#search").val()).endAt(jQuery("#search").val()+'\uf8ff').get();
        } else {
            wherequery=ref.limit(pagesize).get();
        }
        wherequery.then((snapshots) => {
            html='';

            jQuery("#overlay").hide();

            html=buildHTML(snapshots);
            if(html!='') {
                append_list.innerHTML=html;
                start=snapshots.docs[snapshots.docs.length-1];
                endarray.push(snapshots.docs[0]);
                if(snapshots.docs.length<pagesize) {
                    jQuery("#data-table_paginate").hide();
                } else {
                    jQuery("#data-table_paginate").show();
                }
            } else {
                append_list.innerHTML='<tr><td colspan="3" class="text-center font-weight-bold">{{trans("lang.no_record_found")}}</td></tr>';

            }
        });
    }

    $(document).on("click","a[name='revoke-data']",function(e) {
        var id=$(this).attr('id');
        jQuery("#overlay").show();
        database.collection('driver_rules').doc(id).update({
            'isDeleted': false,
        }).then(function(result) {
            window.location.href='{{ url()->current() }}';
        });
    });

    $(document).on("click","a[name='permanent-delete']",function(e) {
        var id=$(this).attr('id');
        jQuery("#overlay").show();
        database.collection('driver_rules').doc(id).delete().then(function(result) {
            window.location.href='{{ url()->current() }}';
        });
    });

</script>

@endsection