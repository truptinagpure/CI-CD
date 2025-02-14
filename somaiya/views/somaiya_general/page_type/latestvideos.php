<section class="BannerSections position-relative">
	<img alt="Banner Section" class="w-100" src="/assets/somaiya_com/img/banners/news.png" />
	<div class="bannerText container">
		<h1>Latest Video</h1>
		<ul class="siteBreadCrum">
			<li><a href="https://somaiya.com/">Home</a></li>
			<li class="divider"><img alt="BreadCrumb Arrow" src="/assets/somaiya_com/img/breadcrumArrow.svg" /></li>
			<li>Latest Video</li>
		</ul>
	</div>
</section>

<section class="aboutpanel naresh_announcement_list newssearch mar-top-0">
	<div role="main">
		<div class="container">
			<div class="row detailbs4row">
				<div class="col-lg-3 col-sm-12 col-md-12 mb-4 refineserach sidefilter">
					<div>
						<h3 class="refhead refheadbs4 d-sm-block">Filter by</h3>
						<form action="" class="newsearchform searchbars4 showbs4" role="form">
							<div class="form-group has-search" role="search">
								 <span class="fa fa-search form-control-feedback"></span>
								<input class="form-control" id="searchkeyword" name="keyword_ann" onkeyup="searchFilter()" placeholder="Search Keywords" type="text" value="" /></div>
						</form>
						<form action="" id="resfilter" method="get" role="form">
							<div class="relabel">Business Divisions</div>
							<div class="repaddleft">
								<select placeholder="Select a business division" class="js-category-multiple" id="category_check" name="category_check[]" onchange="searchFilter()" multiple="multiple" tabindex="-1" place>
									<!-- <option value="">Filter by Entity</option> -->
									<option value="1">Godavari Biorefineries Limited</option>
									<option value="2">KitabKhana</option> 
									<option value="3">Madhuban Resort</option>
									<option value="4">Sathgen Biotech</option>
									<option value="5">Solar Magic Private Limited</option>
									<option value="6">KisanKhazana</option>
									<option value="7">riidl</option>
								</select>
							</div>
							<div class="repaddleft fullwidth">
	                    		<div class="row">
	                      			<div class="col-lg-12 col-sm-12 col-md-12  paddleft">
	                        			<div class="relabel relabelbs4">From Date</div>
	                        			<input type="date" name="fromdate" id="fromdate" class="form-control dateclass placeholderclass" onClick="$(this).removeClass('placeholderclass')" onchange="searchFilter()">
	                        		</div>
	                  				<div class="col-lg-12 col-sm-12 col-md-12  paddleft paddright">
	                    				<div class="relabel relabelbs4">To Date</div>
	                    				<input type="date" name="todate" id="todate" class="form-control dateclass placeholderclass" onClick="$(this).removeClass('placeholderclass')" onchange="searchFilter()">
	                    			</div>
	                    		</div>
	                    		<div class="clear"></div>
                			</div>
						</form>
					</div>
				</div>
				<div class="col-lg-9 col-sm-9 col-md-9 video-wrap" id="refined">
					<!-- Ajax code goes here -->
				</div>
			</div>
		</div>
	</div>
</section>

<script type="text/javascript">
$(document).ready(function() {
    $('.js-category-multiple').select2();
    $("#resfilter select").removeAttr("aria-hidden");
    $(".js-category-multiple").select2({
    	placeholder: "Select a business division"
	});
});

 function searchFilter(page_num) 
 {
    page_num = page_num?page_num:0;
    var keywords = $('#searchkeyword').val();
    keywords = keywords.replace(/[^a-zA-Z ]/g, ""); // remove special character from string for sequrity isssue.

    var myvalinst=[];
    $. each($('select#category_check option:selected'), function(){          
      myvalinst. push($(this).val());       
    });
    myvalinst=myvalinst.toString();

    var fromDate=$('#fromdate').val();
    var toDate=$('#todate').val();


    $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>somaiya_general/video_ajax_new/'+page_num,
        data:'page_no='+page_num+'&keywords='+keywords+'&category_check='+myvalinst+'&from_date='+fromDate+'&to_date='+toDate+'&lang=<?php echo $lang; ?>',
        beforeSend: function () {
            $('.loading').show();
        },
        success: function (html) {
            $('#refined').html(html);
            $('.loading').fadeOut("slow");
        }
    });
  }
  searchFilter();
</script>