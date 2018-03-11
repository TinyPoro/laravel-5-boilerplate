@extends ('backend.layouts.app')

@section ('title', __('labels.backend.news_management.category.management') . ' | ' . __('labels.backend.news_management.category.view'))

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
                    <small class="text-muted">{{ __('labels.backend.news_management.category.view') }}</small>
                </h4>
            </div><!--col-->
        </div><!--row-->

        <div class="row mt-4 mb-4">
            <div class="col">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#overview" role="tab" aria-controls="overview" aria-expanded="true"><i class="fa fa-user"></i> {{ __('labels.backend.news_management.category.tabs.titles.overview') }}</a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane active" id="overview" role="tabpanel" aria-expanded="true">
                        @include('backend.auth.category.show.tabs.overview')
                    </div><!--tab-->
                </div><!--tab-content-->
            </div><!--col-->
        </div><!--row-->
    </div><!--card-body-->

    <div class="card-footer">
        <div class="row">
            <div class="col">
                <small class="float-right text-muted">
                    <strong>{{ __('labels.backend.news_management.category.tabs.content.overview.created_at') }}:</strong> {{ $category->updated_at->timezone(get_user_timezone()) }} ({{ $category->created_at->diffForHumans() }}),
                    <strong>{{ __('labels.backend.news_management.category.tabs.content.overview.last_updated') }}:</strong> {{ $category->created_at->timezone(get_user_timezone()) }} ({{ $category->updated_at->diffForHumans() }})
                    @if ($category->trashed())
                        <strong>{{ __('labels.backend.news_management.category.tabs.content.overview.deleted_at') }}:</strong> {{ $category->deleted_at->timezone(get_user_timezone()) }} ({{ $category->deleted_at->diffForHumans() }})
                    @endif
                </small>
            </div><!--col-->
        </div><!--row-->
    </div><!--card-footer-->
</div><!--card-->
@endsection
