<?php

namespace App\Http\Controllers\EClassify;

use App\Models\Category;
use App\Models\CustomField;
use App\Models\Item;
use App\Models\Language;
use App\Models\User;
use App\Services\ResponseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Session;
use Throwable;
use App\Http\Controllers\Controller; 

class HomeController extends Controller {
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }


    public function index() {
        $items = Item::select('id','name','price','latitude','longitude','city','state','country','image')->where('clicks','>',0)->inRandomOrder()->limit(50)->get();
        $categories = Category::withCount('items')->whereNull('parent_category_id')->get();
        $category_name = array();
        $category_item_count = array();

        foreach ($categories as $key => $value) {
            $category_name[] = "'" . $value->name . "'";
            $category_item_count[] = $value->items_count;
        }

        $categories_count = Category::count();
        $user_count = User::role('User')->count();
        $item_count = Item::count();
        $custom_field_count = CustomField::count();
        // $items = Item::all();
        return view('EClassify/home', compact('category_item_count', 'category_name', 'categories_count', 'item_count', 'user_count', 'custom_field_count','items'));
    }

    public function changePasswordIndex() {
        return view('change_password.index');
    }


    public function changePasswordUpdate(Request $request) {
        $validator = Validator::make($request->all(), [
            'old_password'     => 'required',
            'new_password'     => 'required|min:8',
            'confirm_password' => 'required|same:new_password',
        ]);
        if ($validator->fails()) {
            ResponseService::validationError($validator->errors()->first());
        }
        try {
            $user = Auth::user();
            if (!Hash::check($request->old_password, Auth::user()->password)) {
                ResponseService::errorResponse("Incorrect old password");
            }
            $user->password = Hash::make($request->confirm_password);
            $user->update();
            ResponseService::successResponse('Password Change Successfully');
        } catch (Throwable $th) {
            ResponseService::logErrorResponse($th, "HomeController --> changePasswordUpdate");
            ResponseService::errorResponse();
        }


    }


    public function changeProfileIndex() {
        return view('change_profile.index');
    }

    public function changeProfileUpdate(Request $request) {
        $validator = Validator::make($request->all(), [
            'name'    => 'required',
            'email'   => 'required|email|unique:users,email,' . Auth::user()->id,
            'profile' => 'nullable|mimes:jpeg,jpg,png'
        ]);
        if ($validator->fails()) {
            ResponseService::validationError($validator->errors()->first());
        }
        try {
            $user = Auth::user();
            $data = [
                'name'  => $request->name,
                'email' => $request->email
            ];
            if ($request->hasFile('profile')) {
                $data['profile'] = $request->file('profile')->store('admin_profile', 'public');
            }
            $user->update($data);
            ResponseService::successResponse('Profile Updated Successfully');
        } catch (Throwable $th) {
            ResponseService::logErrorResponse($th, "HomeController --> updateProfile");
            ResponseService::errorResponse();
        }

    }
    public function getMapsData()
    {
        $apiKey = env('PLACE_API_KEY');

        $url = "https://maps.googleapis.com/maps/api/js?" . http_build_query([
            'libraries' => 'places',
            'key' => $apiKey, // Use the API key from the .env file
            // Add any other parameters you need here
        ]);

        return file_get_contents($url);
    }
}
