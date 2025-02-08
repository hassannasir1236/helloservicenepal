@extends('layouts.app')

@section('content')

<div class="page-wrapper">

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">{{trans('lang.provider_plural')}}</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">{{trans('lang.dashboard')}}</a></li>
                <li class="breadcrumb-item active">{{trans('lang.provider_table')}}</li>
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
                <div class="card">
                    <div class="card-header">
                        <ul class="nav nav-tabs align-items-end card-header-tabs w-100">
                            <li class="nav-item">
                                <a class="nav-link active" href="{!! url()->current() !!}"><i
                                        class="fa fa-list mr-2"></i>{{trans('lang.provider_table')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{!! route('providers.create') !!}"><i
                                        class="fa fa-plus mr-2"></i>{{trans('lang.provider_create')}}</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">

                        <div class="table-responsive m-t-10">
                            <table id="userTable"
                                class="display nowrap table table-hover table-striped table-bordered table table-striped"
                                cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <?php if (in_array('providers.delete', json_decode(@session('user_permissions')))) { ?>

                                        <th class="delete-all"><input type="checkbox" id="is_active"><label
                                                class="col-3 control-label" for="is_active"><a id="deleteAll"
                                                    class="do_not_delete" href="javascript:void(0)"><i
                                                        class="fa fa-trash"></i> {{trans('lang.all')}}</a></label></th>
                                        <?php }?>
                                        <th>{{trans('lang.extra_image')}}</th>
                                        <th>{{trans('lang.user_name')}}</th>
                                        <th>{{trans('lang.email')}}</th>
                                        <th>{{trans('lang.date')}}</th>
                                        <th>{{trans('lang.total_orders')}}</th>
                                        <th>{{trans('lang.active')}}</th>
                                        <th>{{trans('lang.wallet_transaction')}}</th>
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
    var database = firebase.firestore();
    var ref = database.collection('users').where("role", "in", ["provider"]).orderBy('createdAt', 'desc');
    var user_permissions = '<?php echo @session('user_permissions') ?>';

    user_permissions = JSON.parse(user_permissions);

    var checkDeletePermission = false;

    if ($.inArray('providers.delete', user_permissions) >= 0) {
        checkDeletePermission = true;
    }

    var placeholderImage = '';

    $(document).ready(function () {

        $(document.body).on('click', '.redirecttopage', function () {
            var url = $(this).attr('data-url');
            window.location.href = url;
        });
        jQuery("#data-table_processing").show();

        var placeholder = database.collection('settings').doc('placeHolderImage');
        placeholder.get().then(async function (snapshotsimage) {
            var placeholderImageData = snapshotsimage.data();
            placeholderImage = placeholderImageData.image;
        })
      
        const table = $('#userTable').DataTable({
            pageLength: 10, // Number of rows per page
            processing: false, // Show processing indicator
            serverSide: true, // Enable server-side processing
            responsive: true,
            ajax: function (data, callback, settings) {
                const start = data.start;
                const length = data.length;
                const searchValue = data.search.value.toLowerCase();
                const orderColumnIndex = data.order[0].column;
                const orderDirection = data.order[0].dir;
                const orderableColumns = (checkDeletePermission) ? ['', '', 'fullName', 'email', 'createdAt', 'totalOrder', '', '',''] : ['', 'fullName', 'email', 'createdAt', 'totalOrder', '', '', '']; // Ensure this matches the actual column names
                const orderByField = orderableColumns[orderColumnIndex]; // Adjust the index to match your table

                if (searchValue.length >= 3 || searchValue.length === 0) {
                    $('#data-table_processing').show();
                }

                ref.get().then(async function (querySnapshot) {
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
                        childData.fullName = childData.firstName + ' ' + childData.lastName || " "
                        childData.totalOrder=await orderDetails(childData.id);
                        if (searchValue) {
                            var date = '';
                            var time = '';
                            if (childData.hasOwnProperty("createdAt")) {
                                try {
                                    date = childData.createdAt.toDate().toDateString();
                                    time = childData.createdAt.toDate().toLocaleTimeString('en-US');
                                } catch (err) {
                                }
                            }
                            var createdAt = date + ' ' + time;
                            if (
                                (childData.fullName && childData.fullName.toLowerCase().toString().includes(searchValue)) ||
                                (createdAt && createdAt.toString().toLowerCase().indexOf(searchValue) > -1) ||
                                (childData.email && childData.email.toLowerCase().toString().includes(searchValue)) ||
                                (childData.phoneNumber && childData.phoneNumber.toString().includes(searchValue)) ||
                                (childData.totalOrder && childData.totalOrder.toString().includes(searchValue))

                            ) {
                                filteredRecords.push(childData);
                            }
                        } else {
                            filteredRecords.push(childData);
                        }
                    }));

                    filteredRecords.sort((a, b) => {
                        let aValue = a[orderByField] ? a[orderByField].toString().toLowerCase() : '';
                        let bValue = b[orderByField] ? b[orderByField].toString().toLowerCase() : '';
                        if (orderByField === 'createdAt') {
                            aValue = a[orderByField] ? new Date(a[orderByField].toDate()).getTime() : 0;
                            bValue = b[orderByField] ? new Date(b[orderByField].toDate()).getTime() : 0;
                        }
                        if (orderByField === 'totalOrder') {
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
            order: (checkDeletePermission) ? [[4, 'desc']] : [[3, 'desc']],
            columnDefs: [{
                targets: (checkDeletePermission == true) ? 4 : 3,
                type: 'date',
                render: function (data) {
                    return data;
                }
            },

            {
                orderable: false,
                targets: (checkDeletePermission == true) ? [0, 1, 6, 7, 8] : [0,5, 6,7]
            },
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
        newdate = '';
        var id = val.id;
        var route1 = '{{route("providers.edit", ":id")}}';
        route1 = route1.replace(':id', id);
        var trroute1 = '{{route("users.walletstransaction", ":id")}}';
        trroute1 = trroute1.replace(':id', "providerID=" + val.id);

        var providerView = '{{route("providers.view", ":id")}}';
        providerView = providerView.replace(':id', id);

        if (checkDeletePermission) {

            html.push('<input type="checkbox" id="is_open_' + id + '" class="is_open" dataId="' + id + '"><label class="col-3 control-label"\n' +
                'for="is_open_' + id + '" ></label>');
        }
        if (val.profilePictureURL == '') {

            html.push('<img class="rounded" style="width:50px" src="' + placeholderImage + '" alt="image">');
        } else {
            html.push('<img class="rounded" style="width:50px" src="' + val.profilePictureURL + '" onerror="this.onerror=null;this.src=\'' + placeholderImage + '\'" alt="image">');
        }


        html.push('<a href="' + providerView + '" class="redirecttopage">' + val.firstName + ' ' + val.lastName + '</a>');
        if(val.email != ''){
            html.push(shortEmail(val.email));
        }else{
            html.push('');
        }
        var date = '';
        var time = '';
        if (val.hasOwnProperty("createdAt")) {
            try {
                date = val.createdAt.toDate().toDateString();
                time = val.createdAt.toDate().toLocaleTimeString('en-US');
            } catch (err) {

            }
            html.push('<span class="dt-time">' + date + ' ' + time + '</span>');
        } else {
            html.push('');
        }

        var providerr = await orderDetails(val.id);

        html.push(providerr);

        if (val.active) {
            html.push('<label class="switch"><input type="checkbox" checked id="' + val.id + '" name="isActive"><span class="slider round"></span></label>');
        } else {
            html.push('<label class="switch"><input type="checkbox" id="' + val.id + '" name="isActive"><span class="slider round"></span></label>');
        }
        html.push('<a href="' + trroute1 + '">{{trans("lang.transaction")}}</a>');
        var actionHtml='';
        actionHtml = actionHtml + '<span class="action-btn"><a href="' + providerView + '"><i class="fa fa-eye"></i></a>';
        actionHtml = actionHtml + '<a href="' + route1 + '"><i class="fa fa-edit"></i></a>';
        if (checkDeletePermission) {
            actionHtml = actionHtml + '<a id="' + val.id + '" class="delete-btn" name="user-delete" href="javascript:void(0)"><i class="fa fa-trash"></i></a>';
        }
        actionHtml = actionHtml + '</span>';  
        html.push(actionHtml);
        return html;
    }

    async function orderDetails(id) {
        var count_order_complete = 0;

        await database.collection('provider_orders').where('provider.author', '==', id).get().then(async function (orderSnapshots) {
            count_order_complete = orderSnapshots.docs.length;

        });

        return count_order_complete;
    }




    $("#is_active").click(function () {
        $("#userTable .is_open").prop('checked', $(this).prop('checked'));
    });

    $("#deleteAll").click(function () {
        if ($('#userTable .is_open:checked').length) {
            if (confirm("{{trans('lang.selected_delete_alert')}}")) {
                jQuery("#data-table_processing").show();
                $('#userTable .is_open:checked').each(async function () {
                    var dataId = $(this).attr('dataId');
                    deleteDocumentWithImage('users',dataId,'profilePictureURL')
                    .then(() => {
                        return deleteUserData(dataId);
                    })
                    .then(result => {
                        setTimeout(function () {
                            window.location.reload();
                        }, 7000);
                    })
                    .catch(error => {
                        console.error("Error occurred:", error);
                    });
                });
            }
        
        } else {
            alert("{{trans('lang.select_delete_alert')}}");
        }
    });

    async function deleteUserData(userId) {

        await database.collection('providers_workers').where('providerId', '==', userId).get().then(async function (snapshotsItem) {

            if (snapshotsItem.docs.length > 0) {
                snapshotsItem.docs.forEach((temData) => {
                    var item_data = temData.data();

                    var objectnew = {
                        "data": {
                            "uid": item_data.id
                        }
                    };
                    var projectId = '<?php echo env('FIREBASE_PROJECT_ID') ?>';
                    jQuery.ajax({
                        url: 'https://us-central1-' + projectId + '.cloudfunctions.net/deleteUser',
                        method: 'POST',
                        contentType: "application/json; charset=utf-8",
                        data: JSON.stringify(objectnew),
                        success: async function (data) {
                            await deleteDocumentWithImage('providers_workers',item_data.id,'profilePictureURL');    
                            console.log('Delete user worker success:', data.result);

                        },
                        error: function (xhr, status, error) {
                            var responseText = JSON.parse(xhr.responseText);
                            console.log('Delete user worker error:', responseText.error);
                        }
                    });
                });
            }

        });

        await database.collection('wallet').where('user_id', '==', userId).get().then(async function (snapshotsItem) {
            if (snapshotsItem.docs.length > 0) {
                snapshotsItem.docs.forEach((temData) => {
                    var item_data = temData.data();

                    database.collection('wallet').doc(item_data.id).delete().then(function () {

                    });
                });
            }

        });
        await database.collection('favorite_provider').where('provider_id', '==', userId).get().then(async function (snapshotsItem) {
            if (snapshotsItem.docs.length > 0) {
                snapshotsItem.docs.forEach((temData) => {
                    var item_data = temData.data();

                    database.collection('favorite_provider').doc(item_data.id).delete().then(function () {

                    });
                });
            }

        });
        await database.collection('providers_services').where('author', '==', userId).get().then(async function (snapshotsItem) {
            if (snapshotsItem.docs.length > 0) {
                for (const temData of snapshotsItem.docs) {
                    await deleteDocumentWithImage('providers_services',temData.id,'authorProfilePic','photos');
                }
            }


        });

        await database.collection('providers_coupons').where('providerId', '==', userId).get().then(async function (snapshotsItem) {
            if (snapshotsItem.docs.length > 0) {
                for (const temData of snapshotsItem.docs) {
                    await deleteDocumentWithImage('providers_coupons',temData.id,'image');
                }
            }

        });

        await database.collection('payouts').where('vendorID', '==', userId).get().then(async function (snapshotsItem) {
            if (snapshotsItem.docs.length > 0) {
                snapshotsItem.docs.forEach((temData) => {
                    var item_data = temData.data();

                    database.collection('payouts').doc(item_data.id).delete().then(function () {

                    });
                });
            }

        });

        //delete user from authentication    
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


    $(document).on("click", "a[name='user-delete']", async function (e) {
        var id = this.id;
        var dataId = $(this).attr('dataId');
        jQuery("#data-table_processing").show();
        deleteDocumentWithImage('users',id,'profilePictureURL')
        .then(() => {
                    return deleteUserData(id);
                })
                .then(result => {
                    setTimeout(function () {
                        window.location.reload();
                    }, 7000);
                })
                .catch(error => {
                    console.error("Error occurred:", error);
                });
    });

    $(document).on("click", "input[name='isActive']", function (e) {
        var ischeck = $(this).is(':checked');
        var id = this.id;
        if (ischeck) {
            database.collection('users').doc(id).update({
                'active': true
            }).then(function (result) { });
        } else {
            database.collection('users').doc(id).update({
                'active': false
            }).then(function (result) { });
        }
    });
</script>

@endsection