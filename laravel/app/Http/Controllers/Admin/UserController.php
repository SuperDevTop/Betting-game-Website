<?php

namespace App\Http\Controllers\Admin;

use Gate;
use App\User;
use Illuminate\Http\Request;
use App\Mail\AdminCreatedUserMail;
use App\Http\Controllers\Controller;
use App\Traits\FileManipulationTrait;
use App\Transformers\UsersTransformer;

class UserController extends Controller
{
    use FileManipulationTrait;

    protected $user;
    protected $userTransformer;

    public function __construct(User $user, UsersTransformer $userTransformer)
    {
        $this->user            = $user;
        $this->userTransformer = $userTransformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::denies('developerOnly') && Gate::denies('user.list')) {
            return back();
        }

        // If there is an Ajax request or any request wants json data
        if (request()->ajax() || request()->wantsJson()) {
            $sort   = request()->has('sort')?request()->get('sort'):'first';
            $order  = request()->has('order')?request()->get('order'):'asc';
            $search = request()->has('searchQuery')?request()->get('searchQuery'):'';

            $users = $this->user->where(function ($query) use ($search) {
                if ($search) {
                    $query->where('first', 'like', "$search%")
                        ->orWhere('last', 'like', "$search%")
                        ->orWhere('email', 'like', "$search%");
                }
            })
            ->orderBy("$sort", "$order")->paginate(10);

            if ($users->count()<=0) {
                return response([
                    'status_code' => 404,
                    'message'     => trans('messages.not-found')
                ], 404);
            }

            $paginator=[
                'total_count'  => $users->total(),
                'total_pages'  => $users->lastPage(),
                'current_page' => $users->currentPage(),
                'limit'        => $users->perPage()
            ];

            return response([
                'data'        => $this->userTransformer->transformCollection($users->all()),
                'paginator'   => $paginator,
                'status_code' => 200
            ], 200);
        }
        return view('admin.users.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Gate::denies('developerOnly') && Gate::denies('user.create')) {
            return back();
        }
        return view('admin.users.add', [
            'defaultImg' => url('/images/square/admin.png')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Gate::denies('developerOnly') && Gate::denies('user.create')) {
            return back();
        }

        // VALIDATION OF INPUT
        if ($hasPicture = $request->hasFile('pic')) {
            $validator = validator()->make($request->all(), [
                'name'    => 'required|max:255',
                'email'    => 'required|email|max:255|unique:users',
                'pic'      => 'image|mimes:jpeg,bmp,png'
            ]);
        } else {
            $validator = validator()->make($request->all(), [
                'name'    => 'required|max:255',
                'email'    => 'required|email|max:255|unique:users'
            ]);
        }

        if ($validator->fails()) {
            flash(trans('messages.parameters-fail-validation'), 'error', 'error');
            return back()->withErrors($validator)->withInput();
        }

        // Prepare input
        $setPassword       = randomInteger();
        $input             = array_only($request->all(), ['name', 'email']);
        $input['password'] = bcrypt($setPassword);

        //  Create User
        $user = $this->user->create($input);

        // If has pic then upload new pic
        if ($request->hasFile('pic')) {
            $pic       = $request->file('pic');
            $path      = $this->quickUpload($pic, 'user/'.$user->id);
            $user->profile_pic = $path;
            $user->save();
        }

        //  Send mail for password
        $mail = new AdminCreatedUserMail($user, $setPassword);
        \Mail::to($user->email)->send($mail);

        flash(trans('messages.user-add'), 'success', 'success');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Gate::denies('developerOnly') && Gate::denies('user.edit')) {
            return back();
        }

        $user = $this->user->find($id);

        if (!$user) {
            flash(trans('messages.user-not-found'), 'info');
            return back();
        }
        $picture = $user->profile_pic?$this->getFileUrl($user->profile_pic):url('/images/square/admin.png');
        return view('admin.users.edit', compact('user', 'picture'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Gate::denies('developerOnly') && Gate::denies('user.edit')) {
            return back();
        }

        $user = $this->user->find($id);

        if (!$user) {
            flash(trans('messages.user-not-found'), 'info');
            return back();
        }

        $picture = $user->profile_pic?$this->getFileUrl($user->profile_pic):url('/images/square/admin.png');

        return view('admin.users.edit', compact('user', 'picture'));
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
        if (Gate::denies('developerOnly') && Gate::denies('user.update')) {
            return back();
        }
        $user = $this->user->find($id);

        if (!$user) {
            flash(trans('messages.user-not-found'), 'info');
            return back();
        }

        // VALIDATION OF INPUT
        if ($hasPicture = $request->hasFile('pic')) {
            $validator = validator()->make($request->all(), [
                'name'  => 'required|max:255',
                'email' => 'required|email|max:255|unique:users,email,'.$user->id.',id',
                'pic'   => 'image|mimes:jpeg,bmp,png'
            ]);
        } else {
            $validator = validator()->make($request->all(), [
                'name'  => 'required|max:255',
                'email' => 'required|email|max:255|unique:users,email,'.$user->id.',id',
            ]);
        }
        if ($validator->fails()) {
            flash(trans('messages.parameters-fail-validation'), 'error', 'error');
            return back()->withErrors($validator)->withInput();
        }

        // Prepare input
        $input = array_only($request->all(), ['name', 'email']);
        extract($input);

        // If has pic then update new pic
        if ($request->hasFile('pic')) {
            $pic  = $request->file('pic');

            $path = $this->quickUpload($pic, 'user/'.$user->id);
            if ($path != '' && $user->pic != 'avatar.png') {
                $this->destoryFile("public/$user->profile_pic");
            }
            $user->profile_pic = $path;
        }

        $user->name = $name;
        $user->email = $email;
        $user->save();

        flash(trans('messages.user-update'), 'success', 'success');
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
        if (Gate::denies('developerOnly') && Gate::denies('user.remove')) {
            return back();
        }
        $user = $this->user->find($id);
        $user->delete();
        return response([
            'data'        => [],
            'message'     => trans('messages.user-distroy'),
            'status_code' => 200
        ], 200);
    }

    /**
     * Remove the bulk resource from storage.
     *
     * @param  Request $request [description]
     * @return \Illuminate\Http\Response
     */
    public function destroyBulk(Request $request)
    {
        if (Gate::denies('developerOnly') && Gate::denies('user.remove')) {
            return back();
        }

        $this->user->destroy($request->all());

        return response([
            'data'        => [],
            'message'     => trans('messages.user-distroy'),
            'status_code' => 200
        ], 200);
    }

    /**
     * Switch specified user's active status
     *
     * @param  Request $request [description]
     * @return \Illuminate\Http\Response
     */
    public function switchStatus(Request $request)
    {
        if (Gate::denies('developerOnly') && Gate::denies('user.update')) {
            return back();
        }

        $validator = validator()->make($request->all(), [
            'id'   =>'required'
        ]);

        if ($validator->fails()) {
            return response(['error' => trans('messages.parameters-fail-validation')], 422);
        }

        extract($request->all());
        $user = $this->user->find($id);

        if ($user) {
            $newStatus = ($user->status == User::STATE_ACTIVE)? User::STATE_INACTIVE: User::STATE_ACTIVE;
            $user->status = $newStatus;
            $user->save();

            // Get New updated Object of User
            $updated          = $user->toArray();
            $updated['roles'] = $user->roles;

            if ($request->wantsJson()) {
                return response([
                    'data'        => $this->userTransformer->transform($updated),
                    'message'     => trans('messages.user-status', ['status' => $newStatus]),
                    'status_code' => 200
                ], 200);
            }

            flash(trans('messages.admin-status', ['status' => $newStatus]), 'success', 'success');
            return back();
        }

        flash(trans('messages.admin-update-fail'), 'error');
        return back();
    }

    /**
     * Switch bulk users' active status
     *
     * @param  Request $request [description]
     * @return \Illuminate\Http\Response
     */
    public function switchStatusBulk(Request $request)
    {
        if (Gate::denies('developerOnly') && Gate::denies('user.update')) {
            return back();
        }

        $input = $request->all();

        if (count($input) == 0) {
            return response(['error' => trans('messages.parameters-fail-validation')], 422);
        }

        $users = $this->user->whereIn('id', $request->all())->get();

        if ($users->count() > 0) {
            foreach ($users as $user) {
                $newStatus    = ($user->status == User::STATE_ACTIVE)? User::STATE_INACTIVE: User::STATE_ACTIVE;
                $user->status = $newStatus;
                $user->save();
            }

            if ($request->wantsJson()) {
                return response([
                    'data'        => [],
                    'message'     => trans('messages.user-status', ['status' => 'updated']),
                    'status_code' => 200
                ], 200);
            }

            flash(trans('messages.user-status', ['status' => 'updated']), 'success');
            return back();
        }

        flash(trans('messages.user-update-fail'), 'error');
        return back();
    }
}
