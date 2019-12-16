@extends('layouts.app')

@section('module_url', '/home')
@section('module_name', '用户首页')

@section('content')
    <div class="top-area">
        <div class="nav-links">
            <h2 class="page-title">
                个人信息
            </h2>
        </div>
        <div class="nav-controls">
        </div>
    </div>

    <div class="row">
        <hr>
        <div class="col-md-4">
            <p>
                ID：<span class="light pull-right">{{$admin->id}}</span>
            </p>
            <p>
                姓名：<span class="light pull-right">{{$admin->name}}</span>
            </p>
            <p>
                电子邮件：<span class="light pull-right">{{$admin->email}}</span>
            </p>
            <p>
                所属城市：<span class="light pull-right">{{$admin->city->city_name}}</span>
            </p>
            <p>
                状态：<span class="light pull-right">{{$admin->status?'使用中':'禁用'}}</span>
            </p>
            <p>
                创建时间：<span class="light pull-right">{{$admin->created_at}}</span>
            </p>
        </div>
        <div class="col-md-2">

        </div>
        <div class="col-md-4">
            <p>
            </p>
            <p>
            </p>
            <p>
            </p>
            <p>
            </p>
            <p>
            </p>
        </div>
    </div>
@endsection