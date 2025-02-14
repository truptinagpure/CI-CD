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

<script type="text/javascript">
    $( document ).ready(function() {
        var hash = document.location.hash;
        if (hash) {
            $('.nav-tabs a[href="'+hash+'"]').tab('show');
        } 

        // Change hash for page-reload
        $('.nav-tabs a').on('shown.bs.tab', function (e) {
            document.location.hash = e.target.hash;
        });
    });
    
    $( document ).ready(function() {
        var hash        = document.location.hash;
        var scrollto    = '';
        if (hash) {
            var tab     = '';
            if(hash == '#Business' || hash == '#Biorefineries' || hash == '#Jivana' || hash == '#Paavan' || hash == '#Kitab' || hash == '#Philanthropy')
            {
                tab     = 'Business';
            }
            else if(hash == '#Education1')
            {
                tab     = 'Education1';
            }
            else if(hash == '#Healthcare')
            {
                tab     = 'Healthcare';
            }
            else if(hash == '#Rural')
            {
                tab     = 'Rural';
            }
            else if(hash == '#Agricultural')
            {
                tab     = 'Agricultural';
            }
            else if(hash == '#Philanthropy')
            {
                tab     = 'Philanthropy';
            }
            

            if(tab != '')
            {
                $('.nav-tabs a[href="#'+tab+'"]').tab('show');
            }

            if(hash == '#Jivana')
            {
                scrollto = 'Jivana';
            }
            else if(hash == '#Biorefineries')
            {
                scrollto = 'Biorefineries';
            }
            else if(hash == '#Philanthropy')
            {
                scrollto = 'Philanthropy';
            }
            else if(hash == '#Paavan')
            {
                scrollto = 'Paavan';
            }
            else if(hash == '#Kitab')
            {
                scrollto = 'Kitab';
            }
        } 

        // Change hash for page-reload
        $('.nav-tabs a').on('shown.bs.tab', function (e) {
            if(scrollto != '')
            {
                $('html,body').animate({
                    scrollTop: $("#"+scrollto).offset().top
                }, 'slow');
            }
            // window.location.hash = e.target.hash;
        });
    });

    $('.singleColumn .dropdown-item').on('click', function (e) {  
        // debugger;
        var href = $(this).prop('href');
        var hash1 = href.split('#')[1];
        $('.nav-tabs a[href="#' + hash1 + '"]').tab('show');
    });
</script>