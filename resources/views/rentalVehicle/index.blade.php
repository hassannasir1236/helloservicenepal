@extends('layouts.app')

@section('content')
<div class="page-wrapper">


    <div class="row page-titles">

        <div class="col-md-5 align-self-center">

            <h3 class="text-themecolor">{{trans('lang.rental_vehicle')}}</h3>

        </div>

        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">{{trans('lang.dashboard')}}</a></li>
                <li class="breadcrumb-item active">{{trans('lang.rental_vehicle')}}</li>
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

                                    <th>{{trans('lang.image')}}</th>

                                    <th>{{trans('lang.car_name')}}</th>

                                    <th>{{trans('lang.associate_driver')}}</th>

                                    <th>{{trans('lang.actions')}}</th>

                                </tr>

                                </thead>

                                <tbody id="append_list1">


                                </tbody>

                            </table>
                            <div id="data-table_paginate" style="display:none">
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
    var offest = 1;
    var pagesize = 10;
    var end = null;
    var endarray = [];
    var start = null;

    var append_list = '';
    var user_number = [];
    var refData = database.collection('users').where('serviceType', '==', 'rental-service');

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

                const orderableColumns = ['','carName','driverName',''];

                const orderByField = orderableColumns[orderColumnIndex];

                if (searchValue.length >= 3 || searchValue.length === 0) {
                    $('#data-table_processing').show();
                }

                try {
                    const querySnapshot = await  database.collection('users').where('serviceType', '==', 'rental-service').get();
                    if (!querySnapshot || querySnapshot.empty) {
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
                        var driverName = childData.firstName + " " + childData.lastName;
                        childData.driverName = driverName ? driverName : 0.00;

                        if (searchValue) {
                            if (
                                (childData.carName && childData.carName.toLowerCase().includes(searchValue)) ||
                                (childData.driverName && childData.driverName.toLowerCase().includes(searchValue))
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
            order: [1, 'desc'],
            columnDefs: [
                {orderable: false, targets: [0, 3]},
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

    });

    async function buildHTML(val) {
        var html = [];

        var id = val.id;
        var route1 = '{{route("rental_orders.edit",":id")}}';
        route1 = route1.replace(':id', id);

        var route1 = '{{route("drivers.edit",":id")}}';
        route1 = route1.replace(':id', val.id);
        var route2 = '{{route("drivers.vehicle",":id")}}';
        route2 = route2.replace(':id', val.id);


        if (val.carPictureURL != undefined && val.carPictureURL != '') {
            html.push('<td><img  style="width:50px" src="' + val.carPictureURL + '" alt="Image" onerror="this.onerror=null;this.src=\'' + placeholderImage + '\'"></td>');
        } else {
            html.push('<td><img class="image_' + val.id + '" style="width:50px" src="'+placeholderImage+'" alt="Image"></td>');
        }
        html.push('<td>' + val.carName + '</td>');
        html.push('<td data-url="' + route1 + '" class="redirecttopage driver_' + val.driverID + '">' + val.driverName + '</td>');
        html.push('<span class="action-btn"><a href="' + route2 + '"><i class="fa fa-eye"></i></a><a href="' + route1 + '"><i class="fa fa-edit"></i></a></span>');
        return html;

    }


</script>


@endsection
