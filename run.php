<?php

$patternSearch = '/@section\s*\((.+)*\)((?>(?!@(?:end)?section).|(?0))*)@endsection/s';
$pattern = '/@section\s*\([^)]*\)((?>(?!@(?:end)?section).|(?0))*)@endsection/s';
$res = array();

$str = '@layout("layouts/principal")

@section("styles")
<link href="../../assets/css/custom.css" rel="stylesheet" type="text/css"/>
@endsection

@section("styles")
<link href="../../assets/css/custom.css" rel="stylesheet" type="text/css2"/>
@endsection

@section("styles")
<link href="../../assets/css/custom.css" rel="stylesheet" type="text/css3"/>
@endsection

@section("content")
<div class="container text-center">    
    <div id="deplyn_welcome">
        <img src="<?= URL::to("assets/img/logo.png"); ?>" />
        <h1 class="title">Deplyn<br/><a href="https://starlly.com" target="_blank"><small>&copy; Starlly Software</small></a></h1>
    </div>
</div>
@endsection';



$i = 0;
while (preg_match_all($pattern, $str, $out)) {
    preg_match("/@section\s*\(.(.+)..*\)((?>(?!@(?:end)?section).|(?0))*)@endsection/s", $str, $temp);
    $str = preg_replace($pattern, "$1", $str);
//    var_dump($temp[]);
}
//var_dump($res);


//echo $str;
//