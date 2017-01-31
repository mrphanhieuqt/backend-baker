<?php
namespace App\Http\Controllers;

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
        $limit = env('APP_NUM_PER_PAGE');
        $data = {{Model}}::paginate($limit);

        return view('{{page}}.index', ['data' => $data]);
    }

    /**
    * @param Request $request
    * @return View
    */
    public function add(Request $request) {
        $data = null;
        return view('{{page}}.add', ['data' => $data]);
    }

    /**
    * @param Request $request
    * @return View
    */
    public function edit(Request $request, $id) {
        $data = {{Model}}::find($id);
        return view('{{page}}.edit', ['data' => $data]);
    }

    /**
    * @param Request $request
    */
    public function delete(Request $request) {
        $ids = $request->get('id', []);
        if(!is_array($ids)) {
            $ids = [$ids];
        }
        $n = {{Model}}::whereIn('id', $ids)->delete();
        if($n > 0) {
            $request->session()->flash('success', trans('admin::messages.delete.success.1'));
        } elseif($n == 1) {
            $request->session()->flash('success', trans('admin::messages.delete.success.2', ['num' => $n]));
        } else {
            $request->session()->flash('error', trans('admin::messages.delete.error'));
        }
        return back();
    }
}