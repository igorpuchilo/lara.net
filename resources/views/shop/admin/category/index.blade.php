@extends('layouts.app_admin')

@section('content')
    <section class="content-header">
        @component('shop.admin.components.breadcrumb')
            @slot('title') Category List @endslot
            @slot('parent') Home @endslot
            @slot('active') Category List @endslot
        @endcomponent
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body">
                        <small><i class="fa fa-warning"></i> Click to edit</small>
                        @if($menu)
                            <div class="list-group list-group-root">
                                @include('shop.admin.category.menu.customMenuItems', ['items'=>$menu->roots()])
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection