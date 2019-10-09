@extends('layouts.app_admin')

@section('content')
    <section class="content-header">
        @component('shop.admin.components.breadcrumb')
            @slot('title') Control Panel @endslot
            @slot('parent') Home @endslot
            @slot('active') @endslot
        @endcomponent
    </section>
@endsection