@extends('layouts.admin')

@section('page-title', '{{Page}}')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>{{Page}}</h1>
    <ol class="breadcrumb">
        <li><a href="{{url('/')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">{{Page}}</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">Search</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">

        </div>
        <!-- /.box-body -->
        <div class="box-footer clearfix">
        </div>
    </div>
    <!-- /.box -->


    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">{{Page}} List</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="text-right" style="margin-bottom: 10px;">
                <a class="btn btn-info" href="{{action('{{Page}}Controller@add')}}">Add</a>
            </div>
            <table class="table table-responsive no-padding">
                {{data}}
            </table>
        </div>
        <!-- /.box-body -->
        <div class="box-footer clearfix">
            @if($data->total() > 0)
            <div class="pull-left col-xs-5 text-left">({{$data->firstItem()}}-{{$data->lastItem()}}/{{$data->total()}})</div>
            @endif
            <div class="pull-right col-xs-5 text-right">{!! $data->links() !!}</div>
        </div>
    </div>
    <!-- /.box -->
</section>
<!-- /.content -->
@endsection