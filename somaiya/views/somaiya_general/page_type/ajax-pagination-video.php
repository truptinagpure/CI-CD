<?php if(!empty($video_listing_AJAX1)): foreach($video_listing_AJAX1 as $value): ?>
  <?php 
    $videoURL=$value['video_url'];
    $explodeurl=explode("/", $videoURL);
    $stringValue=substr($explodeurl[3], strpos($explodeurl[3], "=") + 1);  
    $youtubeURL="https://www.youtube.com/embed/$stringValue";
  ?>
  <div class="row mb-3">
    <div class="col-md-6">
      <iframe allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen="" frameborder="0" height="315" src="<?php echo $youtubeURL; ?>" title="YouTube video player" width="560"></iframe>
    </div>
    <div class="col-md-6 video-content">
      <div class="vtitle"><?php echo $value['video_text']; ?></div>
      <p>
        <?php
          $description=$value['video_description'];
          if (strlen($description) > 100) 
          {
            //$stringCut = substr($description, 0, 150);
           // $description = substr($stringCut, 0, strrpos($stringCut, ' '));
            echo $description;
          } else {
            echo $description;
          } 
        ?>
      </p>
      <div class="vdate"><?php echo date("jS", strtotime($value['date'])); ?> <?php echo date("F", strtotime($value['date'])); ?> <?php echo date("Y", strtotime($value['date'])); ?></div>
    </div>
  </div>
  <div class="clear"></div>
<?php endforeach; else: ?>
  <p class="errormsg">There are no videos matching the filter</p>
<?php endif; ?>
<?php echo $this->ajax_pagination->create_links(); ?>    
<style type="text/css">
  .showing-page{display: none;}
</style>