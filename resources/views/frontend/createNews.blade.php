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
                    <form>
                        <div class="form-group" id="title">
                            <label for="title">Tiêu đề</label>
                            <input type="text" class="form-control" name="title" >
                        </div>

                        <div class="form-group" id="content">
                            <label for="content">Nội dung</label>
                            <textarea class="form-control"  name="content" rows="3"></textarea>
                        </div>

                        <div class="form-group" id="category">
                            <label for="category">Chủ đề</label>
                            <div id="cate-form">
                                <span id="render"></span>
                                <div id="cate-box">
                                    <input type="text" class="form-control" name="category" id="category-input">
                                </div>
                            </div>
                        </div>

                        <button type=button class="btn btn-primary" id="create">Tạo</button>
                    </form>
                </div><!--card body-->
            </div><!-- card -->
        </div><!-- col-xs-12 -->
    </div><!-- row -->
@endsection

@section('after-scripts')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        document.getElementById('category-input').onkeyup = function(e){
            if(e.keyCode == 32){
                var input = $(this).val();

                if(input!==''){
                    var data = '<span class="post-tag rendered-element">' +
                        input +
                        '<span class="delete-tag" title="remove this tag"></span>' +
                        '</span>';

                    $('#render').append(data);

                    $('.delete-tag').click(function () {
                        $(this).parent().remove();
                    });

                    $(this).val('');
                }
            }
        };

        $('#create').click(function () {
            var title = $(this).siblings('#title').find('input').val();
            var content = $(this).siblings('#content').find('textarea').val();
            var category = [];
            $('#render > span').each(function (index, value) {
                category.push($(this)[0].innerText);

            })

            $.ajax({
                method: 'POST',
                url: "store_news",
                data: {title:title,
                    content:content,
                    category:category},
                success: function(result){
                }
            });
        });

    </script>
@endsection
