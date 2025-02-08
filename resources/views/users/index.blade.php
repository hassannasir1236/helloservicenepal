@extends('layouts.app')

@section('content')

<div class="page-wrapper">

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">{{trans('lang.user_plural')}}</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">{{trans('lang.dashboard')}}</a></li>
                <li class="breadcrumb-item active">{{trans('lang.user_table')}}</li>
            </ol>
        </div>
        <div>
        </div>
    </div>

    <div class="container-fluid">
        <div id="data-table_processing" class="dataTables_processing panel panel-default" style="display: none;">{{trans('lang.processing')}}</div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <ul class="nav nav-tabs align-items-end card-header-tabs w-100">
                            <li class="nav-item">
                                <a class="nav-link active" href="{!! url()->current() !!}"><i class="fa fa-list mr-2"></i>{{trans('lang.user_table')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{!! route('users.create') !!}"><i class="fa fa-plus mr-2"></i>{{trans('lang.user_create')}}</a>
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
                                <?php if (in_array('users.delete', json_decode(@session('user_permissions')))) { ?>

                                    <th class="delete-all"><input type="checkbox" id="is_active"><label
                                                class="col-3 control-label" for="is_active"><a id="deleteAll"
                                                                                               class="do_not_delete"
                                                                                               href="javascript:void(0)"><i
                                                        class="fa fa-trash"></i> {{trans('lang.all')}}</a></label></th>
                                    <?php }?>
                                    <th>{{trans('lang.extra_image')}}</th>
                                    <th>{{trans('lang.user_name')}}</th>
                                    <th>{{trans('lang.email')}}</th>
                                    <th>{{trans('lang.phone')}}</th>
                                    <th>{{trans('lang.date')}}</th>
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

    var ref = database.collection('users').where("role", "in", ["customer"]).orderBy('createdAt', 'desc');
    var user_permissions = '<?php echo @session('user_permissions') ?>';

    user_permissions = JSON.parse(user_permissions);

    var checkDeletePermission = false;

    if ($.inArray('users.delete', user_permissions) >= 0) {
        checkDeletePermission = true;
    }
    
   
    $(document).ready(function() {

        $(document.body).on('click', '.redirecttopage', function() {
            var url = $(this).attr('data-url');
            window.location.href = url;
        });
        jQuery("#data-table_processing").show();

        var placeholder = database.collection('settings').doc('placeHolderImage');
        placeholder.get().then(async function(snapshotsimage) {
            var placeholderImageData = snapshotsimage.data();
            placeholderImage = placeholderImageData.image;
        })

        const table = $('#userTable').DataTable({
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
                
                const orderableColumns = (checkDeletePermission) ? ['', '', 'name', 'email','phoneNumber', 'createdAt', '', '', ''] : ['', 'name', 'email','phoneNumber', 'createdAt', '', '', '']; // Ensure this matches the actual column names
               
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
                        childData.name = childData.firstName + ' ' + childData.lastName;
                        
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
                                (childData.name && childData.name.toString().toLowerCase().includes(searchValue)) ||
                                (childData.email && childData.email.toString().toLowerCase().includes(searchValue))
                                || (createdAt && createdAt.toString().toLowerCase().indexOf(searchValue) > -1) || (childData.phoneNumber && childData.phoneNumber.toString().toLowerCase().includes(searchValue))
                            ) {
                                filteredRecords.push(childData);
                            }
                        } else {
                            filteredRecords.push(childData);
                        }
                    }));
                    
                    filteredRecords.sort((a, b) => {
                        let aValue = a[orderByField] ;
                        let bValue = b[orderByField] ;                       
                        if (orderByField === 'createdAt') {
                            aValue = a[orderByField] ? new Date(a[orderByField].toDate()).getTime() : 0;
                            bValue = b[orderByField] ? new Date(b[orderByField].toDate()).getTime() : 0;
                        }else{
                            aValue = a[orderByField] ? a[orderByField].toString().toLowerCase().trim() : '';
                            bValue = b[orderByField] ? b[orderByField].toString().toLowerCase().trim() : ''
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

                    console.log("Records fetched:", records.length);

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
            order: (checkDeletePermission) ? [5, 'desc'] : [4, 'desc'],
            columnDefs: [
                {
                    orderable: false,
                    targets: (checkDeletePermission) ? [0, 1, 6, 7,8] : [0,5,6,7] ,
                },
                {
                    type: 'date',
                    render: function(data) {
                        return data;
                    },
                    targets: (checkDeletePermission) ? [5] : [4],
                }

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
        var route1 = '{{route("users.edit",":id")}}';
        route1 = route1.replace(':id', id);


        var user_view = '{{route("users.view",":id")}}';
        user_view = user_view.replace(':id', id);

        var trroute1 = '{{route("users.walletstransaction",":id")}}';
        trroute1 = trroute1.replace(':id', id);
        if (checkDeletePermission) {

        html.push('<td class="delete-all"><input type="checkbox" id="is_open_' + id + '" class="is_open" dataId="' + id + '"><label class="col-3 control-label"\n' +
            'for="is_open_' + id + '" ></label></td>');
        }
        if (val.profilePictureURL == '') {

            html.push('<td><img class="rounded" style="width:50px" src="' + placeholderImage + '" alt="image"></td>');
        } else {
            html.push('<td><img class="rounded" style="width:50px" src="' + val.profilePictureURL + '"  onerror="this.onerror=null;this.src=\'' + placeholderImage + '\'"  alt="image"></td>');
        }

        html.push('<a href="' + user_view + '" class="redirecttopage">' + val.firstName + ' ' + val.lastName + '</a>');

        html.push('<td>' + shortEmail(val.email) + '</td>');
        if(val.phoneNumber.includes('+')){
            html.push('+' + EditPhoneNumber(val.phoneNumber.slice(1)));
        }else{
            html.push(EditPhoneNumber(val.phoneNumber))
        }
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
            html.push('');
        }
        if (val.active) {
            html.push('<td><label class="switch"><input type="checkbox" checked id="' + val.id + '" name="isActive"><span class="slider round"></span></label></td>');
        } else {
            html.push('<td><label class="switch"><input type="checkbox" id="' + val.id + '" name="isActive"><span class="slider round"></span></label></td>');
        }
        html.push('<td><a href="' + trroute1 + '">{{trans("lang.transaction")}}</a></td>');

        var actionHtml = '';
        actionHtml = actionHtml + '<span class="action-btn"><a href="' + user_view + '"><i class="fa fa-eye"></i></a><a href="' + route1 + '"><i class="fa fa-edit"></i></a>';
        if (checkDeletePermission) {
        actionHtml = actionHtml+'<a id="' + val.id + '" class="delete-btn" name="user-delete" href="javascript:void(0)"><i class="fa fa-trash"></i></a>';
        }
        actionHtml = actionHtml + '</span>';
        html.push(actionHtml);

        return html;
    }



    $("#is_active").click(function() {
        $("#userTable .is_open").prop('checked', $(this).prop('checked'));
    });

    $("#deleteAll").click(function() {
        if ($('#userTable .is_open:checked').length) {
            if (confirm("{{trans('lang.selected_delete_alert')}}")) {
                jQuery("#data-table_processing").show();
                $('#userTable .is_open:checked').each(async function() {
                    var dataId = $(this).attr('dataId');
                    await deleteDocumentWithImage('users', dataId, 'profilePictureURL');

                        const getStoreName = deleteUserData(dataId);
                        setTimeout(function() {
                            window.location.reload();
                        }, 7000);
                    

                });
            }
        } else {
            alert("{{trans('lang.select_delete_alert')}}");
        }
    });

    async function deleteUserData(userId) {

        await database.collection('wallet').where('user_id', '==', userId).get().then(async function(snapshotsItem) {

            if (snapshotsItem.docs.length > 0) {
                snapshotsItem.docs.forEach((temData) => {
                    var item_data = temData.data();

                    database.collection('wallet').doc(item_data.id).delete().then(function() {

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
            success: function(data) {
                console.log('Delete user success:', data.result);
            },
            error: function(xhr, status, error) {
                var responseText = JSON.parse(xhr.responseText);
                console.log('Delete user error:', responseText.error);
            }
        });
    }


    $(document).on("click", "a[name='user-delete']", async function(e) {
        var id = this.id;
        jQuery("#data-table_processing").show();
            await deleteDocumentWithImage('users', id, 'profilePictureURL');
            const getStoreName = deleteUserData(id);
            setTimeout(function() {
                window.location.reload();
            }, 7000);
    });

    $(document).on("click", "input[name='isActive']", function(e) {
        var ischeck = $(this).is(':checked');
        var id = this.id;
        if (ischeck) {
            database.collection('users').doc(id).update({
                'active': true
            }).then(function(result) {});
        } else {
            database.collection('users').doc(id).update({
                'active': false
            }).then(function(result) {});
        }
    });
</script>

@endsection