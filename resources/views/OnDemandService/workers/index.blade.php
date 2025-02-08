@extends('layouts.app')

@section('content')
<div class="page-wrapper">


    <div class="row page-titles">

        <div class="col-md-5 align-self-center">

            <h3 class="text-themecolor PageTitle">{{trans('lang.ondemand_plural')}} - {{trans('lang.worker_plural')}}</h3>

        </div>

        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">{{trans('lang.dashboard')}}</a></li>
                <li class="breadcrumb-item active">{{trans('lang.ondemand_plural')}} - {{trans('lang.worker_plural')}}</li>
            </ol>
        </div>

        <div>

        </div>

    </div>


    <div class="container-fluid">
        <div id="data-table_processing" class="dataTables_processing panel panel-default" style="display: none;">
            {{trans('lang.processing')}}
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
                                <li class="active"><a href="{{route('ondemand.workers.index', $id)}}">{{trans('lang.workers')}}</a></li>
                                <li>
                                <li><a href="{{route('ondemand.bookings.index',$id)}}">{{trans('lang.booking_plural')}}</a></li>
                                <li>
                                <li><a href="{{route('ondemand.coupons', $id)}}">{{trans('lang.coupon_plural')}}</a></li>
                                 <li>
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
                                        class="fa fa-list mr-2"></i>{{trans('lang.worker_table')}}</a>
                            </li>
                            @if($id=='')
                            <li class="nav-item">
                                <a class="nav-link" href="{!! route('ondemand.workers.create') !!}"><i
                                        class="fa fa-plus mr-2"></i>{{trans('lang.worker_create')}}</a>

                            </li>
                            @else
                            <li class="nav-item">
                                <a class="nav-link" href="{!! route('ondemand.workers.create','id='.$id) !!}"><i
                                        class="fa fa-plus mr-2"></i>{{trans('lang.worker_create')}}</a>

                            </li>
                            @endif

                        </ul>
                    </div>
                    <div class="card-body">

                        <div class="table-responsive m-t-10">

                            <table id="workerTable"
                                class="display nowrap table table-hover table-striped table-bordered table table-striped"
                                cellspacing="0" width="100%">

                                <thead>

                                    <tr>
                                    <?php if (in_array('ondemand.workers.delete', json_decode(@session('user_permissions')))) { ?>
                                        <th class="delete-all"><input type="checkbox" id="is_active"><label
                                                    class="col-3 control-label" for="is_active"
                                            ><a id="deleteAll" class="do_not_delete"
                                                href="javascript:void(0)"><i
                                                            class="fa fa-trash"></i> {{trans('lang.all')}}</a></label></th>
                                            <?php }?>
                                        <th>{{trans('lang.image')}}</th>
                                        <th>{{trans('lang.name')}}</th>
                                        <th>{{trans('lang.email')}}</th>
                                        <th>{{trans('lang.salary')}}</th>
                                        <th>{{trans('lang.provider')}}</th>
                                        <th>{{trans('lang.onoff')}}</th>
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

</div>

</div>
</div>

@endsection


@section('scripts')
<script>

    var user_permissions = '<?php echo @session('user_permissions') ?>';
    user_permissions = JSON.parse(user_permissions);
    var checkDeletePermission = false;
    if ($.inArray('ondemand.workers.delete', user_permissions) >= 0) {
            checkDeletePermission = true;
    }

    var database = firebase.firestore();
    var id="{{$id}}";
    if(id!=''){
        var wallet_route = "{{route('users.walletstransaction','id')}}";
        $(".wallet_transaction").attr("href", wallet_route.replace('id', 'providerID='+id));

         $('.tabDiv').show();
         ref = database.collection('providers_workers').where('providerId','==',id).orderBy('createdAt', 'desc');
    }else{
         $('.tabDiv').hide();
         ref = database.collection('providers_workers').orderBy('createdAt', 'desc');
    }

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

    var placeholder = database.collection('settings').doc('placeHolderImage');
    placeholder.get().then(async function (snapshotsimage) {
        var placeholderImageData = snapshotsimage.data();
        placeholderImage = placeholderImageData.image;
    })

    $(document).ready(function () {
        if(id!=''){
            getProviderNameForFilter(id);
        }
        jQuery("#data-table_processing").show();


        var userRef = database.collection('users');

        const table = $('#workerTable').DataTable({
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
                var orderableColumns = (checkDeletePermission) ? ['', '', 'name', 'email', 'salary', 'providerName', 'online', '', ''] : ['', 'name', 'email', 'salary', 'providerName', '', '', '']; // Ensure this matches the actual column names
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
                    let userNames = {};

                    // Fetch section names
                    const userDocs = await userRef.get();
                    userDocs.forEach(doc => {
                        userNames[doc.id] = doc.data().firstName + ' ' + doc.data().lastName;
                    });
                    await Promise.all(querySnapshot.docs.map(async (doc) => {
                        let childData = doc.data();
                        childData.id = doc.id; // Ensure the document ID is included in the data
                        if (childData.hasOwnProperty("providerId")) {
                            childData.providerName = userNames[childData.providerId] || '';
                        } else {
                            childData.providerName = '';
                        }
                        childData.name = childData.firstName + ' ' + childData.lastName;

                        let on_status = '';
                        if(childData.online == true){
                            on_status = "Online";
                        }
                        else
                        {
                            on_status = "Offline";
                        }

                        if (searchValue) {
                            if (
                                (childData.name && childData.name.toLowerCase().toString().includes(searchValue)) ||
                                (childData.email && childData.email.toLowerCase().toString().includes(searchValue)) ||
                                (childData.salary && childData.salary.toString().toLowerCase().includes(searchValue)) ||
                                (childData.providerName && childData.providerName.toString().toLowerCase().includes(searchValue)) ||
                                (on_status && on_status.toString().toLowerCase().includes(searchValue))

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

                        if(orderByField === 'salary') {
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
            order: (checkDeletePermission) ? [[2, 'asc']] : [[1, 'asc']],
            columnDefs: [
                { orderable: false, targets: (checkDeletePermission) ? [0, 1, 6, 7, 8] : [0, 5, 6]  },
            ],
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
    });

    async function buildHTML(val) {
        var html = [];

        var id = val.id;
        var idOfProviderDetailPage="<?php echo $id;?>";
        var route1 = '{{route("ondemand.workers.edit",":id")}}';
        if(idOfProviderDetailPage!=''){
            route1 = route1.replace(':id', val.id+"?id="+idOfProviderDetailPage);
        }else{ 
            route1 = route1.replace(':id', val.id);
        }

        var salary = 0;

        // html = html + '<tr>';

        if(checkDeletePermission){
            html.push( '<td class="delete-all"><input type="checkbox" id="is_open_' + id + '" class="is_open" dataId="' + id + '"><label class="col-3 control-label"\n' +
            'for="is_open_' + id + '" ></label></td>');
        }

        if (val.profilePictureURL == '' || val.profilePictureURL == null) {
            html.push('<img class="rounded" style="width:50px" src="' + placeholderImage + '" alt="image">');
        } else {
            html.push('<img onerror="this.onerror=null;this.src=\'' + placeholderImage + '\'" class="rounded" style="width:50px" src="' + val.profilePictureURL + '" alt="image">');
        }

        html.push('<a href="' + route1 + '">' + val.firstName + ' ' + val.lastName + '</a>');
        html.push(shortEmail(val.email));

        if (currencyAtRight) {
            salary = parseFloat(val.salary).toFixed(decimal_degits) + "" + currentCurrency;
        } else {
            salary = currentCurrency + "" + parseFloat(val.salary).toFixed(decimal_degits);
        }
        html.push(salary);


        if (val.hasOwnProperty("providerId")) {
            var providerView = '{{route("providers.view",":id")}}';
            providerView = providerView.replace(':id', val.providerId);
            // var providerName = await getProviderName(val.providerId);
            if(val.providerName==""){
                providerView="javascript:void(0)";
                providerName="{{trans('lang.unknown')}}"
            }
            html.push('<a href="' + providerView + '">' + val.providerName + '</a>');
        } else {
            html.push('');
        }

        var stus = '';

        if(val.online == true){
            stus = 'Online';
        }
        else
        {
            stus = 'Offline';
        }

        html.push(stus);

        if (val.active) {
            html.push('<label class="switch"><input type="checkbox" checked id="' + val.id + '" name="isActive"><span class="slider round"></span></label>');
        } else {
            html.push('<label class="switch"><input type="checkbox" id="' + val.id + '" name="isActive"><span class="slider round"></span></label>');
        }
        var actionHtml = '';

        actionHtml = actionHtml  + '<span class="action-btn"><a href="' + route1 + '"><i class="fa fa-edit"></i></a>';

        if(checkDeletePermission){
            actionHtml = actionHtml + '<a id="' + val.id + '" class="delete-btn" name="worker-delete"  href="javascript:void(0)"><i class="fa fa-trash"></i></a>';
        }
        actionHtml = actionHtml + '</span>';

        html.push(actionHtml);

        return html;

    }

    $("#is_active").click(function () {
        $("#workerTable .is_open").prop('checked', $(this).prop('checked'));
    });

    $(document).on("click", "input[name='isActive']", function (e) {
        var ischeck = $(this).is(':checked');
        var id = this.id;
        var isActive = ischeck ? true : false;
        database.collection('providers_workers').doc(id).update({
            'active': isActive
        });
    });

    $("#deleteAll").click(function () {
        if ($('#workerTable .is_open:checked').length) {
            if (confirm("{{trans('lang.selected_delete_alert')}}")) {
                jQuery("#data-table_processing").show();
                $('#workerTable .is_open:checked').each(async function () {
                    var dataId = $(this).attr('dataId');
                    await deleteDocumentWithImage('providers_workers',dataId,'profilePictureURL');
                    var deleteUser = deleteUserData(dataId);
                    window.location.reload();
                });
            }
        } else {
            alert("{{trans('lang.select_delete_alert')}}");
        }
    });

    $(document).on("click", "a[name='worker-delete']", async function (e) {
        var id = this.id;
        jQuery("#data-table_processing").show();
        await deleteDocumentWithImage('providers_workers',id,'profilePictureURL');
        var deleteUser = deleteUserData(id);
        window.location.reload();
    });

    $(document).on("click", "input[name='isActive']", function (e) {
        var ischeck = $(this).is(':checked');
        var id = this.id;
        if (ischeck) {
            database.collection('providers_workers').doc(id).update({
                'active': true
            }).then(function (result) { });
        } else {
            database.collection('providers_workers').doc(id).update({
                'active': false
            }).then(function (result) { });
        }
    });

    async function getProviderName(providerId) {
        let providerName = '';
        if (providerId != '' && providerId != null) {
            let providerDoc = await database.collection('users').doc(providerId).get();
            if (providerDoc.exists) {
                let providerData = providerDoc.data();
                providerName = providerData.firstName +' '+providerData.lastName;
            }
        }
        return providerName;
    }

    async function deleteUserData(userId) {

        var dataObject = {
            "data": {
                "uid": userId
            }
        };
        var projectId = '<?php echo env('FIREBASE_PROJECT_ID') ?>';
        jQuery.ajax({
            url: 'https://us-central1-' + projectId + '.cloudfunctions.net/deleteUser',
            method: 'POST',
            contentType: "application/json; charset=utf-8",
            data: JSON.stringify(dataObject),
            success: function (data) {
                console.log('Delete user success:', data.result);
            },
            error: function (xhr, status, error) {
                var responseText = JSON.parse(xhr.responseText);
                console.log('Delete user error:', responseText.error);
            }
        });
    }
    async function getProviderNameForFilter(providerId){
        await database.collection('users').where('id', '==', providerId).get().then(async function (snapshots) {
            var providerData = snapshots.docs[0].data();
            providerName = providerData.firstName+' '+providerData.lastName;
            $('.PageTitle').html("{{trans('lang.worker_plural')}} - " + providerName);
        });

    }


</script>

@endsection