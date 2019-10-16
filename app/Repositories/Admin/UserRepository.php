<?php


namespace App\Repositories\Admin;


use App\Repositories\CoreRepository;
use App\Models\Admin\User;
use DB;

class UserRepository extends CoreRepository
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function getModelClass()
    {
        return User::class;
    }

    public function getAllUsers($paginate){
        $users = $this->startConditions()
            ->join('user_roles','user_roles.user_id', '=','users.id')
            ->join('roles','user_roles.role_id','=','roles.id')
            ->select('users.id','users.name','users.email','roles.name as role')
            ->orderBy('users.id')
            ->toBase()
            ->paginate($paginate);
        return $users;
    }
    public function getUserOrders($id, $paginate){
        $res = $this->startConditions()::withTrashed()
            ->join('orders','orders.user_id','=','users.id')
            ->join('order_products','order_products.order_id','=','orders.id')
            ->select('orders.id','orders.user_id','orders.status','orders.created_at',
                'orders.updated_at','orders.currency',\DB::raw('ROUND(SUM(order_products.price),2) AS sum'))
            ->where('user_id','=',$id)
            ->groupBy('orders.id')
            ->orderBy('orders.status')
            ->orderBy('orders.id')
            ->paginate($paginate);
        return $res;
    }
    public function getUserRole($id){
        $res = $this->startConditions()
            ->find($id)
            ->roles()
            ->first();
        return $res;
    }
    public function getCountOrders($id){
        $res = DB::table('orders')
            ->where('user_id','=',$id)
            ->count();
        return $res;
    }
    public function getCountOrdersPaginate($id,$paginate){
        $res = DB::table('orders')
            ->where('user_id','=',$id)
            ->limit($paginate)
            ->get();
        return $res;
    }

}