@extends('layouts.app_admin')

@section('content')
    <section class="content-header">
        @component('shop.admin.components.breadcrumb')
            @slot('title') Create New User @endslot
            @slot('parent') Home @endslot
            @slot('active') Create New User @endslot
        @endcomponent
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <form action="{{route('shop.admin.users.store')}}" method="POST" data-toggle="validator">
                        @csrf
                        <div class="box-body">
                            <div class="form-group has-feedback">
                                <label for="name">Login</label>
                                <input type="text" class="form-control" name="name" id="name"
                                       @if(old('name'))value="{{old('name')}}" @endif required>
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" name="password"
                                       @if(old('password'))value="{{old('password')}}" @endif required>
                            </div>
                            <div class="form-group">
                                <label for="password_confirmation">Confirm password</label>
                                <input type="password" class="form-control" name="password_confirmation"
                                       @if(old('password_confirmation'))value="{{old('password_confirmation')}}
                                       " @endif required>
                            </div>
                            <div class="form-group has-feedback">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" name="email" id="email"
                                       @if(old('email'))value="{{old('email')}}" @endif required>
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>
                            <div class="form-group has-feedback">
                                <label for="role">Role</label>
                                <select name="role" id="role" class="form-control">
                                    <option value="2" selected>User</option>
                                    <option value="3">Administrator</option>
                                    <option value="1">Disabled User</option>
                                </select>
                            </div>
                        </div>
                        <div class="box-footer">
                            <input type="hidden" name="id" value="">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection