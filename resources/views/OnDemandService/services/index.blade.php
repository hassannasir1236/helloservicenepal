@extends('layouts.app')

@section('content')
    <div class="page-wrapper">


        <div class="row page-titles">

            <div class="col-md-5 align-self-center">

                <h3 class="text-themecolor PageTitle">{{trans('lang.ondemand_plural')}}
                    - {{trans('lang.service_plural')}}</h3>

            </div>

            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">{{trans('lang.dashboard')}}</a></li>
                    <li class="breadcrumb-item active">{{trans('lang.ondemand_plural')}}
                        - {{trans('lang.service_plural')}}</li>
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
                    @if($id!='')
                        <div class="resttab-sec">

                            <div class="menu-tab tabDiv">
                                <ul>
                                    <li><a href="{{route('providers.view', $id)}}">{{trans('lang.tab_basic')}}</a>
                                    </li>
                                    <li class="active"><a
                                                href="{{route('ondemand.services.index', $id)}}">{{trans('lang.services')}}</a>
                                    </li>
                                    <li>
                                    <li><a href="{{route('ondemand.workers.index', $id)}}">{{trans('lang.workers')}}</a>
                                    </li>
                                    <li>
                                    <li>
                                        <a href="{{route('ondemand.bookings.index',$id)}}">{{trans('lang.booking_plural')}}</a>
                                    </li>
                                    <li>
                                    <li><a href="{{route('ondemand.coupons', $id)}}">{{trans('lang.coupon_plural')}}</a>
                                    </li>
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

                        <div class="card-body">

                            <div class="card-header">
                                <ul class="nav nav-tabs align-items-end card-header-tabs w-100">
                                    <li class="nav-item">
                                        <a class="nav-link active" href="{!! url()->current() !!}"><i
                                                    class="fa fa-list mr-2"></i>{{trans('lang.service_table')}}</a>
                                    </li>
                                    @if($id=='')
                                        <li class="nav-item">
                                            <a class="nav-link" href="{!! route('ondemand.services.create') !!}"><i
                                                        class="fa fa-plus mr-2"></i>{{trans('lang.service_create')}}</a>
                                        </li>
                                    @else
                                        <li class="nav-item">
                                            <a class="nav-link"
                                               href="{!! route('ondemand.services.create','id='.$id) !!}"><i
                                                        class="fa fa-plus mr-2"></i>{{trans('lang.service_create')}}</a>
                                        </li>
                                    @endif
                                </ul>
                            </div>


                            <div class="table-responsive m-t-10">


                                <table id="serviceTable"
                                       class="display nowrap table table-hover table-striped table-bordered table table-striped"
                                       cellspacing="0" width="100%">

                                    <thead>

                                    <tr>

                                        <?php if (in_array('ondemand.services.delete', json_decode(@session('user_permissions')))) { ?>
                                        <th class="delete-all"><input type="checkbox" id="is_active"><label
                                                    class="col-3 control-label" for="is_active"
                                            ><a id="deleteAll" class="do_not_delete"
                                                href="javascript:void(0)"><i
                                                            class="fa fa-trash"></i> {{trans('lang.all')}}</a></label>
                                        </th>
                                        <?php } ?>
                                        <th>{{trans('lang.name')}}</th>
                                        <th>{{trans('lang.ondemand_category')}}</th>
                                        <th>{{trans('lang.section')}}</th>
                                        <th>{{trans('lang.provider')}}</th>
                                        <th>{{trans('lang.price')}}</th>
                                        <th>{{trans('lang.publish')}}</th>
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
        var id = "{{$id}}";

        var user_permissions = '<?php echo @session('user_permissions') ?>';
        user_permissions = JSON.parse(user_permissions);
        var checkDeletePermission = false;
        if ($.inArray('ondemand.services.delete', user_permissions) >= 0) {
            checkDeletePermission = true;
        }

        var database = firebase.firestore();
        
        if (id != '') {
            var wallet_route = "{{route('users.walletstransaction','id')}}";
            $(".wallet_transaction").attr("href", wallet_route.replace('id', 'providerID=' + id));
            $('.tabDiv').show();
            var ref = database.collection('providers_services').where('author', '==', id).orderBy('createdAt', 'desc');

        } else {
            $('.tabDiv').show();
            var ref = database.collection('providers_services').orderBy('createdAt', 'desc');

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

        var ctegoryRef = database.collection('provider_categories');
        var ref_sections = database.collection('sections');
        var refProvider = database.collection('users');

        $(document).ready(function () {
            jQuery("#data-table_processing").show();
            if (id !== '') {
                getProviderNameForFilter(id);
            }
            const table = $('#serviceTable').DataTable({
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
                    var orderableColumns = (checkDeletePermission) ? ['', 'title','categoryName','sectionName','providerName','finalPrice', '', ''] : ['', 'title','categoryName','sectionName','providerName','finalPrice', '', '']; // Ensure this matches the actual column names
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
                        let sectionNames = {};
                        let categoryName = {};
                        let providerNames = {};
                        // Fetch section names
                        const sectionDocs = await ref_sections.get();
                        sectionDocs.forEach(doc => {
                            sectionNames[doc.id] = doc.data().name;
                        });

                        const categoryDocs = await ctegoryRef.get();
                        categoryDocs.forEach(doc => {
                            categoryName[doc.id] = doc.data().title;
                        });

                        const providerDocs = await refProvider.get();
                        providerDocs.forEach(doc => {
                            providerNames[doc.id] = doc.data().firstName + ' ' + doc.data().lastName;
                        });
                        await Promise.all(querySnapshot.docs.map(async (doc) => {
                            let childData = doc.data();
                            childData.id = doc.id; // Ensure the document ID is included in the data              
                            childData.sectionName = sectionNames[childData.sectionId] || '';
                            childData.categoryName = categoryName[childData.categoryId] || '';
                            if(childData.hasOwnProperty('author')){
                                childData.providerName = providerNames[childData.author] || '';
                            }else{
                                childData.providerName = '';
                            }

                            if(childData.hasOwnProperty('disPrice') && childData.disPrice != '0'){
                                childData.finalPrice = childData.disPrice;
                            }else{
                                childData.finalPrice = childData.price;
                            }
                            if (searchValue) {
                            
                                if (
                                    (childData.title && childData.title.toLowerCase().toString().includes(searchValue)) ||
                                    (childData.categoryName && childData.categoryName.toLowerCase().toString().includes(searchValue)) ||
                                    (childData.sectionName && childData.sectionName.toString().toLowerCase().includes(searchValue)) ||
                                    (childData.providerName && childData.providerName.toString().toLowerCase().includes(searchValue)) ||
                                    (childData.finalPrice && childData.finalPrice.toString().toLowerCase().includes(searchValue))

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
                        
                            if(orderByField === 'finalPrice') {
                                aValue = a[orderByField] ? parseFloat(a[orderByField]) : 0.0;
                                bValue = b[orderByField] ? parseFloat(b[orderByField]) : 0.0;

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
                order: (checkDeletePermission) ? [[1, 'asc']] : [[0, 'asc']],
                columnDefs: [
                    
                    { orderable: false, targets: (checkDeletePermission) ? [0, 6, 7] : [5, 6] },
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
                return function(...args) {
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

            newdate = '';
            var id = val.id;
            var idOfProviderDetailPage = "{{$id}}";
            var route1 = '{{route("ondemand.services.edit",":id")}}';
            if (idOfProviderDetailPage != '') {
                route1 = route1.replace(':id', val.id + "?id=" + idOfProviderDetailPage);
            } else {
                route1 = route1.replace(':id', id);
            }

            if (checkDeletePermission) {
                html.push('<td class="delete-all"><input type="checkbox" id="is_open_' + id + '" class="is_open" dataId="' + id + '"><label class="col-3 control-label"\n' + 'for="is_open_' + id + '" ></label></td>'); 
            }

            html.push('<a href="' + route1 + '">' + val.title + '</a>');

            html.push(val.categoryName);
            html.push(val.sectionName);
          
            if (val.hasOwnProperty("author")) {
                var providerView = '{{route("providers.view",":id")}}';
                providerView = providerView.replace(':id', val.author);
                
                if (val.providerName == "") {
                    providerView = "javascript:void(0)";
                    providerName = "{{trans('lang.unknown')}}"
                }
                html.push('<a href="' + providerView + '">' + val.providerName + '</a>');
            } else {
                html.push('<td></td>');
            }
            
            if (val.disPrice == "0"){
                if (val.priceUnit == "Hourly") {
                    if (currencyAtRight) {
                        html.push('<td data-html="true" data-order="' + val.price + '">' + parseFloat(val.price).toFixed(decimal_degits) + '' + currentCurrency + '/hr</td>');
                    }else {
                        html.push('<td data-html="true" data-order="' + val.price + '">' + currentCurrency + parseFloat(val.price).toFixed(decimal_degits) + '/hr</td>');
                    }
                } else {
                    if (currencyAtRight) {
                        html.push('<td data-html="true" data-order="' + val.price + '">' + parseFloat(val.price).toFixed(decimal_degits) +  '' + currentCurrency + '</td>');
                    }else {
                        html.push('<td data-html="true" data-order="' + val.price + '">' + currentCurrency + parseFloat(val.price).toFixed(decimal_degits) + '</td>');
                    }
                }
            }else {
                if (val.priceUnit == "Hourly") {
                    if (currencyAtRight) {
                        html.push('<td data-html="true" data-order="' + val.disPrice + '">' + parseFloat(val.disPrice).toFixed(decimal_degits) + '' + currentCurrency + '/hr  <s>' + parseFloat(val.price).toFixed(decimal_degits) + '' + currentCurrency + '/hr</s></td>');
                    } else {
                        html.push('<td data-html="true" data-order="' + val.disPrice + '">' + '' + currentCurrency + parseFloat(val.disPrice).toFixed(decimal_degits) + '/hr  <s>' + currentCurrency + '' + parseFloat(val.price).toFixed(decimal_degits) + '/hr</s> </td>');
                    }
                } else {
                    if (currencyAtRight) {
                        html.push('<td data-html="true" data-order="' + val.disPrice + '">' + parseFloat(val.disPrice).toFixed(decimal_degits) + '' + currentCurrency + '  <s>' + parseFloat(val.price).toFixed(decimal_degits) + '' + currentCurrency + '</s></td>');
                    } else {
                        html.push('<td data-html="true" data-order="' + val.disPrice + '">' + '' + currentCurrency + parseFloat(val.disPrice).toFixed(decimal_degits) + ' <s>' + currentCurrency + '' + parseFloat(val.price).toFixed(decimal_degits) + '</s> </td>');
                    }
                }
            }


            if (val.publish) {
                html.push('<label class="switch"><input type="checkbox" checked id="' + val.id + '" name="isActive"><span class="slider round"></span></label>');
            } else {
                html.push('<label class="switch"><input type="checkbox" id="' + val.id + '" name="isActive"><span class="slider round"></span></label>');
            }

            var actionHtml = '';
            actionHtml = actionHtml + '<span class="action-btn"><a href="' + route1 + '"><i class="fa fa-edit"></i></a>';
            if (checkDeletePermission) {
                actionHtml = actionHtml + '<a id="' + val.id + '" name="service-delete" class="delete-btn" href="javascript:void(0)"><i class="fa fa-trash"></i></a>';
            }
            actionHtml = actionHtml + '</span>';
            html.push(actionHtml);
            return html;
        }       

        $(document).on("click", "input[name='isActive']", function (e) {
            var ischeck = $(this).is(':checked');
            var id = this.id;
            var publish = ischeck ? true : false;
            database.collection('providers_services').doc(id).update({
                'publish': publish
            });
        });

        $(document).on("click", "a[name='service-delete']", async function (e) {
            var id = this.id;
            await deleteDocumentWithImage('providers_services',id,'','photos');
            deleteServiceData(id);
            window.location.reload();
        });

        $("#is_active").click(function () {
            $("#serviceTable .is_open").prop('checked', $(this).prop('checked'));
        });

        $("#deleteAll").click(function () {
            if ($('#serviceTable .is_open:checked').length) {
                if (confirm("{{trans('lang.selected_delete_alert')}}")) {
                    jQuery("#data-table_processing").show();
                    $('#serviceTable .is_open:checked').each(async function () {
                        var dataId = $(this).attr('dataId');
                        await deleteDocumentWithImage('providers_services',dataId,'','photos');
                        deleteServiceData(dataId);
                        window.location.reload();
                    });
                }
            } else {
                alert("{{trans('lang.select_delete_alert')}}");
            }
        });

        async function getProviderNameForFilter(providerId) {
            await database.collection('users').where('id', '==', providerId).get().then(async function (snapshots) {
                var providerData = snapshots.docs[0].data();
                providerName = providerData.firstName + ' ' + providerData.lastName;
                $('.PageTitle').html("{{trans('lang.service_plural')}} - " + providerName);
            });

        }
        async function deleteServiceData(serviceId){
            await database.collection('favorite_service').where('service_id', '==', serviceId).get().then(async function(snapshotsItem) {

            if (snapshotsItem.docs.length > 0) {
                snapshotsItem.docs.forEach((temData) => {
                    var item_data = temData.data();

                    database.collection('favorite_service').doc(item_data.id).delete().then(function() {

                    });
                });
            }

        });
        }
    </script>


@endsection