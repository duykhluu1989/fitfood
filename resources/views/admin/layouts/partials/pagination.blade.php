<?php
if(!isset($queryString))
    $queryString = '';
if(!isset($sortString))
    $sortString = '';
?>

Total {{ $pagination->total() }}
@if($pagination->previousPageUrl() != '')
    <a href="{{ $pagination->previousPageUrl() . $queryString . $sortString }}" data-toggle="tooltip" title="Previous Page" class="btn btn-primary btn-outline"><i class="fa fa-arrow-left fa-fw"></i></a>
@else
    <a href="javascript:void(0)" data-toggle="tooltip" title="Previous Page" class="btn btn-primary btn-outline"><i class="fa fa-arrow-left fa-fw"></i></a>
@endif

<a href="javascript:void(0)"
   class="btn btn-primary">{{ $pagination->currentPage() }}
</a>

@if($pagination->nextPageUrl() != '')
    <a href="{{ $pagination->nextPageUrl() . $queryString . $sortString }}" data-toggle="tooltip" title="Next Page" class="btn btn-primary btn-outline"><i class="fa fa-arrow-right fa-fw"></i></a>
@else
    <a href="javascript:void(0)" data-toggle="tooltip" title="Next Page" class="btn btn-primary btn-outline"><i class="fa fa-arrow-right fa-fw"></i></a>
@endif
Per Page {{ $pagination->perPage() }}