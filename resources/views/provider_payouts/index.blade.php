@extends('layouts.app')

@section('content')

<div class="page-wrapper">


    <div class="row page-titles">

        <div class="col-md-5 align-self-center">

            <h3 class="text-themecolor">{{trans('lang.provider_payout_plural')}} <span class="providerTitle"></span></h3>

        </div>

        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">{{trans('lang.dashboard')}}</a></li>
                <li class="breadcrumb-item active">{{trans('lang.provider_payout_plural')}}</li>
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
                @if($id!='')
                    <div class="resttab-sec">

                        <div class="menu-tab tabDiv">
                            <ul>
                                <li ><a href="{{route('providers.view', $id)}}">{{trans('lang.tab_basic')}}</a>
                                </li>
                                <li><a href="{{route('ondemand.services.index', $id)}}">{{trans('lang.services')}}</a></li>
                                <li>
                                <li><a href="{{route('ondemand.workers.index', $id)}}">{{trans('lang.workers')}}</a></li>
                                <li>
                                <li><a href="{{route('ondemand.bookings.index',$id)}}">{{trans('lang.booking_plural')}}</a></li>
                                <li>
                                <li><a href="{{route('ondemand.coupons', $id)}}">{{trans('lang.coupon_plural')}}</a></li>
                                 <li class="active">
                                    <a href="{{route('providerPayouts.payout', $id)}}">{{trans('lang.tab_payouts')}}</a>
                                </li>
                                <li>
                                    <a href="{{route('payoutRequests.providers', $id)}}">{{trans('lang.tab_payout_request')}}</a>
                                </li>
                                 <li>
                                    <a href="{{route('users.walletstransaction',$id)}}"
                                           class="wallet_transaction">{{trans('lang.wallet_transaction')}}</a>
                                </li>
                            </ul>
                        </div>

                    </div>
                    @endif

                <div class="card">
                    <div class="card-header">
                        <ul class="nav nav-tabs align-items-end card-header-tabs w-100">
                            <li class="nav-item">
                                <a class="nav-link active" href="{!! url()->current() !!}"><i
                                            class="fa fa-list mr-2"></i>{{trans('lang.provider_payout_table')}}</a>
                            </li>

                            <?php if ($id != '') { ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="{!! route('providerPayouts.create') !!}/{{$id}}"><i
                                                class="fa fa-plus mr-2"></i>{{trans('lang.provider_payout_create')}}</a>
                                </li>
                            <?php } else { ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="{!! route('providerPayouts.create') !!}"><i
                                                class="fa fa-plus mr-2"></i>{{trans('lang.provider_payout_create')}}</a>
                                </li>
                            <?php } ?>


                        </ul>
                    </div>
                    <div class="card-body">

                    <div class="table-responsive m-t-10">


                        <table id="example24"
                               class="display nowrap table table-hover table-striped table-bordered table table-striped"
                               cellspacing="0" width="100%">

                            <thead>

                            <tr>
                                <?php if ($id == '') { ?>
                                    <th>{{ trans('lang.provider')}}</th>
                                <?php } ?>
                                <th>{{trans('lang.paid_amount')}}</th>
                                <th>{{trans('lang.date')}}</th>
                                <th>{{trans('lang.vendors_payout_note')}}</th>
                                <th>Admin {{trans('lang.vendors_payout_note')}}</th>
                            </tr>

                            </thead>

                            <tbody id="append_list1">


                            </tbody>

                        </table>
                        <div id="data-table_paginate">
                        </div>
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
    var id = '<?php echo $id; ?>';

    var intRegex = /^\d+$/;
    var floatRegex = /^((\d+(\.\d *)?)|((\d*\.)?\d+))$/;

    <?php if ($id != '') { ?>
        var wallet_route = "{{route('users.walletstransaction','id')}}";
        $(".wallet_transaction").attr("href", wallet_route.replace('id', 'providerID='+id));

    var ref = database.collection('payouts').where('vendorID', '==', '<?php echo $id; ?>').where('paymentStatus', '==', 'Success').where('role','==','provider').orderBy('paidDate', 'desc');
    getProviderName('<?php echo $id; ?>');
    <?php } else { ?>
    var ref = database.collection('payouts').where('paymentStatus', '==', 'Success').where('role','==','provider').orderBy('paidDate', 'desc');
    <?php } ?>

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

    var append_list = '';

    $(document).ready(function () {

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
                var orderableColumns = ['title','amount','paidDate','note','adminNote']; // Ensure this matches the actual column names
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
                childData.id = doc.vendorID; // Ensure the document ID is included in the data
                const provider = await payoutProvider(childData.vendorID);
                if (!provider) {
                    return;
                }
                childData.title = provider;
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
                    var paidDate = date + ' ' + time;
                    if (
                        (childData.title && childData.title.toString().toLowerCase().includes(searchValue)) ||
                        (childData.amount && childData.amount.toString().toLowerCase().includes(searchValue)) ||
                        (paidDate && paidDate.toString().toLowerCase().includes(searchValue)) ||
                        (childData.note && childData.note.toString().toLowerCase().includes(searchValue)) ||
                        (childData.adminNote && childData.adminNote.toString().toLowerCase().includes(searchValue)) 
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

                    if (orderByField === 'paidDate' && a[orderByField] != '' && b[orderByField] != '' && a[orderByField] != null && b[orderByField] != null) {
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
    <?php if($id == '') { ?>
       columnDefs: [{
            targets: 1,
            type: 'date',
            render: function (data) {
                return data;
            }
        },
            {orderable: false, targets: [3]},
        ],
        order: [1, "desc"],
    <?php } else { ?>
       columnDefs: [{
            targets: 2,
            type: 'date',
            render: function (data) {
                return data;
            }
        },
            {orderable: false, targets: [3]},
        ],
        order: [2, "desc"],
    <?php } ?>
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


    function getProviderName(providerId) {
        var providerName = '';
        database.collection('users').where('id', '==', providerId).get().then(function (snapshots) {
            var providerData = snapshots.docs[0].data();
            providerName = providerData.firstName+' '+providerData.lastName;
            $(".providerTitle").text(' - ' + providerName);
           
        });
        return providerName;
    }

    async function buildHTML(val) {
        var html = [];

        if (val.title) {

            var amount = '';
            var price = val.amount;

            if (intRegex.test(price) || floatRegex.test(price)) {

                price = parseFloat(price).toFixed(decimal_degits);
            } else {
                price = 0;
            }

            if (currencyAtRight) {
                amount = parseFloat(price).toFixed(decimal_degits) + "" + currentCurrency;
            } else {
                amount = currentCurrency + "" + parseFloat(price).toFixed(decimal_degits);
            }
            <?php if ($id == '') { ?>
            var route = '{{route("providers.view",":id")}}';
            route = route.replace(':id', val.vendorID);
            html.push('<td><a href="' + route + '">' + val.title + '</a></td>');
            <?php } ?>
            html.push('<td>' + amount + '</td>');
            var date = val.paidDate.toDate().toDateString();
            var time = val.paidDate.toDate().toLocaleTimeString('en-US');
            html.push('<td>' + date + ' ' + time + '</td>');

            if (val.note != undefined && val.note != '') {
                html.push('<td>' + val.note + '</td>');
            } else {
                html.push('<td></td>');
            }
            if (val.adminNote != undefined && val.adminNote != '') {
                html.push('<td>' + val.adminNote + '</td>');
            } else {
                html.push('<td></td>');
            }
        }
        return html;
    }


    async function payoutProvider(provider) {
        var payoutProvider = '';

        await database.collection('users').where("id", "==", provider).get().then(async function (snapshotss) {
            if (snapshotss.docs[0]) {
                var provider_data = snapshotss.docs[0].data();
                payoutProvider = provider_data.firstName+' '+provider_data.lastName;

            }
        });
        return payoutProvider;
    }

</script>


@endsection