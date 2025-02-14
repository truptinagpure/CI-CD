    <footer>
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 footLeft ">
                    <div class="row">
                        <div class="trustLOgo col-12 col-sm-12 col-md-4 col-lg-4">
                            <a href="/en"><img src="/assets/somaiya_com/img/logo.png" alt="SOmaiya Trust Logo" /></a>
                            <div class="address">
                                <h4><span>Address</span></h4>
                                <div class="markerWrap"><img src="/assets/somaiya_com/img/navigations.svg" alt="marker" /></div>
                                <p class="pl-sm-3">Somaiya Bhavan, <br/> 45-47, Mahatma Gandhi Road, <br/> Post Box No. 384, Fort, <br/> Mumbai 400 001. India. </p>
                            </div>
                        </div>
                        <div class="footMenu col-12 col-sm-12 col-md-4 col-lg-4">
                            <div class="mainMenu">
                                <h4><span>About Us</span></h4>
                                <ul class="p-0 footeritems">
                                    <li>
                                        <a class="footer-item" href="/en/about-us">About the Group</a>
                                    </li>
                                    <!-- <li>
                                        <a class="footer-item" href="/en/philanthropy">Philanthropy</a>
                                    </li> -->
                                    <li>
                                        <a class="footer-item" href="/en/timeline">Timeline</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="mainMenu">
                                <h4><span><a href="<?=base_url().$lang?>/latest-news">News</a></span></h4>
                            </div>
                        </div>
                        <div class="socialMeida  col-12 col-sm-12 col-md-4 col-lg-4">
                            <div class="mainMenu">
                                <h4><span>Follow US</span></h4>
                            </div>
                            <ul class="m-0 p-0">
                                <li class="d-inline-block">
                                    <a href="https://www.facebook.com/Godavari-Biorefineries-125101814190423/" target="_blank">
                                        <i class="fa fa-facebook"></i>
                                    </a>
                                </li>
                                <li class="d-inline-block">
                                    <a href="https://twitter.com/GodavariBio" target="_blank">
                                        <i class="fa fa-twitter"></i>
                                    </a>
                                </li>
                                <li class="d-inline-block">
                                    <a href="https://www.instagram.com/godavaribiorefineriesltd/?igshid=1nw9jd52wosyhn" target="_blank">
                                        <i class="fa fa-instagram"></i>
                                    </a>
                                </li>
                                <li class="d-inline-block">
                                    <a href="https://www.youtube.com/channel/UCbP-aY2vSm-XkukfeTIqZ7Q" target="_blank">
                                        <i class="fa fa-youtube-play"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 creditpatch text-center">
            <div class="container">
                <span class="credits d-block">&copy;2021 Somaiya Group</span>
            </div>
        </div>
    </footer>
    <div class="toparrow">
        <a href="javascript:void(0)">
            <img src="/assets/somaiya_com/img/toparrow.svg" alt="Top Arrow" />
        </a>
    </div>
    <script type="text/javascript" src="/assets/somaiya_com/js/custom.min.js"></script>
    <link href="<?=base_url()?>assets/somaiya_com/css/select2.min.css" rel="stylesheet" />
    <script src="<?=base_url()?>assets/somaiya_com/js/select2.min.js"></script>
    <script type="text/javascript">
        $('.footeritems .footer-item').on('click', function (e) {  
            //alert('clicked');
            //debugger;
            var href = $(this).prop('href');
            var hash1 = href.split('#')[1];
            $('.nav-tabs a[href="#' + hash1 + '"]').tab('show');
        });

         //active for menu
         $(function()
         {
           $('ul.brandmenu li a').filter(function(){return this.href==location.href}).parent().addClass('highlight').siblings().removeClass('highlight')
           $('ul.brandmenu li a').click(function(){
             $(this).parent().addClass('highlight').siblings().removeClass('highlight')  
           })
           $('ul.brandmenu li.menu-leaf ul li.highlight a').parents().each(function(){
             if ($(this).is('li.menu-leaf'))
             {
               $(this).addClass("highlight");
             }                            
           });
         });

    </script>
</body>
</html>