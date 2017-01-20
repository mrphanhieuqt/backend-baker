<?php
namespace App\Http\Controllers\Auth;

use App\{{Model}};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class {{Page}}Controller extends Controller
{
    /**
     * @param Request $request
     * @return View
     */
    public function index(Request $request) {


        return view('{{page}}.index', $data);
    }

}