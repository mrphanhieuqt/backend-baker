<?php
namespace App\Http\Controllers\Admin;

use App\{{Model}};
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

class {{Page}}Controller extends Controller
{
    /**
     * @param Request $request
     * @return View
     */
    public function index(Request $request) {
        $limit = env('APP_NUM_PER_PAGE');
        $data = {{Model}}::paginate($limit);

        return view('admin.{{page}}.index', ['data' => $data]);
    }

    /**
    * @param Request $request
    * @return View
    */
    public function add(Request $request) {
        if($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
            ]);

            if (!$validator->fails()) {
                $s = {{Model}}::create($request->all());
                if(!empty($s)) {
                    $request->session()->flash('success', trans('admin::messages.add.success'));
                    return redirect()->action('Admin\{{Page}}Controller@edit', ['id' => $s->id]);
                }
            }
        }

        $data = null;
        return view('admin.{{page}}.add', ['data' => $data]);
    }

    /**
    * @param Request $request
    * @return View
    */
    public function edit(Request $request, $id) {
        $data = {{Model}}::find($id);
        return view('admin.{{page}}.edit', ['data' => $data]);
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
        if($n > 1) {
            $request->session()->flash('success', trans('admin::messages.delete.success.2', ['num' => $n]));
        } elseif($n == 1) {
            $request->session()->flash('success', trans('admin::messages.delete.success.1'));
        } else {
            $request->session()->flash('error', trans('admin::messages.delete.error'));
        }
        return back();
    }
}