@extends('admin.layouts.admin')

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
    @if(Session::has('success'))
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        {{ Session::get('success') }}
    </div>
    @elseif(Session::has('error'))
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-ban"></i> {{ trans('admin::messages.error') }}:</h4>
        {{ Session::get('error') }}
    </div>
    @elseif(isset($errorMsg))
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-ban"></i> {{ trans('admin::messages.error') }}:</h4>
        {!! $errorMsg !!}
    </div>
    @endif

    <form method="post" action="{{action('Admin\{{Page}}Controller@delete')}}">
        {{ csrf_field() }}
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">{{Page}} List</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="text-left" style="margin-bottom: 10px;">
                    <a class="btn btn-info" href="{{action('Admin\{{Page}}Controller@add')}}">{{ trans('admin::messages.add') }}</a>
                    <a class="btn btn-danger btn-delete-selected disabled" href="javascript:void(0);">{{ trans('admin::messages.delete') }}</a>
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
    </form>
    <!-- /.box -->
</section>
<!-- /.content -->
@endsection