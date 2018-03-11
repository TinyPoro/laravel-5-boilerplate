@extends ('backend.layouts.app')

@section ('title', __('labels.backend.news_management.news.management') . ' | ' . __('labels.backend.news_management.news.view'))

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
                    <small class="text-muted">{{ __('labels.backend.news_management.news.view') }}</small>
                </h4>
            </div><!--col-->
        </div><!--row-->

        <div class="row mt-4 mb-4">
            <div class="col">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#overview" role="tab" aria-controls="overview" aria-expanded="true"><i class="fa fa-user"></i> {{ __('labels.backend.news_management.news.tabs.titles.overview') }}</a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane active" id="overview" role="tabpanel" aria-expanded="true">
                        @include('backend.auth.news.show.tabs.overview')
                    </div><!--tab-->
                </div><!--tab-content-->
            </div><!--col-->
        </div><!--row-->
    </div><!--card-body-->

    <div class="card-footer">
        <div class="row">
            <div class="col">
                <small class="float-right text-muted">
                    <strong>{{ __('labels.backend.news_management.news.tabs.content.overview.created_at') }}:</strong> {{ $news->updated_at->timezone(get_user_timezone()) }} ({{ $news->created_at->diffForHumans() }}),
                    <strong>{{ __('labels.backend.news_management.news.tabs.content.overview.last_updated') }}:</strong> {{ $news->created_at->timezone(get_user_timezone()) }} ({{ $news->updated_at->diffForHumans() }})
                    @if ($news->trashed())
                        <strong>{{ __('labels.backend.news_management.news.tabs.content.overview.deleted_at') }}:</strong> {{ $news->deleted_at->timezone(get_user_timezone()) }} ({{ $news->deleted_at->diffForHumans() }})
                    @endif
                </small>
            </div><!--col-->
        </div><!--row-->
    </div><!--card-footer-->
</div><!--card-->
@endsection
