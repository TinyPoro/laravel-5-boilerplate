<!-- Trigger the modal with a button -->
<button type="button" class="btn btn-secondary" id="try" data-toggle="modal" data-target="#myModal" style="position: absolute;right: 10px;">Xem thử</button>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Truy cập tin tức riêng tư</h4>
      </div>
      <div class="modal-body">
        <table class="table table-hover">
          <tr>
            <th>{{ __('labels.backend.news_management.news.tabs.content.overview.title') }}</th>
            <td id="try_title"></td>
          </tr>

          <tr>
            <th>{{ __('labels.backend.news_management.news.tabs.content.overview.image') }}</th>
            <td id="try_image"></td>
          </tr>

          <tr>
            <th>{{ __('labels.backend.news_management.news.tabs.content.overview.content') }}</th>
            <td id="try_content"></td>
          </tr>
          <tr>
            <th>{{ __('labels.backend.news_management.news.tabs.content.overview.status') }}</th>
            <td id="try_status"></td>
          </tr>

          <tr>
            <th>{{ __('labels.backend.news_management.news.tabs.content.overview.look_mode') }}</th>
            <td id="try_look_mode"></td>
          </tr>

          <tr>
            <th>{{ __('labels.backend.news_management.news.tabs.content.overview.author') }}</th>
            <td>Admin</td>
          </tr>

          <tr>
            <th>{{ __('labels.backend.news_management.news.tabs.content.overview.created_at') }}</th>
            <td>3 giây trước</td>
          </tr>
        </table>
      </div>
      <div class="modal-footer">

        <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
      </div>
    </div>

  </div>
</div>

