@extends('layouts.app')
@section('module_url', '/home')
@section('module_name', '用户首页')

@section('content')
    <div class="top-area">
        <div class="nav-links">
            <h3 class="page-title">
                修改密码
            </h3>
        </div>
    </div>
    <hr>
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>错误!</strong><br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    {!! Form::open(array('class'=>'form-horizontal','route' => 'admins.set','method'=>'POST')) !!}
    <input type="hidden" name="admin_id" value="{{$admin_id}}"/>
    <div class="form-group"><label class="col-sm-2 control-label">原密码</label>
        <div class="col-sm-10">
            {!! Form::password('old_pwd',  array('placeholder' => '原始密码','class' => 'form-control','maxlength'=>'16')) !!}
        </div>
    </div>

    <div class="form-group"><label class="col-sm-2 control-label">新密码</label>
        <div class="col-sm-10">
            {!! Form::password('new_pwd', array('placeholder' => '新密码','type'=>'password','class' => 'form-control','maxlength'=>'16')) !!}
        </div>
    </div>
    <div class="form-group"><label class="col-sm-2 control-label">确认新密码</label>
        <div class="col-sm-10">
            {!! Form::password('ret_pwd', array('placeholder' => '确认新密码','type'=>'password','class' => 'form-control','maxlength'=>'16')) !!}
        </div>
    </div>
    <div class="form-group"><label class="col-sm-2 control-label" style="color: red">密码修改成功后下次登录生效</label>
    </div>
    <div class="form-actions">
        <input type="submit" name="commit" value="提交" class="btn btn-new btn-sm">
    </div>
    {!! Form::close() !!}
@endsection