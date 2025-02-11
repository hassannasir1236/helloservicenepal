<?php

// use App\Models\Package;
// use App\Models\Setting;
// use Illuminate\Database\Migrations\Migration;
// use Illuminate\Database\Schema\Blueprint;
// use Illuminate\Support\Facades\Schema;
// use Illuminate\Support\Facades\DB;

// return new class extends Migration {
//     /**
//      * Run the migrations.
//      */
//     public function up(): void {
//         Setting::insert([
//             ['name' => 'banner_ad_id_android', 'value' => ''],
//             ['name' => 'banner_ad_id_ios', 'value' => ''],
//             ['name' => 'banner_ad_status', 'value' => 1],

//             ['name' => 'interstitial_ad_id_android', 'value' => ''],
//             ['name' => 'interstitial_ad_id_ios', 'value' => ''],
//             ['name' => 'interstitial_ad_status', 'value' => 1],
//         ]);

//         Schema::table('packages', static function (Blueprint $table) {
//             /*Rename the column*/
//             $table->renameColumn('price', 'final_price');
//             $table->renameColumn('discount_price', 'price');

//             /*Add new column*/
//             $table->float('discount_in_percentage')->after('price')->default(0);
//         });

//         /*This code is added separately because datatype was not changing when running in the code snippet*/
//         Schema::table('packages', static function (Blueprint $table) {
//             $table->float('price')->after('name')->change();
//             $table->float('final_price')->after('discount_in_percentage')->change();
//         });

//         foreach (Package::whereNot('final_price', 0)->get() as $package) {
//             $package->price = $package->final_price;
//             $package->save();
//         }

//         Schema::table('items', static function (Blueprint $table) {
//             $table->string('state')->nullable()->change();
//         });

//         Schema::create('block_users', static function (Blueprint $table) {
//             $table->id();
//             $table->foreignId('user_id')->references('id')->on('users')->onDelete('restrict');
//             $table->foreignId('blocked_user_id')->references('id')->on('users')->onDelete('restrict');
//             $table->unique(['user_id', 'blocked_user_id']);
//             $table->timestamps();
//         });

//         Schema::create('tips', static function (Blueprint $table) {
//             $table->id();
//             $table->string('description', 512);
//             $table->integer('sequence');
//             $table->timestamps();
//             $table->softDeletes();
//         });

//         Schema::create('tip_translations', static function (Blueprint $table) {
//             $table->id();
//             $table->foreignId('tip_id')->references('id')->on('tips')->onDelete('cascade');
//             $table->foreignId('language_id')->references('id')->on('languages')->onDelete('cascade');
//             $table->string('description', 512);
//             $table->timestamps();
//             $table->unique(['tip_id', 'language_id']);
//         });


//     }

//     /**
//      * Reverse the migrations.
//      */
//     public function down(): void {
//         Setting::whereIn('name', [
//             'banner_ad_id_android',
//             'banner_ad_id_ios',
//             'banner_ad_status',
//             'interstitial_ad_id_android',
//             'interstitial_ad_id_ios',
//             'interstitial_ad_status',
//         ])->delete();

//         Schema::table('packages', static function (Blueprint $table) {
//             /*Rename the column*/
//             $table->renameColumn('price', 'discount_price');
//             $table->renameColumn('final_price', 'price');

//             /*Add new column*/
//             $table->dropColumn('discount_in_percentage');
//         });

//         /*This code is added separately because datatype was not changing when running in the code snippet*/
//         Schema::table('packages', static function (Blueprint $table) {
//             /*Change Datatype of old columns*/
//             $table->integer('price')->change();
//             $table->integer('discount_price')->change();
//         });

//         Schema::table('items', static function (Blueprint $table) {
//             $table->string('state')->nullable(false)->change();
//         });

//         Schema::dropIfExists('block_users');
//         Schema::dropIfExists('tips');
//         Schema::dropIfExists('tip_translations');

//     }
// };
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        // Insert default settings
        DB::table('settings')->insert([
            ['name' => 'banner_ad_id_android', 'value' => ''],
            ['name' => 'banner_ad_id_ios', 'value' => ''],
            ['name' => 'banner_ad_status', 'value' => 1],
            ['name' => 'interstitial_ad_id_android', 'value' => ''],
            ['name' => 'interstitial_ad_id_ios', 'value' => ''],
            ['name' => 'interstitial_ad_status', 'value' => 1],
        ]);

        // Rename columns using raw SQL
        DB::statement('ALTER TABLE packages CHANGE `price` `final_price` FLOAT NOT NULL');
        DB::statement('ALTER TABLE packages CHANGE `discount_price` `price` FLOAT NOT NULL');

        // Add new column
        Schema::table('packages', function (Blueprint $table) {
            $table->float('discount_in_percentage')->after('price')->default(0);
        });

        // Ensure correct column order
        Schema::table('packages', function (Blueprint $table) {
            $table->float('price')->after('name')->change();
            $table->float('final_price')->after('discount_in_percentage')->change();
        });

        // Update existing package prices
        DB::table('packages')->where('final_price', '!=', 0)->update([
            'price' => DB::raw('final_price'),
        ]);

        // Modify 'items' table column
        Schema::table('items', function (Blueprint $table) {
            $table->string('state')->nullable()->change();
        });

        // Create 'block_users' table
        Schema::create('block_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('restrict');
            $table->foreignId('blocked_user_id')->constrained('users')->onDelete('restrict');
            $table->unique(['user_id', 'blocked_user_id']);
            $table->timestamps();
        });

        // Create 'tips' table
        Schema::create('tips', function (Blueprint $table) {
            $table->id();
            $table->string('description', 512);
            $table->integer('sequence');
            $table->timestamps();
            $table->softDeletes();
        });

        // Create 'tip_translations' table
        Schema::create('tip_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tip_id')->constrained('tips')->onDelete('cascade');
            $table->foreignId('language_id')->constrained('languages')->onDelete('cascade');
            $table->string('description', 512);
            $table->timestamps();
            $table->unique(['tip_id', 'language_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        // Delete settings
        DB::table('settings')->whereIn('name', [
            'banner_ad_id_android',
            'banner_ad_id_ios',
            'banner_ad_status',
            'interstitial_ad_id_android',
            'interstitial_ad_id_ios',
            'interstitial_ad_status',
        ])->delete();

        // Rename columns back using raw SQL
        DB::statement('ALTER TABLE packages CHANGE `price` `discount_price` INT NOT NULL');
        DB::statement('ALTER TABLE packages CHANGE `final_price` `price` INT NOT NULL');

        // Remove the added column
        Schema::table('packages', function (Blueprint $table) {
            $table->dropColumn('discount_in_percentage');
        });

        // Change column types back
        Schema::table('packages', function (Blueprint $table) {
            $table->integer('price')->change();
            $table->integer('discount_price')->change();
        });

        // Modify 'items' table column
        Schema::table('items', function (Blueprint $table) {
            $table->string('state')->nullable(false)->change();
        });

        // Drop tables
        Schema::dropIfExists('block_users');
        Schema::dropIfExists('tips');
        Schema::dropIfExists('tip_translations');
    }
};
