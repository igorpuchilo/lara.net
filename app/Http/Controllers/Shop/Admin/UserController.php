<?php

namespace App\Http\Controllers\Shop\Admin;

use App\Http\Requests\AdminUserEditRequest;
use App\Models\Admin\User;
use App\Models\UserRole;
use App\Repositories\Admin\MainRepository;
use App\Repositories\Admin\UserRepository;
use DB;
use MetaTag;

class UserController extends AdminBaseController
{
    private $userRepository;

    public function __construct()
    {
        parent::__construct();
        $this->userRepository = app(UserRepository::class);
    }

    /**
     * Display a listing of users
     */
    public function index()
    {
        MetaTag::setTags(['title' => 'User list']);

        $paginatePages = 15;
        $countUsers = MainRepository::getCountUsers();
        $users = $this->userRepository->getAllUsers($paginatePages);
        return view('shop.admin.user.index', compact('countUsers', 'users'));
    }

    /**
     * return user create form
     */
    public function create()
    {
        MetaTag::setTags(['title' => 'Create User']);
        return view('shop.admin.user.create');
    }

    /**
     * Store a newly created user
     */
    public function store(AdminUserEditRequest $request)
    {
        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
        ]);
        if (!$user) {
            return back()->withErrors(['msg' => 'Error on create!'])->withInput();
        } else {
            $role = UserRole::create([
                'user_id' => $user->id,
                'role_id' => (int)$request['role'],
            ]);
            if (!$role) {
                return back()->withErrors(['msg' => 'Error on create role!'])->withInput();
            } else {
                return redirect()->route('shop.admin.users.index', $user->id)->with(['success' => 'Saved']);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing user
     */
    public function edit($id)
    {
        MetaTag::setTags(['title' => 'User Edit']);

        $paginatePages = 15;
        $item = $this->userRepository->getId($id);
        if (empty($item)) abort(404);
        $orders = $this->userRepository->getUserOrders($id, $paginatePages);
        $role = $this->userRepository->getUserRole($id);
        $countOrders = $this->userRepository->getCountOrders($id);
        $countOrdersPaginate = $this->userRepository->getCountOrdersPaginate($id, $paginatePages);
        return view('shop.admin.user.edit', compact('orders', 'item', 'role',
            'countOrders', 'countOrdersPaginate'));
    }

    // Save user data after change
    public function update(AdminUserEditRequest $request, User $user, UserRole $role)
    {
        $user->name = $request['name'];
        $user->email = $request['email'];
        $request['password'] == null ?: $user->password = bcrypt($request['password']);
        $res = $user->save();
        if (!$res) {
            return back()->withErrors(['msg' => 'Error on update!'])->withInput();
        } else {
            $role->where('user_id', $user->id)->update(['role_id' => (int)$request['role']]);
            return redirect()->route('shop.admin.users.edit', $user->id)->with(['success' => 'Saved']);
        }
    }

    /**
     * Remove user from DB
     */
    public function destroy(User $user)
    {
        $id = $user->id;
        $res = $user->forceDelete();
        DB::table('user_roles')->where('user_id',$id)->delete();
            DB::table('orders')->where('user_id',$id)->delete();
        if (!$res) {
            return back()->withErrors(['msg' => 'Error on delete!']);
        } else {
            return redirect()->route('shop.admin.users.index')->with(['success' => 'User has been deleted!']);
        }
    }
}
