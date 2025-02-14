<html lang="en">
<head>
  <meta charset="UTF-8">
  <title> </title>
  <style type="text/css">
  a:hover{text-decoration:none!important;}
  .a-link:hover{
    text-decoration:none!important;
  }
</style>
</head>
<body>
  <table style="max-width: 600px;border: 1px solid #b7b7b7;width: 100%;font-family:sans-serif;margin:0 auto;border-bottom:1px solid #ccc;margin-bottom: -10px;" cellpadding=" 0" cellspacing="0">
    <tbody>
      <tr style="width: 93.5%;float: left;padding: 20px 20px;">
        <td style="width: 49%;float: left;text-align: left;position: relative; top: 2px;">
          <img src="https://svv-public-data.s3.ap-south-1.amazonaws.com/emailer-images/university-logo.png" style="width: 75%;position: relative; top:0;" alt=""/>
        </td>
        <td style="width: 49%;float: right;text-align: right;">
         <img src="https://svv-public-data.s3.ap-south-1.amazonaws.com/emailer-images/somaiya_logo.jpg" style="width:30%;right:20px;position: relative;">
       </td>
     </tr>
     <tr style="width: 100%;float: left;border: none;display: block;border-spacing: 0;height: 197px!important; max-height: 196px!important;">
      <td style="width: 100%;float: left;">
        <a href="#" style="cursor:default;">
          <img src="https://svv-public-data.s3.ap-south-1.amazonaws.com/emailer-images/management-banner.png"  >
        </a>
      </td>
    </tr>
    <tr style="width: 100%;float: left;">
      <td style="width: 100%;float: left;">
        <table style="display: block;float:left;font-family:sans-serif;border-right: 130px solid #b7202e;">
          <tbody style="display: block;float:left;padding-right:23px;">
            <tr style="width:97%;float:left;padding: 20px 10px 20px 20px;line-height: 21px;">
              <td style="width: 100%;float: left;">
                <?php echo $email_body; ?>
              </td>
            </tr>

          </tbody>
        </table>
      </td>
    </tr>
  </tbody>
</table>
</body>
</html>

