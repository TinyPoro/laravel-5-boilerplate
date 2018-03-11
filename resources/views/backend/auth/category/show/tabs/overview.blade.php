<div class="col">
    <div class="table-responsive">
        <table class="table table-hover">
            <tr>
                <th>{{ __('labels.backend.news_management.category.tabs.content.overview.name') }}</th>
                <td>{{ $category->name }}</td>
            </tr>

            <tr>
                <th>{{ __('labels.backend.news_management.category.tabs.content.overview.news_count') }}</th>
                <td>{{ $category->news_count }}</td>
            </tr>

            <tr>
                <th>{{ __('labels.backend.news_management.category.tabs.content.overview.created_at') }}</th>
                <td>{{ $category->created_at->diffForHumans() }}</td>
            </tr>
        </table>
    </div>
</div><!--table-responsive-->