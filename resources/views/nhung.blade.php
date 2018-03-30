@extends('frontend.layouts.app')

@section('title', 'Của Nhung hết')

@section('content')
    <div class="container">
        <h2>Từ khóa:</h2>
        <hr>
        <form id="input" onSubmit="return formstop();">
            <div class="form-group">
                <input type="text" class="form-control" id="url" placeholder="Nhập đường dẫn google bạn mong muốn:">
            </div>
            <button id="submit" class="btn btn-primary">Tìm kiếm</button>
        </form>

        <div id='list_url' style="width: 500px; max-height: 300px; overflow: auto"></div>
    </div>
@endsection

@section('after-script')
    <script>
        function formstop() {
            return false;
        }
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#submit').click(function(){
            var url = $('#url').val();

            $.ajax({
                method: 'POST',
                url: "nhung_support",
                data: {url:url},
                success: function(result){
                    var data = "<ul class=\"list-group\">";
                    result.forEach(function(r){
                        data += "<li class=\"list-group-item\">"+r+"</li>";
                    });
                    data += "</ul>";
                    $('#list_url').html(data);
                }
            });
        })
    </script>
@endsection
