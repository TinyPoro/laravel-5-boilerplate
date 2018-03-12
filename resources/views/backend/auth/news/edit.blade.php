@extends ('backend.layouts.app')

@section ('title', __('labels.backend.news_management.news.management') . ' | ' . __('labels.backend.news_management.news.edit'))

@section('breadcrumb-links')
    @include('backend.auth.user.includes.breadcrumb-links')
@endsection

@section('content')
{{ html()->modelForm($news, 'PATCH', route('admin.auth.news.update', $news->id))->class('form-horizontal')->open() }}
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">
                        {{ __('labels.backend.news_management.news.management') }}
                        <small class="text-muted">{{ __('labels.backend.news_management.news.edit') }}</small>
                    </h4>
                </div><!--col-->
            </div><!--row-->

            <hr />

            <div class="row mt-4 mb-4">
                <div class="col">
                    <div class="form-group row">
                    {{ html()->label(__('validation.attributes.backend.news_management.news.title'))->class('col-md-2 form-control-label')->for('title') }}

                        <div class="col-md-10">
                            {{ html()->text('title')
                                ->class('form-control')
                                ->placeholder(__('validation.attributes.backend.news_management.news.title'))
                                ->attribute('maxlength', 191)
                                ->required() }}
                        </div><!--col-->
                    </div><!--form-group-->

                    <div class="form-group row">
                        {{ html()->label(__('validation.attributes.backend.news_management.news.content'))->class('col-md-2 form-control-label')->for('content') }}

                        {{--<div class="col-md-10">--}}
                            {{--{{ html()->textarea('content')--}}
                                {{--->class('form-control')--}}
                                {{--->placeholder(__('validation.attributes.backend.news_management.news.content'))--}}
                                {{--->attribute('maxlength', 191)--}}
                                {{--->required() }}--}}
                        {{--</div><!--col-->--}}

                        <div class="col-md-10" id="content">{{$news->content}}</div>
                    </div><!--form-group-->

                    <div class="form-group row">
                        {{ html()->label(__('validation.attributes.backend.news_management.news.category'))->class('col-md-2 form-control-label')->for('category') }}

                        <div class="col-md-10">
                            <div id="cate-form">
                                <span id="render">
                                    @foreach($news->categories as $category)
                                        <span class="post-tag rendered-element">
                                            {{$category->name}}
                                            <span class="delete-tag" title="remove this tag"></span>
                                        </span>
                                    @endforeach
                                </span>
                                <div id="cate-box">
                                    <input type="text" class="form-control" name="category" id="category-input">
                                </div>
                            </div>
                        </div><!--col-->
                    </div><!--form-group-->

                    <input type="hidden" id="list-cate" name="list-cate" value="">
                </div><!--col-->
            </div><!--row-->
        </div><!--card-body-->

        <div class="card-footer">
            <div class="row">
                <div class="col">
                    {{ form_cancel(route('admin.auth.news.index'), __('buttons.general.cancel')) }}
                </div><!--col-->

                <div class="col text-right">
                    {{ form_submit(__('buttons.general.crud.update')) }}
                </div><!--row-->
            </div><!--row-->
        </div><!--card-footer-->
    </div><!--card-->
{{ html()->closeModelForm() }}
@endsection

@section('after-scripts')
    <script>
        $(document).ready(function() {
            $('#content').summernote();
        });

        $('.delete-tag').click(function () {
            var deleted_input = $(this).parent()[0].innerText;

            category_arr = category_arr.filter(function(value){return (value!=deleted_input)});
            getValue();

            $(this).parent().remove();
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
                        var deleted_input = $(this).parent()[0].innerText;

                        category_arr = category_arr.filter(function(value){return (value!=deleted_input)});
                        getValue();

                        $(this).parent().remove();
                    });

                    $(this).val('');

                    category_arr.push(input);
                    getValue();
                }
            }
        };

        function getValue(){
            var data = '';

            category_arr.forEach(function (value) {
                data += value+",";
            });

            $('#list-cate').val(data);
        }

        var category_arr = [];
        $('#render > span').each(function (index, value) {
            category_arr.push($(this)[0].innerText);
        });
        getValue();
    </script>
@endsection
