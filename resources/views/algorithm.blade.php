@extends('layouts.layout')
@section('content')
    <div class="container">
        <form onSubmit="return formstop();">
            <div class="row">
                <div class="col">
                    <label for="input">Cụm từ khóa</label>
                    <input id="input" name="input" type="text" class="form-control" placeholder="Full string">
                </div>
                <div class="col">
                    <label for="search">Cụm tìm kiếm</label>
                    <input id="search" name="search" type="text" class="form-control" placeholder="Search string">
                </div>
            </div>
            <br/>
            <button id="submit" class="btn btn-primary">Chạy code</button>
        </form>
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
            var input = $('#input').val();
            var search = $('#search').val();
            console.log(input);
            $.ajax({
                method: 'POST',
                url: "test",
                data: {input:input, search:search},
                success: function(result){
                    console.log(result);
                    // $('form').after("<div id='list_url'></div>");
                    {{--$('input#keyword').prop('disabled', true);--}}
                    {{--$('#submit').remove();--}}
                    {{--data = "<ul class=\"list-group\">";--}}
                    {{--result.forEach(function(article){--}}
                        {{--data += "<li class=\"list-group-item\"><a href=\"{{route('articles_info')}}/" + article['id'] + "\">" + article['url'] + "</a></li>";--}}
                    {{--});--}}
                    {{--data += "</ul>";--}}
                    {{--$('#list_url').html(data);--}}
                    {{--$('#chart').show();--}}
                }
            });
        });

    </script>
@endsection