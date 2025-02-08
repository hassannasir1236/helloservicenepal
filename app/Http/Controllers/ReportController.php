<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($type)
    {
        if ($type == "sales") {
            return view('reports.sales-reports');
        }
    }

    public function indexReports($type)
    {
        if ($type == "user") {
            return view("reports.user-report");
        } elseif ($type == "driver") {
            return view("reports.driver-report");
        } elseif ($type == "ride") {
            return view("reports.ride-report");
        } elseif ($type == "intercity") {
            return view("reports.intercity-report");
        } elseif ($type == "transaction") {
            return view("reports.transaction-report");
        } else {
            return false;
        }
    }

}

?>
