@extends('frontend.layouts.app')

@section('title', app_name() . ' | '.__('labels.frontend.auth.login_box_title'))

@section('content')
    <form id="lunch">
        <input type="checkbox" class="date" name="date" value="Monday"> Thứ hai<br>
        <input type="checkbox" class="date" name="date" value="Tuesday"> Thứ ba<br>
        <input type="checkbox" class="date" name="date" value="Wednesday"> Thứ tư<br>
        <input type="checkbox" class="date" name="date" value="Thursday"> Thứ năm<br>
        <input type="checkbox" class="date" name="date" value="Friday"> Thứ sáu<br>
    </form>

    <button id="register"> Xác nhận </button>

    <style>
        .alert-success{
            color: #155724;
            background-color: #d4edda !important;
            border-color: #c3e6cb;
        }
    </style>
@endsection

@section('after-script')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#register').click(function(){
            var date_arr = [];

            $('.date').each(function(index, ele){
               if(ele.checked) {
                   date_arr.push(ele.value);
               }
            });

            console.log(date_arr);

            $.ajax({
                method: 'POST',
                url: '/lunch',
                data: {date_arr:date_arr},
                success: function(result){
                    alert(result);
                }
            });
        });
    </script>
@endsection
