@extends('frontend.layouts.app')

@section('title', app_name() . ' | '.__('labels.frontend.auth.login_box_title'))

@section('content')
    {!! $html !!}
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
        $( document ).ready(function() {
            var ordered_day = [@foreach($ordered_day as $day)"{{ $day->date }}"@if(!$loop->last),@endif @endforeach];
            ordered_day.forEach(function (value) {
                $('[data-date="' +value +'"]').css("background-color", "yellow");
            });
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        document.querySelectorAll('tbody > tr > td').forEach(function (el) {
            el.setAttribute("style", "");

            el.addEventListener('click', function (e) {
                let class_name = this.className;
                let pos = class_name.indexOf("alert-success");
                if(pos == -1) {
                    class_name += " alert-success";
                    this.className = class_name;
                }
                else this.classList.remove("alert-success");
            })
        })

        $('#register').click(function(){
            var date_arr = [];
            $('tbody > tr > td').each(function (key, ele) {
                let class_name = this.className;
                let pos = class_name.indexOf("alert-success");

                if(pos != -1) date_arr.push(ele.dataset.date);
            });



            $.ajax({
                method: 'POST',
                url: '/lunch',
//            'http://vnp.idist.me:81/',
                data: {date_arr:date_arr},
                success: function(result){
                    alert(result);
                }
            });
        });
    </script>
@endsection
