<!DOCTYPE html>
<html>
    <head>
        <title>该页面不存在</title>

        <style>
            @charset "UTF-8";*{-webkit-tap-highlight-color:transparent}
            html,body,h1,h2,h3,h4,h5,h6,p,q,form,fieldset,figure,iframe,button,input,textarea,dl,ol,ul,li,dt,dd,hr,th,td { margin: 0; padding: 0; }
            body, div, span, object, iframe,
            h1, h2, h3, h4, h5, h6, p, blockquote, pre,
            abbr, address, cite, code, del, dfn, em, img, ins, kbd, q, samp,
            small, strong, sub, sup, var, b, i, dl, dt, dd, ol, ul, li,
            fieldset, form, label, legend,
            caption, tfoot, thead,
            article, aside, canvas, details, figcaption, figure,
            footer, header, hgroup, menu, nav, section, summary,
            time, mark, audio, video { font-size: .14rem; font: inherit; vertical-align: baseline;display: block;text-align: center}
            html, body {
                height: 100%;
                width: 100%;min-height: 100%;background-color: #000;min-width: 320px;overflow-x:hidden;
                margin: 0 auto;font: inherit;
            }
            div{ margin: 0 auto}
            body {
                margin: 0 auto;
                padding: 0;
                width: 100%;
                color: #B0BEC5;
                display: table;
                font-family: 'Lato';
                padding-top:2rem;
                background-color: #2f4050;
            }

            .container {margin: 0 auto;
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }
            h3{color:#fff; text-align: center;font-size: .5rem;margin-top:.1rem;}
            h1{font-size: .7rem;color:#fff}
            .error-desc{height:auto}
            a{font-size:.5rem;color:#15bd24; text-decoration: none; margin-top:.1rem;}
        </style>
    </head>
    <body class="gray-bg">
                <h1>404</h1>
                <h3 class="font-bold" >你访问的页面找不着了！<a href="javascript:;" onclick="history.go(-1);" class="btn btn-primary m-t">返回>></a></h3>
    </body>
    <script src="{{ asset('/plugins/jQuery/jquery-2.1.1.min.js') }}"></script>
<script>
    function htmlSize() {
        var winWidth = $(window).width();
        if (winWidth < 750 && 320 <= winWidth) {
            $('html').css('font-size', 100 * (winWidth / 750) + 'px');
        }
        if (winWidth >= 750) {
            $('html').css('font-size', '100px');
        }
    }
    $(document).ready(function(){
        htmlSize();
    });
</script>
</html>
