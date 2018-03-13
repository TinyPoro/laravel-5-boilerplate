@extends ('backend.layouts.app')

@section ('title', app_name() . ' | ' . __('labels.backend.news_management.news.management'))

@section('breadcrumb-links')
    @include('backend.auth.user.includes.breadcrumb-links')
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-5">
                <h4 class="card-title mb-0">
                    {{ __('labels.backend.news_management.news.management') }}
                </h4>
            </div><!--col-->
        </div><!--row-->

        <form action="{{route('admin.auth.news.index')}}" method="get">
            <div class="form-row">
                <div class="col">
                    <input type="text" name="title" class="form-control" placeholder="Tiêu đề">
                </div>
                <div class="col">
                    <input type="text" name="category" class="form-control" placeholder="Danh mục">
                </div>
                <div class="col">
                    <input type="text" name="author" class="form-control" placeholder="Tác giả">
                </div>
                <div class="col">
                    <button class="btn btn-primary">Lọc</button>
                </div>
            </div>
        </form>

        <a href="{{route('admin.auth.news.delete')}}" class="btn btn-danger"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top"></i>Các tin đã xóa</a>

        <div class="row mt-4">
            <div class="col">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>{{ __('labels.backend.news_management.news.table.id') }}</th>
                            <th>{{ __('labels.backend.news_management.news.table.title') }}</th>
                            <th>{{ __('labels.backend.news_management.news.table.category') }}</th>
                            <th>{{ __('labels.backend.news_management.news.table.status') }}</th>
                            <th>{{ __('labels.backend.news_management.news.table.look_mode') }}</th>
                            <th>{{ __('labels.backend.news_management.news.table.author') }}</th>
                            <th>{{ __('labels.backend.news_management.news.table.created_at') }}</th>
                            <th>{{ __('labels.backend.news_management.news.table.last_updated') }}</th>
                            <th>{{ __('labels.general.actions') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($news as $new)
                            <tr id="{{$new->id}}">
                                <td>{{ $new->id }}</td>
                                <td>{{ $new->title }}</td>
                                <td>
                                    @foreach($new->categories as $category)
                                        <p>{{ $category->name }}</p>
                                    @endforeach
                                </td>
                                <td>{{ $new->getStatusText() }}</td>
                                <td>{{ $new->getModeText() }}</td>
                                <td>{!! $new->user->first_name !!} {!!$new->user->last_name !!}</td>
                                <td>{{ $new->created_at }}</td>
                                <td>{{ $new->updated_at->diffForHumans() }}</td>

                                @if($new->public())
                                    <td>{!! $new->action_buttons !!}</td>
                                @else
                                    <td >
                                        <span class="not-active">
                                            {!! $new->action_buttons !!}
                                        </span>
                                        <span>@include('backend.auth.news.show.modal')</span>
                                    </td>
                                @endif

                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div><!--col-->
        </div><!--row-->
        <div class="row">
            <div class="col-7">
                <div class="float-left">
                    {!! $news->count() !!} {{ trans_choice('labels.backend.news_management.news.table.total', $news->count()) }}
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

@section('after-scripts')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.not-active').click(function(){
            alert("mở khóa đi đã bullshit!!");
        });

        $('.send').each(function () {
            $(this).click(function () {
                var password = $(this).parent().siblings('.modal-body').find('#password').val();
                var id = $(this).parent().siblings('.modal-body').find('#id').val();

                $.ajax({
                    method: 'POST',
                    url: "/check_pass",
                    data: {password:password,
                        id:id},
                    success: function(result){
                        if(result=="pass sai mịa rùi") alert(result);
                        else {
                            alert("ngon rồi. tự đóng box đi. bận quá chưa làm được:(")
                            // $('#' + result).find('.not-active').siblings().remove();
                            $('#' + result).find('.not-active').attr('class', '');
                        }
                    }
                });
            })
        })

    </script>
@endsection
