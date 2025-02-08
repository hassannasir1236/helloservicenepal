@extends('layouts.app')

@section('content')
    <div class="page-wrapper">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor orderTitle page-title ">{{trans('lang.rides')}}</h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">{{trans('lang.dashboard')}}</a></li>
                    <li class="breadcrumb-item active">{{trans('lang.rides')}}</li>
                </ol>
            </div>
            <div>
            </div>
        </div>

        <div class="container-fluid">
            <div id="data-table_processing" class="dataTables_processing panel panel-default"
                 style="display: none;">{{trans('lang.processing')}}
            </div>
            <div class="row">
                <div class="col-12">
                    <?php if ($id != '') { ?>
                    <div class="menu-tab vendorMenuTab">
                        <ul>
                            <li>
                                <a href="{{route('drivers.view',$id)}}">{{trans('lang.tab_basic')}}</a>
                            </li>
                            <li>
                                <a href="{{route('drivers.vehicle',$id)}}">{{trans('lang.vehicle')}}</a>
                            </li>
                            <li class="active">
                                <a href="{{route('drivers.ride',$id)}}">{{trans('lang.order_plural')}}</a>
                            </li>
                            <li>
                                <a href="{{route('driver.payouts',$id)}}">{{trans('lang.tab_payouts')}}</a>
                            </li>
                            <li>
                                <a href="{{route('payoutRequests.drivers.view',$id)}}" >{{trans('lang.tab_payout_request')}}</a>
                            </li>
                            <li>
                                <a href="{{route('users.walletstransaction',$id)}}"
                                           class="wallet_transaction">{{trans('lang.wallet_transaction')}}</a>
                             </li>

                        </ul>
                    </div>
                    <?php } ?>
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive m-t-10">
                                <table id="example24"
                                       class="display nowrap table table-hover table-striped table-bordered table table-striped"
                                       cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <?php if(in_array('rides.delete', json_decode(@session('user_permissions')))){?>
                                        <th class="delete-all">
                                            <input type="checkbox" id="is_active">
                                            <label class="col-3 control-label" for="is_active">
                                                <a id="deleteAll" class="do_not_delete" href="javascript:void(0)"><i
                                                            class="fa fa-trash"></i> {{trans('lang.all')}}</a>
                                            </label>
                                        </th>
                                        <?php }?>

                                        <th>{{trans('lang.order_id')}}</th>
                                        <th>{{trans('lang.order_user_id')}}</th>
                                        <?php if ($id == '') { ?>
                                        <th class="driverClass">{{trans('lang.driver_plural')}}</th>
                                        <?php } ?>
                                        <th>{{trans('lang.ridetype')}}</th>
                                        <th>{{trans('lang.address')}}</th>
                                        <th>{{trans('lang.amount')}}</th>
                                        <th>{{trans('lang.date')}}</th>
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

        @endsection

        @section('scripts')

            <script type="text/javascript">

                var database = firebase.firestore();
                var id = '<?php echo $id; ?>';
                var sosId = '<?php echo @$sosId; ?>';
                var offest = 1;
                var pagesize = 10;
                var end = null;
                var endarray = [];
                var start = null;
                var user_number = [];
                var data = '';
                var user_permissions = '<?php echo @session('user_permissions') ?>';
                user_permissions = JSON.parse(user_permissions);
                var checkDeletePermission = false;
                if ($.inArray('rides.delete', user_permissions) >= 0) {
                    checkDeletePermission = true;
                }
                if (id != '') {
                    getDriverInfo(id);
                    var wallet_route = "{{route('users.walletstransaction','id')}}";
                    $(".wallet_transaction").attr("href", wallet_route.replace('id', 'driverID='+id));
                    var ref = database.collection('rides').where('driverID', '==', id).orderBy('createdAt', 'desc');
                } else if (sosId != '') {
                    var ref = database.collection('rides').where('id', '==', sosId).orderBy('createdAt', 'desc');

                } else {
                    var ref = database.collection('rides').orderBy('createdAt', 'desc');

                }
                var alldriver = database.collection('users').where("id", "==", id).orderBy('createdAt', 'desc');
                var placeholderImage = '';
                var append_list = '';
                var refCurrency = database.collection('currencies').where('isActive', '==', true);
                refCurrency.get().then(async function (snapshots) {
                    var currencyData = snapshots.docs[0].data();
                    currentCurrency = currencyData.symbol;
                    currencyAtRight = currencyData.symbolAtRight;
                });
                $(document).ready(function () {

                    var placeholder = database.collection('settings').doc('placeHolderImage');
                    placeholder.get().then(async function (snapshotsimage) {
                        var placeholderImageData = snapshotsimage.data();
                        placeholderImage = placeholderImageData.image;
                    })

                    jQuery("#data-table_processing").show();
                    const table = $('#example24').DataTable({
                        pageLength: 10,
                        processing: false,
                        serverSide: true,
                        responsive: true,
                        ajax: async function (data, callback, settings) {
                            const start = data.start;
                            const length = data.length;
                            const searchValue = data.search.value.toLowerCase();
                            const orderColumnIndex = data.order[0].column;
                            const orderDirection = data.order[0].dir;

                            const orderableColumns = (checkDeletePermission) ? (id === '') ? ['','id','userName','driverName','rideType','destinationLocationName','total_price','createdAt','status',''] : ['','id','userName','rideType','destinationLocationName','total_price','createdAt','status',''] : (id === '') ? ['id','userName','driverName','rideType','address','total_price','createdAt','status',''] : ['id','userName','rideType','address','total_price','createdAt','status',''];

                            const orderByField = orderableColumns[orderColumnIndex];

                            if (searchValue.length >= 3 || searchValue.length === 0) {
                                $('#data-table_processing').show();
                            }

                            try {
                                const querySnapshot = await ref.get();
                                if (querySnapshot.empty) {
                                    $('#data-table_processing').hide();
                                    callback({
                                        draw: data.draw,
                                        recordsTotal: 0,
                                        recordsFiltered: 0,
                                        data: []
                                    });
                                    return;
                                }

                                let records = [];
                                let filteredRecords = [];

                                await Promise.all(querySnapshot.docs.map(async (doc) => {
                                    let childData = doc.data();
                                    childData.id = doc.id;
                                    var total_price = parseFloat(childData.subTotal).toFixed(2);
                                    var discount = parseFloat(childData.discount).toFixed(2);
                                    total_price = total_price - discount;
                                    try {
                                        if (childData.tax) {
                                            if (childData.taxType && childData.tax) {
                                                if (childData.taxType == "percent") {
                                                    tax = (childData.tax * total_price) / 100;
                                                } else {
                                                    tax = childData.tax;
                                                }
                                                tax = parseFloat(tax).toFixed(2);
                                                if (!isNaN(tax) && tax != 0) {
                                                    total_price = total_price + parseFloat(tax);
                                                }
                                            }
                                        }
                                    } catch (error) {
                                        console.log("Tax calculation error -->",error);
                                    }

                                    var tip_amount = parseFloat(childData.tip_amount).toFixed(2);
                                    if (!isNaN(tip_amount) && tip_amount != 0) {
                                        total_price = total_price + tip_amount;
                                    }
                                    if (currencyAtRight) {
                                        total_price = parseFloat(total_price).toFixed(2) + "" + currentCurrency;
                                    } else {
                                        total_price = currentCurrency + "" + parseFloat(total_price).toFixed(2);
                                    }
                                    childData.total_price = total_price ? total_price : 0.00;
                                    var userName = childData.author ? childData.author.firstName : '';
                                    childData.userName = userName ? userName : '';
                                    var driverName = childData.driver ? childData.driver.firstName : '';
                                    childData.driverName = driverName ? driverName : '';
                                    if (searchValue) {
                                        var date = '';
                                        var time = '';
                                        if (childData.hasOwnProperty("createdAt") && childData.createdAt != '') {
                                            try {
                                                date = childData.createdAt.toDate().toDateString();
                                                time = childData.createdAt.toDate().toLocaleTimeString('en-US');
                                            } catch (err) {

                                            }
                                        }
                                        var createdAt = date + ' ' + time ;
                                        if (
                                            (childData.id && childData.id.toLowerCase().includes(searchValue)) ||
                                            (childData.rideType && childData.rideType.toLowerCase().includes(searchValue)) ||
                                            (childData.status && childData.status.toLowerCase().includes(searchValue)) ||
                                            (childData.total_price && childData.total_price.toLowerCase().includes(searchValue)) ||
                                            (childData.destinationLocationName && childData.destinationLocationName.toLowerCase().includes(searchValue)) ||
                                            (userName && userName.toLowerCase().includes(searchValue)) ||
                                            (driverName && driverName.toLowerCase().includes(searchValue)) ||
                                            (createdAt && createdAt.toString().toLowerCase().indexOf(searchValue) > -1)
                                        ) {
                                            filteredRecords.push(childData);
                                        }
                                    } else {
                                        filteredRecords.push(childData);
                                    }
                                }));

                                filteredRecords.sort((a, b) => {
                                    let aValue = a[orderByField] ? a[orderByField].toString().toLowerCase().trim() : '';
                                    let bValue = b[orderByField] ? b[orderByField].toString().toLowerCase().trim() : '';
                                    if (orderByField === 'createdAt' && a[orderByField] != '' && b[orderByField] != '') {
                                        try {
                                            aValue = a[orderByField] ? new Date(a[orderByField].toDate()).getTime() : 0;
                                            bValue = b[orderByField] ? new Date(b[orderByField].toDate()).getTime() : 0;
                                        } catch (err) {
                                        }
                                    }
                                    if (orderByField === 'total_price') {
                                        aValue = a[orderByField] ? parseFloat(a[orderByField].replace(/[^0-9.-]+/g, '')) : 0;
                                        bValue = b[orderByField] ? parseFloat(b[orderByField].replace(/[^0-9.-]+/g, '')) : 0;
                                    }
                                    if (orderDirection === 'asc') {
                                        return (aValue > bValue) ? 1 : -1;
                                    } else {
                                        return (aValue < bValue) ? 1 : -1;
                                    }
                                });

                                const totalRecords = filteredRecords.length;
                                const paginatedRecords = filteredRecords.slice(start, start + length);

                                const formattedRecords = await Promise.all(paginatedRecords.map(async (childData) => {
                                    return await buildHTML(childData);
                                }));

                                $('#data-table_processing').hide();
                                callback({
                                    draw: data.draw,
                                    recordsTotal: totalRecords,
                                    recordsFiltered: totalRecords,
                                    data: formattedRecords
                                });

                            } catch (error) {
                                console.error("Error fetching data from Firestore:", error);
                                $('#data-table_processing').hide();
                                callback({
                                    draw: data.draw,
                                    recordsTotal: 0,
                                    recordsFiltered: 0,
                                    data: []
                                });
                            }
                        },
                        order: (checkDeletePermission) ? (id === '') ? [[7, "desc"]] : [[6, "desc"]] : (id === '') ? [[6, "desc"]] : [[5, "desc"]],
                        columnDefs: [
                            {
                                targets: (checkDeletePermission) ? (id === '') ? [7] : [6] : (id === '') ? [6] : [5],
                                type: 'date',
                                render: function(data) {
                                    return data;
                                }
                            },
                            {orderable: false, targets: (checkDeletePermission) ? (id === '') ? [0,8,9] : [0,8] : (id === '') ? [7,8] : [7]},
                        ],
                        "language": {
                            "zeroRecords": "{{trans('lang.no_record_found')}}",
                            "emptyTable": "{{trans('lang.no_record_found')}}",
                            "processing": "" // Remove default loader
                        },
                    });
                    function debounce(func, wait) {
                        let timeout;
                        const context = this;
                        return function (...args) {
                            clearTimeout(timeout);
                            timeout = setTimeout(() => func.apply(context, args), wait);
                        };
                    }
                    $('#search-input').on('input', debounce(function () {
                        const searchValue = $(this).val();
                        if (searchValue.length >= 3) {
                            $('#data-table_processing').show();
                            table.search(searchValue).draw();
                        } else if (searchValue.length === 0) {
                            $('#data-table_processing').show();
                            table.search('').draw();
                        }
                    }, 300));

                    alldriver.get().then(async function (snapshotsdriver) {

                        snapshotsdriver.docs.forEach((listval) => {
                            database.collection('rides').where('driverID', '==', listval.id).where("status", "in", ["Order Completed"]).get().then(async function (orderSnapshots) {
                                var count_order_complete = orderSnapshots.docs.length;
                                database.collection('users').doc(listval.id).update({'orderCompleted': count_order_complete}).then(function (result) {

                                });

                            });

                        });
                    });

                });

                async function buildHTML(val) {
                    var html = [];

                    newdate = '';
                    var id = val.id;
                    var user_id = val.author.id;
                    var route1 = '{{route("rides.edit",":id")}}';
                    route1 = route1.replace(':id', id);
                    var customer_view = '{{route("users.view",":id")}}';
                    customer_view = customer_view.replace(':id', user_id);

                    <?php if(in_array('rides.delete', json_decode(@session('user_permissions')))){?>
                        html.push('<td class="delete-all"><input type="checkbox" id="is_open_' + id + '" class="is_open" dataId="' + id + '"><label class="col-3 control-label"\n' +
                            'for="is_open_' + id + '" ></label></td>');
                    <?php }?>
                    html.push('<td data-url="' + route1 + '" class="redirecttopage">' + val.id + '</td>');
                    html.push('<td data-url="' + customer_view + '" class="redirecttopage">' + val.userName + '</td>');
                    if ('<?php echo $id; ?>' == "") {
                        if (val.hasOwnProperty("driver")) {
                            var driverId = val.driver.id;
                            var diverRoute = '{{route("drivers.view",":id")}}';
                            diverRoute = diverRoute.replace(':id', driverId);
                            html.push('<td data-url="' + diverRoute + '" class="redirecttopage">' + val.driverName + '</td>');
                        } else {
                            html.push('<td></td>');
                        }
                    }
                    if (val.hasOwnProperty('rideType')) {
                        html.push('<td>' + val.rideType + '</td>');
                    } else {
                        html.push('<td></td>');
                    }
                    html.push('<td>' + val.destinationLocationName + '</td>');

                    html.push('<td>' + val.total_price + '</td>');
                    var date = '';
                    var time = '';
                    if (val.hasOwnProperty("createdAt")) {
                        try {
                            date = val.createdAt.toDate().toDateString();
                            time = val.createdAt.toDate().toLocaleTimeString('en-US');
                        } catch (err) {

                        }
                        html.push('<td class="dt-time">' + date + ' ' + time + '</td>');
                    } else {
                        html.push('<td></td>');
                    }

                    if (val.status == 'Order Completed') {
                        html.push('<td><span class="badge badge-success">Order Completed</span></td>');
                    } else if (val.status == 'Order Rejected') {
                        html.push('<td><span class="badge badge-danger">Order Rejected</span></td>');
                    } else {
                        html.push('<td><span class="badge badge-danger">Pending</span></td>');
                    }
                    var action = '';
                    action = action + '<span class="action-btn"><a href="' + route1 + '"><i class="fa fa-edit"></i></a>';
                    <?php if(in_array('rides.delete', json_decode(@session('user_permissions')))){?>

                    action = action + '<a id="' + val.id + '" name="driver-delete" class="delete-btn" href="javascript:void(0)"><i class="fa fa-trash"></i></a>';
                    <?php }?>
                    action = action + '</span>';

                    html.push(action);
                    return html;
                }

                $(document.body).on('click', '.redirecttopage', function () {
                    var url = $(this).attr('data-url');
                    window.location.href = url;
                });
                $(document.body).on('change', '#selected_search', function () {
                    jQuery('#ride_type').hide();
                    if (jQuery(this).val() == 'rideType') {
                        jQuery('#ride_type').show();
                        jQuery('#search').hide();

                    } else {

                        jQuery('#ride_type').hide();
                        jQuery('#search').show();

                    }
                });

                $(document).on("click", "a[name='driver-delete']", function (e) {
                    var id = this.id;
                    database.collection('rides').doc(id).delete().then(function () {
                        window.location.reload();
                    });


                });


                $("#is_active").click(function () {
                    $("#example24 .is_open").prop('checked', $(this).prop('checked'));

                });

                $("#deleteAll").click(function () {
                    if ($('#example24 .is_open:checked').length) {
                        if (confirm("{{trans('lang.selected_delete_alert')}}")) {
                            jQuery("#data-table_processing").show();
                            $('#example24 .is_open:checked').each(function () {
                                var dataId = $(this).attr('dataId');
                                database.collection('rides').doc(dataId).delete().then(function () {
                                    setTimeout(function () {
                                        window.location.reload();
                                    }, 5000);
                                });
                            });
                        }
                    } else {
                        alert("{{trans('lang.select_delete_alert')}}");
                    }
                });

async function getDriverInfo(driverId){
   
            await database.collection('users').where("id", "==", driverId).get().then(async function (snapshotss) {

            if (snapshotss.docs[0]) {
                var driver_data = snapshotss.docs[0].data();
                driverName = driver_data.firstName + " " + driver_data.lastName;
                $('.page-title').html("{{trans('lang.rides')}}  - "+driverName);
            }
        });

}

</script>

@endsection