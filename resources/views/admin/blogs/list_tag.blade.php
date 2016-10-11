@extends('admin.layouts.main')

@section('title', 'List Tag')

@section('header', 'List Tag')

@section('content')

    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-sm-6">
                        @include('admin.layouts.partials.pagination', ['pagination' => $tags])
                    </div>
                    <div class="col-sm-6">
                        <a href="{{ url('tag/create') }}" data-toggle="tooltip" title="New Tag" class="btn btn-primary btn-outline">
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
                        <th>Article</th>
                    </tr>
                    <form id="FilterForm" action="{{ url('tag') }}" method="get">
                        <tr>
                            <td></td>
                            <td>
                                <input type="text" class="form-control" name="filter[name]" value="{{ (isset($filter['name']) ? $filter['name'] : '') }}" />
                            </td>
                            <td></td>
                        </tr>

                        <input type="submit" style="display: none" />
                    </form>
                    </thead>
                    <tbody>
                    @foreach($tags as $tag)
                        <tr>
                            <td>
                                <a href="{{ url('tag/edit', ['id' => $tag->id]) }}" class="btn btn-primary btn-outline">{{ $tag->id }}</a>
                            </td>
                            <td>{{ $tag->name }}</td>
                            <td>{{ $tag->article }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="panel-footer">
                @include('admin.layouts.partials.pagination', ['pagination' => $tags])
            </div>
        </div>
    </div>

@stop