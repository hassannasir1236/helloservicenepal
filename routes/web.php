<?php

use Illuminate\Support\Facades\Route;




// EClassify routes define 
use App\Http\Controllers\EClassify\BlogController;
use App\Http\Controllers\EClassify\CategoryController;
use App\Http\Controllers\EClassify\Controller;
use App\Http\Controllers\EClassify\CustomersController;
use App\Http\Controllers\EClassify\CustomFieldController;
use App\Http\Controllers\EClassify\FaqController;
use App\Http\Controllers\EClassify\FeatureSectionController;
// use App\Http\Controllers\EClassify\HomeController;
use App\Http\Controllers\EClassify\InstallerController;
use App\Http\Controllers\EClassify\ItemController;
use App\Http\Controllers\EClassify\LanguageController;
use App\Http\Controllers\EClassify\NotificationController;
use App\Http\Controllers\EClassify\PackageController;
use App\Http\Controllers\EClassify\PlaceController;
use App\Http\Controllers\EClassify\ReportReasonController;
use App\Http\Controllers\EClassify\RoleController;
use App\Http\Controllers\EClassify\SeoSettingController;
use App\Http\Controllers\EClassify\SettingController;
use App\Http\Controllers\EClassify\SliderController;
use App\Http\Controllers\EClassify\StaffController;
use App\Http\Controllers\EClassify\SystemUpdateController;
use App\Http\Controllers\EClassify\TipController;
use App\Http\Controllers\EClassify\UserVerificationController;
use App\Http\Controllers\EClassify\WebhookController;
use App\Models\UserVerification;
use App\Services\CachingService;
use Illuminate\Support\Facades\Artisan;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Route;
use Rap2hpoutre\LaravelLogViewer\LogViewerController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('home/', [App\Http\Controllers\HomeController::class, 'index']);

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('lang/change', [App\Http\Controllers\LangController::class, 'change'])->name('changeLang');

Route::post('payments/razorpay/createorder', [App\Http\Controllers\RazorPayController::class, 'createOrderid']);

Route::post('payments/getpaytmchecksum', [App\Http\Controllers\PaymentController::class, 'getPaytmChecksum']);

Route::post('payments/validatechecksum', [App\Http\Controllers\PaymentController::class, 'validateChecksum']);

Route::post('payments/initiatepaytmpayment', [App\Http\Controllers\PaymentController::class, 'initiatePaytmPayment']);

Route::get('payments/paytmpaymentcallback', [App\Http\Controllers\PaymentController::class, 'paytmPaymentcallback']);

Route::post('payments/paypalclientid', [App\Http\Controllers\PaymentController::class, 'getPaypalClienttoken']);

Route::post('payments/paypaltransaction', [App\Http\Controllers\PaymentController::class, 'createBraintreePayment']);

Route::post('payments/stripepaymentintent', [App\Http\Controllers\PaymentController::class, 'createStripePaymentIntent']);

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');

Route::middleware(['permission:vendors,vendors'])->group(function () {

    Route::get('/owners', [App\Http\Controllers\VendorController::class, 'owners'])->name('owners');
});
Route::middleware(['permission:stores,stores'])->group(function () {

    Route::get('/vendors', [App\Http\Controllers\VendorController::class, 'index'])->name('vendors');
});
Route::middleware(['permission:stores,stores.edit'])->group(function () {

    Route::get('/vendors/edit/{id}', [App\Http\Controllers\VendorController::class, 'edit'])->name('vendors.edit');
});
Route::middleware(['permission:stores,stores.view'])->group(function () {

    Route::get('/vendors/view/{id}', [App\Http\Controllers\VendorController::class, 'view'])->name('vendors.view');
});

Route::middleware(['permission:coupons,coupons'])->group(function () {

    Route::get('/coupon/{id}', [App\Http\Controllers\CouponController::class, 'index'])->name('vendors.coupons');
});

Route::middleware(['permission:items,items'])->group(function () {

    Route::get('/items/{id}', [App\Http\Controllers\FoodController::class, 'index'])->name('vendors.items');
});
Route::middleware(['permission:items,items.create'])->group(function () {

    Route::get('/item/create/{id}', [App\Http\Controllers\FoodController::class, 'create']);
});
Route::middleware(['permission:coupons,coupons.create'])->group(function () {

    Route::get('/coupon/create/{id}', [App\Http\Controllers\CouponController::class, 'create']);
});
Route::middleware(['permission:orders,orders'])->group(function () {

    Route::get('/orders/{id}', [App\Http\Controllers\OrderController::class, 'index'])->name('vendors.orders');
});

Route::get('/reviews/{id}', [App\Http\Controllers\OrderReviewController::class, 'index'])->name('vendors.reviews');


Route::middleware(['permission:stores,stores.create'])->group(function () {

    Route::get('/vendors/create', [App\Http\Controllers\VendorController::class, 'create'])->name('vendors.create');
});
Route::get('/vendorFilters', [App\Http\Controllers\VendorFiltersController::class, 'index'])->name('vendorFilters');

Route::get('/vendorFilters/create', [App\Http\Controllers\VendorFiltersController::class, 'create'])->name('vendorFilters.create');

Route::get('/vendorFilters/edit/{id}', [App\Http\Controllers\VendorFiltersController::class, 'edit'])->name('vendorFilters.edit');

Route::middleware(['permission:categories,categories'])->group(function () {

    Route::get('/categories', [App\Http\Controllers\CategoryController::class, 'index'])->name('categories');
});
Route::middleware(['permission:categories,categories.edit'])->group(function () {

    Route::get('/categories/edit/{id}', [App\Http\Controllers\CategoryController::class, 'edit'])->name('categories.edit');
});
Route::middleware(['permission:categories,categories.create'])->group(function () {

    Route::get('/categories/create', [App\Http\Controllers\CategoryController::class, 'create'])->name('categories.create');
});

Route::middleware(['permission:section-service,section-service.list'])->group(function () {

    Route::get('/section', [App\Http\Controllers\SectionController::class, 'index'])->name('section');
});
Route::middleware(['permission:section-service,section.service.edit'])->group(function () {

    Route::get('/section/edit/{id}', [App\Http\Controllers\SectionController::class, 'edit'])->name('section.edit');
});
Route::middleware(['permission:section-service,section.service.save'])->group(function () {

    Route::get('/section/create', [App\Http\Controllers\SectionController::class, 'create'])->name('section.create');
});
Route::middleware(['permission:users,users'])->group(function () {

    Route::get('/users', [App\Http\Controllers\UserController::class, 'index'])->name('users');
});
Route::middleware(['permission:users,users.edit'])->group(function () {

    Route::get('/users/edit/{id}', [App\Http\Controllers\UserController::class, 'edit'])->name('users.edit');
});
Route::middleware(['permission:users,users.view'])->group(function () {

    Route::get('/users/view/{id}', [App\Http\Controllers\UserController::class, 'view'])->name('users.view');
});

Route::get('/users/profile', [App\Http\Controllers\UserController::class, 'profile'])->name('users.profile');

Route::post('/users/profile/update/{id}', [App\Http\Controllers\UserController::class, 'update'])->name('users.profile.update');

Route::middleware(['permission:users,users.create'])->group(function () {

    Route::get('/users/create', [App\Http\Controllers\UserController::class, 'create'])->name('users.create');
});

Route::middleware(['permission:items,items'])->group(function () {

    Route::get('/items', [App\Http\Controllers\FoodController::class, 'index'])->name('items');
});
Route::middleware(['permission:items,items.edit'])->group(function () {

    Route::get('/items/edit/{id}', [App\Http\Controllers\FoodController::class, 'edit'])->name('items.edit');
});
Route::middleware(['permission:items,items.create'])->group(function () {

    Route::get('/item/create', [App\Http\Controllers\FoodController::class, 'create'])->name('items.create');
});

Route::get('/item/view/{id}', [App\Http\Controllers\FoodController::class, 'view'])->name('items.view');

Route::middleware(['permission:drivers,drivers'])->group(function () {

    Route::get('/drivers', [App\Http\Controllers\DriverController::class, 'index'])->name('drivers');
});
Route::middleware(['permission:drivers,drivers.edit'])->group(function () {

    Route::get('/drivers/edit/{id}', [App\Http\Controllers\DriverController::class, 'edit'])->name('drivers.edit');
});
Route::middleware(['permission:drivers,drivers.create'])->group(function () {

    Route::get('/drivers/create', [App\Http\Controllers\DriverController::class, 'create'])->name('drivers.create');
});
Route::middleware(['permission:drivers,drivers.view'])->group(function () {

    Route::get('/drivers/view/{id}', [App\Http\Controllers\DriverController::class, 'view'])->name('drivers.view');
});

Route::middleware(['permission:parcel-categories,parcel.categories'])->group(function () {

    Route::get('/parcelCategory', [App\Http\Controllers\ParcelController::class, 'index'])->name('parcelCategory');
});
Route::middleware(['permission:parcel-categories,parcel.categories.create'])->group(function () {

    Route::get('/parcelCategory/create', [App\Http\Controllers\ParcelController::class, 'create'])->name('parcelCategory.create');
});
Route::middleware(['permission:parcel-categories,parcel.categories.edit'])->group(function () {

    Route::get('/parcelCategory/edit/{id}', [App\Http\Controllers\ParcelController::class, 'edit'])->name('parcelCategory.edit');
});

Route::middleware(['permission:parcel-weight,parcel.weight'])->group(function () {

    Route::get('/parcel_weight', [App\Http\Controllers\ParcelController::class, 'parcelWeight'])->name('parcel_weight');
});
Route::middleware(['permission:parcel-coupons,parcel.coupons'])->group(function () {

    Route::get('/parcel_coupons', [App\Http\Controllers\ParcelController::class, 'parcelCoupons'])->name('parcel_coupons');
});
Route::middleware(['permission:parcel-coupons,parcel.coupons.edit'])->group(function () {

    Route::get('/parcel_coupons/edit/{id}', [App\Http\Controllers\ParcelController::class, 'parcelCouponsEdit'])->name('parcel_coupons.edit');
});
Route::middleware(['permission:parcel-coupons,parcel.coupons.create'])->group(function () {

    Route::get('/parcel_coupons/create', [App\Http\Controllers\ParcelController::class, 'parcelCouponsCreate'])->name('parcel_coupons.create');
});
Route::middleware(['permission:parcel-orders,parcel.orders'])->group(function () {

    Route::get('/parcel_orders', [App\Http\Controllers\ParcelController::class, 'parcelOrders'])->name('parcel_orders');
});

Route::get('/parcel_orders/{id}', [App\Http\Controllers\ParcelController::class, 'parcelOrders'])->name('parcel_orders.driver');

Route::middleware(['permission:parcel-orders,parcel.orders.edit'])->group(function () {

    Route::get('/parcel_orders/edit/{id}', [App\Http\Controllers\ParcelController::class, 'parcelOrderEdit'])->name('parcel_orders.edit');
});


Route::get('/rides/{id}', [App\Http\Controllers\RideController::class, 'index'])->name('drivers.ride');

Route::get('/rides/{driverId}', [App\Http\Controllers\RideController::class, 'index'])->name('drivers.rides');

Route::get('/ride/{sosId}', [App\Http\Controllers\RideController::class, 'index2'])->name('ride');

Route::middleware(['permission:rides,rides'])->group(function () {

    Route::get('/rides', [App\Http\Controllers\RideController::class, 'index'])->name('rides');
});
Route::get('/rides/view/{id}', [App\Http\Controllers\RideController::class, 'view'])->name('rides.view');
Route::middleware(['permission:rides,rides.edit'])->group(function () {

    Route::get('/rides/edit/{id}', [App\Http\Controllers\RideController::class, 'edit'])->name('rides.edit');
});

Route::middleware(['permission:orders,orders'])->group(function () {

    Route::get('/orders/', [App\Http\Controllers\OrderController::class, 'index'])->name('orders');
});
Route::middleware(['permission:orders,orders.edit'])->group(function () {

    Route::get('/orders/edit/{id}', [App\Http\Controllers\OrderController::class, 'edit'])->name('orders.edit');
});

Route::get('/orders/review/{oid}', [App\Http\Controllers\OrderController::class, 'review'])->name('orders.review');

Route::get('/orderReview', [App\Http\Controllers\OrderReviewController::class, 'index'])->name('orderReview');

Route::get('/orderReview/edit/{id}', [App\Http\Controllers\OrderReviewController::class, 'edit'])->name('orderReview.edit');

Route::middleware(['permission:coupons,coupons'])->group(function () {

    Route::get('/coupons', [App\Http\Controllers\CouponController::class, 'index'])->name('coupons');

});
Route::middleware(['permission:coupons,coupons.edit'])->group(function () {

    Route::get('/coupons/edit/{id}', [App\Http\Controllers\CouponController::class, 'edit'])->name('coupons.edit');
});
Route::middleware(['permission:coupons,coupons.create'])->group(function () {

    Route::get('/coupons/create', [App\Http\Controllers\CouponController::class, 'create'])->name('coupons.create');
});
Route::middleware(['permission:stores-payment,stores.payment'])->group(function () {

    Route::get('/payments', [App\Http\Controllers\AdminPaymentsController::class, 'index'])->name('payments');
});
Route::middleware(['permission:drivers-payment,drivers.payment'])->group(function () {

    Route::get('driverpayments', [App\Http\Controllers\AdminPaymentsController::class, 'driverIndex'])->name('driver.driverpayments');
});

Route::middleware(['permission:stores-payout,stores.payout'])->group(function () {

    Route::get('vendorsPayouts', [App\Http\Controllers\VendorsPayoutController::class, 'index'])->name('vendorsPayouts');
});
Route::middleware(['permission:stores-payout,stores.payout.create'])->group(function () {

    Route::get('vendorsPayouts/create', [App\Http\Controllers\VendorsPayoutController::class, 'create'])->name('vendorsPayouts.create');
});

Route::middleware(['permission:stores-payout,stores.payout'])->group(function () {

    Route::get('/vendorsPayouts/{id}', [App\Http\Controllers\VendorsPayoutController::class, 'index'])->name('vendors.payout');
});

Route::middleware(['permission:stores-payout,stores.payout.create'])->group(function () {

    Route::get('/vendorsPayouts/create/{id}', [App\Http\Controllers\VendorsPayoutController::class, 'create']);
});


Route::middleware(['permission:drivers-payout,drivers.payout.create'])->group(function () {

    Route::get('driversPayouts/create', [App\Http\Controllers\DriversPayoutController::class, 'create'])->name('driversPayouts.create');
});
Route::middleware(['permission:drivers-payout,drivers.payout.create'])->group(function () {

    Route::get('driversPayouts/create/{id}', [App\Http\Controllers\DriversPayoutController::class, 'create']);
});

Route::middleware(['permission:drivers-payout,drivers.payout'])->group(function () {

    Route::get('driversPayouts', [App\Http\Controllers\DriversPayoutController::class, 'index'])->name('driversPayouts');
});

Route::middleware(['permission:drivers-payout,drivers.payout'])->group(function () {

    Route::get('driversPayouts/{id}', [App\Http\Controllers\DriversPayoutController::class, 'index'])->name('driver.payouts');
});
Route::middleware(['permission:wallet-transaction,wallet-transaction'])->group(function () {

    Route::get('walletstransaction', [App\Http\Controllers\TransactionController::class, 'index'])->name('walletstransaction');
});
Route::middleware(['permission:wallet-transaction,wallet-transaction'])->group(function () {

    Route::get('/walletstransaction/{id}', [App\Http\Controllers\TransactionController::class, 'index'])->name('users.walletstransaction');
});

Route::post('order-status-notification', [App\Http\Controllers\OrderController::class, 'sendNotification'])->name('order-status-notification');

Route::middleware(['permission:god-eye,map'])->group(function () {

    Route::get('/map/multivendor', [App\Http\Controllers\MapController::class, 'multivendor'])->name('map.multivendor');
});
Route::middleware(['permission:parcel-service-god-eye,parcel-service-map'])->group(function () {

    Route::get('/map/parcel', [App\Http\Controllers\MapController::class, 'parcel'])->name('map.parcel');
});
Route::middleware(['permission:rental-plural-god-eye,rental-plural-map'])->group(function () {

    Route::get('/map/rental', [App\Http\Controllers\MapController::class, 'rental'])->name('map.rental');
});
Route::middleware(['permission:cab-service-god-eye,cab-service-map'])->group(function () {

    Route::get('/map/cab', [App\Http\Controllers\MapController::class, 'cab'])->name('map.cab');
});

Route::prefix('settings')->group(function () {

    Route::middleware(['permission:currency,currencies'])->group(function () {

        Route::get('/currencies', [App\Http\Controllers\CurrencyController::class, 'index'])->name('currencies');
    });
    Route::middleware(['permission:currency,currencies.edit'])->group(function () {

        Route::get('/currencies/edit/{id}', [App\Http\Controllers\CurrencyController::class, 'edit'])->name('currencies.edit');
    });
    Route::middleware(['permission:currency,currencies.create'])->group(function () {

        Route::get('/currencies/create', [App\Http\Controllers\CurrencyController::class, 'create'])->name('currencies.create');
    });
    Route::middleware(['permission:global-setting,settings.app.globals'])->group(function () {

        Route::get('app/globals', [App\Http\Controllers\SettingsController::class, 'globals'])->name('settings.app.globals');
    });

    Route::middleware(['permission:app-banners-setting,settings.app.banners'])->group(function () {

        Route::get('app/banners', [App\Http\Controllers\SettingsController::class, 'banners'])->name('settings.app.banners');
    });

    Route::middleware(['permission:radius,settings.app.radiusConfiguration'])->group(function () {

        Route::get('app/radiusConfiguration', [App\Http\Controllers\SettingsController::class, 'radiosConfiguration'])->name('settings.app.radiusConfiguration');
    });

    Route::get('mobile/globals', [App\Http\Controllers\SettingsController::class, 'mobileGlobals'])->name('settings.mobile.globals');

    Route::middleware(['permission:payment-method,payment-method'])->group(function () {

        Route::get('payment/stripe', [App\Http\Controllers\SettingsController::class, 'stripe'])->name('payment.stripe');

        Route::get('payment/razorpay', [App\Http\Controllers\SettingsController::class, 'razorpay'])->name('payment.razorpay');

        Route::get('payment/cod', [App\Http\Controllers\SettingsController::class, 'cod'])->name('payment.cod');

        Route::get('payment/paypal', [App\Http\Controllers\SettingsController::class, 'paypal'])->name('payment.paypal');

        Route::get('payment/wallet', [App\Http\Controllers\SettingsController::class, 'wallet'])->name('payment.wallet');

        Route::get('payment/payfast', [App\Http\Controllers\SettingsController::class, 'payfast'])->name('payment.payfast');

        Route::get('payment/paystack', [App\Http\Controllers\SettingsController::class, 'paystack'])->name('payment.paystack');

        Route::get('payment/flutterwave', [App\Http\Controllers\SettingsController::class, 'flutterwave'])->name('payment.flutterwave');

        Route::get('payment/mercadopago', [App\Http\Controllers\SettingsController::class, 'mercadopago'])->name('payment.mercadopago');

        Route::get('payment/xendit', [App\Http\Controllers\SettingsController::class, 'xendit'])->name('payment.xendit');

        Route::get('payment/midtrans', [App\Http\Controllers\SettingsController::class, 'midTrans'])->name('payment.midTrans');

        Route::get('payment/orangepay', [App\Http\Controllers\SettingsController::class, 'orangePay'])->name('payment.orangePay');
    });

    Route::middleware(['permission:delivery-charge,settings.app.deliveryCharge'])->group(function () {

        Route::get('app/deliveryCharge', [App\Http\Controllers\SettingsController::class, 'deliveryCharge'])->name('settings.app.deliveryCharge');
    });

    Route::middleware(['permission:language,language'])->group(function () {

        Route::get('app/languages', [App\Http\Controllers\SettingsController::class, 'languages'])->name('settings.app.languages');
    });
    Route::middleware(['permission:language,language.create'])->group(function () {

        Route::get('app/languages/create', [App\Http\Controllers\SettingsController::class, 'languagescreate'])->name('settings.app.languages.create');
    });
    Route::middleware(['permission:language,language.edit'])->group(function () {

        Route::get('app/languages/edit/{id}', [App\Http\Controllers\SettingsController::class, 'languagesedit'])->name('settings.app.languages.edit');
    });

    Route::middleware(['permission:cab-promo,cab.promo'])->group(function () {

        Route::get('promos', [App\Http\Controllers\SettingsController::class, 'promos'])->name('settings.promos');
    });
    Route::middleware(['permission:cab-promo,cab.promo.create'])->group(function () {

        Route::get('promos/create', [App\Http\Controllers\SettingsController::class, 'promosCreate'])->name('settings.promos.create');
    });
    Route::middleware(['permission:cab-promo,cab.promo.edit'])->group(function () {

        Route::get('promos/edit/{id}', [App\Http\Controllers\SettingsController::class, 'promosEdit'])->name('settings.promos.edit');
    });
    Route::middleware(['permission:special-offer,setting.specialOffer'])->group(function () {

        Route::get('app/specialOffer', [App\Http\Controllers\SettingsController::class, 'specialOffer'])->name('settings.app.specialoffer');
    });

});

Route::middleware(['permission:make,make'])->group(function () {

    Route::get('carMake', [App\Http\Controllers\VehicleController::class, 'carMake'])->name('carMake');
});
Route::middleware(['permission:make,make.create'])->group(function () {

    Route::get('carMake/create', [App\Http\Controllers\VehicleController::class, 'carMakeCreate'])->name('carMake.create');
});
Route::middleware(['permission:make,make.edit'])->group(function () {

    Route::get('carMake/edit/{id}', [App\Http\Controllers\VehicleController::class, 'carMakeEdit'])->name('carMake.edit');
});
Route::middleware(['permission:model,model'])->group(function () {

    Route::get('carModel', [App\Http\Controllers\VehicleController::class, 'carModel'])->name('carModel');
});
Route::middleware(['permission:model,model.create'])->group(function () {

    Route::get('carModel/create', [App\Http\Controllers\VehicleController::class, 'carModelCreate'])->name('carModel.create');
});
Route::middleware(['permission:model,model.edit'])->group(function () {

    Route::get('carModel/edit/{id}', [App\Http\Controllers\VehicleController::class, 'carModelEdit'])->name('carModel.edit');
});

Route::middleware(['permission:cab-vehicle-type,cab-vehicle-type'])->group(function () {

    Route::get('vehicleType', [App\Http\Controllers\VehicleController::class, 'vehicleType'])->name('vehicleType');
});

Route::middleware(['permission:cab-vehicle-type,cab-vehicle-type.create'])->group(function () {

    Route::get('vehicleType/create', [App\Http\Controllers\VehicleController::class, 'vehicleTypeCreate'])->name('vehicleType.create');
});

Route::middleware(['permission:cab-vehicle-type,cab-vehicle-type.edit'])->group(function () {

    Route::get('vehicleType/edit/{id}', [App\Http\Controllers\VehicleController::class, 'vehicleTypeEdit'])->name('vehicleType.edit');
});
Route::middleware(['permission:terms,termsAndConditions'])->group(function () {

    Route::get('/termsAndConditions', [App\Http\Controllers\TermsAndConditionsController::class, 'index'])->name('termsAndConditions');
});
Route::middleware(['permission:privacy,privacyPolicy'])->group(function () {

    Route::get('/privacyPolicy', [App\Http\Controllers\TermsAndConditionsController::class, 'privacyindex'])->name('privacyPolicy');
});

Route::middleware(['permission:banners,banners'])->group(function () {

    Route::get('/banners', [App\Http\Controllers\BannerController::class, 'index'])->name('banners');
});
Route::middleware(['permission:banners,banners.create'])->group(function () {

    Route::get('/banners/create', [App\Http\Controllers\BannerController::class, 'create'])->name('banners.create');
});
Route::middleware(['permission:banners,banners.edit'])->group(function () {

    Route::get('/banners/edit/{id}', [App\Http\Controllers\BannerController::class, 'edit'])->name('banners.edit');
});

Route::middleware(['permission:brands,brands'])->group(function () {

    Route::get('/brands', [App\Http\Controllers\BrandController::class, 'brand'])->name('brands');
});
Route::middleware(['permission:brands,brands.create'])->group(function () {

    Route::get('/brands/create', [App\Http\Controllers\BrandController::class, 'brandCreate'])->name('brands.create');
});
Route::middleware(['permission:brands,brands.edit'])->group(function () {

    Route::get('/brands/edit/{id}', [App\Http\Controllers\BrandController::class, 'brandEdit'])->name('brands.edit');
});
Route::middleware(['permission:destinations,destinations'])->group(function () {

    Route::get('/destinations', [App\Http\Controllers\PopularDestinationController::class, 'index'])->name('destinations');
});
Route::middleware(['permission:destinations,destinations.create'])->group(function () {

    Route::get('/destinations/create', [App\Http\Controllers\PopularDestinationController::class, 'create'])->name('destinations.create');
});
Route::middleware(['permission:destinations,destinations.edit'])->group(function () {

    Route::get('/destinations/edit/{id}', [App\Http\Controllers\PopularDestinationController::class, 'edit'])->name('destinations.edit');

});
Route::middleware(['permission:home-page,homepageTemplate'])->group(function () {

    Route::get('/homepageTemplate', [App\Http\Controllers\SettingsController::class, 'homepageTemplate'])->name('homepageTemplate');
});

Route::middleware(['permission:rental-vehicle-type,rental-vehicle-type'])->group(function () {

    Route::get('rentalvehicleType', [App\Http\Controllers\SettingsController::class, 'rentalvehicleType'])->name('rentalvehicleType');
});
Route::middleware(['permission:rental-vehicle-type,rental-vehicle-type.edit'])->group(function () {

    Route::get('rentalvehicleType/edit/{id}', [App\Http\Controllers\SettingsController::class, 'rentalvehicleTypeEdit'])->name('rentalvehicleType.edit');
});
Route::middleware(['permission:rental-vehicle-type,rental-vehicle-type.create'])->group(function () {

    Route::get('rentalvehicleType/create', [App\Http\Controllers\SettingsController::class, 'rentalvehicleTypeCreate'])->name('rentalvehicleType.create');
});

Route::middleware(['permission:complaints,complaints'])->group(function () {

    Route::get('complaints', [App\Http\Controllers\SettingsController::class, 'complaints'])->name('complaints');
});
Route::middleware(['permission:complaints,complaints.edit'])->group(function () {

    Route::get('complaints/edit/{id}', [App\Http\Controllers\SettingsController::class, 'complaintsEdit'])->name('complaints.edit');
});

Route::middleware(['permission:sos-rides,sos.rides'])->group(function () {

    Route::get('sos', [App\Http\Controllers\SettingsController::class, 'sos'])->name('sos');
});

Route::middleware(['permission:sos-rides,sos.rides.edit'])->group(function () {

    Route::get('sos/edit/{id}', [App\Http\Controllers\SettingsController::class, 'sosEdit'])->name('sos.edit');
});
Route::middleware(['permission:general-notifications,notification.send'])->group(function () {

    Route::get('/notification/send', [App\Http\Controllers\NotificationController::class, 'send'])->name('notification/send');
});

Route::middleware(['permission:general-notifications,notification'])->group(function () {

    Route::get('/notification', [App\Http\Controllers\NotificationController::class, 'index'])->name('notification');
});

Route::post('broadcastnotification', [App\Http\Controllers\NotificationController::class, 'broadcastnotification'])->name('broadcastnotification');

Route::get('/booktable/{id}', [App\Http\Controllers\BookTableController::class, 'index'])->name('vendors.booktable');

Route::get('/booktable/edit/{id}', [App\Http\Controllers\BookTableController::class, 'edit'])->name('booktable.edit');

Route::post('/sendnotification', [App\Http\Controllers\BookTableController::class, 'sendnotification'])->name('sendnotification');

Route::middleware(['permission:payout-request-driver,payout-request.driver'])->group(function () {

    Route::get('/payoutRequests/drivers', [App\Http\Controllers\PayoutRequestController::class, 'index'])->name('payoutRequests.drivers');

    Route::get('/payoutRequests/drivers/{id}', [App\Http\Controllers\PayoutRequestController::class, 'index'])->name('payoutRequests.drivers.view');
});
Route::middleware(['permission:payout-request-vendor,payout-request.vendor'])->group(function () {

    Route::get('/payoutRequests/vendor', [App\Http\Controllers\PayoutRequestController::class, 'vendor'])->name('payoutRequests.vendor');

    Route::get('/payoutRequests/vendor/{id}', [App\Http\Controllers\PayoutRequestController::class, 'vendor'])->name('payoutRequests.vendor.view');
});

Route::get('order_transactions', [App\Http\Controllers\PaymentController::class, 'index'])->name('order_transactions');

Route::get('/order_transactions/{id}', [App\Http\Controllers\PaymentController::class, 'index'])->name('order_transactions.index');

Route::get('/orders/print/{id}', [App\Http\Controllers\OrderController::class, 'orderprint'])->name('vendors.orderprint');

Route::middleware(['permission:item-attributes,item.attributes'])->group(function () {

    Route::get('/attributes', [App\Http\Controllers\AttributeController::class, 'index'])->name('attributes');
});
Route::middleware(['permission:item-attributes,item.attributes.edit'])->group(function () {

    Route::get('/attributes/edit/{id}', [App\Http\Controllers\AttributeController::class, 'edit'])->name('attributes.edit');
});
Route::middleware(['permission:item-attributes,item.attributes.create'])->group(function () {

    Route::get('/attributes/create', [App\Http\Controllers\AttributeController::class, 'create'])->name('attributes.create');
});
Route::middleware(['permission:review-attributes,review.attributes'])->group(function () {

    Route::get('/reviewattributes', [App\Http\Controllers\ReviewAttributeController::class, 'index'])->name('reviewattributes');
});
Route::middleware(['permission:review-attributes,review.attributes.edit'])->group(function () {

    Route::get('/reviewattributes/edit/{id}', [App\Http\Controllers\ReviewAttributeController::class, 'edit'])->name('reviewattributes.edit');
});
Route::middleware(['permission:review-attributes,review.attributes.create'])->group(function () {

    Route::get('/reviewattributes/create', [App\Http\Controllers\ReviewAttributeController::class, 'create'])->name('reviewattributes.create');
});
Route::middleware(['permission:rental-discount,rental-discount'])->group(function () {

    Route::get('/rentaldiscount', [App\Http\Controllers\SettingsController::class, 'rentalDiscount'])->name('rentaldiscount');
});
Route::middleware(['permission:rental-discount,rental-discount.edit'])->group(function () {

    Route::get('/rentaldiscount/edit/{id}', [App\Http\Controllers\SettingsController::class, 'rentalDiscountEdit'])->name('rentaldiscount.edit');
});
Route::middleware(['permission:rental-discount,rental-discount.create'])->group(function () {

    Route::get('/rentaldiscount/create', [App\Http\Controllers\SettingsController::class, 'rentalDiscountCreate'])->name('rentaldiscount.create');
});
Route::middleware(['permission:rental-orders,rental-orders'])->group(function () {

    Route::get('/rental_orders', [App\Http\Controllers\RentalController::class, 'rentalOrders'])->name('rental_orders');
});

Route::get('/rental_orders/{id}', [App\Http\Controllers\RentalController::class, 'rentalOrders'])->name('rental_orders.driver');

Route::middleware(['permission:rental-orders,rental-orders.edit'])->group(function () {

    Route::get('/rental_orders/edit/{id}', [App\Http\Controllers\RentalController::class, 'rentalOrderEdit'])->name('rental_orders.edit');
});
Route::middleware(['permission:rental-vehicle,rental-vehicle'])->group(function () {

    Route::get('rentalvehicle', [App\Http\Controllers\SettingsController::class, 'rentalvehicle'])->name('rentalvehicle');
});
Route::middleware(['permission:rental-vehicle,rental-vehicle.view'])->group(function () {

    Route::get('/rentalvehicle/view/{id}', [App\Http\Controllers\SettingsController::class, 'rentalVehicleView'])->name('drivers.vehicle');
});

Route::middleware(['permission:footer,footerTemplate'])->group(function () {

    Route::get('footerTemplate', [App\Http\Controllers\SettingsController::class, 'footerTemplate'])->name('footerTemplate');
});

Route::post('complaint_notification', [App\Http\Controllers\RideController::class, 'complaintNotification'])->name('complaint_notification');

Route::middleware(['permission:cms,cms'])->group(function () {

    Route::get('cms', [App\Http\Controllers\CmsController::class, 'index'])->name('cms');
});
Route::middleware(['permission:cms,cms.edit'])->group(function () {

    Route::get('/cms/edit/{id}', [App\Http\Controllers\CmsController::class, 'edit'])->name('cms.edit');
});
Route::middleware(['permission:cms,cms.create'])->group(function () {

    Route::get('/cms/create', [App\Http\Controllers\CmsController::class, 'create'])->name('cms.create');
});

Route::post('/firebase/config', [App\Http\Controllers\FirebaseController::class, 'config'])->name('firebase.config');

Route::middleware(['permission:dynamic-notifications,dynamic-notification.index'])->group(function () {

    Route::get('dynamic-notification', [App\Http\Controllers\DynamicNotificationController::class, 'index'])->name('dynamic-notification.index');
});
Route::middleware(['permission:dynamic-notifications,dynamic-notification.save'])->group(function () {

    Route::get('dynamic-notification/save/{id?}', [App\Http\Controllers\DynamicNotificationController::class, 'save'])->name('dynamic-notification.save');
});

Route::get('dynamic-notification/delete/{id}', [App\Http\Controllers\DynamicNotificationController::class, 'delete'])->name('dynamic-notification.delete');

Route::middleware(['permission:tax,tax'])->group(function () {

    Route::get('/tax', [App\Http\Controllers\TaxController::class, 'index'])->name('tax');
});
Route::middleware(['permission:tax,tax.edit'])->group(function () {

    Route::get('/tax/edit/{id}', [App\Http\Controllers\TaxController::class, 'edit'])->name('tax.edit');
});
Route::middleware(['permission:tax,tax.create'])->group(function () {

    Route::get('/tax/create', [App\Http\Controllers\TaxController::class, 'create'])->name('tax.create');
});

Route::middleware(['permission:email-template,email-templates.index'])->group(function () {

    Route::get('email-templates', [App\Http\Controllers\SettingsController::class, 'emailTemplatesIndex'])->name('email-templates.index');
});
Route::middleware(['permission:email-template,email-templates.edit'])->group(function () {

    Route::get('email-templates/save/{id?}', [App\Http\Controllers\SettingsController::class, 'emailTemplatesSave'])->name('email-templates.save');
});

Route::get('email-templates/delete/{id}', [App\Http\Controllers\SettingsController::class, 'emailTemplatesDelete'])->name('email-templates.delete');

Route::post('send-email', [App\Http\Controllers\SendEmailController::class, 'sendMail'])->name('sendMail');

Route::middleware(['permission:report,' . ((str_contains(Request::url(), 'report/')) ? explode("report/", Request::url())[1] : Request::url())])->group(function () {

    Route::get('report/{type}', [App\Http\Controllers\ReportController::class, 'index'])->name('report.index');
});
Route::middleware(['permission:gift-cards,gift-card.index'])->group(function () {

    Route::get('gift-card', [App\Http\Controllers\GiftCardController::class, 'index'])->name('gift-card.index');
});
Route::middleware(['permission:gift-cards,gift-card.save'])->group(function () {

    Route::get('gift-card/save/{id?}', [App\Http\Controllers\GiftCardController::class, 'save'])->name('gift-card.save');
});
Route::middleware(['permission:gift-cards,gift-card.edit'])->group(function () {

    Route::get('gift-card/edit/{id}', [App\Http\Controllers\GiftCardController::class, 'save'])->name('gift-card.edit');
});

Route::middleware(['permission:roles,role.index'])->group(function () {

    Route::get('role', [App\Http\Controllers\RoleController::class, 'index'])->name('role.index');
});
Route::middleware(['permission:roles,role.save'])->group(function () {

    Route::get('role/save', [App\Http\Controllers\RoleController::class, 'save'])->name('role.save');
});
Route::middleware(['permission:roles,role.store'])->group(function () {

    Route::post('role/store', [App\Http\Controllers\RoleController::class, 'store'])->name('role.store');
});
Route::middleware(['permission:roles,role.delete'])->group(function () {

    Route::get('role/delete/{id}', [App\Http\Controllers\RoleController::class, 'delete'])->name('role.delete');
});
Route::middleware(['permission:roles,role.edit'])->group(function () {

    Route::get('role/edit/{id}', [App\Http\Controllers\RoleController::class, 'edit'])->name('role.edit');
});
Route::middleware(['permission:roles,role.update'])->group(function () {

    Route::post('role/update/{id}', [App\Http\Controllers\RoleController::class, 'update'])->name('role.update');
});

Route::middleware(['permission:admins,admin.users'])->group(function () {

    Route::get('admin-users', [App\Http\Controllers\UserController::class, 'adminUsers'])->name('admin.users');
});
Route::middleware(['permission:admins,admin.users.create'])->group(function () {

    Route::get('admin-users/create', [App\Http\Controllers\UserController::class, 'createAdminUsers'])->name('admin.users.create');
});
Route::middleware(['permission:admins,admin.users.store'])->group(function () {

    Route::post('admin-users/store', [App\Http\Controllers\UserController::class, 'storeAdminUsers'])->name('admin.users.store');
});
Route::middleware(['permission:admins,admin.users.delete'])->group(function () {

    Route::get('admin-users/delete/{id}', [App\Http\Controllers\UserController::class, 'deleteAdminUsers'])->name('admin.users.delete');
});
Route::middleware(['permission:admins,admin.users.edit'])->group(function () {

    Route::get('admin-users/edit/{id}', [App\Http\Controllers\UserController::class, 'editAdminUsers'])->name('admin.users.edit');
});
Route::middleware(['permission:admins,admin.users.update'])->group(function () {

    Route::post('admin-users/update/{id}', [App\Http\Controllers\UserController::class, 'updateAdminUsers'])->name('admin.users.update');
});




Route::middleware(['permission:ondemand-categories,ondemand.categories'])->group(function () {

    Route::get('/ondemand-categories', [App\Http\Controllers\OnDemandServiceController::class, 'Category'])->name('ondemandcategory');
});
Route::middleware(['permission:ondemand-categories,ondemand.categories.create'])->group(function () {

    Route::get('/ondemand-categories/create', [App\Http\Controllers\OnDemandServiceController::class, 'CategoryCreate'])->name('ondemandcategory.create');
});
Route::middleware(['permission:ondemand-categories,ondemand.categories.edit'])->group(function () {

    Route::get('/ondemand-categories/edit/{id}', [App\Http\Controllers\OnDemandServiceController::class, 'CategoryEdit'])->name('ondemandcategory.edit');
});

Route::middleware(['permission:providers,providers'])->group(function () {

    Route::get('/providers', [App\Http\Controllers\ProvidersController::class, 'index'])->name('providers');
});
Route::middleware(['permission:providers,providers.create'])->group(function () {

    Route::get('/providers/create', [App\Http\Controllers\ProvidersController::class, 'create'])->name('providers.create');
});
Route::middleware(['permission:providers,providers.edit'])->group(function () {

    Route::get('/providers/edit/{id}', [App\Http\Controllers\ProvidersController::class, 'edit'])->name('providers.edit');
});
Route::middleware(['permission:providers,providers.view'])->group(function () {

    Route::get('/providers/view/{id}', [App\Http\Controllers\ProvidersController::class, 'view'])->name('providers.view');
});

Route::middleware(['permission:ondemand-coupons,ondemand.coupons'])->group(function () {

    Route::get('/ondemand-coupons/{id?}', [App\Http\Controllers\OnDemandServiceController::class, 'Coupons'])->name('ondemand.coupons');
});
Route::middleware(['permission:ondemand-coupons,ondemand.coupons.create'])->group(function () {

    Route::get('/ondemand-coupon/create', [App\Http\Controllers\OnDemandServiceController::class, 'CouponCreate'])->name('ondemand.coupons.create');
});
Route::middleware(['permission:ondemand-coupons,ondemand.coupons.edit'])->group(function () {

    Route::get('/ondemand-coupons/edit/{id}', [App\Http\Controllers\OnDemandServiceController::class, 'CouponEdit'])->name('ondemand.coupons.edit');
});

Route::middleware(['permission:ondemand-services,ondemand.services.index'])->group(function () {

    Route::get('/ondemand-services/{id?}', [App\Http\Controllers\OnDemandServiceController::class, 'Services'])->name('ondemand.services.index');

});
Route::middleware(['permission:ondemand-services,ondemand.services.create'])->group(function () {

    Route::get('/ondemand-service/create', [App\Http\Controllers\OnDemandServiceController::class, 'ServicesCreate'])->name('ondemand.services.create');

});

Route::middleware(['permission:ondemand-services,ondemand.services.edit'])->group(function () {

    Route::get('/ondemand-services/edit/{id}', [App\Http\Controllers\OnDemandServiceController::class, 'ServicesEdit'])->name('ondemand.services.edit');
});

Route::middleware(['permission:ondemand-bookings,ondemand.bookings.index'])->group(function () {

    Route::get('/ondemand-bookings/{id?}', [App\Http\Controllers\OnDemandServiceController::class, 'Bookings'])->name('ondemand.bookings.index');

});
Route::middleware(['permission:ondemand-bookings,ondemand.bookings.edit'])->group(function () {

    Route::get('/ondemand-bookings/edit/{id}', [App\Http\Controllers\OnDemandServiceController::class, 'BookingsEdit'])->name('ondemand.bookings.edit');

});
Route::middleware(['permission:ondemand-bookings,ondemand.bookings.print'])->group(function () {

    Route::get('/ondemand-bookings/print/{id}', [App\Http\Controllers\OnDemandServiceController::class, 'BookingsPrint'])->name('ondemand.bookings.print');

});

Route::middleware(['permission:ondemand-workers,ondemand.workers.index'])->group(function () {

    Route::get('/ondemand-workers/{id?}', [App\Http\Controllers\OnDemandServiceController::class, 'Workers'])->name('ondemand.workers.index');

});
Route::middleware(['permission:ondemand-workers,ondemand.workers.create'])->group(function () {

    Route::get('/ondemand-worker/create', [App\Http\Controllers\OnDemandServiceController::class, 'WorkersCreate'])->name('ondemand.workers.create');

});
Route::middleware(['permission:ondemand-workers,ondemand.workers.edit'])->group(function () {

    Route::get('/ondemand-worker/edit/{id}', [App\Http\Controllers\OnDemandServiceController::class, 'WorkersEdit'])->name('ondemand.workers.edit');

});
Route::middleware(['permission:on-board,onboard.list'])->group(function () {

    Route::get('/on-board', [App\Http\Controllers\OnBoardController::class, 'index'])->name('on-board');
});

Route::middleware(['permission:on-board,onboard.edit'])->group(function () {

    Route::get('/on-board/save/{id}', [App\Http\Controllers\OnBoardController::class, 'save'])->name('on-board.save');
});
Route::middleware(['permission:provider-payout,provider.payout'])->group(function () {

    Route::get('providerPayouts', [App\Http\Controllers\ProviderPayoutsController::class, 'index'])->name('providerPayouts');
});

Route::middleware(['permission:provider-payout,provider.payout.create'])->group(function () {

    Route::get('providerPayouts/create', [App\Http\Controllers\ProviderPayoutsController::class, 'create'])->name('providerPayouts.create');
});

Route::middleware(['permission:provider-payout,provider.payout'])->group(function () {

    Route::get('/providerPayouts/{id}', [App\Http\Controllers\ProviderPayoutsController::class, 'index'])->name('providerPayouts.payout');
});

Route::middleware(['permission:provider-payout,provider.payout.create'])->group(function () {

    Route::get('/providerPayouts/create/{id}', [App\Http\Controllers\ProviderPayoutsController::class, 'create']);
});
Route::middleware(['permission:provider-payment,provider.payment'])->group(function () {

    Route::get('providerpayments', [App\Http\Controllers\AdminPaymentsController::class, 'providerIndex'])->name('providerpayments');
});
Route::middleware(['permission:payout-request-provider,payout-request.provider'])->group(function () {
    Route::get('/payoutRequests/providers/{id?}', [App\Http\Controllers\PayoutRequestController::class, 'provider'])->name('payoutRequests.providers');
});

Route::post('store-firebase-service', [App\Http\Controllers\HomeController::class,'storeFirebaseService'])->name('store-firebase-service');

Route::post('pay-to-user', [App\Http\Controllers\UserController::class,'payToUser'])->name('pay.user');
Route::post('check-payout-status', [App\Http\Controllers\UserController::class,'checkPayoutStatus'])->name('check.payout.status');


// Route::middleware(['permission:zone,zone.list'])->group(function () {
    Route::get('zone', [App\Http\Controllers\ZoneController::class, 'index'])->name('zone');
// });
// Route::middleware(['permission:zone,zone.create'])->group(function () {
    Route::get('/zone/create', [App\Http\Controllers\ZoneController::class, 'create'])->name('zone.create');
// });
// Route::middleware(['permission:zone,zone.edit'])->group(function () {
    Route::get('/zone/edit/{id}', [App\Http\Controllers\ZoneController::class, 'edit'])->name('zone.edit');
// });


// Route::middleware(['permission:documents,document.list'])->group(function () {

    Route::get('/documents', [App\Http\Controllers\DocumentsController::class, 'index'])->name('documents');
// });
// Route::middleware(['permission:deleted-documents,document.deleted'])->group(function () {


    Route::get('/documents/deleted', [App\Http\Controllers\DocumentsController::class, 'deletedIndex'])->name('documents.deleted');
// });
// Route::middleware(['permission:documents,document.' . ((str_contains(Request::url(), 'save/')) ? ((explode("save/", Request::url())[1]) == 0 ? "create" : "edit") : Request::url())])->group(function () {

    Route::get('/documents/save/{id}', [App\Http\Controllers\DocumentsController::class, 'save'])->name('documents.save');
// });



// Route::middleware(['permission:report,' . ((str_contains(Request::url(), 'report/')) ? explode("report/", Request::url())[1] : Request::url())])->group(function () {

    Route::get('reports/{type}', [App\Http\Controllers\ReportController::class, 'indexReports'])->name('indexReports.index');
// });


// Route::middleware(['permission:service,service.list'])->group(function () {

    Route::get('/services', [App\Http\Controllers\ServiceController::class, 'index'])->name('services');
// });
// Route::middleware(['permission:service,service.edit'])->group(function () {

    Route::get('/services/edit/{id}', [App\Http\Controllers\ServiceController::class, 'edit'])->name('services.edit');
// });
// Route::middleware(['permission:service,service.create'])->group(function () {

    Route::get('/services/create', [App\Http\Controllers\ServiceController::class, 'create'])->name('services.create');
// });



// Route::middleware(['permission:intercity_service,intercity.service.list'])->group(function () {

    Route::get('/intercity-service', [App\Http\Controllers\IntercityServiceController::class, 'index'])->name('intercity-service');
// });
// Route::middleware(['permission:intercity_service,intercity.service.edit'])->group(function () {

    Route::get('/intercity-service/edit/{id}', [App\Http\Controllers\IntercityServiceController::class, 'edit'])->name('intercity-service.edit');
// });

// Route::middleware(['permission:intercity_order,intercity.order.list'])->group(function () {

    Route::get('/intercity-service-rides', [App\Http\Controllers\IntercityServiceController::class, 'ridesList'])->name('intercity-service-rides');
// });
// Route::middleware(['permission:intercity_order,intercity.order.view'])->group(function () {

    Route::get('/intercity-service-rides/view/{id}', [App\Http\Controllers\IntercityServiceController::class, 'rideView'])->name('intercity-service-rides.view');
// });


// Route::middleware(['permission:freight,freight.list'])->group(function () {

    Route::get('/freight-vehicles', [App\Http\Controllers\FreightVehicleController::class, 'index'])->name('freight-vehicle');
// });

// Route::middleware(['permission:freight,freight.' . ((str_contains(Request::url(), 'save')) ? (explode("save", Request::url())[1] ? "edit" : "create") : Request::url())])->group(function () {

    Route::get('/freight-vehicles/save/{id?}', [App\Http\Controllers\FreightVehicleController::class, 'save'])->name('freight-vehicles.save');
// });


// Route::middleware(['permission:airports,airports.list'])->group(function () {

    Route::get('/airports', [App\Http\Controllers\AirportsController::class, 'index'])->name('airports');
// });
// Route::middleware(['permission:airports,airports.' . ((str_contains(Request::url(), 'save')) ? (explode("save", Request::url())[1] ? "edit" : "create") : Request::url())])->group(function () {

    Route::get('/airports/save/{id?}', [App\Http\Controllers\AirportsController::class, 'save'])->name('airport.save');
// });


// Route::middleware(['permission:vehicle-type,vehicle.type.list'])->group(function () {

    Route::get('/vehicle-type', [App\Http\Controllers\VehicleTypeController::class, 'index'])->name('vehicle-type');
// });
// Route::middleware(['permission:vehicle-type,vehicle.type.edit'])->group(function () {

    Route::get('/vehicle-type/edit/{id}', [App\Http\Controllers\VehicleTypeController::class, 'edit'])->name('vehicle-type.edit');
// });
// Route::middleware(['permission:vehicle-type,vehicle.type.create'])->group(function () {

    Route::get('/vehicle-type/create', [App\Http\Controllers\VehicleTypeController::class, 'create'])->name('vehicle-type.create');
// });



// Route::middleware(['permission:driver-rules,rule.list'])->group(function () {

    Route::get('/driver-rules', [App\Http\Controllers\DriverRulesController::class, 'rulesIndex'])->name('driver-rules');
// });
// Route::middleware(['permission:deleted-driver-rules,rule.delete.list'])->group(function () {

    Route::get('/driver-rules/deleted', [App\Http\Controllers\DriverRulesController::class, 'deletedRulesIndex'])->name('driver-rules.deleted.index');
// });
// Route::middleware(['permission:driver-rules,rule.' . ((str_contains(Request::url(), 'save/')) ? ((explode("save/", Request::url())[1]) == 0 ? "create" : "edit") : Request::url())])->group(function () {

    Route::get('/driver-rules/save/{id}', [App\Http\Controllers\DriverRulesController::class, 'saveRule'])->name('driver-rules.save');
// });


// Route::middleware(['permission:faq,faq.list'])->group(function () {

    Route::get('/faq', [App\Http\Controllers\FAQController::class, 'index'])->name('faq');
// });
// Route::middleware(['permission:faq,faq.' . ((str_contains(Request::url(), 'save')) ? (explode("save", Request::url())[1] ? "edit" : "create") : Request::url())])->group(function () {

    Route::get('/faq/save/{id?}', [App\Http\Controllers\FAQController::class, 'save'])->name('faq.save');
// });

// Route::middleware(['permission:sos,sos.list'])->group(function () {

    Route::get('sos', [App\Http\Controllers\SosController::class, 'sos'])->name('sos');
// });
// Route::middleware(['permission:sos,sos.edit'])->group(function () {

    Route::get('sos/edit/{id}', [App\Http\Controllers\SosController::class, 'sosEdit'])->name('sos.edit');
// });



// EClassify Routes

    Route::get('/echome', [App\Http\Controllers\EClassify\HomeController::class, 'index'])->name('echome');
    Route::get('change-password', [App\Http\Controllers\EClassify\HomeController::class, 'changePasswordIndex'])->name('change-password.index');
    Route::post('change-password', [App\Http\Controllers\EClassify\HomeController::class, 'changePasswordUpdate'])->name('change-password.update');

    Route::get('change-profile', [App\Http\Controllers\EClassify\HomeController::class, 'changeProfileIndex'])->name('change-profile.index');
    Route::post('change-profile', [App\Http\Controllers\EClassify\HomeController::class, 'changeProfileUpdate'])->name('change-profile.update');
    /*** Home Module : END ***/

    /*** Category Module : START ***/
    Route::resource('category', App\Http\Controllers\EClassify\CategoryController::class);
    Route::group(['prefix' => 'category'], static function () {
        Route::get('/{id}/subcategories', [App\Http\Controllers\EClassify\CategoryController::class, 'getSubCategories'])->name('category.subcategories');
        Route::get('/{id}/custom-fields', [App\Http\Controllers\EClassify\CategoryController::class, 'customFields'])->name('category.custom-fields');
        Route::get('/{id}/custom-fields/show', [App\Http\Controllers\EClassify\CategoryController::class, 'getCategoryCustomFields'])->name('category.custom-fields.show');
        Route::delete('/{id}/custom-fields/{customFieldID}/delete', [App\Http\Controllers\EClassify\CategoryController::class, 'destroyCategoryCustomField'])->name('category.custom-fields.destroy');
    });
    /*** Category Module : END ***/

    /*** Custom Field Module : START ***/
    Route::group(['prefix' => 'custom-fields'], static function () {
        Route::post('/{id}/value/add', [App\Http\Controllers\EClassify\CustomFieldController::class, 'addCustomFieldValue'])->name('custom-fields.value.add');
        Route::get('/{id}/value/show', [App\Http\Controllers\EClassify\CustomFieldController::class, 'getCustomFieldValues'])->name('custom-fields.value.show');
        Route::put('/{id}/value/edit', [App\Http\Controllers\EClassify\CustomFieldController::class, 'updateCustomFieldValue'])->name('custom-fields.value.update');
        Route::delete('/{id}/value/{value}/delete', [App\Http\Controllers\EClassify\CustomFieldController::class, 'deleteCustomFieldValue'])->name('custom-fields.value.delete');
    });
    Route::resource('custom-fields', App\Http\Controllers\EClassify\CustomFieldController::class);

  /*** Feature Section Module : START ***/
  Route::resource('feature-section', App\Http\Controllers\EClassify\FeatureSectionController::class);
  Route::resource('item', App\Http\Controllers\EClassify\ItemController::class);


  Route::group(['prefix' => 'contact-us'], static function () {
    Route::get('/', [App\Http\Controllers\EClassify\Controller::class, 'contactUsUIndex'])->name('contact-us.index');
    Route::get('/show', [App\Http\Controllers\EClassify\Controller::class, 'contactUsShow'])->name('contact-us.show');
});
  /*** Language Module : START ***/
  Route::group(['prefix' => 'language'], static function () {
    Route::get('set-language/{lang}', [App\Http\Controllers\EClassify\LanguageController::class, 'setLanguage'])->name('language.set-current');
    Route::get('download/panel', [App\Http\Controllers\EClassify\LanguageController::class, 'downloadPanelFile'])->name('language.download.panel.json');
    Route::get('download/app', [App\Http\Controllers\EClassify\LanguageController::class, 'downloadAppFile'])->name('language.download.app.json');
    Route::get('download/web', [App\Http\Controllers\EClassify\LanguageController::class, 'downloadWebFile'])->name('language.download.web.json');

    Route::put('/language/update/{id}/{type}', [App\Http\Controllers\EClassify\LanguageController::class, 'updatelanguage'])->name('updatelanguage');
    Route::get('languageedit/{id}/{type}', [App\Http\Controllers\EClassify\LanguageController::class, 'editLanguage'])->name('languageedit');
});
Route::resource('language', App\Http\Controllers\EClassify\LanguageController::class);
Route::group(['prefix' => 'common'], static function () {
    Route::get('/js/lang', [App\Http\Controllers\EClassify\Controller::class, 'readLanguageFile'])->name('common.language.read');
});






 /*** Category Module : START ***/
//  Route::resource('category', App\Http\Controllers\CategoriesController::class);
//  Route::group(['prefix' => 'category'], static function () {
//      Route::get('/{id}/subcategories', [App\Http\Controllers\CategoriesController::class, 'getSubCategories'])->name('category.subcategories');
//      Route::get('/{id}/custom-fields', [App\Http\Controllers\CategoriesController::class, 'customFields'])->name('category.custom-fields');
//      Route::get('/{id}/custom-fields/show', [App\Http\Controllers\CategoriesController::class, 'getCategoryCustomFields'])->name('category.custom-fields.show');
//      Route::delete('/{id}/custom-fields/{customFieldID}/delete', [App\Http\Controllers\CategoriesController::class, 'destroyCategoryCustomField'])->name('category.custom-fields.destroy');
//  })->name('category');
 /*** Category Module : END ***/

