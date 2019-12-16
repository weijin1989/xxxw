<!DOCTYPE html>
<html>
    <head>
        <title>Be right back.</title>
        <link rel="stylesheet" href="{{ asset('/plugins/bootstrap/css/bootstrap.min.css') }}">


        {{--<link href="//fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">--}}

        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                color: #B0BEC5;
                display: table;
                font-weight: 100;
                font-family: 'Lato';
                padding-top:200px;
                background-color: #2f4050;
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 72px;
                margin-bottom: 40px;
            }
        </style>
    </head>
    <body class="gray-bg">
            <div class="middle-box text-center animated fadeInDown">
                <h1 style="color:#d9534f">400</h1>
                <h3 class="font-bold"  style="line-height: 25px;">你没有权限访问该页面</h3>

                <div class="error-desc"><a href="javascript:;" onclick="history.go(-1);" class="btn btn-primary m-t">返回</a>
                </div>
            </div>
    </body>
</html>
