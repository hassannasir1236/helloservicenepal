@extends('layouts.app')

@section('content')

<div class="page-wrapper">

    <div class="row page-titles">

        <div class="col-md-5 align-self-center">

            <h3 class="text-themecolor page-title">{{trans('lang.drivers_payout_plural')}}</h3>

        </div>

        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">{{trans('lang.dashboard')}}</a></li>
                <li class="breadcrumb-item active">{{trans('lang.drivers_payout_plural')}}</li>
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
                            <li class="service_type_orders">

                            </li>
                            <li class="active">
                                <a href="{{route('driver.payouts',$id)}}">{{trans('lang.tab_payouts')}}</a>
                            </li>
                            <li>
                                <a href="{{route('payoutRequests.drivers.view',$id)}}" class="vendor_payout">{{trans('lang.tab_payout_request')}}</a>
                            </li>
                            <li>
                                <a href="{{route('users.walletstransaction',$id)}}"
                                           class="wallet_transaction">{{trans('lang.wallet_transaction')}}</a>
                             </li>
                        </ul>
                    </div>
                    <?php } ?>
                <div class="card">
                    <div class="card-header">
                        <ul class="nav nav-tabs align-items-end card-header-tabs w-100">
                            <li class="nav-item">
                                <a class="nav-link active" href="{!! url()->current() !!}"><i
                                            class="fa fa-list mr-2"></i>{{trans('lang.drivers_payout_table')}}</a>
                            </li>
                            @if($id=='')
                            <li class="nav-item">
                                <a class="nav-link" href="{!! route('driversPayouts.create') !!}"><i
                                            class="fa fa-plus mr-2"></i>{{trans('lang.drivers_payout_create')}}</a>
                            </li>
                            @else
                             <li class="nav-item">
                                <a class="nav-link" href="{{ url('driversPayouts/create/'.$id) }}"><i
                                            class="fa fa-plus mr-2"></i>{{trans('lang.drivers_payout_create')}}</a>
                            </li>
                            @endif

                        </ul>
                    </div>
                    <div class="card-body">

                    <div class="table-responsive m-t-10">


                        <table id="example24"
                               class="display nowrap table table-hover table-striped table-bordered table table-striped"
                               cellspacing="0" width="100%">

                            <thead>

                            <tr>
                                <th>{{ trans('lang.driver')}}</th>
                                <th>{{trans('lang.paid_amount')}}</th>

                                <th>{{trans('lang.drivers_payout_paid_date')}}</th>
                                <th>{{trans('lang.drivers_payout_note')}}</th>
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
    var id="{{$id}}";
    var refData = database.collection('driver_payouts').where('paymentStatus', '==', 'Success');
    if(id!=''){
        var wallet_route = "{{route('users.walletstransaction','id')}}";
        $(".wallet_transaction").attr("href", wallet_route.replace('id', 'driverID='+id));
        refData=refData.where('driverID','==',id);
    }
    var ref = refData.orderBy('paidDate', 'desc');
    var append_list = '';

    var currentCurrency = '';
    var currencyAtRight = false;
    var decimal_degits = 0;
    var refCurrency = database.collection('currencies').where('isActive', '==', true);
    refCurrency.get().then(async function (snapshots) {
        var currencyData = snapshots.docs[0].data();
        currentCurrency = currencyData.symbol;
        currencyAtRight = currencyData.symbolAtRight;

        if (currencyData.decimal_degits) {
            decimal_degits = currencyData.decimal_degits;
        }
    });

    $(document).ready(function () {
        if(id!=''){
            payoutDriverfunction(id);
        }
        
        $(document.body).on('click', '.redirecttopage', function () {
            var url = $(this).attr('data-url');
            window.location.href = url;
        });

        jQuery("#data-table_processing").show();

         const table = $('#example24').DataTable({
            pageLength: 10, // Number of rows per page
            processing: false, // Show processing indicator
            serverSide: true, // Enable server-side processing
            responsive: true,
            ajax: async function (data, callback, settings) {
                const start = data.start;
                const length = data.length;
                const searchValue = data.search.value.toLowerCase();
                const orderColumnIndex = data.order[0].column;
                const orderDirection = data.order[0].dir;
                var orderableColumns = ['title','amount','paidDate','note']; // Ensure this matches the actual column names
                const orderByField = orderableColumns[orderColumnIndex]; // Adjust the index to match your table
                if (searchValue.length >= 3 || searchValue.length === 0) {
                    $('#data-table_processing').show();
                }

            await ref.get().then(async function (querySnapshot) {
                if (querySnapshot.empty) {
                    console.error("No data found in Firestore.");
                    $('#data-table_processing').hide(); // Hide loader
                    callback({
                        draw: data.draw,
                        recordsTotal: 0,
                        recordsFiltered: 0,
                        data: [] // No data
                    });
                    return;
                }
           
            let records = [];
            let filteredRecords = [];

            await Promise.all(querySnapshot.docs.map(async (doc) => {
                let childData = doc.data();
                childData.id = doc.driverID; // Ensure the document ID is included in the data
                var payoutDriver = '';
                if(childData.driverID != undefined){
                    payoutDriver = await payoutDriverfunction(childData.driverID);
                }
                if (!payoutDriver) {
                    return;
                }
                childData.title = payoutDriver;
                if (searchValue) {
                    var date = '';
                    var time = '';
                    if (childData.hasOwnProperty("paidDate")) {
                        try {
                            date = childData.paidDate.toDate().toDateString();
                            time = childData.paidDate.toDate().toLocaleTimeString('en-US');
                        } catch (err) {
                        }
                    }
                    var createdAt = date + ' ' + time;
                    if (
                        (childData.title && childData.title.toString().toLowerCase().includes(searchValue)) ||
                        (childData.amount && childData.amount.toString().toLowerCase().includes(searchValue)) ||
                        (createdAt && createdAt.toString().toLowerCase().includes(searchValue)) ||
                        (childData.note && childData.note.toString().toLowerCase().includes(searchValue)) 
                    ) {
                        filteredRecords.push(childData);
                    }
                } else {
                    filteredRecords.push(childData);
                }
            }));
  
            filteredRecords.sort((a, b) => {
                let aValue = a[orderByField];
                let bValue = b[orderByField];

                if (orderByField === 'createdAt') {
                    try {
                        aValue = a[orderByField] ? new Date(a[orderByField].toDate()).getTime() : 0;
                        bValue = b[orderByField] ? new Date(b[orderByField].toDate()).getTime() : 0;
                    } catch (err) {

                    }
                }
            
                if (orderByField === 'amount') {
                   
                    aValue = a[orderByField] ? parseInt(a[orderByField]) : 0;
                    bValue = b[orderByField] ? parseInt(b[orderByField]) : 0;
                }

                if (orderByField === 'title') {
                    aValue = a[orderByField] ? a[orderByField].toString().toLowerCase() : '';
                    bValue = b[orderByField] ? b[orderByField].toString().toLowerCase() : '';
                }

                if (orderDirection === 'asc') {
                    return (aValue > bValue) ? 1 : -1;
                } else {
                    return (aValue < bValue) ? 1 : -1;
                }

            });

            const totalRecords = filteredRecords.length;

            const paginatedRecords = filteredRecords.slice(start, start + length);

            await Promise.all(paginatedRecords.map(async (childData) => {
                if(childData.hasOwnProperty('title') || childData.title != null || childData.title!=''){
                    var getData = await buildHTML(childData);
                    records.push(getData);                  
                }
  
            }));


            $('#data-table_processing').hide(); // Hide loader
            callback({
                draw: data.draw,
                recordsTotal: totalRecords, // Total number of records in Firestore
                recordsFiltered: totalRecords, // Number of records after filtering (if any)
                data: records // The actual data to display in the table
            });
        }).catch(function (error) {
            console.error("Error fetching data from Firestore:", error);
            $('#data-table_processing').hide(); // Hide loader
            callback({
                draw: data.draw,
                recordsTotal: 0,
                recordsFiltered: 0,
                data: [] // No data due to error
            });
        });
    },
      columnDefs: [{
            targets: 2,
            type: 'date',
            render: function (data) {
                return data;
            }
        }
           
        ],
        order: [0, "desc"],
        "language": {
            "zeroRecords": "{{trans("lang.no_record_found")}}",
            "emptyTable": "{{trans("lang.no_record_found")}}",
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

    });


    async function buildHTML(val) {
        var html = [];
        if (val.title) {

            var routedriver = '{{route("drivers.view",":id")}}';
            routedriver = routedriver.replace(':id', val.driverID);

            html.push('<td><a href="' + routedriver + '">' + val.title + '</a></td>');

            if (currencyAtRight) {
                html.push('<td>' + parseFloat(val.amount).toFixed(decimal_degits) + '' + currentCurrency + '</td>');
            } else {
                html.push('<td>' + currentCurrency + '' + parseFloat(val.amount).toFixed(decimal_degits) + '</td>');
            }
            var date = val.paidDate.toDate().toDateString();
            var time = val.paidDate.toDate().toLocaleTimeString('en-US');
            html.push('<td>' + date + ' ' + time + '</td>');
            html.push('<td>' + val.note + '</td>');
        }
        return html;
    }

    async function payoutDriverfunction(driver) {
    
        var payoutDriver = '';

        await database.collection('users').where("id", "==", driver).get().then(async function (snapshotss) {

            if (snapshotss.docs[0]) {
                var driver_data = snapshotss.docs[0].data();
                payoutDriver = driver_data.firstName + " " + driver_data.lastName;
                $('.page-title').html("{{trans('lang.drivers_payout_plural')}}"+" - "+payoutDriver)
                if (driver_data.serviceType == "cab-service") {

                        var url = "{{route('drivers.rides','driverId')}}";
                        url = url.replace('driverId', driver_data.id);
                        $('.service_type_orders').html('<a href="' + url + '">{{trans('lang.order_plural')}}</a>');

                    } else if (driver_data.serviceType == "rental-service") {
                        var url = "{{route('rental_orders.driver','id')}}";
                        url = url.replace("id", driver_data.id);
                        $('.service_type_orders').html('<a href="' + url + '">{{trans('lang.order_plural')}}</a>');

                    } else if (driver_data.serviceType == "delivery-service" || driver_data.serviceType == "ecommerce-service") {
                        var url = "{{route('orders','id')}}";
                        url = url.replace("id", 'driverId=' + driver_data.id);
                        $('.service_type_orders').html('<a href="' + url + '">{{trans('lang.order_plural')}}</a>');

                    } else if (driver_data.serviceType == "parcel_delivery") {
                        var url = "{{route('parcel_orders.driver','id')}}";
                        url = url.replace("id", driver_data.id);
                        $('.service_type_orders').html('<a href="' + url + '">{{trans('lang.order_plural')}}</a>');

                    }
            }
        });
        return payoutDriver;
    }

</script>

@endsection