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
          <label for="image">Nhập mật khẩu</label>
          <input type="text" class="form-control" name="password" id="password">
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-primary send">Gửi</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
      </div>
    </div>

  </div>
</div>

