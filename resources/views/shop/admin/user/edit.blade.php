@extends('layouts.app_admin')

@section('content')
    <section class="content-header">
        @component('shop.admin.components.breadcrumb')
            @slot('title') User Edit @endslot
            @slot('parent') Home @endslot
            @slot('user') User List @endslot
            @slot('active') User Edit @endslot
        @endcomponent
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <form action="{{route('shop.admin.users.update',$item->id)}}" method="POST" data-toggle="validator">
                        @method('PUT')
                        @csrf
                        <div class="box-body">
                            <div class="form-group has-feedback">
                                <label for="name">Login</label>
                                <input type="text" class="form-control" name="name" id="name"
                                       @if (old('name'))value="{{old('name')}}"
                                       @else value="{{$item->name ?? ""}}" @endif>
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" name="password"
                                       placeholder="Typing To Change">
                            </div>
                            <div class="form-group">
                                <label for="password_confirmation">Password</label>
                                <input type="password" class="form-control" name="password_confirmation"
                                       placeholder="Confirm New Password">
                            </div>
                            <div class="form-group has-feedback">
                                <label for="email">E-mail</label>
                                <input type="email" class="form-control" name="email" id="email"
                                       @if (old('email'))value="{{old('email')}}" @else value="{{$item->email ?? ""}}"
                                       @endif
                                       required>
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>
                            <div class="form-group has-feedback">
                                <label for="role">Role</label>
                                <select name="role" id="role" class="form-control">
                                    <option value="2" @php if($role == 'user') echo ' selected' @endphp>User
                                    </option>
                                    <option value="3" @php if($role == 'admin') echo ' selected' @endphp>Administrator
                                    </option>
                                    <option value="1" @php if($role == 'disabled') echo ' selected' @endphp>
                                        Disabled User
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="box-footer">
                            <input type="hidden" name="id" value="{{$item->id}}">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
                <h3>User Orders</h3>
                <div class="box">
                    <div class="box-body">
                        @if($countOrders)
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Status</th>
                                        <th>Summary</th>
                                        <th>Created At</th>
                                        <th>Updated At</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($orders as $order)
                                        @php $class = $order->status ? 'success' : '' @endphp
                                        <tr>
                                            <td>{{$order->id}}</td>
                                            <td>{{$order->status ? 'Complete' : 'New'}}</td>
                                            <td>{{$order->sum}} {{$order->currency}}</td>
                                            <td>{{$order->created_at}}</td>
                                            <td>{{$order->updated_at}}</td>
                                            <td><a href="{{route('shop.admin.orders.edit',$order->id)}}"><i
                                                            class="fa fa-fw fa-pencil"></i></a></td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <br><p class="text">No Orders...</p>
                        @endif
                    </div>
                </div>
                <div class="text-center">
                    @if ($orders->total() > $orders->count())
                        <br>
                        <div class="row justify-content-center">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        {{$orders->links()}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
