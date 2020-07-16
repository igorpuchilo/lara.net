@extends('layouts.app_admin')

@section('content')
    <section class="content-header">
        @component('shop.admin.components.breadcrumb')
            @slot('title') User List @endslot
            @slot('parent') Home @endslot
            @slot('active') User List @endslot
        @endcomponent
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>@sortablelink('id')</th>
                                    <th>@sortablelink('name','Login')</th>
                                    <th>@sortablelink('email')</th>
                                    <th>@sortablelink('role','Role')</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($users as $user)
                                    @php
                                        $class = '';
                                        $status = $user->role;
                                        if ($status == 'disabled') $class = "danger";
                                    @endphp
                                    <tr class="{{$class}}">
                                        <td>{{$user->id}}</td>
                                        <td>{{$user->name}}</td>
                                        <td>{{$user->email}}</td>
                                        <td>{{$user->role}}</td>
                                        <td><a href="{{route('shop.admin.users.edit',$user->id)}}" title="Show user">
                                                <i class="btn btn-xs"></i>
                                                <button type="submit" class="btn btn-success btn-xs">Show</button>
                                            </a>
                                            <a class="btn btn-xs">
                                                <form method="POST" style="float:none"
                                                      action="{{route('shop.admin.users.destroy', $user->id)}}">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger btn-xs
                                                    delete">Delete
                                                    </button>
                                                </form>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center"><h2>No one users to show</h2></td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="text-center">
                            {!! $users->appends(\Request::except('page'))->render() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
