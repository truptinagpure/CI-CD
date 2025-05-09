
<body>
    <div class="parallax aem-GridColumn aem-GridColumn--default--12 d-none" data-aos="fade-left">
        <section class="hidden-xs hidden-sm">
            <div class="parallaxControls">
                <div class="pointerDiv active">
                    <span class="point" data-slide="0"></span><span class="linePointer"></span>
                    <a href="#home-slider">
                        <div class="pointerText tab ">Slider</div>
                    </a>
                </div>
                <div class="pointerDiv">
                    <span class="point" data-slide="1"></span><span class="linePointer"></span>
                    <a href="#About-the-group">
                        <div class="pointerText tab">About the group</div>
                    </a>
                </div>
                <div class="pointerDiv">
                    <span class="point" data-slide="2"></span><span class="linePointer"></span>
                    <a href="#our-verticals">
                        <div class="pointerText">Our Verticals</div>
                    </a>
                </div>
                <div class="pointerDiv">
                    <span class="point" data-slide="2"></span><span class="linePointer"></span>
                    <a href="#our-community">
                        <div class="pointerText">Our Community</div>
                    </a>
                </div>
                <div class="pointerDiv">
                    <span class="point" data-slide="3"></span><span class="linePointer"></span>
                    <a href="#latest-news">
                        <div class="pointerText">Latest News</div>
                    </a>
                </div>
                <div class="pointerDiv">
                    <span class="point" data-slide="4"></span><span class="linePointer"></span>
                    <a href="#timeline">
                        <div class="pointerText">Timeline</div>
                    </a>
                </div>
                <div class="pointerDiv">
                    <span class="point" data-slide="4"></span><span class="linePointer"></span>
                    <a href="#Founders">
                        <div class="pointerText">Our Founders</div>
                    </a>
                </div>
            </div>
        </section>
        <section class="sliderElem"></section>
    </div>
    <main class="page-content" style="overflow:hidden;" >
        <div class="home-slider section-wrap" id="home-slider" data-aos="fade-up">
            <div id="main-carousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators d-none">
                    <button type="button" data-bs-target="#main-carousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <?php $i=0; for ($i=0;$i<count($banner_listing);$i++) { ?>
                        <button type="button" data-bs-target="#main-carousel" data-bs-slide-to="<?=$i + 1;?>" aria-current="true" aria-label="Slide <?=$i + 1;?>"></button>
                    <?php } ?>
                </div>
                <div class="carousel-inner">
                   <!--  <div class="carousel-item active">
                        <video  autoplay="autoplay" loop="loop" muted="muted" id="myVideo">
                            <source src="https://somaiya.org/video/video.mp4" type="video/mp4">
                            </video>
                        <div class="container videotxtblk text-center">
                            <h2>Building an inclusive society since 1939</h2>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <video  autoplay="autoplay" loop="loop" muted="muted" id="myVideo">
                            <source src="/assets/somaiya_com/img/video/1047708412-hd.mp4" type="video/mp4">
                            </video>
                        <div class="container videotxtblk text-center">
                            <h2>Somaiya Group is a well-established business house with diversified interests</h2>
                        </div>
                    </div> -->
                    <?php 
                    //echo "window width = ".$window_width;

                    $i=0; for ($i=0;$i<count($banner_listing);$i++) { 
                        //var_dump($banner_listing);
                         ?>
                        <div class="carousel-item">
                            <!-- <img src="<?=base_url().$banner_listing[$i]['image']?>" class="d-block w-100" alt="...">
                            <div class="carousel-caption">
                                <h2><?=$banner_listing[$i]['banner_text']?></h2>
                            </div> -->   
                            <?php
                                $desktop_banner = base_url().'upload_file/banner_images/'.$banner_listing[$i]['image'];
                                if(isset($banner_listing[$i]['mobile_image']) && !empty($banner_listing[$i]['mobile_image']))
                                {
                                    $mobile_banner = base_url().'upload_file/banner_images/'.$banner_listing[$i]['mobile_image'];
                                }
                                else
                                {
                                    $mobile_banner = base_url().'upload_file/banner_images/'.$banner_listing[$i]['image'];
                                }
                            ?>
                                <img src="<?=$desktop_banner?>" class="desktop-banner desktop w-100" alt="...">
                                <img src="<?=$mobile_banner?>" class="mobile-banner mobile w-100" alt="...">                  
                            
                            <!-- <img src="/assets/somaiya_com/img/homeBanners/home8.jpg" class="w-100" alt="homepage Banner" /> -->
                            <div class="videotxtblk bottomtext text-center ">
                                <div class="position-relative">
                                    <div class="bannerContent">
                                        <h2 class="animate__animated animate__fadeInUp ">
                                            <?=$banner_listing[$i]['banner_text']?>
                                        </h2>
                                        <?php  
                                        if(!empty($banner_listing[$i]['banner_url'])){ ?>
                                            <a href="<?= $banner_listing[$i]['banner_url'] ?>" target="<?= $banner_listing[$i]['banner_url_target'] ?>" class="animate__animated animate__fadeInUp link " target="_blank">
                                            <?= $banner_listing[$i]['banner_url_button_text'] ?>
                                             <img src="/assets/somaiya_com/img/arrow-right.svg" alt="">
                                            </a>
                                        <?php 
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="ctrl">
                    <a class="modal-carousel-control carousel-control-prev" href="#main-carousel" data-bs-slide="prev" >
                        <img src="/assets/somaiya_com/img/arrow-left.svg">
                        <span class="visually-hidden">Previous</span>
                    </a> 
                    <span class="count"></span>
                     <a class="modal-carousel-control carousel-control-next" href="#main-carousel" data-bs-slide="next">
                        <img src="/assets/somaiya_com/img/arrow-right.svg">
                        <span class="visually-hidden">Next</span>
                    </a> 
                </div>
            </div>
        </div>
      
        <!-- About the group-->
        <section class="about-the-gp section-wrap" id="About-the-group" data-aos="fade-up" data-aos-delay="50">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="title capital" >About the group 15</h2>
                        <img class="fimg"  data-aos-duration="1500" src="/assets/somaiya_com/img/Shri-K.-J.-Somaiya.png" alt="">
                        <div class="col-md-7 col-lg-4">
                            <p>One of the oldest and well-established business houses in India, the Somaiya Group has diversified interests in foods, biofuel, speciality chemicals, education, healthcare, rural development and agricultural research. </p>
                            <p class="d-none">About the group medha -  With a humble start in 1939, with Padmabhushan Shri Karamshibhai Jethabhai Somaiya, opening a sugar factory in Sakarwadi, Karnataka, Godavari Sugar Mills soon became a name to reckon with giving him the title of the ‘Sugar King of India’. Pioneering in alcohol production from agricultural feedstock, the Group diversified into value-added products with its distillery in 1941 and paved the way for manufacture of alcohol-based chemicals in India.</p>
                            <p>
                                <a class="link" href="/en/about-us/">Read More <img src="/assets/somaiya_com/img/link-arrow.svg" alt=""></a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End about the group>-->
          <!-- event section-->
        <section class="latest-news" id="latest-news" data-aos="fade-up" data-aos-delay="50">
            <div class="container">
                <h2 class="title capital">Latest News</h2>
                <div class="row">
                    <div class="col-md-8">
                        <p class="d-none d-sm-block">There are various events happening across our verticals. Stay in the loop of everything by checking this section from time to time. </p>
                    </div>
                    <div class="col-md-4 d-none d-sm-block mt-0 my-4">
                        <a class="link float-end" href="/en/latest-news">Read More <img src="/assets/somaiya_com/img/link-arrow.svg" alt=""></a>
                    </div>
                </div>
                <div class="latest-news-wrap" style="display: none;">
                    <div class="row">
                        <?php if(isset($newsann) && count($newsann)!=0){ ?>
                            <?php foreach($newsann as $announcement){ ?>
                                <div class="col-md-3 event-list">
                                    <a href="<?php echo  base_url().'en/view-news/'.$announcement['announcement_id']; ?>">
                                        <div class="new-content">
                                            <div class="img-wrapper">
                                                <?php
                                                    if($announcement['image'] == '')
                                                    {
                                                ?>
                                                        <img src="/assets/somaiya_com/img/placeholders.png" alt="placeholders">
                                                <?php } else { ?>
                                                        <img src="/upload_file/images20/<?=$announcement['image']?>" alt="">
                                                <?php } ?>
                                            </div>
                                            <div class="content-wrap">
                                            
                                                <p class="d-none"><?=$announcement['category_name']?></p>
                                                <p class="status">                                              
                                                <?php 
                                                  $title = $announcement['title'];
                                                     if (strlen($title) > 60) {
                                                     $string = substr($title, 0, 60) . "..."; 
                                                     echo $string;
                                                    } else { echo $title;}
                                                 ?>
                                                </p>
                                                <!-- <p class="">Lorem ipsum is a placeholder text commonly used to demonstrate.</p> -->
                                                <div class="date d-none"><?php echo date("d", strtotime($announcement['date'])); ?>  <?php echo date("M", strtotime($announcement['date'])); ?>  <?php echo date("Y", strtotime($announcement['date'])); ?></div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            <?php } ?>
                        <?php } ?>
                        <!-- <div class="col-md-4">
                            <div class="new-content">
                                <div class="img-wrapper">
                                    <img src="assets/somaiya_com/img/jivan.png" alt="">
                                </div>
                                <div class="content-wrap">
                                    <a href="">KITAB KHANA</a>
                                    <p class="status">Re-opening on July'21</p>
                                    <p class="">Lorem ipsum is a placeholder text commonly used to demonstrate.</p>
                                    <div class="date">15 - Jul - 2021</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="new-content">
                                <div class="img-wrapper">
                                    <img src="assets/somaiya_com/img/kisan.png" alt="">
                                </div>
                                <div class="content-wrap">
                                    <a href="">KITAB KHANA</a>
                                    <p class="status">Re-opening on July'21</p>
                                    <p class="">Lorem ipsum is a placeholder text commonly used to demonstrate.</p>
                                    <div class="date">15 - Jul - 2021</div>
                                </div>
                            </div>
                        </div> -->
                    </div>
                </div>
                <div class="latest-news-wrap">
                    <div class="row">
                        <?php
                        if(isset($latestnews) && count($latestnews)!=0)
                        {   
                            foreach(array_slice($latestnews, 0, 4) as $wn)
                            {
                                $url = base_url($lang.'/');
                                $icon = 'fa-bullhorn';
                                if($wn['type'] == 'Announcement')
                                {
                                    $url = $url.'/view-news/'.$wn['id'];
                                    $icon = 'fa-bullhorn';
                                }
                                else if($wn['type'] == 'Media Coverage')
                                {
                                    $url = $url.'/view-media-coverage/'.$wn['id'];
                                    $icon = 'fa-video-camera';
                                }
                        
                                $chr_lim = 46;
                                if(strlen($wn['name']) > $chr_lim)
                                {
                                    $name = substr($wn['name'], 0, $chr_lim) . '...';
                                }
                                else
                                {
                                    $name = $wn['name'];
                                }
                        ?>
                                <div class="col-md-6 col-lg-3 event-list">
                                    <a href="<?php echo $url; ?>">
                                        <div class="new-content">
                                            <div class="img-wrapper">
                                                <?php
                                                    if($wn['image'] == '')
                                                    {
                                                ?>
                                                        <img src="/assets/somaiya_com/img/placeholders.png" alt="placeholders">
                                                <?php } else { ?>
                                                        <img src="/upload_file/images20/<?=$wn['image']?>" alt="">
                                                <?php } ?>
                                            </div>
                                            <div class="content-wrap">
                                                <p class="event-cat"><?=$wn['type']?></p>
                                                <p class="status"><?php echo $name; ?></p>
                                                <div class="date d-none"><?php echo date("d", strtotime($wn['date'])); ?>  <?php echo date("M", strtotime($wn['date'])); ?>  <?php echo date("Y", strtotime($wn['date'])); ?></div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            <?php
                            }
                        }
                        ?>
                    </div>
                </div>
                <div class="d-block d-sm-none float-end float-none">
                    <p class="mobcenter mt-4">
                        <a class="link"href="/en/latest-news">Read More <img src="/assets/somaiya_com/img/link-arrow.svg" alt=""></a>
                    </p>
                </div>
                <div class="clearfix"></div>
            </div>
        </section>
        <!-- end event section-->
        <!--Carousel Wrapper-->
        <!-- <section class="our-vertical d-none" id="our-verticals" data-aos="fade-up" data-aos-delay="50">
            <div class="container">
                <div class="row">
                    <div col-md-12>
                        <h2 class="title text-center capital">Our Business verticals</h2>
                        <p class="text-center introp">From Business to Philanthropy, our vast verticals touch upon every aspect for the betterment of mankind. We excel in each vertical and strive to continue the legacy with great service. </p>
                    </div>
                </div>
            </div>
            <div id="carousel-thumb" class="carousel slide carousel-fade carousel-thumbnails" data-bs-ride="carousel">
              
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img class="d-block w-100 wow fadeInUp" src="/assets/somaiya_com/img/new-vertical-home/godavari-vertical.png" alt="First slide">
                        <div class="carousel-caption wow fadeInUp">
                            <div class="caption-title wow fadeInRightBig" data-wow-delay="0.1s">Godavari Biorefineries</div>
                            <p class="wow fadeInRightBig">Using sugarcane as the primary feedstock, we are a biorefining company producing sugar, other foods, biofuels, chemicals, power, compost, waxes, and related products. We are now working on bagasse-based biorefinery and also the biotransformation of sugar to biopolymers. </p>
                            <a class="link wow fadeInRightBig" href="/en/our-verticals#Biorefineries">Read More <img src="/assets/somaiya_com/img/link-arrow.svg" alt=""></a>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img class="d-block w-100" src="/assets/somaiya_com/img/new-vertical-home/kitabkhana.png" alt="Second slide">
                        <div class="carousel-caption wow fadeInUp">
                            <div class="caption-title wow fadeInRightBig" data-wow-delay="0.1s">KitabKhana</div>
                            <p class="wow fadeInRightBig">The store has always been a community hub—a place to discover hidden gems from international prose and poetry or hard to find books in Hindi, Marathi, Gujarati and Indian language translations. </p>
                            <a class="link wow fadeInRightBig" href="/en/our-verticals#Kitab" target="_blank">Read More <img src="/assets/somaiya_com/img/link-arrow.svg" alt=""></a>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img class="d-block w-100" src="/assets/somaiya_com/img/new-vertical-home/jiwan.png" alt="Third slide">
                        <div class="carousel-caption wow fadeInUp">
                            <div class="caption-title wow fadeInRightBig" data-wow-delay="0.1s">Jivana </div>
                            <p class="wow fadeInRightBig">With the objective of retaining the purity and goodness of naturally-occurring ingredients, we at Jivana brought out our range of essential cooking ingredients such as sugar, brown sugar, jaggery, pure and natural sugarcane concentrate, salt, turmeric and others.</p>
                            <a class="link wow fadeInRightBig" href="/en/our-verticals#Jivana">Read More <img src="/assets/somaiya_com/img/link-arrow.svg" alt=""></a>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img class="d-block w-100" src="/assets/somaiya_com/img/new-vertical-home/pawan.png" alt="fouth slide">
                        <div class="carousel-caption wow fadeInUp">
                            <div class="caption-title wow fadeInRightBig" data-wow-delay="0.1s">Paawan</div>
                            <p class="wow fadeInRightBig">A non-sticky hand sanitiser, Paavan immediately cleanses hands without water and soap providing effective protection against a variety of bacteria, fungi, and viruses.</p>
                            <a class="link wow fadeInRightBig" href="/en/our-verticals#Paavan" >Read More <img src="/assets/somaiya_com/img/link-arrow.svg" alt=""></a>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img class="d-block w-100" src="/assets/somaiya_com/img/new-vertical-home/sathgen.png" alt="fifth slide">
                        <div class="carousel-caption wow fadeInUp">
                            <div class="caption-title wow fadeInRightBig" data-wow-delay="0.1s">Satgen</div>
                            <p class="wow fadeInRightBig">Sathgen Biotech is a division of Godavari Biorefineries Ltd. and is actively involved in anti-cancer drug screening using novel methods. The laboratory has achieved some major breakthroughs in developing a few anti-cancer stem cell molecules, which are showing better performance than the standard chemotherapeutic drugs.</p>
                            <a class="link wow fadeInRightBig" href="https://www.sathgenbiotech.com/" target="_blank">Read More <img src="/assets/somaiya_com/img/link-arrow.svg" alt=""></a>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img class="d-block w-100" src="/assets/somaiya_com/img/new-vertical-home/kisan.png" alt="sixth slide">
                        <div class="carousel-caption wow fadeInUp">
                            <div class="caption-title wow fadeInRightBig" data-wow-delay="0.1s">Kisan Khazana</div>
                            <p class="wow fadeInRightBig">A subsidiary of Godavari Biorefineries Ltd. Kisan Khazana is a mobile application in agriculture which is designed for farmers. It aims to use science to develop solutions for challenges faced by farmers while increasing productivity and ensuring the health of the earth. </p>
                            <a class="link wow fadeInRightBig" href="#">Read More <img src="/assets/somaiya_com/img/link-arrow.svg" alt=""></a>
                        </div>
                    </div>
                </div>

                <div class="wrap d-flex justify-content-center">
                    <ol class="BrandSectionIndicator carousel-indicators align-content-around flex-wrap mt-4 d-flex align-items-end">
                        <li data-bs-target="#carousel-thumb" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1">

                            <img class=" w-100 upMark" src="/assets/somaiya_com/img/menu-active.svg" alt="Arrow">
                            <div class="arrow">
                                <div class="overlay"></div>
                                <img class="d-block w-100 thumb " src="/assets/somaiya_com/img/new-vertical-home/godavari-th.png">
                            </div>
                            <div class="catlable">Biorefineries</div>
                        </li>

                        <li type="button" data-bs-target="#carousel-thumb" data-bs-slide-to="1" aria-label="Slide 2">
                            <img class=" w-100 upMark" src="/assets/somaiya_com/img/menu-active.svg" alt="Arrow">
                            <div class="arrow">
                                <div class="overlay"></div>
                                <img class="d-block w-100 thumb" src="/assets/somaiya_com/img/new-vertical-home/kiab-th.png">
                            </div>
                            <div class="catlable">KitabKhana</div>
                        </li>
                        <li data-bs-target="#carousel-thumb" data-bs-slide-to="2" aria-label="Slide 3">
                            <img class=" w-100 upMark" src="/assets/somaiya_com/img/menu-active.svg" alt="Arrow">
                            <div class="arrow">
                                <div class="overlay"></div>
                                <img class="d-block w-100 thumb" src="/assets/somaiya_com/img/new-vertical-home/jivan-th.png">
                            </div>
                            <div class="catlable">Jivana</div>
                        </li>
                        <li data-bs-target="#carousel-thumb" data-bs-slide-to="3" aria-label="Slide 4">
                            <img class=" w-100 upMark" src="/assets/somaiya_com/img/menu-active.svg" alt="Arrow">
                            <div class="arrow">
                                <div class="overlay"></div>
                                <img class="d-block w-100 thumb" src="/assets/somaiya_com/img/new-vertical-home/paawan-th.png">
                            </div>
                            <div class="catlable">Paawan </div>
                        </li>
                        <li data-bs-target="#carousel-thumb" data-bs-slide-to="4" aria-label="Slide 5">
                            <img class=" w-100 upMark" src="/assets/somaiya_com/img/menu-active.svg" alt="Arrow">
                            <div class="arrow">
                                <div class="overlay"></div>
                                <img class="d-block w-100 thumb" src="/assets/somaiya_com/img/new-vertical-home/sathgen-th.png">
                            </div>
                            <div class="catlable">Satgen</div>
                        </li>
                        <li data-bs-target="#carousel-thumb" data-bs-slide-to="5" aria-label="Slide 6">
                            <img class=" w-100 upMark" src="/assets/somaiya_com/img/menu-active.svg" alt="Arrow">
                            <div class="arrow">
                                <div class="overlay"></div>
                                <img class="d-block w-100 thumb" src="/assets/somaiya_com/img/new-vertical-home/kisan-th.png">
                            </div>
                            <div class="catlable">Kisan Khazana</div>
                        </li>
                    </ol>
                </div>
            </div>          
            </div>
        </section> -->
        <!-- OUr vetucals ends -->
        <!-- Community Sections -->
        <!-- <div class="CommunitySlider d-none position-relative" id="our-community" data-aos="fade-up" data-aos-delay="50">
            <div id="community-carousel" class="carousel slide" data-bs-ride="carousel">                
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="container">
                            <div class="row m-auto align-items-center">
                                <div class=" col-12 col-sm-12 col-md-7 imageCLoumn">
                                    <div class="logoWrapper position-relative">
                                        <img src="/assets/somaiya_com/img/community/logo/somaiyaVV.svg" class="" alt="...">
                                        <div class="position-relative comImgWrap">                                        
                                            <div class="comInnerImgWrap">
                                                <span class="slideText">Education</span>
                                                <img src="/assets/somaiya_com/img/community/educations.png" class="d-block w-100" alt="...">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class=" col-12 col-sm-12 col-md-5 textColumns">
                                    <div class="comTitle">
                                        <h2>Our Community</h2>
                                    </div>
                                    <p>Somaiya Vidyavihar is an educational trust that has build up educational institutes in Mumbai, Rural, Maharashtra and Karnataka.</p>
                                    <ul>
                                        <li><span class="headingIcons"></span>Somaiya Vidyavihar</li>
                                        <li><span class="headingIcons"></span>Somaiya Vidyavihar University</li>
                                        <li><span class="headingIcons"></span>Somaiya Schools</li>
                                        <li><span class="headingIcons"></span>Initiatives</li>
                                        <li><span class="headingIcons"></span>Medical, physiotherapy & nursing</li>
                                    </ul>
                                    <a href="/en/our-verticals#Education">Read More  <img src="/assets/somaiya_com/img/arrow-right.svg" alt=" Icons" /></a>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="carousel-item Healthcare">
                        <div class="container">
                            <div class="row m-auto align-items-center">
                                <div class=" col-12 col-sm-12 col-md-7 imageCLoumn">
                                    <div class="logoWrapper position-relative">
                                        <img src="/assets/somaiya_com/img/community/logo/somaiyaVV.svg" class="" alt="...">
                                        <div class="position-relative comImgWrap">
                                            <div class="comInnerImgWrap">
                                                <span class="slideText">Healthcare</span>
                                                <img src="/assets/somaiya_com/img/community/healthcare.png" class="d-block w-100" alt="...">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class=" col-12 col-sm-12 col-md-5 textColumns">
                                    <div class="comTitle">
                                        <h2>Our Community</h2>
                                    </div>
                                    <p>Along with the field of medical education, we also provide cutting-edge research and patient treatment. We facilitate world-class infrastructure and top-notch health education. </p>
                                    <ul>
                                        <li><span class="headingIcons"></span>Medical</li>
                                        <li><span class="headingIcons"></span>Ayurveda</li>
                                        <li><span class="headingIcons"></span>Blood bank</li>
                                        <li><span class="headingIcons"></span>Blood bank</li>
                                    </ul>
                                    <a href="/en/our-verticals#Healthcare">Read More  <img src="/assets/somaiya_com/img/arrow-right.svg" alt=" Icons" /></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item Rural">
                        <div class="container">
                            <div class="row m-auto align-items-center">
                                <div class=" col-12 col-sm-12 col-md-7 imageCLoumn">
                                    <div class="logoWrapper position-relative">
                                        <img src="/assets/somaiya_com/img/community/logo/somaiyaVV.svg" class="" alt="...">
                                        <div class="position-relative comImgWrap">
                                            <div class="comInnerImgWrap">
                                                <span class="slideText">Rural Development</span>
                                                <img src="/assets/somaiya_com/img/community/rural.png" class="d-block w-100" alt="...">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class=" col-12 col-sm-12 col-md-5 textColumns">
                                    <div class="comTitle">
                                        <h2>Our Community</h2>
                                    </div>
                                    <p>Our mission is to preserve and protect traditional arts through education, innovation and economic empowerment of artisans. We believe that empowerment and progress go together for rural development.</p>
                                    <ul>
                                        <li><span class="headingIcons"></span>Nareshwadi</li>
                                        <li><span class="headingIcons"></span>Somaiya KALAVIDYA</li>
                                        <li><span class="headingIcons"></span>Help A Child</li>
                                    </ul>
                                    <a href="/en/our-verticals#Rural">Read More  <img src="/assets/somaiya_com/img/arrow-right.svg" alt=" Icons" /></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item Agricultural">
                        <div class="container">
                            <div class="row m-auto align-items-center">
                                <div class=" col-12 col-sm-12 col-md-7 imageCLoumn">
                                    <div class="logoWrapper position-relative">
                                        <img src="/assets/somaiya_com/img/community/logo/somaiyaVV.svg" class="" alt="...">
                                        <div class="position-relative comImgWrap">
                                            <div class="comInnerImgWrap">
                                                <span class="slideText">Agricultural Research</span>
                                                <img src="/assets/somaiya_com/img/community/agro.png" class="d-block w-100" alt="...">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class=" col-12 col-sm-12 col-md-5 textColumns">
                                    <div class="comTitle">
                                        <h2>Our Community</h2>
                                    </div>
                                    <p>Research forms the base of any agricultural development. Somaiya Vidyavihar has facilitated top research centers to innovate agricultural technologies for improving economy and livelihood.</p>
                                    <ul>
                                        <li><span class="headingIcons"></span>KIAAR</li>
                                    </ul>
                                    <a href="/en/our-verticals#Agricultural">Read More  <img src="/assets/somaiya_com/img/arrow-right.svg" alt=" Icons" /></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item Philanthropy">
                        <div class="container">
                            <div class="row m-auto align-items-center">
                                <div class=" col-12 col-sm-12 col-md-7 imageCLoumn">
                                    <div class="logoWrapper position-relative">
                                        <img src="/assets/somaiya_com/img/community/logo/somaiyaVV.svg" class="" alt="...">
                                        <div class="position-relative comImgWrap">
                                            <div class="comInnerImgWrap">
                                                <span class="slideText">Philanthropy</span>
                                                <img src="/assets/somaiya_com/img/community/phil.png" class="d-block w-100" alt="...">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class=" col-12 col-sm-12 col-md-5 textColumns">
                                    <div class="comTitle">
                                        <h2>Our Community</h2>
                                    </div>
                                    <p>Somaiya Trust proactively contributes to the process of social transformation through initiatives in education, affordable healthcare, preservation and promotion of art and culture, tribal welfare and women empowerment.
                                    </p>
                                    <a href="/en/our-verticals#Philanthropy">Read More  <img src="/assets/somaiya_com/img/arrow-right.svg" alt=" Icons" /></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="communityCtrl ">
                    <a class="prev carousel-control-prev" type="a" data-bs-target="#community-carousel" data-bs-slide="prev">
                        <img src="/assets/somaiya_com/img/arrow-left.svg">
                    </a>
                    <span class="count"></span>
                    <a class="next carousel-control-next" type="a" data-bs-target="#community-carousel" data-bs-slide="next">
                        <img src="/assets/somaiya_com/img/arrow-right.svg">
                    </a>
                </div>
            </div>
        </div> -->
        <!-- Community Sections -->
      
        <!--timeline-->
        <!-- <section class="timeline" id="timeline" data-aos="fade-up" data-aos-delay="50">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="title capital text-center white">Timeline</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="borderWrap"></div>
                    <div class="col-md-5 pr0">
                        <div class="whitbg">
                            <div class="tag capital">Since 1939</div>
                            <p>Established in 1939, in just five decades, we have pillared an array of verticals. We continue to build a legacy with each vertical. Have a look at how Somaiya Vidyavihar began and achieved remarkable milestones over time. 
                            </p>
                            <a class="link wow fadeInRightBig">Know More <img src="/assets/somaiya_com/img/link-arrow.svg" alt=""></a>
                        </div>
                    </div>
                    <div class="col-md-7 rtime">
                        <div>
                            <img src="/assets/somaiya_com/img/timeline1.png" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </section> -->
        <!--end timelie-->
        <!-- our founder-->
        <section class="our-founder" id="Founders" data-aos="fade-up" data-aos-delay="50">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="title capital">Our Founders</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <ul class="nav nav-tabs justify-content-end" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active capital" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Shri. K. J. Somaiya</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link capital" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Dr. S. K. Somaiya</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <div class="row">
                                    <div class="col-md-3 overlapimg">
                                        <div class="">
                                            <img src="/assets/somaiya_com/img/our-founder1.png" alt="">
                                        </div>
                                    </div>
                                    <div class="col-md-9 pl">
                                        <div class="tab-wrap">
                                            <!-- <h3>Shri. K. J. Somaiya</h3>
                                            <div class="sub-head">Padma Bhushan</div> -->
                                            <div class="contentp">
                                                <p>“Whatever you do in word or in deed, do all the Name of Lord, Giving Thanks to Him.”</p>
                                                <p>It’s no small achievement to distinguish oneself in such diverse fields as commerce, education, and philanthropy.</p>
                                                <p>Pujya Shriman Karamshibhai Jethabhai Somaiya, born on May 16 1902 in the remote village of Malunjar in Ahmednagar district of Maharashtra, India, was however, a blessed person by dint of hard work and singular
                                                    devotion to service.</p>
                                            </div>
                                            <p class="mobcenter"><a class="link wow fadeInRightBig" href="/en/our-founders#KJ">Know More <img src="/assets/somaiya_com/img/link-arrow.svg" alt=""></a></p>
                                        </div>
                                    </div>
                                    <div class="col-md-12 d-flex justify-content-center">
                                        <ul class="light-gallery">
                                            <li>
                                                <div class="item green">
                                                    <a class="example-image-link" href="/assets/somaiya_com/img/light1.jpg" data-lightbox="example-set" data-title="Click the right half of the image to move forward.">
                                                        <img class="example-image" src="/assets/somaiya_com/img/light1.jpg" alt="Golden Gate Bridge with San Francisco in distance">
                                                        <div class="wrap">
                                                        <img class ="over_lapimg" src="/assets/somaiya_com/img/arrows-expand.svg" alt=""/>
                                                    </div>
                                                    </a>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="item green">
                                                    <a class="example-image-link" href="/assets/somaiya_com/img/light2.jpg" data-lightbox="example-set" data-title="Or press the right arrow on your keyboard.">
                                                        <img class="example-image" src="/assets/somaiya_com/img/light2.jpg" alt="Forest with mountains behind">
                                                        <div class="wrap">
                                                        <img class ="over_lapimg" src="/assets/somaiya_com/img/arrows-expand.svg" alt=""/>
                                                </div>
                                                    </a>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="item green">
                                                    <a class="example-image-link" href="/assets/somaiya_com/img/light3.jpg" data-lightbox="example-set" data-title="The next image in the set is preloaded as you're viewing.">
                                                        <img class="example-image" src="/assets/somaiya_com/img/light3.jpg" alt="Bicyclist looking out over hill at ocean">
                                                        <div class="wrap">
                                                        <img class ="over_lapimg" src="/assets/somaiya_com/img/arrows-expand.svg" alt=""/>
                                                </div>
                                                    </a>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="item green">
                                                    <a class="example-image-link" href="/assets/somaiya_com/img/light4.jpg" data-lightbox="example-set" data-title="Click anywhere outside the image or the X to the right to close.">
                                                        <img class="example-image" src="/assets/somaiya_com/img/light4.jpg" alt="Small lighthouse at bottom with ocean behind">
                                                        <div class="wrap">
                                                        <img class ="over_lapimg" src="/assets/somaiya_com/img/arrows-expand.svg" alt=""/>
                                                </div>
                                                    </a>

                                                </div>
                                            </li>
                                            <li>
                                                <div class="item green">
                                                    <a class="example-image-link" href="/assets/somaiya_com/img/light5.jpg" data-lightbox="example-set" data-title="Click anywhere outside the image or the X to the right to close.">
                                                        <img class="example-image" src="/assets/somaiya_com/img/light5.jpg" alt="Small lighthouse at bottom with ocean behind">
                                                        <div class="wrap">
                                                        <img class ="over_lapimg" src="/assets/somaiya_com/img/arrows-expand.svg" alt=""/>
                                                </div>
                                                    </a>
                                                </div>
                                            </li>
                                            <!-- <li>
                                        <div class="item green">
                                        <a class="example-image-link" href="assets/img/light6.jpg" data-lightbox="example-set" data-title="Click anywhere outside the image or the X to the right to close.">
                                            <img class="example-image" src="assets/somaiya_com/img/light6.jpg" alt="Small lighthouse at bottom with ocean behind">
                                           <i class="fa fa-expand" aria-hidden="true"></i>
                                        </a>
                                    </div>
                                </li> -->
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                <div class="row">
                                    <div class="col-md-3 overlapimg">
                                        <div class="">
                                            <img src="/assets/somaiya_com/img/sk-somaiya.png" alt="">
                                        </div>
                                    </div>
                                    <div class="col-md-9 pl">
                                        <div class="tab-wrap">
                                            <!-- <h3>Dr. S. K. Somaiya</h3> -->
                                            
                                            <div class="contentp">
                                                <p>Dr. Somaiya did much in the field of sugarcane research, sugar manufacture and ethanol, and ethanol based chemistry.</p>
                                                <p>His contribution to the company was the identification of the site for sugar production in Karnataka, at Sameerwadi, in the late 1960s. At the time, there was very little cane grown there.</p>
                                                <p>He founded the K. J. Somaiya Institute of Applied Agriculture Research (KIAAR), and taught the farmers of the area how to grow cane. Today, North Karnataka, is among the best cane growing areas of India</p>
                                            </div>
                                            <p class="mobcenter"><a class="link wow fadeInRightBig" href="/en/our-founders#SK">Know More <img src="/assets/somaiya_com/img/link-arrow.svg" alt=""></a></p>
                                        </div>
                                    </div>
                                    <div class="col-md-12 d-flex justify-content-center">
                                        <ul class="light-gallery">
                                            <li>
                                                <div class="item green">
                                                    <a class="example-image-link" href="/assets/somaiya_com/img/sk-tab-home/sk1.png" data-lightbox="example-set" data-title="Click the right half of the image to move forward.">
                                                        <img class="example-image" src="/assets/somaiya_com/img/sk-tab-home/sk1.png" alt="Golden Gate Bridge with San Francisco in distance">
                                                        <div class="wrap">
                                                        <img class ="over_lapimg" src="/assets/somaiya_com/img/arrows-expand.svg" alt=""/>
                                                </div>
                                                    </a>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="item green">
                                                    <a class="example-image-link" href="/assets/somaiya_com/img/sk-tab-home/sk2.png" data-lightbox="example-set" data-title="Or press the right arrow on your keyboard.">
                                                        <img class="example-image" src="/assets/somaiya_com/img/sk-tab-home/sk2.png" alt="Forest with mountains behind">
                                                        <div class="wrap">
                                                        <img class ="over_lapimg" src="/assets/somaiya_com/img/arrows-expand.svg" alt=""/>
                                                </div>
                                                    </a>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="item green">
                                                    <a class="example-image-link" href="/assets/somaiya_com/img/sk-tab-home/sk3.png" data-lightbox="example-set" data-title="The next image in the set is preloaded as you're viewing.">
                                                        <img class="example-image" src="/assets/somaiya_com/img/sk-tab-home/sk3.png" alt="Bicyclist looking out over hill at ocean">
                                                        <div class="wrap">
                                                        <img class ="over_lapimg" src="/assets/somaiya_com/img/arrows-expand.svg" alt=""/>
                                                </div>
                                                    </a>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="item green">
                                                    <a class="example-image-link" href="/assets/somaiya_com/img/sk-tab-home/sk4.png" data-lightbox="example-set" data-title="Click anywhere outside the image or the X to the right to close.">
                                                        <img class="example-image" src="/assets/somaiya_com/img/sk-tab-home/sk4.png" alt="Small lighthouse at bottom with ocean behind">
                                                        <div class="wrap">
                                                        <img class ="over_lapimg" src="/assets/somaiya_com/img/arrows-expand.svg" alt=""/>
                                                </div>
                                                    </a>

                                                </div>
                                            </li>
                                            <li>
                                                <div class="item green">
                                                    <a class="example-image-link" href="/assets/somaiya_com/img/sk-tab-home/sk5.png" data-lightbox="example-set" data-title="Click anywhere outside the image or the X to the right to close.">
                                                        <img class="example-image" src="/assets/somaiya_com/img/sk-tab-home/sk5.png" alt="Small lighthouse at bottom with ocean behind">
                                                        <div class="wrap">
                                                        <img class ="over_lapimg" src="/assets/somaiya_com/img/arrows-expand.svg" alt=""/>
                                                </div>
                                                    </a>
                                                </div>
                                            </li>
                                            <!-- <li>
                                        <div class="item green">
                                        <a class="example-image-link" href="assets/img/light6.jpg" data-lightbox="example-set" data-title="Click anywhere outside the image or the X to the right to close.">
                                            <img class="example-image" src="assets/somaiya_com/img/light6.jpg" alt="Small lighthouse at bottom with ocean behind">
                                           <i class="fa fa-expand" aria-hidden="true"></i>
                                        </a>
                                    </div>
                                </li> -->
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- end our founder-->
    </main>