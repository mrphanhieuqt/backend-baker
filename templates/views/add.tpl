@extends('admin.layouts.admin')

@section('page-title', trans('admin::messages.add.title', ['item' => '{{Page}}']))

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>{{ trans('admin::messages.add.title', ['item' => '{{Page}}']) }}</h1>
    <ol class="breadcrumb">
        <li><a href="{{url('/')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ action("Admin\\{{Page}}Controller@index") }}">{{Page}}</a></li>
        <li class="active">{{ trans('admin::messages.add') }}</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <form method="post" action="">
        @include('admin.{{page}}._form', ['data' => $data, 'isEdit' => false])
    </form>
</section>
@endsection