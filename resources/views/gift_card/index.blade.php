@extends('layouts.app')

@section('content')

<div class="page-wrapper">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor restaurantTitle">{{trans('lang.gift_card_plural')}}</h3>
        </div>

        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">{{trans('lang.dashboard')}}</a></li>
                <li class="breadcrumb-item active">{{trans('lang.gift_card_plural')}}</li>
            </ol>

        </div>

        <div>

        </div>

    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <ul class="nav nav-tabs align-items-end card-header-tabs w-100">
                            <li class="nav-item">
                                <a class="nav-link active" href="{!! url()->current() !!}"><i
                                        class="fa fa-list mr-2"></i>{{trans('lang.gift_card_table')}}</a>
                            </li>
                            <li class="nav-item">
                                    <a class="nav-link" href="{!! route('gift-card.save') !!}"><i
                                            class="fa fa-plus mr-2"></i>{{trans('lang.create_gift_card')}}</a>
                            </li>

                        </ul>
                    </div>
                    <div class="card-body">

                        <div id="data-table_processing" class="dataTables_processing panel panel-default"
                            style="display: none;">Processing...
                        </div>

                        <div class="table-responsive m-t-10">

                            <table id="giftCardTable"
                                class="display nowrap table table-hover table-striped table-bordered table table-striped"
                                cellspacing="0" width="100%">

                                <thead>

                                    <tr>
                                    <?php if (in_array('gift-card.delete', json_decode(@session('user_permissions')))) { ?>
                      
                                        <th class="delete-all"><input type="checkbox" id="is_active"><label
                                                class="col-3 control-label" for="is_active">
                                                <a id="deleteAll" class="do_not_delete" href="javascript:void(0)"><i
                                                        class="fa fa-trash"></i> {{trans('lang.all')}}</a></label></th>
                                         <?php }?>               
                                        <th>{{trans('lang.image')}}</th>
                                        <th>{{trans('lang.title')}}</th>
                                        <th>{{trans('lang.expires_in')}}</th>
                                        <th>{{trans('lang.status')}}</th>
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
</div>

@endsection

@section('scripts')

<script type="text/javascript">
    var user_permissions = '<?php echo @session('user_permissions') ?>';

    user_permissions = JSON.parse(user_permissions);

    var checkDeletePermission = false;

    if ($.inArray('gift-card.delete', user_permissions) >= 0) {
        checkDeletePermission = true;
    }
    var database = firebase.firestore();
    var offest = 1;
    var pagesize = 10;
    var ref = database.collection('gift_cards');
    var append_list = '';
    var placeholderImage = '';
    var placeholder = database.collection('settings').doc('placeHolderImage');
    placeholder.get().then(async function (snapshotsimage) {
        var placeholderImageData = snapshotsimage.data();
        placeholderImage = placeholderImageData.image;
    })


    $(document).ready(function () {
        $(document.body).on('click', '.redirecttopage', function () {
            var url = $(this).attr('data-url');
            window.location.href = url;
        });

        jQuery("#data-table_processing").show();

        append_list = document.getElementById('append_list1');
        append_list.innerHTML = '';
        ref.get().then(async function (snapshots) {
            var html = '';

            html = await buildHTML(snapshots);

            if (html != '') {
                append_list.innerHTML = html;
            }

            $('#giftCardTable').DataTable({
                    order: [],
                    columnDefs: [
                        { orderable: false, targets: (checkDeletePermission==true) ? [0, 1, 4,5] : [0,3,4] },

                    ],
                    "language": {
                        "zeroRecords": "{{trans("lang.no_record_found")}}",
                        "emptyTable": "{{trans("lang.no_record_found")}}"
                    },
                    responsive: true
                });


            jQuery("#data-table_processing").hide();
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
        newdate = '';

        var id = val.id;
        var route1 = '{{route("gift-card.edit",":id")}}';
        route1 = route1.replace(':id', id);
        if(checkDeletePermission){
        html = html + '<td class="delete-all"><input type="checkbox" id="is_open_' + id + '" class="is_open" dataId="' + id + '"><label class="col-3 control-label"\n' +
            'for="is_open_' + id + '" ></label></td>';
        }
        if (val.image != '') {
            html = html + '<td><img class="rounded" style="width:50px" src="' + val.image + '" alt="image" onerror="this.onerror=null;this.src=\'' + placeholderImage + '\'"></td>';
        } else {
            html = html + '<td><img class="rounded" style="width:50px" src="' + placeholderImage + '" alt="image"></td>';
        }
        html = html + '<td data-url="' + route1 + '" class="redirecttopage">' + val.title + '</td>';
        html = html + '<td>'+val.expiryDay+' Days</td>';
        if (val.isEnable) {
            html = html + '<td><label class="switch"><input type="checkbox" checked id="' + val.id + '" name="isActive"><span class="slider round"></span></label></td>';
        } else {
            html = html + '<td><label class="switch"><input type="checkbox" id="' + val.id + '" name="isActive"><span class="slider round"></span></label></td>';
        }
        html = html + '<td class="action-btn"><a href="' + route1 + '" class="link-td"><i class="fa fa-edit"></i></a>';
        if(checkDeletePermission){
        html=html+'<a id="' + val.id + '" name="giftcard-delete" href="javascript:void(0)" class="delete-btn"><i class="fa fa-trash"></i></a>';
        }
        html=html+'</td>';

        html = html + '</tr>';

        return html;
    }

    $(document).on("click", "input[name='isActive']", function (e) {
        var ischeck = $(this).is(':checked');
        var id = this.id;
        if (ischeck) {
            database.collection('gift_cards').doc(id).update({ 'isEnable': true }).then(function (result) {

            });
        } else {
            database.collection('gift_cards').doc(id).update({ 'isEnable': false }).then(function (result) {

            });
        }

    });

    $(document).on("click", "a[name='giftcard-delete']", async function (e) {
        var id = this.id;

        await deleteDocumentWithImage('gift_cards',id,'image');
        window.location.href = '{{ url()->current() }}';
    });


    $("#is_active").click(function () {
        $("#giftCardTable .is_open").prop('checked', $(this).prop('checked'));
    });

    $("#deleteAll").click(function () {
        if ($('#giftCardTable .is_open:checked').length) {

            if (confirm("{{trans('lang.selected_delete_alert')}}")) {
                jQuery("#data-table_processing").show();
                $('#giftCardTable .is_open:checked').each(async function () {
                    var dataId = $(this).attr('dataId');
                    await deleteDocumentWithImage('gift_cards',dataId,'image');

                    database.collection('gift_cards').doc(dataId).delete().then(function () {
                        setTimeout(function () {
                            window.location.reload();
                        }, 2000);

                    });
                });
            }
        } else {
            alert("{{trans('lang.select_delete_alert')}}");
        }
    });

</script>


@endsection