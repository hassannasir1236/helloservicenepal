@php
$user=Auth::user();
$role_has_permission = App\Models\Permission::where('role_id',$user->role_id)->pluck('permission')->toArray();
@endphp

<nav class="sidebar-nav">

    <ul id="sidebarnav">

        <li>
            <a class="waves-effect waves-dark" href="{!! url('dashboard') !!}" aria-expanded="false">
                <i class="mdi mdi-home"></i>
                <span class="hide-menu">{{trans('lang.dashboard')}}</span>
            </a>
        </li>

        @if(in_array('section-service',$role_has_permission))

        <li><a class="waves-effect waves-dark" href="{!! url('section') !!}" aria-expanded="false">
                <i class="mdi mdi-clipboard-text"></i>
                <span class="hide-menu">{{trans('lang.section_plural')}}</span>
            </a>
        </li>

        @endif
        @if(in_array('admins',$role_has_permission) || in_array('roles',$role_has_permission))

        <li><a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">

                <i class="mdi mdi-lock-outline"></i>

                <span class="hide-menu">{{trans('lang.access_control')}}</span>

            </a>

            <ul aria-expanded="false" class="collapse">

                @if(in_array('roles',$role_has_permission))
                <li><a href="{!! url('role') !!}">{{trans('lang.role_plural')}}</a></li>
                @endif

                @if(in_array('admins',$role_has_permission))
                <li><a href="{!! url('admin-users') !!}">{{trans('lang.admin_plural')}}</a></li>
                @endif


            </ul>

        </li>

        @endif
        @if(in_array('users',$role_has_permission))

        <li>
            <a class="waves-effect waves-dark" href="{!! url('users') !!}" aria-expanded="false">
                <i class="mdi mdi-account-multiple"></i>
                <span class="hide-menu">{{trans('lang.user_customer')}}</span>
            </a>
        </li>
        @endif
        @if(in_array('vendors',$role_has_permission))

        <li>
            <a class="waves-effect waves-dark" href="{!! url('owners') !!}" aria-expanded="false">

                <i class="mdi mdi-account-multiple"></i>

                <span class="hide-menu">{{trans('lang.owner_vendor')}}</span>

            </a>
        </li>
        @endif

        @if(in_array('providers',$role_has_permission))
        <li>
            <a class="waves-effect waves-dark" href="{!! url('providers') !!}" aria-expanded="false">

                <i class="mdi mdi-account-multiple"></i>

                <span class="hide-menu">{{trans('lang.provider_plural')}}</span>

            </a>
        </li>
        @endif

        @if(in_array('stores',$role_has_permission) || in_array('drivers',$role_has_permission) || in_array('categories',$role_has_permission)
        || in_array('brands',$role_has_permission) || in_array('destinations',$role_has_permission) || in_array('item-attributes',$role_has_permission)
        || in_array('review-attributes',$role_has_permission) || in_array('report',$role_has_permission) || in_array('items',$role_has_permission)
        || in_array('god-eye',$role_has_permission) || in_array('orders',$role_has_permission) || in_array('gift-cards',$role_has_permission)
        || in_array('coupons',$role_has_permission) || in_array('banners',$role_has_permission))

        <li class="nav-subtitle">
            <span class="nav-subtitle-span">{{trans('lang.ecommerce_multivendor')}}</span>
        </li>

        @endif

        @if(in_array('stores',$role_has_permission))


        <li><a class="waves-effect waves-dark" href="{!! url('vendors') !!}" aria-expanded="false">
                <i class="mdi mdi-shopping"></i>
                <span class="hide-menu">{{trans('lang.vendor_plural')}}</span>
            </a>
        </li>
        @endif

        @if(in_array('drivers',$role_has_permission))

        <li><a class="waves-effect waves-dark" href="{!! url('drivers') !!}" aria-expanded="false">
                <i class="mdi mdi-car"></i>
                <span class="hide-menu">{{trans('lang.driver_plural')}}</span>
            </a>
        </li>
        @endif

        @if(in_array('categories',$role_has_permission))
        <li><a class="waves-effect waves-dark" href="{!! url('categories') !!}" aria-expanded="false">
                <i class="mdi mdi-clipboard-text"></i>
                <span class="hide-menu">{{trans('lang.category_plural')}}</span>
            </a>
        </li>
        @endif

        @if(in_array('brands',$role_has_permission))
        <li><a class="waves-effect waves-dark" href="{!! url('brands') !!}" aria-expanded="false">
                <i class="mdi mdi-domain"></i>
                <span class="hide-menu">{{trans('lang.brand')}}</span>
            </a>
        </li>
        @endif

        @if(in_array('destinations',$role_has_permission))

        <li><a class="waves-effect waves-dark" href="{!! url('destinations') !!}" aria-expanded="false">
                <i class="mdi mdi-account-location"></i>
                <span class="hide-menu">{{trans('lang.destination')}}</span>
            </a>
        </li>
        @endif

        @if(in_array('item-attributes',$role_has_permission) || in_array('review-attributes',$role_has_permission))
        <li><a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                <i class="mdi mdi-plus-box"></i>
                <span class="hide-menu">{{trans('lang.attribute_plural')}}</span>
            </a>

            <ul aria-expanded="false" class="collapse">

                @if(in_array('item-attributes',$role_has_permission))
                <li><a href="{!! url('attributes') !!}">{{trans('lang.item_attribute_plural')}}</a></li>
                @endif
                @if(in_array('review-attributes',$role_has_permission))

                <li><a href="{!! url('reviewattributes') !!}">{{trans('lang.review_attribute_plural')}}</a></li>
                @endif
            </ul>

        </li>

        @endif

        @if(in_array('report',$role_has_permission))

        <li><a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">

                <i class="mdi mdi-calendar-check"></i>

                <span class="hide-menu">{{trans('lang.report_plural')}}</span>

            </a>

            <ul aria-expanded="false" class="collapse">

                <li><a href="{!! url('/report/sales') !!}">{{trans('lang.reports_sale')}}</a></li>

            </ul>

        </li>
        @endif

        @if(in_array('items',$role_has_permission))

        <li><a class="waves-effect waves-dark" href="{!! url('items') !!}" aria-expanded="false">
                <i class="mdi mdi-cart"></i>
                <span class="hide-menu">{{trans('lang.item_plural')}}</span>
            </a>
        </li>
        @endif

        @if(in_array('god-eye',$role_has_permission))
        <li>
            <a class="waves-effect waves-dark" href="{!! url('map/multivendor') !!}" aria-expanded="false">
                <i class="mdi mdi-home-map-marker"></i>
                <span class="hide-menu">{{trans('lang.god_eye')}}</span>
            </a>
        </li>
        @endif

        @if(in_array('orders',$role_has_permission))
        <li><a class="waves-effect waves-dark" href="{!! url('orders') !!}" aria-expanded="false">
                <i class="mdi mdi-library-books"></i>
                <span class="hide-menu">{{trans('lang.order_plural')}}</span>
            </a>
        </li>
        @endif

        @if(in_array('gift-cards',$role_has_permission))
        <li><a class="waves-effect waves-dark" href="{!! url('gift-card') !!}" aria-expanded="false">
                <i class="mdi mdi-wallet-giftcard"></i>
                <span class="hide-menu">{{trans('lang.gift_card_plural')}}</span>
            </a>
        </li>
        @endif

        @if(in_array('coupons',$role_has_permission))
        <li><a class="waves-effect waves-dark" href="{!! url('coupons') !!}" aria-expanded="false">
                <i class="mdi mdi-sale"></i>
                <span class="hide-menu">{{trans('lang.coupon_plural')}}</span>
            </a>
        </li>
        @endif

        @if(in_array('banners',$role_has_permission))

        <li><a class="waves-effect waves-dark" href="{!! url('banners') !!}" aria-expanded="false">
                <i class="mdi mdi-monitor-multiple "></i>
                <span class="hide-menu">{{trans('lang.menu_items')}}</span>
            </a>
        </li>
        @endif

        @if(in_array('parcel-service-god-eye',$role_has_permission) || in_array('parcel-categories',$role_has_permission) || in_array('parcel-weight',$role_has_permission)
        || in_array('parcel-coupons',$role_has_permission) || in_array('parcel-orders',$role_has_permission) || in_array('cab-service-god-eye',$role_has_permission)
        || in_array('rides',$role_has_permission) || in_array('sos-rides',$role_has_permission) || in_array('cab-promo',$role_has_permission)
        || in_array('complaints',$role_has_permission) || in_array('cab-vehicle-type',$role_has_permission) || in_array('rental-plural-god-eye',$role_has_permission)
        || in_array('rental-vehicle-type',$role_has_permission) || in_array('rental-discount',$role_has_permission) || in_array('rental-orders',$role_has_permission)
        || in_array('rental-vehicle',$role_has_permission) || in_array('make',$role_has_permission) || in_array('model',$role_has_permission))

        <li class="nav-subtitle">
            <span class="nav-subtitle-span">{{trans('lang.other_services')}}</span>
        </li>
        @endif

        @if(in_array('ondemand-categories',$role_has_permission) || in_array('ondemand-banners',$role_has_permission)
        || in_array('ondemand-services',$role_has_permission) || in_array('ondemand-workers',$role_has_permission) || in_array('ondemand-bookings',$role_has_permission))

        <li>
            <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                <i class="mdi mdi-package"></i>
                <span class="hide-menu">{{trans('lang.ondemand_plural')}}</span>
            </a>

            <ul aria-expanded="false" class="collapse">

                @if(in_array('ondemand-categories',$role_has_permission))
                <li><a href="{!! url('ondemand-categories') !!}">{{ trans('lang.category') }} </a></li>
                @endif

                @if(in_array('ondemand-coupons',$role_has_permission))
                <li><a href="{!! url('ondemand-coupons') !!}">{{ trans('lang.coupon_plural') }} </a></li>
                @endif

                @if(in_array('ondemand-services',$role_has_permission))
                <li><a href="{!! url('ondemand-services') !!}">{{ trans('lang.service_plural') }} </a></li>
                @endif

                @if(in_array('ondemand-workers',$role_has_permission))
                <li><a href="{!! url('ondemand-workers') !!}">{{ trans('lang.worker_plural') }} </a></li>
                @endif

                @if(in_array('ondemand-bookings',$role_has_permission))
                <li><a href="{!! url('ondemand-bookings') !!}">{{ trans('lang.booking_plural') }} </a></li>
                @endif

            </ul>
        </li>
        @endif

        <li>
            <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                <i class="mdi mdi-package"></i>
                <span class="hide-menu">{{trans('lang.go_ride')}}</span>
            </a>

            <ul aria-expanded="false" class="collapse">

                <li>
                    <a class="waves-effect waves-dark" href="{!! url('zone') !!}" aria-expanded="false">

                        <!-- <i class="mdi mdi-map-marker-circle"></i> -->

                        <span class="hide-menu">{{trans('lang.zone')}}</span>

                    </a>
                </li>


                <li>
                    <a class="has-arrow waves-effect waves-dark document_menu" href="#" aria-expanded="false">

                        <!-- <i class="mdi mdi-file-document"></i> -->

                        <span class="hide-menu">{{trans('lang.document_plural')}}</span>

                    </a>

                    <ul aria-expanded="false" class="collapse document_sub_menu">

                        <li class="all_document_menu">
                            <a href="{!! url('documents') !!}">{{trans('lang.all_document_plural')}}</a>
                        </li>
                        <li class="deleted_document_menu">
                            <a href="{!! url('documents/deleted') !!}">{{trans('lang.deleted_document_plural')}}</a>
                        </li>
                    </ul>

                </li>

                <li>
                    <a class="has-arrow waves-effect waves-dark report_menu" href="#" aria-expanded="false">
                        <i class="mdi mdi-calendar-check"></i>
                        <span class="hide-menu">{{trans('lang.report_plural')}}</span>
                    </a>
                    <ul aria-expanded="false" class="collapse report_sub_menu">
                        <li><a href="{!! url('reports/user') !!}">{{trans('lang.reports_user')}}</a></li>
                        <li><a href="{!! url('reports/driver') !!}">{{trans('lang.reports_driver')}}</a></li>
                        <li><a href="{!! url('reports/ride') !!}">{{trans('lang.reports_ride')}}</a></li>
                        <li><a href="{!! url('reports/intercity') !!}">{{trans('lang.intercity_report')}}</a></li>
                        <li><a href="{!! url('reports/transaction') !!}">{{trans('lang.reports_transaction')}}</a></li>

                    </ul>

                </li>

                <li>
                    <a class="has-arrow waves-effect waves-dark rides_menu" href="#" aria-expanded="false">
                        <i class="mdi mdi-map-marker-multiple"></i>
                        <span class="hide-menu">{{trans('lang.rides')}}</span>
                    </a>
                    <ul aria-expanded="false" class="collapse ride_sub_menu">
                        <li class="services_menu"><a href="{!! url('services') !!}">{{trans('lang.service_plural')}}</a></li>
                        <li class="rides_menu"><a href="{!! url('rides') !!}">{{trans('lang.ride_order_plural')}}</a></li>
                    </ul>
                </li>

                <li>
                    <a class="has-arrow waves-effect waves-dark intercity_service_menu" href="#" aria-expanded="false">
                        <i class="mdi mdi-city"></i>
                        <span class="hide-menu">{{trans('lang.intercity')}}</span>
                    </a>
                    <ul aria-expanded="false" class="collapse intercity_service_sub_menu">
                        <li class="intercity_service_menu"><a
                                    href="{!! url('intercity-service') !!}">{{trans('lang.intercity_service_plural')}}</a></li>
                        <li class="intercity_service_menu"><a
                                    href="{!! url('intercity-service-rides') !!}">{{trans('lang.intercity_order_plural')}}</a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a class="has-arrow waves-effect waves-dark freight_menu" href="#" aria-expanded="false">
                        <i class="mdi mdi-truck"></i>
                        <span class="hide-menu">{{trans('lang.freight')}}</span>
                    </a>
                    <ul aria-expanded="false" class="collapse freight_sub_menu">
                        <li class="freight_vehicle_menu"><a
                                    href="{!! url('freight-vehicles') !!}">{{trans('lang.freight_vehicles')}}</a></li>
                    </ul>
                </li>

                    <li>
                        <a class="waves-effect waves-dark airport_menu" href="{!! url('airports') !!}" aria-expanded="false">
                            <i class="mdi mdi-airplane"></i>
                            <span class="hide-menu">{{trans('lang.airports')}}</span>
                        </a>

                    </li>

                    <li>
                        <a class="waves-effect waves-dark vehicle_type_menu" href="{!! url('vehicle-type') !!}"
                        aria-expanded="false">

                            <i class="mdi mdi-car"></i>

                            <span class="hide-menu">{{trans('lang.vehicle_type')}}</span>

                        </a>
                    </li>

                    <li>
                        <a class="has-arrow waves-effect waves-dark driver_rules_menu" href="#" aria-expanded="false">
                            <i class="mdi mdi-playlist-check"></i>
                            <span class="hide-menu">{{trans('lang.driver_rule_plural')}}</span>
                        </a>
                        <ul aria-expanded="false" class="collapse driver_rules_sub_menu">
                            <li class="all_driver_rules_menu"><a
                                        href="{!! url('driver-rules') !!}">{{trans('lang.all_driver_rule_plural')}}</a></li>
                            <li class="deleted_driver_rules_menu"><a
                                        href="{!! url('driver-rules/deleted') !!}">{{trans('lang.deleted_driver_rule_plural')}}</a>
                            </li>
                        </ul>
                    </li>


                    <li><a class="waves-effect waves-dark faq_menu" href="{!! url('faq') !!}" aria-expanded="false">
                            <i class="mdi mdi-comment-question-outline"></i>
                            <span class="hide-menu">{{trans('lang.faq_plural')}}</span>
                        </a>
                    </li>
                    <!-- <li><a class="waves-effect waves-dark sos_menu" href="{!! url('sos') !!}" aria-expanded="false">
                            <i class="mdi mdi-heart-pulse"></i>
                            <span class="hide-menu">{{trans('lang.sos')}}</span>
                        </a>
                    </li> -->

                    <!-- <li>
                        <a class="has-arrow waves-effect waves-dark coupon_menu" href="#" aria-expanded="false">

                            <i class="mdi mdi-ticket-percent"></i>

                            <span class="hide-menu">{{trans('lang.coupon_plural')}}</span>

                        </a>

                        <ul aria-expanded="false" class="collapse coupon_sub_menu">
                            <li class="all_coupon_menu"><a href="{!! url('coupons') !!}">{{trans('lang.all_coupon_plural')}}</a>
                            </li>
                            <li class="deleted_coupon_menu"><a
                                        href="{!! url('coupons/deleted') !!}">{{trans('lang.deleted_coupon_plural')}}</a></li>
                        </ul>

                    </li> -->


            </ul>
        </li>



        <li>
            <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                <i class="mdi mdi-package"></i>
                <span class="hide-menu">{{trans('lang.e_classified')}}</span>
            </a>

            <ul aria-expanded="false" class="collapse">

                <li>
                    <a class="waves-effect waves-dark" href="{!! url('echome') !!}" aria-expanded="false">

                        <span class="hide-menu">{{trans('lang.e_dashboard')}}</span>

                    </a>
                </li>
                <li>
                    <a class="waves-effect waves-dark" href="{!! url('EClassify/category') !!}" aria-expanded="false">

                        <span class="hide-menu">{{trans('lang.category_plural')}}</span>

                    </a>
                </li>
                <li>
                    <a class="waves-effect waves-dark" href="{!! url('EClassify/custom-fields') !!}" aria-expanded="false">

                        <span class="hide-menu">{{trans('lang.custom_fields_plural')}}</span>

                    </a>
                </li>
                <li>
                    <a class="waves-effect waves-dark" href="{{ Route('item.index') }}" class='sidebar-link'>
                        <i class="bi bi-ui-radios-grid"></i>
                        <span class="menu-item">{{ __('Items') }}</span>
                    </a>
                </li>
                <li>
                    <a class="waves-effect waves-dark" href="{{ route('tips.index') }}" class='sidebar-link'>
                        <i class="bi bi-info-circle"></i>
                        <span class="menu-item">{{ __('Tips') }}</span>
                    </a>
                </li>
                <li>
                    <a class="waves-effect waves-dark" href="{{ route('package.index') }}" class='sidebar-link'>
                        <i class="bi bi-list"></i>
                        <span class="menu-item">{{ __('Item Listing Package') }}</span>
                    </a>
                </li>
                <li>
                    <a class="waves-effect waves-dark" href="{{ route('package.advertisement.index') }}" class='sidebar-link'>
                        <i class="bi bi-badge-ad"></i>
                        <span class="menu-item">{{ __('Advertisement Package') }}</span>
                    </a>
                </li>
                <li>
                    <a class="waves-effect waves-dark" href="{{ route('package.users.index') }}" class='sidebar-link'>
                        <i class="bi bi-person-badge-fill"></i>
                        <span class="menu-item">{{ __('User Packages') }}</span>
                    </a>
                </li>
                <li>
                    <a class="waves-effect waves-dark" href="{{ route('package.payment-transactions.index') }}" class='sidebar-link'>
                        <i class="bi bi-cash-coin"></i>
                        <span class="menu-item">{{ __('Payment Transactions') }}</span>
                    </a>
                </li>
                <!-- <li>
                    <a class="has-arrow waves-effect waves-dark document_menu" href="#" aria-expanded="false">

                        <span class="hide-menu">{{trans('lang.document_plural')}}</span>

                    </a>

                    <ul aria-expanded="false" class="collapse document_sub_menu">
                        <li class="all_document_menu">
                            <a href="{!! url('documents') !!}">{{trans('lang.e_dashboard')}}</a>
                        </li>
                        <li class="all_document_menu">
                            <a href="{!! url('documents') !!}">{{trans('lang.all_document_plural')}}</a>
                        </li>
                        <li class="deleted_document_menu">
                            <a href="{!! url('documents/deleted') !!}">{{trans('lang.deleted_document_plural')}}</a>
                        </li>
                    </ul>

                </li> -->


            </ul>
        </li>

        @if(in_array('parcel-service-god-eye',$role_has_permission) || in_array('parcel-categories',$role_has_permission) || in_array('parcel-weight',$role_has_permission)
        || in_array('parcel-coupons',$role_has_permission) || in_array('parcel-orders',$role_has_permission))

        <li><a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                <i class="mdi mdi-package"></i>
                <span class="hide-menu">{{trans('lang.parcel_plural')}}</span>
            </a>


            <ul aria-expanded="false" class="collapse">

                @if(in_array('parcel-service-god-eye',$role_has_permission))
                <li><a href="{!! url('map/parcel') !!}">{{ trans('lang.god_eye') }} </a></li>
                @endif
                @if(in_array('parcel-categories',$role_has_permission))

                <li><a href="{!! url('parcelCategory') !!}">{{ trans('lang.parcel_category') }} </a></li>
                @endif
                @if(in_array('parcel-weight',$role_has_permission))

                <li><a href="{!! url('parcel_weight') !!}">{{ trans('lang.parcel_weight') }} </a></li>
                @endif
                @if(in_array('parcel-coupons',$role_has_permission))

                <li><a href="{!! url('parcel_coupons') !!}">{{ trans('lang.parcel_coupons') }}</a></li>
                @endif
                @if(in_array('parcel-orders',$role_has_permission))

                <li><a href="{!! url('parcel_orders') !!}">{{trans('lang.parcel_orders')}}</a></li>
                @endif

            </ul>
        </li>
        @endif
        @if(in_array('cab-service-god-eye',$role_has_permission) || in_array('rides',$role_has_permission) || in_array('sos-rides',$role_has_permission)
        || in_array('cab-promo',$role_has_permission) || in_array('complaints',$role_has_permission)
        || in_array('cab-vehicle-type',$role_has_permission))

        <li><a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                <i class="mdi mdi-car"></i>
                <span class="hide-menu">{{trans('lang.cab_service')}}</span>
            </a>

            <ul aria-expanded="false" class="collapse">
                @if(in_array('cab-service-god-eye',$role_has_permission))
                <li><a href="{!! url('map/cab') !!}">{{ trans('lang.god_eye') }} </a></li>
                @endif
                @if(in_array('rides',$role_has_permission))

                <li><a href="{!! url('rides') !!}">{{ trans('lang.rides') }} </a></li>
                @endif
                @if(in_array('sos-rides',$role_has_permission))

                <li><a href="{!! url('sos') !!}">{{ trans('lang.sos_ride') }} </a></li>
                @endif
                @if(in_array('cab-promo',$role_has_permission))

                <li><a class="waves-effect waves-dark" href="{!! url('settings/promos') !!}"
                       aria-expanded="false">
                        <span class="hide-menu">{{trans('lang.promo_pural')}}</span>
                    </a>
                </li>
                @endif
                @if(in_array('complaints',$role_has_permission))

                <li><a class="waves-effect waves-dark" href="{!! url('complaints') !!}" aria-expanded="false">
                        <span class="hide-menu">{{trans('lang.complaints')}}</span>
                    </a>
                </li>
                @endif
                @if(in_array('cab-vehicle-type',$role_has_permission))

                <li><a class="waves-effect waves-dark" href="{!! url('vehicleType') !!}" aria-expanded="false">
                        {{trans('lang.cab')}} {{trans('lang.vehicle_type')}}
                    </a>

                </li>
                @endif
            </ul>
        </li>

        @endif

        @if(in_array('rental-plural-god-eye',$role_has_permission) || in_array('rental-vehicle-type',$role_has_permission) || in_array('rental-discount',$role_has_permission)
        || in_array('rental-orders',$role_has_permission) || in_array('rental-vehicle',$role_has_permission))

        <li><a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                <i class="mdi mdi-package"></i>
                <span class="hide-menu">{{trans('lang.rental_plural')}}</span>
            </a>

            <ul aria-expanded="false" class="collapse">

                @if(in_array('rental-plural-god-eye',$role_has_permission))
                <li><a href="{!! url('map/rental') !!}">{{ trans('lang.god_eye') }} </a></li>
                @endif
                @if(in_array('rental-vehicle-type',$role_has_permission))

                <li><a class="waves-effect waves-dark" href="{!! url('rentalvehicleType') !!}"
                       aria-expanded="false">{{trans('lang.rental_vehicle_type')}}</a>
                </li>
                @endif
                @if(in_array('rental-discount',$role_has_permission))

                <li><a class="waves-effect waves-dark" href="{!! url('rentaldiscount') !!}"
                       aria-expanded="false">{{trans('lang.rental_discount')}}</a>
                </li>
                @endif
                @if(in_array('rental-orders',$role_has_permission))
                <li><a href="{!! url('rental_orders') !!}">{{trans('lang.rental_orders')}} </a></li>
                @endif
                @if(in_array('rental-vehicle',$role_has_permission))

                <li><a class="waves-effect waves-dark" href="{!! url('rentalvehicle') !!}"
                       aria-expanded="false">{{trans('lang.rental_vehicle')}}</a>
                </li>
                @endif
            </ul>
        </li>

        @endif

        @if(in_array('make',$role_has_permission) || in_array('model',$role_has_permission))
        <li><a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                <i class="fa fa-taxi"></i>
                <span class="hide-menu">{{trans('lang.vehicle_manage')}}</span>
            </a>

            <ul aria-expanded="false" class="collapse">
                @if(in_array('make',$role_has_permission))
                <li><a class="waves-effect waves-dark" href="{!! url('carMake') !!}"
                       aria-expanded="false">{{trans('lang.make')}}</a>
                </li>
                @endif
                @if(in_array('model',$role_has_permission))
                <li><a class="waves-effect waves-dark" href="{!! url('carModel') !!}"
                       aria-expanded="false">{{trans('lang.model')}}</a>
                </li>
                @endif
            </ul>
        </li>
        @endif

        @if(in_array('general-notifications',$role_has_permission) || in_array('dynamic-notifications',$role_has_permission) || in_array('email-template',$role_has_permission)
        || in_array('cms',$role_has_permission)  || in_array('global-setting',$role_has_permission)
        || in_array('currency',$role_has_permission) || in_array('payment-method',$role_has_permission)
        || in_array('radius',$role_has_permission) || in_array('tax',$role_has_permission) || in_array('delivery-charge',$role_has_permission)
        || in_array('language',$role_has_permission) || in_array('special-offer',$role_has_permission) || in_array('terms',$role_has_permission)
        || in_array('privacy',$role_has_permission) || in_array('home-page',$role_has_permission) || in_array('footer',$role_has_permission)
        || in_array('stores-payment',$role_has_permission) || in_array('stores-payout',$role_has_permission) || in_array('drivers-payment',$role_has_permission)
        || in_array('drivers-payout',$role_has_permission) || in_array('provider-payout',$role_has_permission) || in_array('wallet-transaction',$role_has_permission) || in_array('payout-request',$role_has_permission))

        <li class="nav-subtitle"><span class="nav-subtitle-span">{{trans('lang.other_settings')}}</span></li>

        @endif
        @if(in_array('general-notifications',$role_has_permission) || in_array('dynamic-notifications',$role_has_permission))

        <li><a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                <i class="mdi mdi-comment-alert"></i>
                <span class="hide-menu">{{trans('lang.notifications')}}</span>
            </a>

            <ul aria-expanded="false" class="collapse">

                @if(in_array('general-notifications',$role_has_permission))
                <li>
                    <a href="{!! url('notification') !!}">{{ trans('lang.send_notification') }}</a>
                </li>
                @endif
                @if(in_array('dynamic-notifications',$role_has_permission))

                <li><a href="{!! url('dynamic-notification') !!}">{{trans('lang.dynamic_notification')}}</a>
                </li>
                @endif

            </ul>

        </li>

        @endif

        @if(in_array('on-board', $role_has_permission))
        <li><a class="waves-effect waves-dark onboard_menu" href="{!! url('on-board') !!}" aria-expanded="false">
                <i class="mdi mdi-cellphone"></i>
                <span class="hide-menu">{{trans('lang.on_board_plural')}}</span>
            </a>
        </li>
        @endif

        @if(in_array('email-template',$role_has_permission))

        <li><a class="waves-effect waves-dark" href="{!! url('email-templates') !!}" aria-expanded="false">
                <i class="mdi mdi-email"></i>
                <span class="hide-menu">{{trans('lang.email_templates')}}</span>
            </a>
        </li>

        @endif
        @if(in_array('cms',$role_has_permission))

        <li><a class="waves-effect waves-dark" href="{!! url('cms') !!}" aria-expanded="false">
                <i class="mdi mdi-book-open-page-variant"></i>
                <span class="hide-menu">{{trans('lang.cms_plural')}}</span>
            </a>
        </li>
        @endif
        @if(in_array('stores-payment',$role_has_permission) || in_array('stores-payout',$role_has_permission) || in_array('drivers-payment',$role_has_permission)
        || in_array('drivers-payout',$role_has_permission) || in_array('provider-payout',$role_has_permission) || in_array('wallet-transaction',$role_has_permission) || in_array('payout-request-vendor',$role_has_permission)
        || in_array('payout-request-driver',$role_has_permission))

        <li><a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                <i class="mdi mdi-bank"></i>
                <span class="hide-menu">{{trans('lang.payment_plural')}}</span>
            </a>

            <ul aria-expanded="false" class="collapse">
                @if(in_array('stores-payment',$role_has_permission) )
                <li>
                    <a href="{!! url('payments') !!}">{{ trans('lang.vendor_plural') }}
                        {{trans('lang.payment_plural')}}</a>
                </li>
                @endif
                @if(in_array('stores-payout',$role_has_permission) )

                <li><a href="{!! url('vendorsPayouts') !!}">{{trans('lang.vendors_payout_plural')}}</a></li>
                @endif

                @if(in_array('drivers-payment',$role_has_permission) )
                <li>
                    <a href="{!! url('driverpayments') !!}">{{trans('lang.driver_plural')}} {{trans('lang.payment_plural')}}</a>
                </li>
                @endif

                @if(in_array('drivers-payout',$role_has_permission) )
                <li><a href="{!! url('driversPayouts') !!}">{{trans('lang.drivers_payout')}}</a></li>
                @endif


                @if(in_array('provider-payment',$role_has_permission) )
                <li>
                    <a href="{!! url('providerpayments') !!}">{{trans('lang.provider_plural')}} {{trans('lang.payment_plural')}}</a>
                </li>
                @endif
                @if(in_array('provider-payout',$role_has_permission) )
                <li><a href="{!! url('providerPayouts') !!}">{{trans('lang.provider_payout')}}</a></li>
                @endif


                @if(in_array('wallet-transaction',$role_has_permission) )
                <li><a href="{!! url('walletstransaction') !!}">{{trans('lang.wallet_transaction')}}</a></li>
                @endif

                @if(in_array('payout-request-vendor',$role_has_permission))
                <li><a href="{!! url('payoutRequests/vendor') !!}">{{trans('lang.payout_request')}}</a></li>
                @elseif(in_array('payout-request-driver',$role_has_permission))
                <li><a href="{!! url('payoutRequests/drivers') !!}">{{trans('lang.payout_request')}}</a></li>
                @elseif(in_array('payout-request-provider',$role_has_permission))
                <li><a href="{!! url('payoutRequests/providers') !!}">{{trans('lang.payout_request')}}</a></li>
                @endif


            </ul>

        </li>

        @endif

        @if(in_array('global-setting',$role_has_permission) || in_array('currency',$role_has_permission) || in_array('payment-method',$role_has_permission)
        || in_array('radius',$role_has_permission) || in_array('tax',$role_has_permission)
        || in_array('delivery-charge',$role_has_permission) || in_array('language',$role_has_permission) || in_array('special-offer',$role_has_permission)
        || in_array('terms',$role_has_permission) || in_array('privacy',$role_has_permission) || in_array('home-page',$role_has_permission)
        || in_array('footer',$role_has_permission))

        <li><a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                <i class="mdi mdi-settings"></i>
                <span class="hide-menu">{{trans('lang.app_setting')}}</span>
            </a>

            <ul aria-expanded="false" class="collapse">
                @if(in_array('global-setting',$role_has_permission))
                <li><a href="{!! url('settings/app/globals') !!}">{{trans('lang.app_setting_globals')}}</a></li>
                @endif
                @if(in_array('app-banners-setting',$role_has_permission))
                <li><a href="{!! url('settings/app/banners') !!}">{{trans('lang.app_setting_banners')}}</a></li>
                @endif
                @if(in_array('currency',$role_has_permission))

                <li><a href="{!! url('settings/currencies') !!}">{{trans('lang.currency_plural')}}</a></li>
                @endif
                @if(in_array('payment-method',$role_has_permission))

                <li><a href="{!! url('settings/payment/stripe') !!}">{{trans('lang.app_setting_payment')}}</a>
                </li>
                @endif
                @if(in_array('radius',$role_has_permission))
                <li>
                    <a href="{!! url('settings/app/radiusConfiguration') !!}">{{trans('lang.radios_configuration')}}</a>
                </li> @endif
                @if(in_array('tax',$role_has_permission))

                <li><a href="{!! url('tax') !!}">{{trans('lang.tax_setting')}}</a></li>
                @endif
                @if(in_array('delivery-charge',$role_has_permission))
                <li><a href="{!! url('settings/app/deliveryCharge') !!}">{{trans('lang.delivery_charge')}}</a>
                </li>
                @endif
                @if(in_array('language',$role_has_permission))
                <li><a href="{!! url('settings/app/languages') !!}">{{trans('lang.languages')}}</a></li>
                @endif
                @if(in_array('special-offer',$role_has_permission))
                <li><a href="{!! url('settings/app/specialOffer') !!}">{{trans('lang.special_offer')}}</a></li>
                @endif
                @if(in_array('terms',$role_has_permission))
                <li><a href="{!! url('termsAndConditions') !!}">{{trans('lang.terms_and_conditions')}}</a></li>
                @endif
                @if(in_array('privacy',$role_has_permission))
                <li><a href="{!! url('privacyPolicy') !!}">{{trans('lang.privacy_policy')}}</a></li>
                @endif
                @if(in_array('home-page',$role_has_permission))
                <li><a href="{!! url('homepageTemplate') !!}">{{trans('lang.homepageTemplate')}}</a></li>
                @endif
                @if(in_array('footer',$role_has_permission))
                <li><a href="{!! url('footerTemplate') !!}">{{trans('lang.footer_template')}}</a></li>
                @endif
            </ul>


        </li>
        @endif
    </ul>

    <p class="web_version"></p>
</nav>
