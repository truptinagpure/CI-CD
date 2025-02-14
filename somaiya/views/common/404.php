<?php 
// ini_set("display_errors", "1");
// error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
  <link rel="icon" href="<?=base_url()?>assets/arigel_general/img/favicon.png" type="image/x-icon" sizes="16x16"/>
  <title>404 ERROR</title>
</head>

<section class="errorpg">
  <div class="container "><img class="pos img-responsive lazyloadimg" alt="" src="<?=base_url()?>assets/common_img/SVG-04.svg" data-lazy="<?=base_url()?>assets/common_img/SVG-04.svg" /></div>&nbsp;
  <div class="cen">
    <div class="container">
      <div class="errorbtn">404 ERROR</div>
    </div>
    <div class="container">
      <h3 class="txtcolor">Sorry, The Page Not Found</h3>
    </div>
    <div class="container"><a class="btn btn-primary home" href="<?=base_url()?>/" role="button">Back to Home</a></div>
  </div>
</section>

<style type="text/css">
/*404 css*/
@font-face {
font-family: 'Roboto-Light';
src: url('../assets/arigel_general/fonts/Roboto-Light.ttf'); /* IE9 Compat Modes */
}
@font-face {
font-family: 'ProximaNova-Semibold';
src: url('../assets/arigel_general/fonts/ProximaNova-Semibold.otf'); /* IE9 Compat Modes */
}
@font-face {
font-family: 'ProximaNova-Regular';
src: url('../assets/arigel_general/fonts/ProximaNova-Regular.otf'); /* IE9 Compat Modes */
}
@font-face {
font-family: 'proxima-nova-bold';
src: url('../assets/arigel_general/fonts/proxima-nova-bold.otf'); /* IE9 Compat Modes */
}

.errorpg { background: url("/assets/common_img/Bg-01.jpg");  background-size: cover; background-repeat: no-repeat;padding-bottom: 30px;}
.errorpg .cen{ text-align: center;}
.errorpg .pos{ /*margin-top: 30px;*/ display: block;  margin-left: auto; margin-right: auto;  height: 250px; width: auto;}
.errorpg .errorbtn{ border-radius: 12px;  font-size: 32px;  cursor: auto;
    background-color: #d63c36; font-family: ProximaNova-Semibold;  color:#fff; width: 300px; margin: 0 auto; padding: 10px;}
.errorpg .btn-danger:hover{ background-color: #d63c36;}
.errorpg .txtcolor{ /*color: #0b1d45;*/ color: #022043;  font-size: 36px; font-family: ProximaNova-Regular;}
.errorpg a{ border-color: #142544;}
.errorpg .home{  background-color: #142544; font-family:ProximaNova-Semibold; font-size:16px; border-color: #142544; width: 140px;color: #fff;}
.errorpg .btn-primary:hover{  background-color: #142544; border-color: #142544;}
.errorpg .btn-primary:focus{ border-color: #142544;}
.btn { display: inline-block;padding: 6px 12px;margin-bottom: 0;font-size: 14px;font-weight: 400;line-height: 1.42857143;text-align: center;white-space: nowrap;vertical-align: middle;-ms-touch-action: manipulation;touch-action: manipulation;cursor: pointer;-webkit-user-select: none;-moz-user-select: none;-ms-user-select: none;user-select: none;background-image: none;border: 1px solid transparent;
    border-radius: 4px;}
@media (max-width:1200px){
    .errorpg .pos{ height: 215px; }
}
@media (max-width:990px){
    .errorpg .pos{ height: 175px; }
}
/* End 404 Css*/
</style>