<?php if($ann_count !=0 AND !empty($announcement_listing_AJAX)){ ?>
  <h4 class="d-none d-sm-block"><b><?=$ann_count;?></b> Latest News.</h4>
<?php } ?>  
<div class="row">  
<?php if(!empty($announcement_listing_AJAX)): foreach($announcement_listing_AJAX as $announcement): ?>     
  <div class="col-md-4">
    <div class="event-wrap">
        <div class="">
        <div class="list-img">
          <?php if($announcement['image'] != '') { ?>
            <img src="<?=base_url()?>upload_file/images20/<?=$announcement['image']?>" alt="" class="d-none d-sm-block img-fluid">
          <?php } else { ?>
            <img src="<?=base_url()?>assets/somaiya_com/img/placeholders.png" alt="placeholders" class="d-none d-sm-block img-fluid">
          <?php } ?>
        </div>
            <div class="event-detail">
                <a href="#" class="d-none"><?=$announcement['category_name']?></a>
                <p> <a href="<?php echo  base_url().'en/view-news/'.$announcement['announcement_id']; ?>">
             
                <?php 
                    $title = $announcement['title'];
                        if (strlen($title) > 60) {
                        $string = substr($title, 0, 60) . "..."; 
                        echo $string;
                      } else { echo $title;}
                    ?>
              </a></p>
                <div class="edate d-none"><?php echo date("d", strtotime($announcement['date'])); ?>  <?php echo date("M", strtotime($announcement['date'])); ?>  <?php echo date("Y", strtotime($announcement['date'])); ?></div>
            </div>
        </div>
        
    </div>
  </div>
<?php endforeach; else: ?>
  <p class="errormsg">There are no latest news matching the filter.</p>
<?php endif; ?>
</div>
<?php echo $this->ajax_pagination->create_links(); ?>   