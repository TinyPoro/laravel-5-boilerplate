@extends ('backend.layouts.app')

@section ('title', __('labels.backend.news_management.news.management') . ' | ' . __('labels.backend.ewsnews_management.news.deleted'))

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
                    <small class="text-muted">{{ __('labels.backend.news_management.news.deleted') }}</small>
                </h4>
            </div><!--col-->
        </div><!--row-->

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
                            <th>{{ __('labels.general.actions') }}
                        </tr>
                        </thead>
                        <tbody>

                        @if ($news->count())
                            @foreach ($news as $new)
                                <tr>
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
                                    <td>{!! $new->action_buttons !!}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr><td colspan="9"><p class="text-center">{{ __('strings.backend.news_management.news.no_deleted') }}</p></td></tr>
                        @endif
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
                    {{--{!! $users->render() !!}--}}
                </div>
            </div><!--col-->
        </div><!--row-->
    </div><!--card-body-->
</div><!--card-->
@endsection
