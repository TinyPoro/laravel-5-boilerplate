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

        <div class="result">
        </div>
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

            $.ajax({
                method: 'POST',
                url: "test",
                data: {input:input, search:search},
                success: function(result){
                    data = "";

                    for (var key in result) {
                        data += "<div><label><b>"+key+": </b></label>\n";

                        for(var prop in result[key]){
                            if(prop === 'time') {
                                data += "<i>"+result[key][prop]+"</i>";
                            }

                            if(prop === 'data'){
                                data += '<ul>';

                                result[key][prop].forEach(function(value){
                                    data += "<li>"+value+"</li>";
                                });

                                data += '</ul>';
                            }
                        }

                        data += "</div>";
                    }

                    $('.result').html(data);
                }
            });
        });

    </script>
@endsection