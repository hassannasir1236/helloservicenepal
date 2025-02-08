@extends('layouts.app')



@section('content')



<div class="page-wrapper">

    <div class="row page-titles">

        <div class="col-md-5 align-self-center">

            <h3 class="text-themecolor">{{trans('lang.category_plural')}}</h3>

        </div>



        <div class="col-md-7 align-self-center">

            <ol class="breadcrumb">

                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">{{trans('lang.dashboard')}}</a></li>

                <li class="breadcrumb-item active">{{trans('lang.category_plural')}}</li>

            </ol>

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

                                        class="fa fa-list mr-2"></i>{{trans('lang.category_table')}}</a>

                            </li>

                            <li class="nav-item">

                                <a class="nav-link" href="{!! route('categories.create') !!}"><i

                                        class="fa fa-plus mr-2"></i>{{trans('lang.category_create')}}</a>

                            </li>

                        </ul>

                    </div>



                    <div class="card-body">







                        <div id="users-table_filter" class="pull-right">

                            <div class="row">

                                <div class="col-md-9">

                                </div>

                                <div class="col-md-3">

                                    <select id="section_id" class="form-control allModules" style="width:100%"

                                        onchange="clickLink(this.value)">

                                        <option value="">{{trans('lang.select')}} {{trans('lang.section_plural')}}

                                        </option>

                                    </select>

                                    <p style="color: red;font-size: 13px;">

                                        {{trans('lang.rental_parcel_cab_service_are_not')}}</p>

                                </div>

                            </div>

                        </div>



                        <div class="table-responsive m-t-10">

                            <table id="categoryTable"

                                class="display nowrap table table-hover table-striped table-bordered table table-striped"

                                cellspacing="0" width="100%">

                                <thead>





                                    <tr>

                                        <?php if (in_array('categories.delete', json_decode(@session('user_permissions')))) { ?>



                                            <th class="delete-all"><input type="checkbox" id="is_active"><label

                                                    class="col-3 control-label" for="is_active">

                                                    <a id="deleteAll" class="do_not_delete" href="javascript:void(0)"><i

                                                            class="fa fa-trash"></i> {{trans('lang.all')}}</a></label></th>

                                        <?php } ?>

                                        <th>{{trans('lang.category_image')}}</th>

                                        <th>{{trans('lang.faq_category_name')}}</th>

                                        <th>{{trans('lang.section')}}</th>

                                        <th>{{trans('lang.item')}}</th>

                                        <th> {{trans('lang.item_publish')}}</th>

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

    var user_permissions = '<?php echo @session('user_permissions') ?>';



    user_permissions = JSON.parse(user_permissions);



    var checkDeletePermission = false;



    if ($.inArray('categories.delete', user_permissions) >= 0) {

        checkDeletePermission = true;

    }

    var database = firebase.firestore();

    var offest = 1;

    var pagesize = 10;

    var end = null;

    var endarray = [];

    var start = null;

    var user_number = [];

    var section_id = getCookie('section_id');



    if (section_id != '') {

        var ref = database.collection('vendor_categories').where('section_id', '==', section_id);

    } else {

        var ref = database.collection('vendor_categories');

    }

    var append_list = '';

    var placeholderImage = '';

    var ref_sections = database.collection('sections');

    let selected_gender = "";



    $(document).ready(function () {



        var inx = parseInt(offest) * parseInt(pagesize);

        jQuery("#data-table_processing").show();



        var placeholder = database.collection('settings').doc('placeHolderImage');

        placeholder.get().then(async function (snapshotsimage) {

            var placeholderImageData = snapshotsimage.data();

            placeholderImage = placeholderImageData.image;

        })



        //start



        const table = $('#categoryTable').DataTable({

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

                const orderableColumns = (checkDeletePermission) ? ['', '', 'title', 'sectionName', 'totalProducts', '', ''] : ['', 'title', 'sectionName', 'totalProducts', '', '']; // Ensure this matches the actual column names

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

                        var sectionName = '';

                        if (childData.hasOwnProperty("section_id")) {

                            sectionName = await getSectionName(childData.section_id);

                        }

                        var totalProducts = await getProductTotal(childData.id, childData.section_id);

                        childData.sectionName = sectionName ? sectionName : '';

                        childData.totalProducts = totalProducts ? totalProducts : 0;

                        if (searchValue) {

                            if (

                                (childData.title && childData.title.toString().toLowerCase().includes(searchValue)) ||

                                (childData.totalProducts && childData.totalProducts.toString().includes(searchValue)) ||

                                (sectionName && sectionName.toString().includes(searchValue))

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

                        if (orderByField === 'totalProducts') {

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

            order: (checkDeletePermission) ? [2, 'asc'] : [1, 'asc'],

            columnDefs: [

                {

                    orderable: false,

                    targets: (checkDeletePermission==true) ? [0,1,5,6] : [0,4,5]

                },

            ],

            "language": {

                "zeroRecords": "{{trans("lang.no_record_found")}}",

                "emptyTable": "{{trans("lang.no_record_found")}}",

                "processing": "" // Remove default loader

            },

        });



        table.columns.adjust().draw();



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



        ref_sections.get().then(async function (snapshots) {



            snapshots.docs.forEach((listval) => {

                var data = listval.data();



                if (data.serviceTypeFlag == "delivery-service" || data.serviceTypeFlag == "ecommerce-service") {

                    $('#section_id').append($("<option></option>")

                        .attr("value", data.id)

                        .text(data.name));

                }



            })



            $('#section_id').val(section_id);

        })



    });



    async function buildHTML(val) {

        var html = [];



        newdate = '';



        var id = val.id;

        var route1 = '{{route("categories.edit",":id")}}';

        route1 = route1.replace(':id', id);

        if (checkDeletePermission) {

            html.push('<td class="delete-all"><input type="checkbox" id="is_open_' + id + '" class="is_open" dataId="' + id + '"><label class="col-3 control-label"\n' +

                'for="is_open_' + id + '" ></label></td>');

        }

        if (val.photo == '') {

            html.push('<td><img class="rounded" style="width:50px" src="' + placeholderImage + '" alt="image"></td>');

        } else {

            html.push('<td><img class="rounded" style="width:50px" src="' + val.photo + '" alt="image" onerror="this.onerror=null;this.src=\'' + placeholderImage + '\'"></td>');

        }



        html.push('<td><a href="' + route1 + '">' + val.title + '</a></td>');



        html.push('<td>' + val.sectionName + '</td>');





        var categoryId = val.id;

        var url = '{{url("items?categoryID=id")}}';

        url = url.replace("id", categoryId);

        html.push('<td ><a href="' + url + '">' + val.totalProducts + '</a></td>');



        if (val.publish) {

            html.push('<td><label class="switch"><input type="checkbox" checked id="' + val.id + '" name="isSwitch"><span class="slider round"></span></label></td>');

        } else {

            html.push('<td><label class="switch"><input type="checkbox" id="' + val.id + '" name="isSwitch"><span class="slider round"></span></label></td>');

        }

        var action = '';

        action = action + '<span class="action-btn"><a href="' + route1 + '"><i class="fa fa-edit"></i></a>';

        if (checkDeletePermission) {

            action = action + '<a id="' + val.id + '" name="category-delete" class="delete-btn" href="javascript:void(0)"><i class="fa fa-trash"></i></a>';

        }

        action = action + '</span>';

        html.push(action)

        return html;

    }



    /* toggal publish action code start*/

    $(document).on("click", "input[name='isSwitch']", function (e) {

        var ischeck = $(this).is(':checked');

        var id = this.id;

        if (ischeck) {

            database.collection('vendor_categories').doc(id).update({

                'publish': true

            }).then(function (result) {



            });

        } else {

            database.collection('vendor_categories').doc(id).update({

                'publish': false

            }).then(function (result) {



            });

        }

    });



    /*toggal publish action code end*/





    async function getSectionName(sectionId) {



        var sectionName = '';

        if (sectionId != '') {

            await database.collection('sections').where("id", "==", sectionId).get().then(async function (snapshots) {



                if (snapshots.docs.length) {

                    var data = snapshots.docs[0].data();

                    sectionName = data.name;

                }

            });

        }



        return sectionName;

    }

    async function getProductTotal(id, section_id) {

        var Product_total = '';

        if (section_id != '') {

            await database.collection('vendor_products').where('categoryID', '==', id).where('section_id', '==', section_id).get().then(async function (productSnapshots) {



                Product_total = productSnapshots.docs.length;



            });



        }

        return Product_total;

    }



    $(document).on("click", "a[name='category-delete']", async function (e) {

        var id = this.id;

        await deleteDocumentWithImage('vendor_categories',id,'photo');

        window.location.href = '{{ route("categories")}}';

    });



    function clickLink(value) {

        setCookie('section_id', value, 30);

        location.reload();

    }



    function clickpage(value) {

        setCookie('pagesizes', value, 30);

        location.reload();

    }



    $("#is_active").click(function () {

        $("#categoryTable .is_open").prop('checked', $(this).prop('checked'));



    });



    $("#deleteAll").click(function () {

        if ($('#categoryTable .is_open:checked').length) {

            if (confirm("{{trans('lang.selected_delete_alert')}}")) {

                jQuery("#data-table_processing").show();

                $('#categoryTable .is_open:checked').each(async function () {

                    var dataId = $(this).attr('dataId');

                    await deleteDocumentWithImage('vendor_categories',dataId,'photo');

                    window.location.reload();

                });

            }

        } else {

            alert("{{trans('lang.select_delete_alert')}}");

        }

    });

</script>



@endsection

