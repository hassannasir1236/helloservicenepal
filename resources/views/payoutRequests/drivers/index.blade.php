@extends('layouts.app')



@section('content')



<div class="page-wrapper">





    <div class="row page-titles">





        <div class="col-md-5 align-self-center">





            <h3 class="text-themecolor driverTitle">{{trans('lang.payout_request')}}</h3>





        </div>





        <div class="col-md-7 align-self-center">



            <ol class="breadcrumb">



                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">{{trans('lang.dashboard')}}</a></li>



                <li class="breadcrumb-item active">{{trans('lang.payout_request')}}</li>



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



                    @if($id !='' )

                    <div class="resttab-sec">

                        <div class="menu-tab">

                            <ul>

                                <li>

                                    <a href="{{route('drivers.view',$id)}}" class="basic">{{trans('lang.tab_basic')}}</a>

                                </li>

                                <li>

                                    <a href="{{route('drivers.vehicle',$id)}}" class="vehicle">{{trans('lang.vehicle')}}</a>

                                </li>

                                <li class="service_type_orders">

                                </li>

                                <li>

                                    <a href="{{route('driver.payouts',$id)}}" class="payout">{{trans('lang.tab_payouts')}}</a>

                                </li>

                                <li class="active">

                                    <a href="{{route('payoutRequests.drivers.view',$id)}}" class="vendor_payout">{{trans('lang.tab_payout_request')}}</a>

                                </li>

                                <li>

                                    <a href="{{route('users.walletstransaction',$id)}}" class="wallet_transaction">{{trans('lang.wallet_transaction')}}</a>

                                </li>

                            </ul>

                        </div>

                    </div>

                    @endif



                <div class="card">



                    <div class="card-header">



                        <ul class="nav nav-tabs align-items-end card-header-tabs w-100">



                            @if($id == '')

                            <li class="nav-item parcel-driver">

                                <a class="nav-link" href="{!! url('payoutRequests/vendor') !!}"><i

                                            class="fa fa-list mr-2"></i>{{trans('lang.vendors_payout_request')}}</a>

                            </li>

                            @endif



                            <li class="nav-item">

                                <a class="nav-link active" href="{!! url('payoutRequests/drivers') !!}"><i

                                            class="fa fa-list mr-2"></i>{{trans('lang.drivers_payout_request')}}</a>

                            </li>



                            @if($id == '')

                            <li class="nav-item">

                                <a class="nav-link" href="{!! url('payoutRequests/providers') !!}"><i

                                            class="fa fa-list mr-2"></i>{{trans('lang.providers_payout_request')}}</a>

                            </li>

                            @endif





                        </ul>



                    </div>



                    <div class="card-body">



                        <div class="error_top" style="display:none"></div>



                        <div class="success_top" style="display:none"></div>



                        <div id="data-table_processing" class="dataTables_processing panel panel-default"



                             style="display: none;">{{trans('lang.processing')}}



                        </div>



                    <div class="table-responsive m-t-10">





                        <table id="example24"



                               class="display nowrap table table-hover table-striped table-bordered table table-striped"



                               cellspacing="0" width="100%">





                            <thead>





                            <tr>



                                @if($id == '')

                                <th>{{ trans('lang.driver')}}</th>

                                @endif



                                <th>{{trans('lang.paid_amount')}}</th>



                                <th>{{trans('lang.drivers_payout_note')}}</th>



                                <th>{{trans('lang.drivers_payout_paid_date')}}</th>



                                <th>{{trans('lang.status')}}</th>



                                <th>{{trans('lang.withdraw_method')}}</th>



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





<div class="modal fade" id="bankdetailsModal" tabindex="-1" role="dialog"

     aria-hidden="true">



    <div class="modal-dialog modal-dialog-centered location_modal">



        <div class="modal-content">



            <div class="modal-header">



                <h5 class="modal-title locationModalTitle">{{trans('lang.bankdetails')}}</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                    <span aria-hidden="true">&times;</span>

                </button>



            </div>



            <div class="modal-body">



                <form class="">



                    <div class="form-row">



                        <input type="hidden" name="driverId" id="driverId">



                        <div class="form-group row">



                            <div class="form-group row width-100">

                                <label class="col-12 control-label">{{

                                    trans('lang.bank_name')}}</label>

                                <div class="col-12">

                                    <input type="text" name="bank_name" class="form-control" id="bankName">

                                </div>

                            </div>



                            <div class="form-group row width-100">

                                <label class="col-12 control-label">{{

                                    trans('lang.branch_name')}}</label>

                                <div class="col-12">

                                    <input type="text" name="branch_name" class="form-control" id="branchName">

                                </div>

                            </div>





                            <div class="form-group row width-100">

                                <label class="col-4 control-label">{{

                                    trans('lang.holer_name')}}</label>

                                <div class="col-12">

                                    <input type="text" name="holer_name" class="form-control" id="holderName">

                                </div>

                            </div>



                            <div class="form-group row width-100">

                                <label class="col-12 control-label">{{

                                    trans('lang.account_number')}}</label>

                                <div class="col-12">

                                    <input type="text" name="account_number" class="form-control" id="accountNumber">

                                </div>

                            </div>



                            <div class="form-group row width-100">

                                <label class="col-12 control-label">{{

                                    trans('lang.other_information')}}</label>

                                <div class="col-12">

                                    <input type="text" name="other_information" class="form-control" id="otherDetails">

                                </div>

                            </div>



                        </div>



                    </div>



                </form>



                <div class="modal-footer">

                    <button type="button" class="btn btn-primary save-form-btn" id="submit_accept">

                        {{trans('lang.accept')}}</a>

                    </button>

                    <button type="button" class="btn btn-primary" data-dismiss="modal" aria-label="Close">

                        {{trans('close')}}</a>

                    </button>



                </div>

            </div>

        </div>



    </div>



</div>



<div class="modal fade" id="cancelRequestModal" tabindex="-1" role="dialog" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title locationModalTitle">{{trans('lang.cancel_payout_request')}}</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                    <span aria-hidden="true">&times;</span>

                </button>

            </div>

            <div class="modal-body">

                <div id="data-table_processing_modal" class="dataTables_processing panel panel-default"

                        style="display: none;">{{trans('lang.processing')}}

                </div>

                <form class="">

                    <div class="form-row">

                        <div class="form-group row">

                            <div class="form-group row width-100">

                                <label class="col-12 control-label">{{trans('lang.notes')}}</label>

                                <div class="col-12">

                                    <textarea name="admin_note" class="form-control" id="admin_note" cols="5" rows="5"></textarea>

                                </div>

                            </div>

                        </div>

                    </div>

                </form>

                <div class="modal-footer">

                    <button type="button" class="btn btn-primary save-form-btn" id="submit_cancel">

                        {{trans('lang.submit')}}</a>

                    </button>

                    <button type="button" class="btn btn-primary" data-dismiss="modal" aria-label="Close">

                        {{trans('lang.close')}}</a>

                    </button>

                </div>

            </div>

        </div>

    </div>

</div>



<div class="modal fade" id="payoutResponseModal" tabindex="-1" role="dialog" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">{{trans('lang.payout_response')}}</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                    <span aria-hidden="true">&times;</span>

                </button>

            </div>

            <div class="modal-body">

                <div class="payout-response"></div>

            </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-primary" data-dismiss="modal" aria-label="Close">

                    {{trans('lang.close')}}</a>

                </button>

            </div>

        </div>

    </div>

</div>



@endsection





@section('scripts')



<script type="text/javascript">



    var id = '<?php echo $id; ?>';

    var database = firebase.firestore();

    var offest = 1;

    var pagesize = 10;

    var end = null;



    var endarray = [];

    var intRegex = /^\d+$/;

    var floatRegex = /^((\d+(\.\d *)?)|((\d*\.)?\d+))$/;

    var start = null;

    var user_number = [];



    if (id != "") {
        var wallet_route = "{{route('users.walletstransaction','id')}}";

        $(".wallet_transaction").attr("href", wallet_route.replace('id', 'driverID='+id));

        var refData = database.collection('driver_payouts').where('driverID', '==', id);

        database.collection('users').where("id", "==", id).get().then(async function (snapshotss) {

            if (snapshotss.docs[0]) {

                var driver_data = snapshotss.docs[0].data();

                if (driver_data.serviceType != "parcel_delivery") {

                    $('.parcel-driver').removeClass('d-none');

                } else {

                    $('.parcel-driver').html('');

                }

            }

        });

        getDriverName(id);

    } else {

        var refData = database.collection('driver_payouts').where('paymentStatus', '==', 'Pending');

    }



    var ref = refData.orderBy('paidDate', 'desc');



    var append_list = '';



    var email_templates = database.collection('email_templates').where('type', '==', 'payout_request_status');



    var emailTemplatesData = null;



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



        email_templates.get().then(async function (snapshots) {

            emailTemplatesData = snapshots.docs[0].data();



        });



        $(document.body).on('click', '.redirecttopage', function () {



            var url = $(this).attr('data-url');



            window.location.href = url;



        });





        // var inx = parseInt(offest) * parseInt(pagesize);



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

                @if($id == '')

                    const orderableColumns =  ['title', 'amount', 'note', 'paidDate', 'paymentStatus','withdrawMethod','']; // Ensure this matches the actual column names

                @else

                    const orderableColumns =  ['', 'amount', 'note', 'paidDate', 'paymentStatus','withdrawMethod',''];

                @endif

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

                var driver = '';

                if(childData.hasOwnProperty('driverID')){

                    driver = await payoutDriverfunction(childData.driverID);

                }

                if (!driver) {

                    return;

                }

                childData.title = driver;

                var date = '';

                var time = '';

                if (childData.hasOwnProperty("paidDate") && childData.paidDate != '') {

                    try {

                        date = childData.paidDate.toDate().toDateString();

                        time = childData.paidDate.toDate().toLocaleTimeString('en-US');

                    } catch (err) {

                    }

                }



                var paidDate = date + ' ' + time;





                if (searchValue) {



                    if (

                        (childData.title && childData.title.toString().toLowerCase().includes(searchValue)) ||

                        (childData.amount && childData.amount.toString().toLowerCase().includes(searchValue)) ||

                        (paidDate && paidDate.toString().toLowerCase().indexOf(searchValue) > -1) ||

                        (childData.note && childData.note.toString().toLowerCase().includes(searchValue)) ||

                        (

                            (childData.paymentStatus && childData.paymentStatus.toString().toLowerCase().includes(searchValue)) || (childData.withdrawMethod && childData.withdrawMethod.toString().toLowerCase().includes(searchValue))

                        )

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



                 if (orderByField === 'paidDate' && a[orderByField] != '' && b[orderByField] != '') {

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

    columnDefs: [

        {orderable: false, targets: [4, 5]},

    ],

    order: [3, "desc"],

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



    async function getDriverName(driverId) {

        var snapshots = await database.collection('users').doc(driverId).get();

        if(snapshots.exists){

            var driverData = snapshots.data();

            var driverName = driverData.firstName+' '+driverData.lastName;

            $('.driverTitle').html('{{trans("lang.payout_request")}} - ' + driverName);



            if (driverData.serviceType) {

                if (driverData.serviceType == "cab-service") {

                    var url = "{{route('drivers.rides','driverId')}}";

                    url = url.replace('driverId', driverData.id);

                    $('.service_type_orders').html('<a href="' + url + '">{{trans('lang.order_plural')}}</a>');

                } else if (driverData.serviceType == "rental-service") {

                    var url = "{{route('rental_orders.driver','id')}}";

                    url = url.replace("id", driverData.id);

                    $('.service_type_orders').html('<a href="' + url + '">{{trans('lang.order_plural')}}</a>');

                } else if (driverData.serviceType == "delivery-service" || driverData.serviceType == "ecommerce-service") {

                    var url = "{{route('orders','id')}}";

                    url = url.replace("id", 'driverId=' + driverData.id);

                    $('.service_type_orders').html('<a href="' + url + '">{{trans('lang.order_plural')}}</a>');

                } else if (driverData.serviceType == "parcel_delivery") {

                    var url = "{{route('parcel_orders.driver','id')}}";

                    url = url.replace("id", driverData.id);

                    $('.service_type_orders').html('<a href="' + url + '">{{trans('lang.order_plural')}}</a>');

                }

            }

        }

    }



    function buildHTML(val) {



        var html = [];

        var alldata = [];

        var number = [];



        var amount = '';

        var price = val.amount;



        if (intRegex.test(price) || floatRegex.test(price)) {



            price = parseFloat(price);

        } else {

            price = 0;

        }



        if (currencyAtRight) {

            amount = parseFloat(price).toFixed(decimal_degits) + "" + currentCurrency;

        } else {

            amount = currentCurrency + "" + parseFloat(price).toFixed(decimal_degits);

        }



        if (id == "") {

            var route_url = '{{route("drivers.view",":id")}}';

            route_url = route_url.replace(':id', val.driverID);

            html.push('<td><span data-url="' + route_url + '" class="driver_' + val.driverID + ' redirecttopage">'+val.title+'</span></td>');

        }



        html.push('<td>' + amount + '</td>');



        var date = val.paidDate.toDate().toDateString();



        var time = val.paidDate.toDate().toLocaleTimeString('en-US');



        html.push('<td>' + val.note + '</td>');



        html.push('<td>' + date + ' ' + time + '</td>');



        if (val.paymentStatus == 'Pending' || val.paymentStatus == 'In Process') {

            html.push('<td class="order_placed"><span>' + val.paymentStatus + '</span></td>');

        }else if (val.paymentStatus == 'Reject' || val.paymentStatus == 'Failed') {

            html.push('<td class="order_rejected"><span>' + val.paymentStatus + '</span></td>');

        }else if (val.paymentStatus == 'Success') {

            html.push('<td class="order_completed"><span>' + val.paymentStatus + '</span></td>');

        } else{

            html.push('');

        }



        if (val.withdrawMethod) {

            var selectedwithdrawMethod = (val.withdrawMethod == "bank") ? "Bank Transfer" : val.withdrawMethod;

            html.push('<td><span style="text-transform:capitalize">' + selectedwithdrawMethod + '</span></td>');

        } else {

            html.push('');

        }



        var actionHtml = '';

        actionHtml = actionHtml + '<td class="action-btn">';



        if (val.paymentStatus != "Reject" && val.paymentStatus != "Success") {

            actionHtml = actionHtml + '<a id="' + val.id + '" name="driver_view" data-auth="' + val.driverID + '" data-amount = "' + amount + '" href="javascript:void(0)" data-toggle="modal" data-target="#bankdetailsModal" class="btn btn-info mb-2">Manual Pay</a>';

        }



        if (val.withdrawMethod && val.withdrawMethod != "bank" && val.paymentStatus != "Reject" && val.paymentStatus != "Success") {

            actionHtml = actionHtml + '<br>';

            actionHtml = actionHtml + '<a id="' + val.id + '" name="driver_pay"  data-auth="' + val.driverID + '" data-amount="' + price + '" data-method="'+val.withdrawMethod+'" href="javascript:void(0)" class="btn btn-success mb-2 direct-click-btn">Pay Online</a>';

        }



        if (val.paymentStatus != "Reject" && val.paymentStatus != "Success") {

            actionHtml = actionHtml + '<br>';

            actionHtml = actionHtml + '<a id="' + val.id + '" name="driver_reject_request" data-toggle="modal" data-target="#cancelRequestModal" data-auth="' + val.driverID + '" data-amount = "' + amount + '" data-price="' + price + '" href="javascript:void(0)" class="btn btn-primary mb-2">Cancel Request</a>';

        }



        if (val.paymentStatus == "In Process") {

            actionHtml = actionHtml + '<br>';

            actionHtml = actionHtml + '<a id="' + val.id + '" name="driver_check_status" data-auth="' + val.driverID + '" data-amount="' + price + '" data-method="'+val.withdrawMethod+'" href="javascript:void(0)" class="btn btn-dark mb-2">Check Payment Status</a>';

        }



        actionHtml = actionHtml + '</td>';



        html.push(actionHtml);



        return html;



    }



    async function getDriverBankDetails() {

        var driverId = $('#driverId').val();

        await database.collection('users').where("id", "==", driverId).get().then(async function (snapshotss) {

            if (snapshotss.docs[0]) {

                var user_data = snapshotss.docs[0].data();

                if (user_data.userBankDetails) {

                    $('#bankName').val(user_data.userBankDetails.bankName);

                    $('#branchName').val(user_data.userBankDetails.branchName);

                    $('#holderName').val(user_data.userBankDetails.holderName);

                    $('#accountNumber').val(user_data.userBankDetails.accountNumber);

                    $('#otherDetails').val(user_data.userBankDetails.otherDetails);

                }

            }

        });

    }



    $(document).on("click", "a[name='driver_view']", function (e) {

        $('#bankName').val("");

        $('#branchName').val("");

        $('#holderName').val("");

        $('#accountNumber').val("");

        $('#otherDetails').val("");

        var id = this.id;

        var auth = $(this).attr('data-auth');

        var amount = $(this).attr('data-amount');

        $('#driverId').val(auth);

        getDriverBankDetails();

        $('#submit_accept').attr('data-id',id).attr('data-amount',amount).attr('data-auth',auth);

    });



    $(document).on("click", "a[name='driver_pay']", async function (e) {

        var $this = $(this);

        $(this).prop('disabled',true).css({'cursor':'default','opacity':'0.5'});

        var data = {};

        data['payoutId'] = this.id;

        data['method'] = $(this).data('method');

        data['amount'] = $(this).data('amount');

        data['user'] =  await getUserData($(this).data('auth'));

        data['settings'] = await getPaymentSettings();

        if(data['method'] != "undefined"){

            $.ajax({

                type: 'POST',

                data: {

                    data: btoa(JSON.stringify(data)),

                },

                url: "{{url('pay-to-user')}}",

                headers: {

                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                },

                success: function (response) {

                    if(response.success == true){

                        $(".success_top").show().html("");

                        $(".success_top").append("<p>"+response.message+"</p>");

                        window.scrollTo(0, 0);

                        database.collection('driver_payouts').doc(data['payoutId']).update({'paymentStatus': response.status,'payoutResponse' : response.result}).then(async function (result) {

                            if (data['user'] && data['user'] != undefined){

                                var emailData = await sendMailToRestaurant(data['user'], data['payoutId'], 'Approved', data['amount']);

                                if(emailData){

                                    window.location.reload();

                                }

                            }

                        });

                    }else{

                        $this.prop('disabled', false).css({'cursor': '', 'opacity': '1'});

                        $(".error_top").show().html("");

                        $(".error_top").append("<p>"+response.message+"</p>");

                        window.scrollTo(0, 0);

                    }

                }

            });

        }

    });



    $(document).on("click", "a[name='driver_check_status']", async function (e) {

        $(this).prop('disabled',true).css({'cursor':'default','opacity':'0.5'});

        var data = {};

        data['payoutId'] = this.id;

        data['method'] = $(this).data('method');

        data['amount'] = $(this).data('amount');

        data['user'] =  await getUserData($(this).data('auth'));

        data['settings'] = await getPaymentSettings();

        data['payoutDetail'] = await getPayoutDetail(data['payoutId']);

        if(data['method'] != "undefined"){

            $.ajax({

                type: 'POST',

                data: {

                    data: btoa(JSON.stringify(data)),

                },

                url: "{{url('check-payout-status')}}",

                headers: {

                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                },

                success: function (response) {

                    if(response.success == true){

                        $(".success_top").show().html("");

                        $(".success_top").append("<p>"+response.message+"</p>");

                        window.scrollTo(0, 0);

                    }else{

                        $(".error_top").show().html("");

                        $(".error_top").append("<p>"+response.message+"</p>");

                        window.scrollTo(0, 0);

                    }

                    $(this).prop('disabled',false).css({'cursor':'pointer','opacity':'1'});



                    if(response.result && response.status){

                        database.collection('driver_payouts').doc(data['payoutId']).update({'paymentStatus': response.status,'payoutResponse' : response.result});

                        $("#payoutResponseModal .payout-response").html(JSON.stringify(JSON.parse(JSON.stringify(response.result)),null,4));

                        $("#payoutResponseModal").modal('show');

                    }

                }

            });

        }

    });



    async function getPaymentSettings() {

        var settings = {};

        await database.collection('settings').get().then(async function (snapshots) {

            snapshots.forEach((doc) => {

                if(doc.id == "flutterWave"){

                    settings["flutterwave"] = doc.data();

                }

                if(doc.id == "paypalSettings"){

                    settings["paypal"] = doc.data();

                }

                if(doc.id == "razorpaySettings"){

                    settings["razorpay"] = doc.data();

                }

                if(doc.id == "stripeSettings"){

                    settings["stripe"] = doc.data();

                }

            });

        });

        return settings;

    }



    // $(document).on("click", "a[name='driver_pay']", async function (e) {

    //     $(this).prop('disabled',true).css({'cursor':'default','opacity':'0.5'});

    //     var data = {};

    //     data['payoutId'] = this.id;

    //     data['method'] = $(this).data('method');

    //     data['amount'] = $(this).data('amount');

    //     data['user'] =  await getUserData($(this).data('auth'));

    //     data['settings'] = await getPaymentSettings();

    //     if(data['method'] != "undefined"){

    //         $.ajax({

    //             type: 'POST',

    //             data: {

    //                 data: btoa(JSON.stringify(data)),

    //             },

    //             url: "{{url('pay-to-user')}}",

    //             headers: {

    //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

    //             },

    //             success: function (response) {

    //                 if(response.success == true){

    //                     $(".success_top").show().html("");

    //                     $(".success_top").append("<p>"+response.message+"</p>");

    //                     window.scrollTo(0, 0);

    //                     database.collection('driver_payouts').doc(data['payoutId']).update({'paymentStatus': response.status,'payoutResponse' : response.result}).then(async function (result) {

    //                         if (data['user'] && data['user'] != undefined){

    //                             var emailData = await sendMailToRestaurant(data['user'], data['payoutId'], 'Approved', data['amount']);

    //                             if(emailData){

    //                                 window.location.reload();

    //                             }

    //                         }

    //                     });

    //                 }else{

    //                     $(".error_top").show().html("");

    //                     $(".error_top").append("<p>"+response.message+"</p>");

    //                     window.scrollTo(0, 0);

    //                     setTimeout(function(){

    //                         window.location.reload();

    //                     },5000);

    //                 }

    //             }

    //         });

    //     }

    // });



    // $(document).on("click", "a[name='driver_check_status']", async function (e) {

    //     $(this).prop('disabled',true).css({'cursor':'default','opacity':'0.5'});

    //     var data = {};

    //     data['payoutId'] = this.id;

    //     data['method'] = $(this).data('method');

    //     data['amount'] = $(this).data('amount');

    //     data['user'] =  await getUserData($(this).data('auth'));

    //     data['settings'] = await getPaymentSettings();

    //     data['payoutDetail'] = await getPayoutDetail(data['payoutId']);

    //     if(data['method'] != "undefined"){

    //         $.ajax({

    //             type: 'POST',

    //             data: {

    //                 data: btoa(JSON.stringify(data)),

    //             },

    //             url: "{{url('check-payout-status')}}",

    //             headers: {

    //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

    //             },

    //             success: function (response) {

    //                 if(response.success == true){

    //                     $(".success_top").show().html("");

    //                     $(".success_top").append("<p>"+response.message+"</p>");

    //                     window.scrollTo(0, 0);

    //                 }else{

    //                     $(".error_top").show().html("");

    //                     $(".error_top").append("<p>"+response.message+"</p>");

    //                     window.scrollTo(0, 0);

    //                 }

    //                 $(this).prop('disabled',false).css({'cursor':'pointer','opacity':'1'});



    //                 if(response.result && response.status){

    //                     database.collection('driver_payouts').doc(data['payoutId']).update({'paymentStatus': response.status,'payoutResponse' : response.result});

    //                     $("#payoutResponseModal .payout-response").html(JSON.stringify(JSON.parse(JSON.stringify(response.result)),null,4));

    //                     $("#payoutResponseModal").modal('show');

    //                 }

    //             }

    //         });

    //     }

    // });



    async function payoutDriverfunction(driver) {

        var payoutDriver = '';

        var routedriver = '{{route("drivers.view",":id")}}';

        routedriver = routedriver.replace(':id', driver);

        await database.collection('users').where("id", "==", driver).get().then(async function (snapshotss) {

            if (snapshotss.docs[0]) {

                var driver_data = snapshotss.docs[0].data();

                payoutDriver = driver_data.firstName + " " + driver_data.lastName;

                jQuery(".driver_" + driver).attr("data-url", routedriver).html(payoutDriver);

            } else {

                jQuery(".driver_" + driver).attr("data-url", "#").html('');

            }

        });

        return payoutDriver;

    }



    async function getUserData(driverId) {

        var data = '';

        await database.collection('users').where("id", "==", driverId).get().then(async function (snapshotss) {

            if (snapshotss.docs[0]) {

                data = snapshotss.docs[0].data();

            }

        });

        if(data.id){

            await database.collection('withdraw_method').where("userId", "==", data.id).get().then(async function (snapshotss) {

                if (snapshotss.docs.length) {

                    data['withdrawMethod'] = snapshotss.docs[0].data();

                }

            });

        }

        return data;

    }



    async function sendMailToRestaurant(user, id, status, amount) {



        var formattedDate = new Date();

        var month = formattedDate.getMonth() + 1;

        var day = formattedDate.getDate();

        var year = formattedDate.getFullYear();



        month = month < 10 ? '0' + month : month;

        day = day < 10 ? '0' + day : day;



        formattedDate = day + '-' + month + '-' + year;



        var subject = emailTemplatesData.subject;



        subject = subject.replace(/{requestid}/g, id);

        emailTemplatesData.subject = subject;



        var message = emailTemplatesData.message;

        message = message.replace(/{username}/g, user.firstName + ' ' + user.lastName);

        message = message.replace(/{date}/g, formattedDate);

        message = message.replace(/{requestid}/g, id);

        message = message.replace(/{status}/g, status);

        message = message.replace(/{amount}/g, amount);

        message = message.replace(/{usercontactinfo}/g, user.phoneNumber);



        emailTemplatesData.message = message;



        var url = "{{url('send-email')}}";



        return await sendEmail(url, emailTemplatesData.subject, emailTemplatesData.message, [user.email]);

    }



    async function getPayoutDetail(payoutId) {

        var snapshot = await database.collection('driver_payouts').doc(payoutId).get();

        return snapshot.data();

    }



    $(document).on("click", "a[name='driver_reject_request']", function (e) {

        $('#admin_note').val("");

        var id = this.id;

        var auth = $(this).attr('data-auth');

        var amount = $(this).attr('data-amount');

        var price = $(this).attr('data-price');

        $('#submit_cancel').attr('data-id',id).attr('data-amount',amount).attr('data-price',price).attr('data-auth',auth);

    });



    $(document).on("click", "#submit_cancel", async function (e) {

        $(this).prop('disabled',true).css({'cursor':'default','opacity':'0.5'});

        var id = $(this).data('id');

        var auth = $(this).data('auth');

        var user = await getUserData(auth);

        var priceadd = $(this).data('price');

        var amount = $(this).data('amount');

        var admin_note = $("#admin_note").val();

        jQuery("#data-table_processing").show();

        database.collection('users').where("id", "==", auth).get().then(function (resultdriver) {

            if (resultdriver.docs.length) {

                var driver = resultdriver.docs[0].data();

                var wallet_amount = 0;

                if (isNaN(driver.wallet_amount) || driver.wallet_amount == undefined) {

                    wallet_amount = 0;

                } else {

                    wallet_amount = driver.wallet_amount;

                }

                price = parseFloat(wallet_amount) + parseFloat(priceadd);

                if (!isNaN(price)) {

                    database.collection('driver_payouts').doc(id).update({'paymentStatus': 'Reject','adminNote':admin_note}).then(function (result) {

                        database.collection('users').doc(driver.id).update({'wallet_amount': price}).then(async function (result) {

                            var wId = database.collection('temp').doc().id;

                            database.collection('wallet').doc(wId).set({

                                'amount': parseFloat(priceadd),

                                'date': firebase.firestore.FieldValue.serverTimestamp(),

                                'id': wId,

                                'isTopUp': false,

                                'order_id': id,

                                'payment_method': 'Wallet',

                                'payment_status': 'Refund success',

                                'transactionUser': 'driver',

                                'user_id': driver.id,

                                'note': 'Refund by admin'

                            });

                            if (user && user != undefined) {

                                var emailData = await sendMailToRestaurant(user, id, 'Disapproved', amount);

                                if (emailData) {

                                    window.location.reload();

                                }

                            } else {

                                window.location.reload();

                            }

                        });

                    });

                }

            } else {

                alert('Driver not found.');

            }

        });

    });



    $(document).on("click", "#submit_accept", async function (e) {

        $(this).prop('disabled',true).css({'cursor':'default','opacity':'0.5'});

        var id = $(this).data('id');

        var auth = $(this).data('auth');

        var user = await getUserData(auth);

        var amount = $(this).data('amount');

        jQuery("#data-table_processing").show();

        database.collection('driver_payouts').doc(id).update({'paymentStatus': 'Success'}).then(async function (result) {

            if (user && user != undefined) {

                var emailData = await sendMailToRestaurant(user, id, 'Approved', amount);

                if (emailData) {

                    window.location.reload();

                }

            } else {

                window.location.reload();

            }

        });

    });



</script>





@endsection

