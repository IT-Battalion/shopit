<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Session;
use Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Application|ResponseFactory|Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string|required',
        ]);

        if ($validator->fails()) {
            Session::flash($validator->errors());
            return redirect()->back()->withInput();
        }

        ProductCategory::create([
            'name' => $request['name'],
        ]);
        return response('Success', 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string|required',
        ]);

        if ($validator->fails()) {
            Session::flash($validator->errors());
            return redirect()->back()->withInput();
        }

        ProductCategory::whereId($id)->update(['name' => $request['name']]);
        return response('Success', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        ProductCategory::whereId($id)->delete();
        return response('Success', 200);
    }
}
