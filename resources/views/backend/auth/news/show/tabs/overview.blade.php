<div class="col">
    <div class="table-responsive">
        <table class="table table-hover">
            <tr>
                <th>{{ __('labels.backend.news_management.news.tabs.content.overview.title') }}</th>
                <td>{{ $news->title }}</td>
            </tr>

            <tr>
                <th>{{ __('labels.backend.news_management.news.tabs.content.overview.image') }}</th>
                <td>{!! $news->picture !!}</td>
            </tr>

            <tr>
                <th>{{ __('labels.backend.news_management.news.tabs.content.overview.content') }}</th>
                <td>{{ $news->content }}</td>
            </tr>

            <tr>
                <th>{{ __('labels.backend.news_management.news.tabs.content.overview.category') }}</th>

                @foreach($news->categories as $category)
                    <td>{{ $category->name }}</td>
                @endforeach
            </tr>

            <tr>
                <th>{{ __('labels.backend.news_management.news.tabs.content.overview.status') }}</th>
                <td>{{ $news->getStatusText() }}</td>
            </tr>

            <tr>
                <th>{{ __('labels.backend.news_management.news.tabs.content.overview.look_mode') }}</th>
                <td>{{ $news->getModeText() }}</td>
            </tr>

            <tr>
                <th>{{ __('labels.backend.news_management.news.tabs.content.overview.author') }}</th>
                <td>{!! $news->user->first_name !!} {!!$news->user->last_name !!}</td>
            </tr>

            <tr>
                <th>{{ __('labels.backend.news_management.news.tabs.content.overview.created_at') }}</th>
                <td>{!! $news->created_at->diffForHumans() !!}</td>
            </tr>
        </table>
    </div>
</div><!--table-responsive-->