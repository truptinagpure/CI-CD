<?php 
  $CI =& get_instance();
  $CI->load->model('Somaiya_general_model');
  $announcement_category      = $CI->Somaiya_general_model->announcement_category();

  $area_interest_value = '';

  if(isset($_GET['area-interest']) && !empty($_GET['area-interest']) && is_numeric($_GET['area-interest']))
  { 
      $area_interest_value = $_GET['area-interest'];
  } 
?>

<section class="BannerSections position-relative">
  <img alt="Banner Section" class="w-100" src="/assets/somaiya_com/img/banners/news.png">
  <div class="bannerText container">
    <h1>Latest News</h1>
    <ul class="siteBreadCrum">
      <li><a href="<?=base_url()?>">Home</a></li>
      <li class="divider"><img alt="BreadCrumb Arrow" src="/assets/somaiya_com/img/breadcrumArrow.svg"></li>
      <li>Latest news</li>
    </ul>
  </div>
</section>

<section class="aboutpanel naresh_announcement_list newssearch mar-top-0">
  <div role="main">
    <div class="container">
      <div class="row detailbs4row">
        <div class="col-lg-3 col-sm-12 col-md-12 refineserach sidefilter">
          <div class="">
            <h3 class="refhead refheadbs4 d-none d-sm-block">Filter by </h3>
            <form action="" class="newsearchform searchbars4 showbs4"  role="form">
              <div class="form-group has-search" role="search">
                <span class="fa fa-search form-control-feedback"></span>
                <input type="text" name="keyword_ann" class="form-control" value="<?php echo $matchannounce; ?>" placeholder="Search Keywords" id='searchkeyword' onkeyup="searchFilter()">
              </div>
            </form>
            <form action="" method="get" role="form" id="resfilter" class="d-none">
              <div class="relabel">Area of Interest</div>
              <div class="repaddleft">
                <select class="js-category-multiple" name="category_check[]" id="category_check" multiple="multiple" class="form-control" onchange="searchFilter()">
                  <?php if(isset($announcement_category) && count($announcement_category)!=0){ ?>
                  <?php foreach($announcement_category as $cat){ ?>
                    <option value="<?=$cat['category_id']?>" <?php if(isset($area_interest_value) && !empty($area_interest_value) && $area_interest_value == $cat['category_id']){ echo 'selected="selected"'; } ?>><?=$cat['category_name']?></option>
                  <?php } ?>
                  <?php } ?>
                </select> 
              </div>
              <div class="repaddleft">
                <div>
                  <div class="relabel relabelbs4">From Date</div>
                  <input type="date" name="fromdate" id="fromdate" class="form-control dateclass placeholderclass" onClick="$(this).removeClass('placeholderclass')" onchange="searchFilter()">
                </div>
                <div>
                  <div class="relabel relabelbs4">To Date</div>
                  <input type="date" name="todate" id="todate" class="form-control dateclass placeholderclass" onClick="$(this).removeClass('placeholderclass')" onchange="searchFilter()">
                </div>
              </div>
              <div class="repaddleft">
                <i class="fa fa-refresh" aria-hidden="true"></i>
                <input type="reset" name="btn_clear" id="btn_clear" class="clearbtn" value="Clear all filters">
              </div>
            </form>
          </div>
        </div>        
        <div class="col-lg-9 col-sm-12 col-md-12 announcement-result refineresultbs4"  id="refined"></div> 
      </div>
    </div>
  </div>
</section>

<script type="text/javascript">
$(document).ready(function() {
    $('.js-category-multiple').select2();
    $("#resfilter select").removeAttr("aria-hidden");

    $("#myDiv").hide();
    $("#showHideClick").click(function(){
        $("#myDiv").slideToggle("slow");
        $(this).text( $(this).text() == 'More Filters +' ? "Less Filters -" : "More Filters +");
    });

    $('#btn_clear').click(function(e){ 
      $('#searchkeyword').val('');     
    $("#category_check,#fromdate,#todate").val('').trigger('change');
    });
});

$('#searchkeyword').on('keyup keypress', function(e) 
{
  var keyCode = e.keyCode || e.which;
  if (keyCode === 13) { 
    e.preventDefault();
    return false;
  }
});                              

function searchFilter(page_num) 
{
  page_num = page_num?page_num:0;
  var keywords = $('#searchkeyword').val();
  var myvalcat=[];
  $. each($('select#category_check option:selected'), function(){          
    myvalcat. push($(this).val());       
  });
  myvalcat=myvalcat.toString();
  var fromDate=$('#fromdate').val();
  var toDate=$('#todate').val();
  $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>somaiya_general/announcement_ajax/'+page_num,
        data:'page_no='+page_num+'&keywords='+keywords+'&category_check='+myvalcat+'&from_date='+fromDate+'&to_date='+toDate+'&lang=<?php echo $lang; ?>',
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
