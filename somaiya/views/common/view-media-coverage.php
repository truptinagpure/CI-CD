<?php
    if(!empty($data))
    {   
        $mediacoverage_id   = $data[0]['mediacoverage_id'];
        $post_title         = $data[0]['title'];
        $short_desc         = $data[0]['description'];
        $post_url           = base_url($lang.'/view-media-coverage/'.$mediacoverage_id);
        $baseurl            = base_url();
        $gmail_body         = $post_url.'<br><br>'.$short_desc;
        $link_href          = $post_url;
        $gmail_href         = "https://mail.google.com/mail/u/0/?view=cm&fs=1&to&su=".$post_title."&body=".$link_href."&ui=2&tf=1&pli=1?";
        $email_href         = "mailto:?subject=".$post_title."&amp;body=".$link_href."";
        $facebook_href      = "http://www.facebook.com/sharer.php?u=".$post_url;
        $twitter_href       = "https://twitter.com/share?url=".$post_url."&text=".$post_title;
        $linkedin_href      = "https://www.linkedin.com/shareArticle?mini=true&url=".$post_url."&title=".$post_title."&summary=".$short_desc."&source=somaiya.edu";
        $whatsappURL        = 'whatsapp://send?text='.$post_url;

    }
?>
<?php if(isset($data) && count($data)!=0) { ?>
    <?php foreach($data as $item) { ?>
        <section class="view-announcement">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                            <div class="row asidebar">
                                <div class="swrap">
                                    <a class="simple-link capital" href="<?=base_url().$lang?>/latest-news">
                                    <img src="/assets/somaiya_com/img/link-arrow.svg" alt="">Back to all latest news</a>
                                </div>
                                <div class="swrap d-none">
                                    <p class="slabel">Date</p>                                
                                    <p class="sdata"><?php echo date("jS", strtotime($item['date'])); ?> <?php echo date("F", strtotime($item['date'])); ?> <?php echo date("Y", strtotime($item['date'])); ?></p>
                                </div>                                  
                                <?php //if($item['person'] != '') {?> 
                                    <!-- <div class="swrap">                                 
                                        <p class="slabel">Relevant Person(s)</p>                                    
                                        <p class="sdata"><?=$item['person']?></p>
                                    </div>   -->                                 
                                <?php //} ?>  
                                <div class="swrap d-none">                                
                                    <p class="slabel">Area of Interest</p>                            
                                    <p class="sdata"><?=$item['category_name']?></p>
                                </div>  
                                <div class="swrap">
                                    <div class="share">
                                    <p class="slabel">SHARE</p>
                                    <span class="fb-share-button" data-href="<?php echo $facebook_href; ?>" data-layout="button" data-size="large" data-mobile-iframe="true">
                                        <a class="fb-xfbml-parse-ignore" target="_blank" href="<?php echo $facebook_href; ?>">
                                            <!-- <img src="<?=base_url()?>assets/somaiya_com/img/social/facebook-f.svg"  class="lazyloadimg" alt="facebook open a new window" data-lazy="<?=base_url()?>assets/arigel_general/img/footer/fb.png"/> -->
                                            <i class="fa fa-facebook"></i>
                                        </a>
                                    </span>
                                    <span>
                                        <a class="twitter-share-button" href="<?php echo $twitter_href; ?>" target="_blank">
                                           <!--  <img class="twitter lazyloadimg" src="<?=base_url()?>assets/arigel_general/img/footer/twit.png" alt="twitter open  a new window" data-lazy="<?=base_url()?>assets/arigel_general/img/footer/twit.png" /> -->
                                           <i class="fa fa-twitter"></i>
                                        </a>
                                    </span>
                                    <!-- <span>
                                        <a class="twitter-share-button" href="<?php //echo $whatsappURL; ?>" target="_blank">
                                            <i class="fa fa-instagram"></i>
                                        </a>
                                    </span> -->
                                    <div class="clear"></div>
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="col-md-8 announcement-content">
                            <div class="row bkeditor">
                                <h2 class="title"><?=$item["title"]?></h2>
                                <?php // if($item['image'] == '') { ?>
                                    <!-- <img src="/assets/somaiya_com/img/placeholders.png" alt="placeholders"> -->
                                <?php
                                // } else { ?>
                                    <!-- <img alt="" src="<?=base_url()?>upload_file/images20/<?=$item['image']?>" alt="" class="img-responsive articleleft lazyloadimg" data-lazy="<?=base_url()?>upload_file/images20/<?=$item['image']?>" /> -->
                                <?php //} ?>
                                <p><?=$item['description']?></p>
                            </div>
                        </div>
                    </div>
          
            </div>
        <?php } ?>
    </section>
<?php } ?> 
<script>
    function myFunction() {
        window.print();
    }
</script>