@extends('layouts.admin')

@section('page-title', '{{Page}}')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>{{Page}}</h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">{{Page}}</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="box">
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


    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">{{Page}} List</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <table class="table table-bordered">
                {{data}}
            </table>
        </div>
        <!-- /.box-body -->
        <div class="box-footer clearfix">
            <ul class="pagination pagination-sm no-margin pull-right">
                <li><a href="#">&laquo;</a></li>
                <li><a href="#">1</a></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#">&raquo;</a></li>
            </ul>
        </div>
    </div>
    <!-- /.box -->
</section>
<!-- /.content -->
@endsection