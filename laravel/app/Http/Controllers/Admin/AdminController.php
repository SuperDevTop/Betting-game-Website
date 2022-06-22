<?php

namespace App\Http\Controllers\Admin;

use Gate;
use App\Admin;
use Illuminate\Http\Request;
use App\Mail\WelcomeNewAdmin;
use App\Http\Controllers\Controller;
use App\Traits\FileManipulationTrait;
use App\Transformers\AdminTransformer;

class AdminController extends Controller
{
    use FileManipulationTrait;

    protected $admin;
    protected $adminTransformer;

    public function __construct(Admin $admin, AdminTransformer $adminTransformer)
    {
        $this->admin            = $admin;
        $this->adminTransformer = $adminTransformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::denies('developerOnly') && Gate::denies('admin.list')) {
            return back();
        }
        // If there is an Ajax request or any request wants json data
        if (request()->ajax() || request()->wantsJson()) {
            $sort   = request()->has('sort')?request()->get('sort'):'name';
            $order  = request()->has('order')?request()->get('order'):'asc';
            $search = request()->has('searchQuery')?request()->get('searchQuery'):'';

            $admins = $this->admin->where(function ($query) use ($search) {
                if ($search) {
                    $query->where('admins.name', 'like', "$search%")
                        ->orWhere('admins.email', 'like', "$search%")
                        ->orWhere('admins.designation', 'like', "$search%");
                }
            })
            ->where('id', '<>', DEVELOPER_KEY)
            ->where('id', '<>', auth()->user()->id)
            ->orderBy("$sort", "$order")->paginate(10);
            if ($admins->count() <= 0) {
                return response([
                    'status_code' => 404,
                    'message'     => trans('messages.not-found')
                ], 404);
            }

            $paginator = [
                'total_count'  => $admins->total(),
                'total_pages'  => $admins->lastPage(),
                'current_page' => $admins->currentPage(),
                'limit'        => $admins->perPage()
            ];

            return response([
                'data'        => $this->adminTransformer->transformCollection($admins->all()),
                'paginator'   => $paginator,
                'status_code' => 200
            ], 200);
        }
        return view('admin.administrator.list');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Gate::denies('developerOnly') && Gate::denies('admin.create')) {
            return response(['error' => trans('messages.unauthorized-access')], 401);
        }

        $validator = validator()->make($request->all(), [
            'name'   => 'required|max:255',
            'email'  => 'required|email|max:255|unique:admins',
            'inrole' => 'required'
        ]);
        if ($validator->fails()) {
            return response(['error' => trans('messages.parameters-fail-validation')], 422);
        }

        // Prepare Input
        $setPassword       = randomInteger();
        $input             = array_only($request->all(), ['name', 'email']);
        $input['password'] = bcrypt($setPassword);
        $input['status']   = Admin::STATE_ACTIVE;

        // Create Admin
        $admin = $this->admin->create($input);

        // Assign Role
        if ($request->get('inrole') != '') {
            $admin->assignRole($request->get('inrole'));
        }

        // Mailing for password
        $mail = new WelcomeNewAdmin($admin, $setPassword);
        \Mail::to($admin->email)->send($mail);

        $newAdmin          = $admin->toArray();
        $newAdmin['roles'] = $admin->roles;

        if ($request->wantsJson()) {
            return response([
                'data'        => $this->adminTransformer->single($newAdmin),
                'message'     => trans('messages.admin-add'),
                'status_code' => 201
            ], 201);
        }

        flash(trans('messages.admin-add'), 'success', 'success');
        return back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (Gate::denies('developerOnly') && Gate::denies('admin.edit')) {
            return response(['error' => trans('messages.unauthorized-access')], 401);
        }

        $admin = Admin::findOrFail($id);

        $validator = validator()->make($request->all(), [
            'name'        => 'required|max:255',
            'email'       => 'required|email|max:255|unique:admins,email,'.$admin->id.',id',
            'designation' => 'max:255',
            'inrole'      => 'required'
        ]);

        if ($validator->fails()) {
            return response(['error' => trans('messages.parameters-fail-validation')], 422);
        }

        extract($request->all());

        // Update in Role
        if (! $admin->hasRole($inrole)) {
            $existingRoles = $this->adminTransformer->roleName($admin->roles);
            if ($existingRoles) {
                foreach ($existingRoles as $eachRole) {
                    $admin->detachRole($eachRole);
                }
            }
            $admin->assignRole($inrole);
        }

        // Set new updated profile contents to admin
        $admin->name        = $name;
        $admin->email       = $email;
        $admin->designation = $designation;
        $admin->save();

        if ($request->wantsJson()) {
            return response([
                'data'        => $this->adminTransformer->single($admin->toArray()),
                'message'     => trans('messages.admin-update'),
                'status_code' => 200
            ], 200);
        }
        flash(trans('messages.admin-update'), 'success', 'success');
        return back();
    }

    /**
     * Switch status toggle (active/inactive)
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function switchStatus(Request $request)
    {
        if (Gate::denies('developerOnly') && Gate::denies('admin.update')) {
            return response(['error' => trans('messages.unauthorized-access')], 401);
        }

        $validator = validator()->make($request->all(), [
            'id'   => 'required'
        ]);

        if ($validator->fails()) {
            return response(['error' => trans('messages.parameters-fail-validation')], 422);
        }

        extract($request->all());

        $admin= $this->admin->findOrFail($id);

        if ($admin->count() > 0) {
            $newStatus = ($admin->status == Admin::STATE_ACTIVE)? Admin::STATE_INACTIVE: Admin::STATE_ACTIVE;
            $admin->status = $newStatus;
            $admin->save();

            // Get New updated Object of Admin
            $updated = $admin->toArray();
            $updated['roles'] = $admin->roles;

            if ($request->wantsJson()) {
                return response([
                    'data'        => $this->adminTransformer->single($updated),
                    'message'     => trans('messages.admin-status', ['status' => $newStatus]),
                    'status_code' => 200
                ], 200);
            }
            flash(trans('messages.admin-status', ['status' => $newStatus]), 'success', 'success');
            return back();
        }
        flash(trans('messages.admin-update-fail'), 'error', 'error');
        return back();
    }

    /**
     * Switch status toggle (active/inactive) in bulk
     * @param  Request $request [description]
     * @return \Illuminate\Http\Response
     */
    public function switchStatusBulk(Request $request)
    {
        if (Gate::denies('developerOnly') && Gate::denies('admin.update')) {
            return back();
        }

        $input = $request->all();
        if (count($input) == 0) {
            return response(['error'=>trans('messages.parameters-fail-validation')], 422);
        }

        $admins= $this->admin->whereIn('id', $request->all())->get();

        if ($admins->count() > 0) {
            foreach ($admins as $admin) {
                $newStatus = ($admin->status == Admin::STATE_ACTIVE)? Admin::STATE_INACTIVE: Admin::STATE_ACTIVE;
                $admin->status = $newStatus;
                $admin->save();
            }

            if ($request->wantsJson()) {
                return response([
                    'data'        => [],
                    'message'     => trans('messages.admin-status', ['status' => 'updated']),
                    'status_code' => 200
                ], 200);
            }
            flash(trans('messages.admin-status', ['status' => 'updated']), 'success', 'success');
            return back();
        }
        flash(trans('messages.admin-update-fail'), 'error', 'error');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Gate::denies('developerOnly') && Gate::denies('admin.remove')) {
            return response(['error' => trans('messages.unauthorized-access')], 401);
        }

        $admin = $this->admin->findOrFail($id);
        $admin->delete();

        return response([
            'data'        => [],
            'message'     => trans('messages.admin-distroy'),
            'status_code' => 200
        ], 200);
    }

    /**
     * Remove the bulk resource from storage
     * @param  Request $request [description]
     * @return \Illuminate\Http\Response
     */
    public function destroyBulk(Request $request)
    {
        if (Gate::denies('developerOnly') && Gate::denies('admin.remove')) {
            return back();
        }

        $this->admin->destroy($request->all());

        return response([
            'data'        => [],
            'message'     => trans('messages.admin-distroy'),
            'status_code' => 200
        ], 200);
    }

    /**
     * Admin logged in user profile edit view
     *
     */
    public function profileEdit()
    {
        $adminPic = auth()->user()->pic?
            $this->getFileUrl(auth()->user()->pic):url('/images/square/male_6.jpg');
        return view('admin.profile', compact('adminPic'));
    }

    /**
     * Update logged in admin user profile
     * @param  Request $request [description]
     * @param  Admin   $admin   [description]
     *
     */
    public function profileUpdate(Request $request, Admin $admin)
    {
        // Validation CASE-1 : has file then it must be image with name is required
        if ($hasPicture = $request->hasFile('pic')) {
            $validator = validator()->make($request->all(), [
                'name'        => 'required|max:255',
                'designation' => 'max:255',
                'pic'         => 'image|mimes:jpeg,bmp,png'
            ]);
        }

        // Validation CASE-2 : there is no-file in request
        else {
            $validator = validator()->make($request->all(), ['name'=>'required|max:255']);
        }

        // If validation fail
        if ($validator->fails()) {
            flash(trans('messages.parameters-fail-validation'), 'error', 'error');
            return back()->withErrors($validator)->withInput();
        }

        // If has pic then upload new pic
        if ($request->hasFile('pic')) {
            if ($admin->pic != '' && $admin->pic != 'admin.png') {
                $this->destoryFile("public/$admin->pic");
            }

            $pic        = $request->file('pic');
            $path       = $this->uploadAs($pic, 'admin/'.$admin->id);
            $admin->pic = $path;
        }

        //  Save the name of admin and designation
        $admin->name        = $request->get('name');
        $admin->designation = $request->designation;
        $admin->save();

        //  Throw the flash message
        flash(trans('messages.admin-profile-update'), 'success', 'success');
        return back()->with('show-alert', true);
    }

    /**
     * Change Password of Admin User (Update Profile)
     * @param  Request $request [description]
     * @param  Admin   $admin   [description]
     *
     */
    public function changePassword(Request $request, Admin $admin)
    {
        /// Validate inputes
        $validator = validator()->make($request->all(), [
            'oldpassword'           => 'required',
            'password'              => 'required|min:6|max:16',
            'password_confirmation' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            flash(trans('messages.parameters-fail-validation'), 'error', 'error');
            return back()->withErrors($validator)->withInput();
        }

        if (! \Hash::check($request->get('oldpassword'), $admin->password)) {
            flash(trans('passwords.oldpassword-wrong'), 'warning', 'warning');
            return back()->withInput();
        }


        //  Save the New Password
        $admin->password = bcrypt($request->get('password'));
        $admin->save();

        //  Throw the flash message
        flash(trans('passwords.reset'), 'success', 'success');
        return back()->with('show-alert', true);
    }
}
