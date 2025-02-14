<?php 
    if(isset($data) && count($data)!=0)
    { 
        foreach($data["body"] as $item)
        { 
?>
        <div>
            <?=$item['description']?>
        </div>
<?php 
        } 
    } 
?>

<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/somaiya_com/openFiles/css/timeline.css" />
<!-- <script src="<?=base_url()?>assets/somaiya_com/openFiles/js/timeline.js"></script> -->
<script type="text/javascript" src="https://cdn.knightlab.com/libs/timeline3/latest/js/timeline-min.js"></script>



<section class="BannerSections position-relative"><img alt="Banner Section" class="w-100" src="/assets/somaiya_com/img/banners/timeline.png">
  <div class="bannerText container">
    <h1>Timeline</h1>
    <ul class="siteBreadCrum">
      <li><a href="<?=base_url()?>">Home</a></li>
      <li class="divider"><img alt="BreadCrumb Arrow" src="/assets/somaiya_com/img/breadcrumArrow.svg"></li>
      <li>Timeline</li>
    </ul>
  </div>
</section>

<div role="main" class="timeline-com" style="display:block;">
  <div id="timeline-embed" style="width: 100%; height: 600px">&nbsp;</div> 
</div>

<script type="text/javascript">
    timeline = new TL.Timeline('timeline-embed',
    'https://docs.google.com/spreadsheets/d/1yT2rtRITBc6uF7MxDD7nJNP31j7fI0RoUjoNpVGxNoA/edit#gid=0');
  </script>


<style>
    footer{overflow: inherit!important;}
    body{ overflow-x: clip;}
</style>


 
  

  

