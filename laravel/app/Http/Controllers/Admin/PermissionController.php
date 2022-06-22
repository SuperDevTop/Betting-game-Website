<?php

namespace App\Http\Controllers\Admin;

use Gate;
use App\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Transformers\PermissionsTransformer;

class PermissionController extends Controller
{
    protected $permission;
    protected $permissionsTransformer;

    public function __construct(Permission $permission, PermissionsTransformer $permissionsTransformer)
    {
        $this->permission             = $permission;
        $this->permissionsTransformer = $permissionsTransformer;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::allows('developerOnly')) {
            // If there is an Ajax request or any request wants json data
            if (request()->ajax() || request()->wantsJson()) {
                $sort   = request()->has('sort')?request()->get('sort'):'title';
                $order  = request()->has('order')?request()->get('order'):'asc';
                $search = request()->has('searchQuery')?request()->get('searchQuery'):'';

                $permissions = $this->permission->where(function ($query) use ($search) {
                    if ($search) {
                        $query->where('name', 'like', "$search%")
                            ->orWhere('label', 'like', "$search%");
                    }
                })
                ->where('id', '<>', DEVELOPER_PERMISSION_KEY)
                ->orderBy("$sort", "$order")->paginate(10);

                if ($permissions->count() <= 0) {
                    return response([
                        'status_code' => 404,
                        'message'     => trans('messages.not-found')
                    ], 404);
                }

                // Paginator For this list
                $paginator=[
                    'total_count'  => $permissions->total(),
                    'total_pages'  => $permissions->lastPage(),
                    'current_page' => $permissions->currentPage(),
                    'limit'        => $permissions->perPage()
                ];

                return response([
                    'data'        => $this->permissionsTransformer->transformCollection($permissions->all()),
                    'paginator'   => $paginator,
                    'status_code' => 200
                ], 200);
            }
            return view('admin.permission');
        }
        return view('errors.503');
    }

    public function all()
    {
        if (Gate::allows('developerOnly')) {
            $permissions = $this->permission->all();
        } else {
            $permissions = $this->permission->where('id', '<>', DEVELOPER_PERMISSION_KEY)->get();
        }

        return response([
            'data'        => $this->permissionsTransformer->transformCollection($permissions->toArray()),
            'status_code' => 200
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // VALIDATION OF INPUT
        $validator = validator()->make($request->all(), [
            'name' => 'required|max:255'
        ]);
        if ($validator->fails()) {
            return response(['error' => trans('messages.parameters-fail-validation')], 422);
        }

        $input = array_only($request->all(), ['name', 'label']);

        $this->permission->name  = $input['name'];
        $this->permission->label = $input['label'];
        $this->permission->save();

        if ($request->wantsJson()) {
            return response([
                'data'        => $this->permissionsTransformer->transform($this->permission->toArray()),
                'message'     => trans('messages.permission-add'),
                'status_code' => 201
            ], 201);
        }

        flash(trans('messages.permission-add'), 'success', 'success');
        return back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permission $permission)
    {
        $validator = validator()->make($request->all(), [
            'name' => 'required|max:255'
        ]);
        if ($validator->fails()) {
            return response(['error' => trans('messages.parameters-fail-validation')], 422);
        }

        // SET AND UPDATE
        $permission->name  = $request->get('name');
        $permission->label = $request->get('label');
        $permission->save();

        if ($request->wantsJson()) {
            return response([
                'data'        => $this->permissionsTransformer->transform($permission->toArray()),
                'message'     => trans('messages.permission-update'),
                'status_code' => 200
            ], 200);
        }
        flash(trans('messages.permission-add'), 'success', 'success');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        $permission->delete();
        return response([
            'data'        => [],
            'message'     => trans('messages.permission-distroy'),
            'status_code' => 200
        ], 200);
    }
}
