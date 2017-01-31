{{ csrf_field() }}

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

<div class="box box-info">
    <div class="box-body">
        {{data}}
    </div>
    <div class="box-footer text-right">
        @if (!$isEdit)
        <a class="btn btn-primary" href="javascript:void(0);" onclick="$(this).closest('form').submit();">{{ trans('admin::messages.add') }}</a>
        @else
        <a class="btn btn-primary" href="javascript:void(0);" onclick="$(this).closest('form').submit();">{{ trans('admin::messages.update') }}</a>
        @endif
        <a class="btn btn-default" href="{{action('Admin\{{Page}}Controller@index')}}">{{ trans('admin::messages.cancel') }}</a>
    </div>
</div>