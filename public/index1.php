<?php
function get_arr($a){
    unset($a[0]);
}
$arr1=[1,2];
$arr2=[1,2];
get_arr(&$arr1);
get_arr($arr2);
echo count($arr1);
echo '<pre/>';
echo count($arr2);
exit;
$GLOBALS['var1']=5;
$var2=1;
function get_v(){
    global $var2;
    $var1=0;
    return $var2++;
}
get_v();
echo $var1;
echo $var2;
exit;
$count=5;
function  get_c(){
    static  $count=0;
    return $count++;
}
//echo $count;
//echo ++$count;exit;
echo get_c();
echo '<pre/>';
echo get_c();
exit;
$test='888';
$abc=& $test;
unset($test);
echo  $abc;exit;

$A1=null;
$A2=false;
$A3='';
$A4=0;
$A5='0';
$A6=0;
//echo $A1==$A2 ? '1':'0';exit;
//echo $A3==$A4 ? '1':'0';exit;
$a1=null;
$a2=false;
$a3=0;
$a4='';
$a5='null';
$a6=array();
$a7=array(array());
$a8='0';
//echo empty($a1) ? 1:0;exit;
//echo empty($a2) ? 1:0;exit;
//echo empty($a3) ? 1:0;exit;
//echo empty($a4) ? 1:0;exit;
//echo empty($a5) ? 1:0;exit;
//echo empty($a6) ? 1:0;exit;
//echo empty($a7) ? 1:0;exit;
echo empty($a8) ? 1:0;exit;
echo $A5===$A6 ? '1':'0';exit;
$a=[1,2,3,[4,5,6,[7,8,9,[10,11,12,13]]]];
function qt_ar($a){
    foreach ($a as $v){
        if(count($v)>1){
            qt_ar($v);
        }else {
            echo '<pre/>';
            echo $v;
        }
    }
}
qt_ar($a);
exit;
$s=['20150102','15-11-2012','11-25-2019','2019-11-21'];
print_r($s);
echo '<pre/>';
foreach($s as $v){
    echo 'strtotime='.strtotime($v);
//    echo date('Y-m-d',strtotime($v));
    echo"<pre/>";
}
exit;
list($d, $m, $y) = preg_split('/\//', '15/11/2012');
$mydate = sprintf('%4d%02d%02d', $y, $m, $d);
print $mydate;exit;
echo 1,2,3;exit;
$b=array(true=>222,2=>2);
//$b='asassss';
//$aaa=serialize($b);
echo date('t',strtotime('2019-7-1'));exit;
print_r($aaa);exit;
echo count($b);exit;
var_dump($b);exit;
$a='asdasdasd';
$a[$a['11']]=2;
print_r($a);exit;
$a=['aa','bb','cc'];
//foreach($a as $v){
//    echo $v.',';
//}
//exit;
//echo implode($a,',');exit;
$b='sss';
echo $b{0};
print_r(implode(',',$a));
echo '<pre/>';
define('AAA',[2,3]);
print_r(AAA[1]);
echo '<pre/>';
echo 8%(-2);
echo '<pre/>';
$y=parse_url('http://www.baidu.com/index.php');
print_r($y);
echo '<pre/>';
print_r(basename($y['path'],'.php'));