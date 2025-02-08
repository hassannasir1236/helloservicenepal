@extends('layouts.app')

@section('content')
<div class="page-wrapper">


    <div class="row page-titles">

        <div class="col-md-5 align-self-center">

            <h3 class="text-themecolor">{{trans('lang.payment_plural')}}</h3>

        </div>

        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">{{trans('lang.dashboard')}}</a></li>
                <li class="breadcrumb-item active">{{trans('lang.payment_plural')}}</li>
            </ol>
        </div>

        <div>

        </div>

    </div>


    <div class="container-fluid">
        <div id="data-table_processing" class="dataTables_processing panel panel-default"
                                 style="display: none;">{{ trans('lang.processing')}}
                                </div>
        <div class="row">

            <div class="col-12">

                <div class="card">

                    <div class="card-body">

                    <div class="table-responsive m-t-10">


                        <table id="example24"
                               class="display nowrap table table-hover table-striped table-bordered table table-striped"
                               cellspacing="0" width="100%">

                            <thead>

                            <tr>
                                <th>{{ trans('lang.provider')}}</th>
                                <th>{{ trans('lang.total_amount')}}</th>
                                <th>{{trans('lang.paid_amount')}}</th>
                                <th>{{trans('lang.remaining_amount')}}</th>
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

var ref = database.collection('users').where('role','==','provider');

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
                var orderableColumns = ['Name', 'totalAmount','paidAmount','remainingAmount']; // Ensure this matches the actual column names
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
                childData.id = doc.id; // Ensure the document ID is included in the data

                var data = await remainingPrice(doc.id);

                
                childData.Name = (childData['firstName'] + '  ' + childData['lastName']);
                childData.totalAmount = data.total;
                childData.paidAmount = data.paid_price_val;
                childData.remainingAmount = data.remaining_val;
                
                if (searchValue) {
                    if (
                        (childData.Name && childData.Name.toString().toLowerCase().includes(searchValue)) ||
                        (childData.totalAmount && childData.totalAmount.toString().includes(searchValue)) ||
                        (childData.paidAmount && childData.paidAmount.toString().toLowerCase().includes(searchValue)) ||
                        (childData.remainingAmount && childData.remainingAmount.toString().toLowerCase().includes(searchValue))
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
                 if (orderByField === 'totalAmount') {
                    
                   aValue = a[orderByField] ? parseInt(a[orderByField]) : 0;
                    bValue = b[orderByField] ? parseInt(b[orderByField]) : 0;
                }
                if (orderByField === 'paidAmount') {
                   
                    aValue = a[orderByField] ? parseInt(a[orderByField]) : 0;
                    bValue = b[orderByField] ? parseInt(b[orderByField]) : 0;
                }
                if (orderByField === 'remainingAmount') {
                    
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
                var getData = await buildHTML(childData);
                records.push(getData);
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
        order:[0, 'desc'],
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
        newdate = '';
        var id = val.id;
        var route1 = '{{route("providers.view", ":id")}}';
        route1 = route1.replace(':id', id);

        html.push('<td data-url="' + route1 + '" class="redirecttopage ">' + val.firstName+' '+val.lastName + '</td>');

        var total_class = '';
        var paid_price_val_class = '';
        var remaining_val_class = '';

        if (currencyAtRight) {

            if (val.totalAmount < 0) {
                total_class = '';

                total = Math.abs(val.totalAmount);
                val.totalAmount = '(-' + parseFloat(total).toFixed(decimal_degits) + "" + currentCurrency + ')';

            } else {
                val.totalAmount = parseFloat(val.totalAmount).toFixed(decimal_degits) + "" + currentCurrency;

            }

            
            paid_price_val = Math.abs(val.paidAmount);
            val.paidAmount = '(' + parseFloat(paid_price_val).toFixed(decimal_degits) + "" + currentCurrency + ')';
            


            if (val.remainingAmount < 0) {
                remaining_val_class = '';
                remaining_val = Math.abs(val.remainingAmount);
                val.remainingAmount = '(-' + parseFloat(remaining_val).toFixed(decimal_degits) + "" + currentCurrency + ')';
            } else {
                val.remainingAmount = parseFloat(val.remainingAmount).toFixed(decimal_degits) + "" + currentCurrency;

            }
        } else {

            if (val.totalAmount < 0) {
                total_class = '';

                total = Math.abs(val.totalAmount);
                val.totalAmount = '(-' + currentCurrency + "" + parseFloat(total).toFixed(decimal_degits) + ')';

            } else {
                val.totalAmount = currentCurrency + "" + parseFloat(val.totalAmount).toFixed(decimal_degits);

            }

            paid_price_val = Math.abs(val.paidAmount);
            val.paidAmount = '(' + currentCurrency + "" + parseFloat(paid_price_val).toFixed(decimal_degits) + ')';
            

            if (val.remainingAmount < 0) {
                remaining_val_class = '';

                remaining_val = Math.abs(val.remainingAmount);

                val.remainingAmount = '(-' + currentCurrency + "" + parseFloat(remaining_val).toFixed(decimal_degits) + ')';

            } else {
                val.remainingAmount = currentCurrency + "" + parseFloat(val.remainingAmount).toFixed(decimal_degits);

            }


        }

        html.push('<td class="' + total_class + '">' + val.totalAmount + '</td>');
        html.push('<td class="' + paid_price_val_class + '">' + val.paidAmount + '</td>');
        html.push('<td class="' + remaining_val_class + '">' + val.remainingAmount + '</td>');

        return html;
    }

async function remainingPrice(providerID) {

        var data = {};

        var paid_price = 0;

        var total_price = 0;

        var remaining = 0;

        var adminCommission = 0;

        await database.collection('payouts').where('vendorID', '==', providerID).where('paymentStatus', '==', 'Success').get().then(async function (payoutSnapshots) {

            payoutSnapshots.docs.forEach((payout) => {

                var payoutData = payout.data();

                paid_price = parseFloat(paid_price) + parseFloat(payoutData.amount);

            });

            await database.collection('users').where('id', '==', providerID).get().then(async function (providerSnapshots) {
                var provider = [];
                var wallet_amount = 0;
                if (providerSnapshots.docs.length) {
                    provider = providerSnapshots.docs[0].data();

                    if (isNaN(provider.wallet_amount) || provider.wallet_amount == undefined || provider.wallet_amount == "") {
                        wallet_amount = 0;
                    } else {
                        wallet_amount = provider.wallet_amount;
                    }

                }

                var remaining = wallet_amount;

                total_price = wallet_amount + paid_price;

                if (Number.isNaN(paid_price)) {
                    paid_price = 0;
                }

                if (Number.isNaN(total_price)) {
                    total_price = 0;
                }

                if (Number.isNaN(remaining)) {
                    remaining = 0;
                }

                data = {
                    'total': total_price,
                    'paid_price_val': paid_price,
                    'remaining_val': remaining,
                };
            });

        });
        return data;

    }

</script>

@endsection
