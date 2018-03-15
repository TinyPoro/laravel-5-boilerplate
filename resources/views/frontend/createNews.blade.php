@extends('frontend.layouts.app')

@section('content')
    <div class="row justify-content-center align-items-center mb-3">
        <div class="col col-sm-10 align-self-center">
            <div class="card">
                <div class="card-header">
                    <strong>
                        Tạo tin tức mới
                    </strong>
                </div>

                <div class="card-body">
                    <form method="post" action="{{route('store_news')}}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="col-md-8">
                            <div class="form-group" id="title">
                                <label for="title">Tiêu đề</label>
                                <input type="text" class="form-control" name="title" >
                            </div>

                            <div class="form-group" id="image">
                                <label for="image">Ảnh đại diện</label>
                                <input type="file" class="form-control" name="image" id="image-input">
                            </div>

                            <div class="form-group" id="content">
                                <label for="content">Nội dung</label>
                                <textarea class="col-md-10" id="content-input" name="content"></textarea>
                            </div>

                            <div class="form-group" id="category">
                                <label for="category">Chủ đề</label>
                                <div id="cate-form">
                                    <span id="render"></span>
                                    <div id="cate-box">
                                        {{--<input type="text" class="form-control" id="category-input">--}}
                                        <select class="js-example-basic-single form-control" multiple name="category" id="category-input">
                                            @foreach($categories as $category)
                                                <option value="{{$category->name}}">{{$category->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <input type="text" class="form-control" name="category" id="category-hidden" style="display:none" >

                        </div>

                        <div class="col-md-4">
                            <div class="form-group" id="status">
                                <label for="status">Trạng thái</label>
                                <select class="custom-select" name="status" id="status-input">
                                    <option selected value="0">Bản chính</option>
                                    <option value="1">Bản nháp</option>
                                </select>
                            </div>

                            <div class="form-group" id="look_mode">
                                <label for="look_mode">Chế độ xem</label>
                                <select class="custom-select" name="look_mode" id="look_mode-input">
                                    <option selected value="0">Công khai</option>
                                    <option value="1">Riêng tư</option>
                                </select>
                            </div>

                            <div class="form-group" id="password" style="display:none;">
                                <label for="password">Mật khẩu</label>
                                <input type="password" class="form-control" name="password" id="password-input" >
                            </div>

                            <div class="form-group" id="post_mode">
                                <label for="post_mode">Chế độ đăng</label>
                                <select class="custom-select" name="post_mode" id="post_mode-input">
                                    <option selected value="0">Đăng ngay</option>
                                    <option value="1">Đăng sau</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary" id="create">Tạo mới</button>
                            @include('backend.auth.news.show.try_modal')
                        </div>
                    </form>
                </div><!--card body-->
            </div><!-- card -->
        </div><!-- col-xs-12 -->
    </div><!-- row -->
@endsection

@section('after-scripts')
    <script>
        $(document).ready(function() {
            $('#content-input').summernote({
                height: 200
            });
            $('.js-example-basic-single').select2();
        });

        document.getElementById('category-input').change = function(e){
            var data = '';
            $('.select2-selection__choice').each(function () {
                data += $(this).attr('title')+",";
            })
            $('#category-hidden').val(data);
        };

        // document.getElementById('category-input').onkeyup = function(e){
        //     if(e.keyCode == 13){
        //         var input = $(this).val();
        //
        //         if(input!==''){
        //             var data = '<span class="post-tag rendered-element">' +
        //                 input +
        //                 '<span class="delete-tag" title="remove this tag"></span>' +
        //                 '</span>';
        //
        //             $('#render').append(data);
        //
        //             $('.delete-tag').click(function () {
        //                 $(this).parent().remove();
        //             });
        //
        //             $(this).val('');
        //
        //             //them value vào input hidden
        //             $cur_val = $('#category-hidden').val();
        //             $cur_val += input +",";
        //             $('#category-hidden').val($cur_val);
        //         }
        //     }
        // };

        $("#look_mode").change(function() {
            var x = document.getElementById("password");
            if (x.style.display === "none") {
                x.style.display = "block";
            } else {
                x.style.display = "none";
            }
        });

        $('#try').click(function(){
            var title = $('[name="title"]').val();
            var image = $('[name="image"]').val();
            var content = $('[name="content"]').val();
            var status = $('[name="status"]').val();
            var status_text = (status == 0) ? "Xuất bản" : "Bản nháp";
            var look_mode = $('[name="look_mode"]').val();
            var look_mode_text = (look_mode == 0) ? "Công khai" : "Cá nhân";

            $('#try_title').text(title);
            $('#try_image').text(image);
            $('#try_content').text(content);
            $('#try_status').text(status_text);
            $('#try_look_mode').text(look_mode_text);
        })
    </script>
@endsection
