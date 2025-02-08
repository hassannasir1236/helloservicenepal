@extends('layouts.app')



@section('content')



<div class="page-wrapper">

    <div class="row page-titles">



        <div class="col-md-5 align-self-center">

            <h3 class="text-themecolor itemTitle">{{trans('lang.item_plural')}}</h3>

        </div>



        <div class="col-md-7 align-self-center">

            <ol class="breadcrumb">

                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">{{trans('lang.dashboard')}}</a></li>

                <li class="breadcrumb-item active">{{trans('lang.item_plural')}}</li>

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

                <?php if ($id != '') { ?>

                    <div class="menu-tab">

                        <ul>

                            <li>

                                <a href="{{route('vendors.view',$id)}}">{{trans('lang.tab_basic')}}</a>

                            </li>

                            <li class="active">

                                <a href="{{route('vendors.items',$id)}}">{{trans('lang.tab_items')}}</a>

                            </li>

                            <li>

                                <a href="{{route('vendors.orders',$id)}}">{{trans('lang.tab_orders')}}</a>

                            </li>

                            <li>

                                <a href="{{route('vendors.reviews',$id)}}">{{trans('lang.tab_reviews')}}</a>

                            </li>

                            <li>

                                <a href="{{route('vendors.coupons',$id)}}">{{trans('lang.tab_promos')}}</a>

                            <li>

                                <a href="{{route('vendors.payout',$id)}}">{{trans('lang.tab_payouts')}}</a>

                            </li>

                            <li>

                                <a href="{{route('payoutRequests.vendor.view',$id)}}">{{trans('lang.tab_payout_request')}}</a>

                            </li>

                            <li>

                                <a class="wallet_transaction">{{trans('lang.wallet_transaction')}}</a>

                            </li>



                            <li class="dine_in_future" style="display:none;">

                                <a href="{{route('vendors.booktable',$id)}}">{{trans('lang.dine_in_future')}}</a>

                            </li>



                        </ul>

                    </div>

                <?php } ?>



                <div class="card">

                    <div class="card-header">

                        <ul class="nav nav-tabs align-items-end card-header-tabs w-100">

                            <li class="nav-item">

                                <a class="nav-link active" href="{!! url()->current() !!}"><i

                                        class="fa fa-list mr-2"></i>{{trans('lang.item_table')}}</a>

                            </li>

                            <?php if ($id != '') { ?>

                                <li class="nav-item">

                                    <a class="nav-link" href="{!! route('items.create') !!}/{{$id}}"><i

                                            class="fa fa-plus mr-2"></i>{{trans('lang.item_create')}}</a>

                                </li>

                            <?php } else { ?>

                                <li class="nav-item">

                                    <a class="nav-link" href="{!! route('items.create') !!}"><i

                                            class="fa fa-plus mr-2"></i>{{trans('lang.item_create')}}</a>

                                </li>

                            <?php } ?>



                        </ul>

                    </div>

                    <div class="card-body">





                        <div id="users-table_filter" class="pull-right">

                            <div class="row">

                                <div class="col-sm-9">

                                </div>

                                <div class="col-sm-3 sectionDiv">

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

                            <table id="itemTable"

                                class="display nowrap table table-hover table-striped table-bordered table table-striped"

                                cellspacing="0" width="100%">

                                <thead>

                                    <tr>

                                        <?php if (in_array('items.delete', json_decode(@session('user_permissions')))) { ?>



                                            <th class="delete-all"><input type="checkbox" id="is_active"><label

                                                    class="col-3 control-label" for="is_active"><a id="deleteAll"

                                                        class="do_not_delete" href="javascript:void(0)"><i

                                                            class="fa fa-trash"></i> {{trans('lang.all')}}</a></label>

                                            </th>

                                        <?php } ?>

                                        <th>{{trans('lang.item_image')}}</th>

                                        <th>{{trans('lang.item_name')}}</th>

                                        <th>{{trans('lang.item_price')}}</th>

                                        <th>{{trans('lang.section')}}</th>

                                        <?php if ($id == '') { ?>

                                            <th>{{trans('lang.item_vendor_id')}}</th>

                                        <?php } ?>



                                        <th>{{trans('lang.item_category_id')}}</th>



                                        <th>{{trans('lang.brand')}}</th>



                                        <th>{{trans('lang.item_publish')}}</th>

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



    if ($.inArray('items.delete', user_permissions) >= 0) {

        checkDeletePermission = true;

    }

    const urlParams = new URLSearchParams(location.search);

    for (const [key, value] of urlParams) {

        if (key == 'brandID') {

            var brandID = value;

        } else {

            var brandID = '';

        }

        if (key == 'categoryID') {

            var categoryID = value;

        } else {

            var categoryID = '';

        }



    }

    var database = firebase.firestore();

    var currentCurrency = '';

    var currencyAtRight = false;

    var decimal_degits = 0;

    var ref_sections = database.collection('sections');

    var vendorID = "{{$id}}";

    <?php if ($id != '') { ?>

        $('.sectionDiv').hide();


        const getStoreName = getStoreNameFunction('<?php echo $id; ?>');



        var ref = database.collection('vendor_products').where('vendorID', '==', '<?php echo $id; ?>');

        <?php } else { ?>

            var section_id = getCookie('section_id');

            $('.sectionDiv').show();



            if (brandID != '' && brandID != undefined) {

                if (section_id != '') {

                    var ref = database.collection('vendor_products').where('brandID', '==', brandID).where('section_id', '==', section_id);

                } else {

                    var ref = database.collection('vendor_products').where('brandID', '==', brandID);

                }



            } else if (categoryID != '' && categoryID != undefined) {

                if (section_id != '') {

                    var ref = database.collection('vendor_products').where('categoryID', '==', categoryID).where('section_id', '==', section_id);

                } else {

                    var ref = database.collection('vendor_products').where('categoryID', '==', categoryID);

                }

            } else {

                if (section_id != '') {

                    var ref = database.collection('vendor_products').where('section_id', '==', section_id);



                } else {

                    var ref = database.collection('vendor_products');



                }

            }



        <?php } ?>



    async function getStoreNameFunction(vendorId) {

        var vendorName = '';

        await database.collection('vendors').where('id', '==', vendorId).get().then(async function (snapshots) {

            if (snapshots.docs.length > 0) {

                var vendorData = snapshots.docs[0].data();



                vendorName = vendorData.title;

                $('.itemTitle').html("{{trans('lang.item_plural')}} - " + vendorName);



                if (vendorData.dine_in_active == true) {

                    $(".dine_in_future").show();

                }
                var wallet_route = "{{route('users.walletstransaction','id')}}";

                $(".wallet_transaction").attr("href", wallet_route.replace('id', 'storeID=' + vendorData.author));

            }

        });



        return vendorName;



    }



    var refCurrency = database.collection('currencies').where('isActive', '==', true);

    var append_list = '';



    refCurrency.get().then(async function (snapshots) {

        var currencyData = snapshots.docs[0].data();

        currentCurrency = currencyData.symbol;

        currencyAtRight = currencyData.symbolAtRight;



        if (currencyData.decimal_degits) {

            decimal_degits = currencyData.decimal_degits;

        }

    });



    var placeholderImage = '';

    var placeholder = database.collection('settings').doc('placeHolderImage');

    placeholder.get().then(async function (snapshotsimage) {

        var placeholderImageData = snapshotsimage.data();

        placeholderImage = placeholderImageData.image;

    })



    $(document).ready(function () {

        $('#brand_search_dropdown').hide();

        $('#category_search_dropdown').hide();



        $(document.body).on('click', '.redirecttopage', function () {

            var url = $(this).attr('data-url');

            window.location.href = url;

        });



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



        $(document.body).on('change', '#selected_search', function () {



            if (jQuery(this).val() == 'brand') {

                database.collection('brands').get().then(async function (snapshots) {

                    snapshots.docs.forEach((listval) => {

                        var data = listval.data();

                        $('#brand_search_dropdown').append($("<option></option").attr("value", data.id).text(data.title));

                    });



                });

                jQuery('#brand_search_dropdown').show();

                jQuery('#search').hide();

                jQuery('#category_search_dropdown').hide();

            } else if (jQuery(this).val() == 'category') {

                var section_id = getCookie('section_id');

                if (section_id != '') {

                    var ref_category = database.collection('vendor_categories').where('section_id', '==', section_id);

                } else {

                    var ref_category = database.collection('vendor_categories');

                }

                ref_category.get().then(async function (snapshots) {

                    snapshots.docs.forEach((listval) => {

                        var data = listval.data();

                        $('#category_search_dropdown').append($("<option></option").attr("value", data.id).text(data.title));



                    });



                });

                jQuery('#brand_search_dropdown').hide();

                jQuery('#search').hide();

                jQuery('#category_search_dropdown').show();

            } else {

                jQuery('#brand_search_dropdown').hide();

                jQuery('#search').show();

                jQuery('#category_search_dropdown').hide();



            }

        });



        jQuery("#data-table_processing").show();





        const table = $('#itemTable').DataTable({

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

                @if ($id != '')

                    const orderableColumns = (checkDeletePermission) ? ['', '', 'foodName', 'finalPrice', 'section', 'category', 'brand', '', ''] : ['', 'foodName', 'finalPrice', 'section', 'category', 'brand', '', '']; // Ensure this matches the actual column names

                @else

                    const orderableColumns = (checkDeletePermission) ? ['', '', 'foodName', 'finalPrice', 'section', 'store', 'category', 'brand', '', ''] : ['', 'foodName', 'finalPrice', 'section', 'store', 'category', 'brand', '', '']; // Ensure this matches the actual column names

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

                    var storeNames = {};

                    // Fetch restaurants names

                    @if ($id == '')

                        const vendorDocs = await database.collection('vendors').get();

                    vendorDocs.forEach(doc => {

                        storeNames[doc.id] = doc.data().title;

                    });

                    @endif



                    var categoryNames = {};

                    const categoryDocs = await database.collection('vendor_categories').get();

                    categoryDocs.forEach(doc => {

                        categoryNames[doc.id] = doc.data().title;

                    });



                    var sectionNames = {};

                    const sectionDocs = await database.collection('sections').get();

                    sectionDocs.forEach(doc => {

                        sectionNames[doc.id] = doc.data().name;

                    });



                    var brandNames = {};

                    const brandDocs = await database.collection('brands').get();

                    brandDocs.forEach(doc => {

                        brandNames[doc.id] = doc.data().title;

                    });



                    let records = [];

                    let filteredRecords = [];



                    await Promise.all(querySnapshot.docs.map(async (doc) => {

                        let childData = doc.data();

                        childData.id = doc.id; // Ensure the document ID is included in the data

                        var finalPrice = 0;

                        if (childData.hasOwnProperty('disPrice') && childData.disPrice != '' && childData.disPrice != '0') {

                            finalPrice = childData.disPrice;

                        } else {

                            finalPrice = childData.price;

                        }

                        childData.foodName = childData.name;

                        childData.finalPrice = parseInt(finalPrice);

                        childData.store = storeNames[childData.vendorID] || '';

                        childData.category = categoryNames[childData.categoryID] || '';

                        childData.section = sectionNames[childData.section_id] || '';

                        if (childData.hasOwnProperty('brandID') && childData.brandID != '' && childData.brandID != null) {

                            childData.brand = brandNames[childData.brandID] || '';

                        }

                        if (searchValue) {

                            if (

                                (childData.name && childData.name.toString().toLowerCase().includes(searchValue)) ||

                                (childData.finalPrice && childData.finalPrice.toString().includes(searchValue)) ||

                                (childData.store && childData.store.toString().toLowerCase().includes(searchValue)) ||

                                (childData.category && childData.category.toString().toLowerCase().includes(searchValue)) ||

                                (childData.brand && childData.brand.toString().toLowerCase().includes(searchValue)) ||

                                (childData.section && childData.section.toString().toLowerCase().includes(searchValue))



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

                        if (orderByField === 'finalPrice') {

                            aValue = a[orderByField] ? parseInt(a[orderByField]) : 0;

                            bValue = b[orderByField] ? parseInt(b[orderByField]) : 0;

                        }

                        else if (orderByField === 'brand' && orderByField != null && orderByField != '') {

                            aValue = a[orderByField] ? a[orderByField].toString().toLowerCase().trim() : '';

                            bValue = b[orderByField] ? b[orderByField].toString().toLowerCase().trim() : ''



                        }

                        else {

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

                targets: (vendorID == '') ? ((checkDeletePermission) ? [0, 1, 8, 9] : [0, 7, 8]) : ((checkDeletePermission) ? [0, 1, 7, 8] : [0, 6, 7])

            },

            {

                type: 'formatted-num',

                targets: (checkDeletePermission) ? [3] : [2]

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

    var route1 = '{{route("items.edit",":id")}}';

    route1 = route1.replace(':id', id);



    <?php if ($id != '') { ?>



        route1 = route1 + '?eid={{$id}}';



    <?php } ?>



    var vendorroute = '{{route("vendors.view",":id")}}';

    vendorroute = vendorroute.replace(':id', val.vendorID);

    if (checkDeletePermission) {

        html.push('<input type="checkbox" id="is_open_' + id + '" class="is_open" dataId="' + id + '"><label class="col-3 control-label"\n' +

            'for="is_open_' + id + '" ></label>');

    }

    if (val.photo != '') {

        html.push('<img class="rounded" style="width:50px" src="' + val.photo + '" alt="image" onerror="this.onerror=null;this.src=\'' + placeholderImage + '\'">');



    } else {



        html.push('<img class="rounded" style="width:50px" src="' + placeholderImage + '" alt="image">');

    }

    html.push('<a href="' + route1 + '" class="redirecttopage">' + val.name + '</a>');





    if (val.hasOwnProperty('disPrice') && val.disPrice != '' && val.disPrice != '0') {

        if (currencyAtRight) {

            html.push(parseFloat(val.disPrice).toFixed(decimal_degits) + '' + currentCurrency + '  <s>' + parseFloat(val.price).toFixed(decimal_degits) + '' + currentCurrency + '</s>');

        } else {

            html.push(currentCurrency + parseFloat(val.disPrice).toFixed(decimal_degits) + '  <s>' + currentCurrency + '' + parseFloat(val.price).toFixed(decimal_degits) + '</s>');

        }



    } else {



        if (currencyAtRight) {

            html.push(parseFloat(val.price).toFixed(decimal_degits) + '' + currentCurrency);

        } else {

            html.push(currentCurrency + '' + parseFloat(val.price).toFixed(decimal_degits));

        }

    }



    if (val.section_id != undefined) {

        html.push(val.section);



    } else {

        html.push('');



    }



    <?php if ($id == '') { ?>

        if (val.store == '') {

            vendorroute = "Javascript:void(0)";

            vendor = '{{trans("lang.unknown")}}'

        }

        html.push('<a href="' + vendorroute + '">' + val.store + '</a>');

    <?php } ?>



    var caregoryroute = '{{route("categories.edit",":id")}}';

    caregoryroute = caregoryroute.replace(':id', val.categoryID);

    if (val.category == '') {

        caregoryroute = "Javascript:void(0)";

        category = '{{trans("lang.unknown")}}'

    }

    html.push('<a href="' + caregoryroute + '">' + val.category + '</a>');



    var brandroute = "Javascript:void(0)";

    if (val.hasOwnProperty('brandID') && val.brandID != '' && val.brandID != null) {

        brandroute = '{{route("brands.edit",":id")}}';

        brandroute = brandroute.replace(':id', val.brandID);

        var brand = val.brand;

        if (val.brand == '') {

            brandroute = "Javascript:void(0)";

            brand = '{{trans("lang.unknown")}}';

        }

    } else {

        var brand = '';

    }



    html.push('<a href="' + brandroute + '">' + brand + '</a>');



    if (val.publish) {

        html.push('<label class="switch"><input type="checkbox" checked id="' + val.id + '" name="isActive"><span class="slider round"></span></label>');

    } else {

        html.push('<label class="switch"><input type="checkbox" id="' + val.id + '" name="isActive"><span class="slider round"></span></label>');

    }

    var actionHtml = '';

    actionHtml = actionHtml + '<span class="action-btn"><a href="' + route1 + '" class="link-td"><i class="fa fa-edit"></i></a>';

    if (checkDeletePermission) {

        actionHtml = actionHtml + '<a id="' + val.id + '" name="item-delete" href="javascript:void(0)" class="delete-btn"><i class="fa fa-trash"></i></a>';

    }

    actionHtml = actionHtml + '</span>';

    html.push(actionHtml);

    return html;

}



$(document).on("click", "input[name='isActive']", function (e) {

    var ischeck = $(this).is(':checked');

    var id = this.id;

    if (ischeck) {

        database.collection('vendor_products').doc(id).update({

            'publish': true

        }).then(function (result) {



        });

    } else {

        database.collection('vendor_products').doc(id).update({

            'publish': false

        }).then(function (result) {



        });

    }



});



$("#is_active").click(function () {

    $("#itemTable .is_open").prop('checked', $(this).prop('checked'));



});



$("#deleteAll").click(function () {

    if ($('#itemTable .is_open:checked').length) {

        if (confirm("{{trans('lang.selected_delete_alert')}}")) {

            jQuery("#data-table_processing").show();

            $('#itemTable .is_open:checked').each(function () {

                var dataId = $(this).attr('dataId');

                deleteDocumentWithImage('vendor_products', dataId, 'photo', 'photos')

                .then(() => {

                    return deleteProductData(dataId);

                })

                .then(() => {

                    setTimeout(function () {

                        window.location.reload();

                    }, 5000);

                })

                .catch((error) => {

                    console.error("Error occurred during deletion process:", error);

                });

            });

        }

    } else {

        alert("{{trans('lang.select_delete_alert')}}");

    }

});



async function productsection(section) {

    var productsection = '';

    await database.collection('sections').where("id", "==", section).get().then(async function (snapshotss) {



        if (snapshotss.docs[0]) {

            var section_data = snapshotss.docs[0].data();

            productsection = section_data.name;



        }

    });

    return productsection;

}



async function productvendor(vendor) {

    var productvendor = '';

    await database.collection('vendors').where("id", "==", vendor).get().then(async function (snapshotss) {

        var vendorroute = '{{route("vendors.edit",":id")}}';

        vendorroute = vendorroute.replace(':id', vendor);



        if (snapshotss.docs[0]) {

            var vendor_data = snapshotss.docs[0].data();

            productvendor = vendor_data.title;

        }

    });

    return productvendor;

}



async function productCategory(category) {

    var productCategory = '';

    await database.collection('vendor_categories').where("id", "==", category).get().then(async function (snapshotss) {

        var caregoryroute = '{{route("categories.edit",":id")}}';

        caregoryroute = caregoryroute.replace(':id', category);

        if (snapshotss.docs[0]) {

            var category_data = snapshotss.docs[0].data();

            productCategory = category_data.title;

        }

    });

    return productCategory;

}



async function productBrand(brand) {

    var productBrand = '';

    await database.collection('brands').where("id", "==", brand).get().then(async function (snapshotss) {



        if (snapshotss.docs[0]) {

            var brand_data = snapshotss.docs[0].data();

            productBrand = brand_data.title;



        }

    });

    return productBrand;

}



$(document).on("click", "a[name='item-delete']", function (e) {

    var id = this.id;

    jQuery("#data-table_processing").show();

    deleteDocumentWithImage('vendor_products', id, 'photo', 'photos')

    .then(() => {

        return deleteProductData(id);

    })

    .then(() => {

        setTimeout(function () {

            window.location.reload();

        }, 5000);

    })

    .catch((error) => {

        console.error("Error occurred during deletion process:", error);

    });

});



function clickLink(value) {

    setCookie('section_id', value, 30);

    location.reload();

}

async function deleteProductData(productId) {

    await database.collection('favorite_item').where('product_id', '==', productId).get().then(async function (snapshotsItem) {



        if (snapshotsItem.docs.length > 0) {

            snapshotsItem.docs.forEach((temData) => {

                var item_data = temData.data();



                database.collection('favorite_item').doc(item_data.id).delete().then(function () {



                });

            });

        }



    });

}

</script>



@endsection

