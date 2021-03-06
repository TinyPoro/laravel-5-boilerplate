@extends ('backend.layouts.app')

@section ('title', app_name() . ' | ' . __('labels.backend.news_management.category.management'))

@section('breadcrumb-links')
    @include('backend.auth.user.includes.breadcrumb-links')
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-5">
                <h4 class="card-title mb-0">
                    {{ __('labels.backend.news_management.category.management') }}
                </h4>
            </div><!--col-->
        </div><!--row-->

        <form action="{{route('admin.auth.category.index')}}" method="get">
            <div class="form-row">
                <div class="col">
                    <input type="text" name="id" class="form-control" placeholder="Id">
                </div>
                <div class="col">
                    <input type="text" name="name" class="form-control" placeholder="Danh mục">
                </div>
                <div class="col">
                    <button class="btn btn-primary">Lọc</button>
                </div>
            </div>
        </form>

        <a href="{{route('admin.auth.category.delete')}}" class="btn btn-danger"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top"></i>Các danh mục đã xóa</a>
        <a href="{{route('admin.auth.category.create')}}" class="btn btn-primary"><i class="fa fa-plus" data-toggle="tooltip" data-placement="top"></i>Tạo danh mục mới</a>
        <div class="row mt-4">
            <div class="col">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>{{ __('labels.backend.news_management.category.table.id') }}</th>
                            <th>{{ __('labels.backend.news_management.category.table.name') }}</th>
                            <th>{{ __('labels.backend.news_management.category.table.news_count') }}</th>
                            <th>{{ __('labels.backend.news_management.category.table.parent_name') }}</th>
                            <th>{{ __('labels.backend.news_management.category.table.url') }}</th>
                            <th>{{ __('labels.general.actions') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($datas as $data)
                            <tr>
                                <td>{{ $data['id'] }}</td>
                                <td>{{ $data['name'] }}</td>
                                <td>{{ $data['news_count'] }}</td>
                                <td>{{ $data['parent_name'] }}</td>
                                <td> <a href="{{$data['static_url']}}">{{$data['name']}}</a> </td>
                                <td>{!! $data['action_buttons'] !!}</td>
                            </tr>
                            @if(count($data['children'])>0)
                                @foreach ($data['children'] as $child)
                                    <tr>
                                        <td>{{ $child['id'] }}</td>
                                        <td>==={{ $child['name'] }}</td>
                                        <td>{{ $child['news_count'] }}</td>
                                        <td>{{ $child['parent_name'] }}</td>
                                        <td> <a href="{{$child['static_url']}}">{{$child['name']}}</a> </td>
                                        <td>{!! $child['action_buttons'] !!}</td>
                                    </tr>
                                @endforeach
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div><!--col-->
        </div><!--row-->
        <div class="row">
            <div class="col-7">
                <div class="float-left">
                    {{--{!! $categories->count() !!} {{ trans_choice('labels.backend.news_management.category.table.total', $categories->count()) }}--}}
                </div>
            </div><!--col-->

            <div class="col-5">
                <div class="float-right">
                    {{--{!! $news->render() !!}--}}
                </div>
            </div><!--col-->
        </div><!--row-->
    </div><!--card-body-->
</div><!--card-->
@endsection
