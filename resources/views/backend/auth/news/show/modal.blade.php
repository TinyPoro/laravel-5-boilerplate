<!-- Trigger the modal with a button -->
<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#myModal{{$new->id}}">
    <i class="fa fa-lock" aria-hidden="true"></i>
</button>

<!-- Modal -->
<div id="myModal{{$new->id}}" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Truy cập tin tức riêng tư</h4>
      </div>
      <div class="modal-body">
          <label for="image">Nhập mật khẩu</label>
          <input type="text" class="form-control" name="password" id="password">
          <input type="text" class="form-control" name="id" id="id" value="{{$new->id}}" style="display:none;">
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-primary send">Gửi</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
      </div>
    </div>

  </div>
</div>

