@extends('admin.layouts.main')

@section('title', 'List Article')

@section('header', 'List Article')

@section('content')

    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-sm-6">
                        @include('admin.layouts.partials.pagination', ['pagination' => $articles])
                    </div>
                    <div class="col-sm-6">
                        <a href="{{ url('article/create') }}" data-toggle="tooltip" title="New Article" class="btn btn-primary btn-outline">
                            <i class="fa fa-plus fa-fw"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Name EN</th>
                        <th>Slug</th>
                        <th>Slug EN</th>
                        <th>Status</th>
                        <th>View</th>
                        <th>Created</th>
                    </tr>
                    <form id="FilterForm" action="{{ url('article') }}" method="get">
                        <tr>
                            <td></td>
                            <td>
                                <input type="text" class="form-control" name="filter[name]" value="{{ (isset($filter['name']) ? $filter['name'] : '') }}" />
                            </td>
                            <td>
                                <input type="text" class="form-control" name="filter[name_en]" value="{{ (isset($filter['name_en']) ? $filter['name_en'] : '') }}" />
                            </td>
                            <td></td>
                            <td></td>
                            <td>
                                <select class="form-control DropDownFilterForm" name="filter[status]">
                                    <option value=""></option>
                                    @foreach(App\Libraries\Util::getArticleStatus() as $value => $label)
                                        @if(isset($filter['status']) && $filter['status'] !== '' && $filter['status'] == $value)
                                            <option selected="selected" value="{{ $value }}">{{ $label }}</option>
                                        @else
                                            <option value="{{ $value }}">{{ $label }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </td>
                            <td></td>
                            <td></td>
                        </tr>

                        <input type="submit" style="display: none" />
                    </form>
                    </thead>
                    <tbody>
                    @foreach($articles as $article)
                        <tr>
                            <td>
                                <a href="{{ url('article/edit', ['id' => $article->id]) }}" class="btn btn-primary btn-outline">{{ $article->id }}</a>
                            </td>
                            <td>{{ $article->name }}</td>
                            <td>{{ $article->name_en }}</td>
                            <td>{{ $article->slug }}</td>
                            <td>{{ $article->slug_en }}</td>
                            <td>{{ App\Libraries\Util::getArticleStatus($article->status) }}</td>
                            <td>{{ $article->view }}</td>
                            <td>{{ $article->created_at }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="panel-footer">
                @include('admin.layouts.partials.pagination', ['pagination' => $articles])
            </div>
        </div>
    </div>

@stop

@section('script')

    <script type="text/javascript">

        $(document).ready(function() {

            $('.DropDownFilterForm').change(function() {

                $('#FilterForm').submit();

            });

        });

    </script>

@stop