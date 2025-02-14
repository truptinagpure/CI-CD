<?php if($news_count !=0 AND !empty($latestNews_AJAX)){ ?>
  <h4 class="d-none d-sm-block"><b><?=$news_count;?></b> Latest News.</h4>
<?php } ?>  
<div class="row">  
<?php if(!empty($latestNews_AJAX)): foreach($latestNews_AJAX as $latestnews): ?>     
  <div class="col-md-4">
    <div class="event-wrap">
        <div class="">
        <div class="list-img">
          <?php if($latestnews['image'] != '') { ?>
            <img src="<?=base_url()?>upload_file/images20/<?=$latestnews['image']?>" alt="" class="d-none d-sm-block img-fluid">
          <?php } else { ?>
            <img src="<?=base_url()?>assets/somaiya_com/img/placeholders.png" alt="placeholders" class="d-none d-sm-block img-fluid">
          <?php } ?>
        </div>
            <div class="event-detail">
                <a href="#" class="d-none"><?=$latestnews['category_name']?></a>
                <p class="event-cat"><?=$latestnews['badge']?></p>
                <?php if($latestnews['badge'] == 'Announcement')
                {
                ?>
                  <p> <a href="<?php echo  base_url().'en/view-news/'.$latestnews['id']; ?>">
                <?php } elseif($latestnews['badge'] == 'MediaCoverage') { ?>
                  <p> <a href="<?php echo  base_url().'en/view-media-coverage/'.$latestnews['id']; ?>">
                <?php } ?>
             
                <?php 
                    $title = $latestnews['title'];
                        if (strlen($title) > 46) {
                        $string = substr($title, 0, 46) . "..."; 
                        echo $string;
                      } else { echo $title;}
                    ?>
              </a></p>
                <div class="edate d-none"><?php echo date("d", strtotime($latestnews['date'])); ?>  <?php echo date("M", strtotime($latestnews['date'])); ?>  <?php echo date("Y", strtotime($latestnews['date'])); ?></div>
            </div>
        </div>
        
    </div>
  </div>
<?php endforeach; else: ?>
  <p class="errormsg">There are no latest news matching the filter.</p>
<?php endif; ?>
</div>
<?php echo $this->ajax_pagination->create_links(); ?>   