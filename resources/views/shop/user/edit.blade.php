@extends('layouts.app')
@section('content')

    @csrf
    <div class="row">
        <div class="col-md-12">
            <div class="container mt-5">
                {{ Breadcrumbs::render('Profile') }}
                @include('shop.components.result_messages')
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <h4>Profile Edit</h4>
                        <form action="{{route('shop.user.update')}}" method="POST"
                              data-toggle="validator">
                            @method('POST')
                            @csrf
                            <div class="box-body">
                                <div class="form-group has-feedback">
                                    <label for="email">E-mail</label>
                                    <input type="email" class="form-control" name="email" id="email"
                                           @if (old('email'))value="{{old('email')}}"
                                           @else value="{{$item->email ?? ""}}"
                                           @endif
                                           required>
                                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                </div>
                                <hr>
                                <h4>Password Change</h4>
                                <div class="form-group">
                                    <label for="password">Old Password</label>
                                    <input type="password" class="form-control" name="password"
                                           placeholder="Typing To Change">
                                </div>
                                <div class="form-group">
                                    <label for="password_confirmation">New Password</label>
                                    <input type="password" class="form-control" name="password_confirmation"
                                           placeholder="Confirm New Password">
                                </div>
                            </div>
                            <div class="box-footer">
                                <input type="hidden" name="id" value="{{$item->id}}">
                                <button type="submit" class="btn btn-outline-dark">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection