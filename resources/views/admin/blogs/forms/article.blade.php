<div class="col-sm-12">
    <div class="panel panel-default">
        <div class="panel-body">
            <button type="submit" class="btn btn-primary">{{ empty($article->id) ? 'Create' : 'Update' }}</button>
            <a href="{{ url('admin/article') }}" class="btn btn-primary btn-outline pull-right">Back</a>
        </div>
    </div>
</div>

@if(isset($errors))
    @include('admin.layouts.partials.form_error', ['errors' => $errors])
@endif

<div class="col-sm-12">
    <div class="row">
        <div class="col-sm-5">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Title</h3>
                </div>
                <div class="panel-body">
                    <input type="text" class="form-control" name="article[name]" value="{{ $article->name }}" autofocus="autofocus" required="required" />
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Slug</h3>
                </div>
                <div class="panel-body">
                    <input type="text" class="form-control" name="article[slug]" value="{{ $article->slug }}" />
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Author</h3>
                </div>
                <div class="panel-body">
                    <input type="text" class="form-control" name="article[author]" value="{{ $article->author }}" />
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-sm-12">
    <div class="row">
        <div class="col-sm-5">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Title EN</h3>
                </div>
                <div class="panel-body">
                    <input type="text" class="form-control" name="article[name_en]" value="{{ $article->name_en }}" />
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Slug EN</h3>
                </div>
                <div class="panel-body">
                    <input type="text" class="form-control" name="article[slug_en]" value="{{ $article->slug_en }}" />
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Category</h3>
                </div>
                <div class="panel-body">
                    <select class="form-control" name="article[category_id]">
                        @foreach(App\Models\BlogCategory::getModelActiveCategory() as $category)
                            @if($article->category_id == $category->id)
                                <option selected="selected" value="{{ $category->id }}">{{ $category->name }}</option>
                            @else
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-sm-12">
    <div class="row">
        <div class="col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Tags</h3>
                </div>
                <div class="panel-body">
                    <input type="text" id="TagsInput" class="form-control" name="article[tags]" value="{{ $article->tags }}" />
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Status</h3>
                </div>
                <div class="panel-body">
                    <select class="form-control" id="StatusDropDown" name="article[status]">
                        @foreach(App\Libraries\Util::getArticleStatus() as $value => $label)
                            @if($article->status == $value)
                                <option selected="selected" value="{{ $value }}">{{ $label }}</option>
                            @else
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Publish Time</h3>
                </div>
                <div class="panel-body">
                    <input type="text" id="PublishedAtInput" class="form-control" name="article[published_at]" value="{{ $article->published_at }}"{{ ($article->status != App\Libraries\Util::STATUS_ARTICLE_PUBLISH_VALUE ? ' readonly="readonly"' : '') }} />
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-sm-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Description</h3>
        </div>
        <div class="panel-body">
            <input type="text" class="form-control" name="article[description]" value="{{ $article->description }}" />
        </div>
    </div>
</div>

<div class="col-sm-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Description EN</h3>
        </div>
        <div class="panel-body">
            <input type="text" class="form-control" name="article[description_en]" value="{{ $article->description_en }}" />
        </div>
    </div>
</div>

<div class="col-sm-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Body</h3>
        </div>
        <div class="panel-body">
            <textarea class="ArticleBodyHtml form-control" rows="20" name="article[body_html]">{{ $article->body_html }}</textarea>
        </div>
    </div>
</div>

<div class="col-sm-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Body EN</h3>
        </div>
        <div class="panel-body">
            <textarea class="ArticleBodyHtml form-control" rows="20" name="article[body_html_en]">{{ $article->body_html_en }}</textarea>
        </div>
    </div>
</div>

<div class="col-sm-12">
    <div class="row">
        <div class="col-sm-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Image (1540 x 900)</h3>
                </div>
                <div class="panel-body">
                    <input type="file" class="form-control" name="image" accept=".jpg, .jpeg, .png, .gif, .JPG, .JPEG, .PNG, .GIF" />
                    @if(!empty($article->image_src))
                        <img src="{{ $article->image_src }}" width="80%" alt="Fitfood" />
                    @endif
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Thumbnail (585 x 585)</h3>
                </div>
                <div class="panel-body">
                    <input type="file" class="form-control" name="thumbnail" accept=".jpg, .jpeg, .png, .gif, .JPG, .JPEG, .PNG, .GIF" />
                    @if(!empty($article->thumbnail_src))
                        <img src="{{ $article->thumbnail_src }}" width="100%" alt="Fitfood" />
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">

<div class="col-sm-12">
    <div class="panel panel-default">
        <div class="panel-body">
            <button type="submit" class="btn btn-primary">{{ empty($article->id) ? 'Create' : 'Update' }}</button>
            <a href="{{ url('admin/article') }}" class="btn btn-primary btn-outline pull-right">Back</a>
        </div>
    </div>
</div>

@section('script')

    <?php
    echo Minify::javascript([
        '/../assets/js/tinymce.min.js',
        '/../assets/js/jquery.caret.min.js',
        '/../assets/js/jquery.tag-editor.min.js',
    ])->withFullUrl();
    ?>
    <script type="text/javascript">

        tinymce.init({
            selector: '.ArticleBodyHtml',
            theme: 'modern',
            plugins: [
                'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                'searchreplace wordcount visualblocks visualchars code fullscreen',
                'insertdatetime media nonbreaking save table contextmenu directionality',
                'emoticons template paste textcolor colorpicker textpattern imagetools'
            ],
            toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
            toolbar2: 'print preview media | forecolor backcolor emoticons',
            image_advtab: true,
            nonbreaking_force_tab: true
        });

        $(document).ready(function() {

            @if($article->status == App\Libraries\Util::STATUS_ARTICLE_PUBLISH_VALUE)
            $('#PublishedAtInput').datetimepicker({

                format: 'Y-m-d H:i'

            });
            @endif

            $('#StatusDropDown').change(function() {

                if($(this).val() == '{{ App\Libraries\Util::STATUS_ARTICLE_PUBLISH_VALUE }}')
                {
                    $('#PublishedAtInput').removeAttr('readonly', 'readonly').datetimepicker({

                        format: 'Y-m-d H:i'

                    });
                }
                else
                    $('#PublishedAtInput').datetimepicker('destroy').val('').prop('readonly', 'readonly');

            });

            $('#TagsInput').tagEditor({
                delimiter: ';',
                placeholder: 'tag;tag;tag ...',
                autocomplete: {
                    source: function(request, response) {
                        $.ajax({
                            url: '{{ url('admin/article/get/autoComplete/tag') }}',
                            type: 'post',
                            data: '_token={{ csrf_token() }}&term=' + request.term,
                            success: function(result) {
                                result = JSON.parse(result);
                                response(result);
                            }
                        });
                    },
                    minLength: 3
                }
            });

        });

    </script>

@stop