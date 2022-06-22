<?php

namespace App\Http\Controllers\Admin;

use Gate;
use App\Role;
use App\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Transformers\RolesTransformer;
use App\Transformers\PermissionsTransformer;

class RoleController extends Controller
{
    protected $role;
    protected $rolesTransformer;
    protected $permissionsTransformer;

    public function __construct(Role $role, RolesTransformer $rolesTransformer, PermissionsTransformer $permissionsTransformer)
    {
        $this->role             = $role;
        $this->rolesTransformer = $rolesTransformer;
        $this->permissionsTransformer = $permissionsTransformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::denies('developerOnly') && Gate::denies('role')) {
            return back();
        }
        // If there is an Ajax request or any request wants json data
        if (request()->ajax() || request()->wantsJson()) {
            $sort   = request()->has('sort')?request()->get('sort'):'title';
            $order  = request()->has('order')?request()->get('order'):'asc';
            $search = request()->has('searchQuery')?request()->get('searchQuery'):'';

            $roles = $this->role->where(function ($query) use ($search) {
                if ($search) {
                    $query->where('name', 'like', "$search%")
                        ->orWhere('label', 'like', "$search%");
                }
            })
            ->where('id', '<>', DEVELOPER_ROLE_KEY)
            ->orderBy("$sort", "$order")->paginate(10);

            if ($roles->count() <= 0) {
                return response([
                    'status_code' => 404,
                    'message'     => trans('messages.not-found')
                ], 404);
            }

            // Paginator For this list
            $paginator = [
                'total_count'  => $roles->total(),
                'total_pages'  => $roles->lastPage(),
                'current_page' => $roles->currentPage(),
                'limit'        => $roles->perPage()
            ];
            return response([
                'data'        => $this->rolesTransformer->transformCollection($roles->all()),
                'paginator'   => $paginator,
                'status_code' => 200
            ], 200);
        }
        return view('admin.role');
    }

    /**
     * All Roles
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        if (Gate::allows('developerOnly')) {
            $roles = $this->role->all();
        } else {
            $roles = $this->role->where('id', '<>', DEVELOPER_ROLE_KEY)->get();
        }

        return response([
            'data'        => $this->rolesTransformer->transformCollection($roles->toArray()),
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
        if (Gate::denies('developerOnly') && Gate::denies('role')) {
            return response(['error' => trans('messages.unauthorized-access')], 401);
        }

        $validator = validator()->make($request->all(), [
            'name' => 'required|max:255'
        ]);
        if ($validator->fails()) {
            return response(['error' => trans('messages.parameters-fail-validation')], 422);
        }

        $input = array_only($request->all(), ['name','label']);

        # Setting up to save
        $this->role->name  = $input['name'];
        $this->role->label = $input['label'];
        $this->role->save();

        $response = array_only($this->role->toArray(), ['name', 'label', 'id']);

        if ($request->wantsJson()) {
            return response([
                'data'        => $this->rolesTransformer->transform($this->role->toArray()),
                'message'     => trans('messages.role-add'),
                'status_code' => 201
            ], 201);
        }

        flash(trans('messages.role-add'), 'success', 'success');
        return back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        if (Gate::denies('developerOnly') && Gate::denies('role')) {
            return response(['error' => trans('messages.unauthorized-access')], 401);
        }

        $validator = validator()->make($request->all(), [
            'name' => 'required|max:255'
        ]);

        if ($validator->fails()) {
            return response(['error' => trans('messages.parameters-fail-validation')], 422);
        }

        // SET AND UPDATE
        $role->name  = $request->get('name');
        $role->label = $request->get('label');
        $role->save();

        if ($request->wantsJson()) {
            return response([
                'data'        => $this->rolesTransformer->transform($role->toArray()),
                'message'     => trans('messages.role-update'),
                'status_code' => 200
            ], 200);
        }

        flash(trans('messages.role-add'), 'success', 'success');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        if (Gate::denies('developerOnly') && Gate::denies('role')) {
            return response(['error' => trans('messages.unauthorized-access')], 401);
        }

        $role->delete();

        return response([
            'data'        => [],
            'message'     => trans('messages.role-distroy'),
            'status_code' => 200
        ], 200);
    }

    /**
     * Role Permissions
     *
     * @param  Role   $role [description]
     * @return \Illuminate\Http\Response
     */
    public function permissions(Role $role)
    {
        $permissions     = $role->permissions;
        $permissionsList = [];

        if ($permissions->count()) {
            foreach ($permissions as $permission) {
                array_push($permissionsList, [
                    'id'    => $permission->id,
                    'name'  => $permission->name,
                    'label' => $permission->label,
                ]);
            }
        }

        return response([
            'data'        => $permissionsList,
            'status_code' => 200
        ], 200);
    }

    /**
     * Role Permission assignment view
     *
     */
    public function rolePermissions()
    {
        return view('admin.role-permission');
    }

    /**
     * Attaching Permission to role
     *
     * @param  Request $request [description]
     * @return Permissions $permission
     */
    public function attachPermission(Request $request)
    {
        if (Gate::denies('developerOnly') && Gate::denies('role')) {
            return response(['error' => trans('messages.unauthorized-access')], 401);
        }

        $validator = validator()->make($request->all(), [
            'permissionID' => 'required',
            'roleID'       => 'required'
        ]);

        if ($validator->fails()) {
            return response(['error' => trans('messages.parameters-fail-validation')], 422);
        }
        extract($request->all());

        // Role Modal Object for this RoleID
        $role = $this->role->findOrFail($roleID);

        // Permission Modal Object for this permissionID
        $permission = Permission::findOrFail($permissionID);

        //  Assigning Permission to $role
        $role->givePermissionTo($permission);

        // Revierting a new permission for the role selected.
        return $this->permissions($role); // Native Function
    }

    /**
     * Detach Permission
     *
     * @param  Request $request [description]
     * @return Permissions $permission
     */
    public function detachPermission(Request $request)
    {
        if (Gate::denies('developerOnly') && Gate::denies('role')) {
            return response(['error' => trans('messages.unauthorized-access')], 401);
        }
        $validator = validator()->make($request->all(), [
            'permissionID' => 'required',
            'roleID'       => 'required'
        ]);

        if ($validator->fails()) {
            return response(['error' => trans('messages.parameters-fail-validation')], 422);
        }

        extract($request->all());

        // Role Modal Object for this RoleID
        $role = $this->role->findOrFail($roleID);

        // Permission Modal Object for this permissionID
        $permission = Permission::findOrFail($permissionID);

        //  Assigning Permission to $role
        $role->detachPermissionFrom($permission);

        // Revierting a new permission for the role selected.
        return $this->permissions($role); // Native Function
    }
}
