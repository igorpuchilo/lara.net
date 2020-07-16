@extends('layouts.app_admin')

@section('content')
    <section class="content-header">
        @component('shop.admin.components.breadcrumb')
            @slot('title') Trash @endslot
            @slot('parent') Home @endslot
            @slot('active') Trash @endslot
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
                                    <th class="text-center">@sortablelink('id')</th>
                                    <th class="text-center">@sortablelink('file','FileName')</th>
                                    <th class="text-center">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(!$files->isEmpty())
                                    @foreach($files as $file)
                                        <tr>
                                            <td>{{$file->id}}</td>
                                            <td>{{$file->file}}</td>
                                            <td class="text-center">
                                                <a class="btn btn-warning"
                                                   href="{{route('shop.admin.trash.deletefile',$file->id)}}"
                                                   title="Delete This File">Delete This File</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <div class="margin-bottom">
                                        <a class="btn btn-danger" href="{{route('shop.admin.trash.deleteallfiles')}}">
                                            Delete All Tmp Files
                                        </a>
                                    </div>
                                @else
                                    <tr>
                                        <td class="text-center" colspan="3"><h2>No Files</h2></td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>

                        </div>
                        <div class="text-center">
                            {!! $files->appends(\Request::except('page'))->render() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection