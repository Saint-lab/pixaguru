<div class="pg-screen-container" style="display: inline-flex;flex-wrap: wrap;    flex-direction: row;    align-content: space-around;    justify-content: space-between;">
    <div class="pg-modal-btn-wrap">
        <a href="javascript:;" class="pg-btn pg-btn-lg" id="ChangeURL" val="1">import 1 </a> 
    </div>
    <div class="pg-modal-btn-wrap">
        <a href="javascript:;" class="pg-btn pg-btn-lg" id="ChangeURL" val="2">import 2 </a> 
    </div>
    <div class="pg-modal-btn-wrap">
        <a href="javascript:;" class="pg-btn pg-btn-lg" id="ChangeURL" val="3">import 3 </a> 
    </div>
    <div class="pg-modal-btn-wrap">
        <a href="javascript:;" class="pg-btn pg-btn-lg" id="ChangeURL" val="4">import 4 </a> 
    </div>
    <div class="pg-modal-btn-wrap">
        <a href="javascript:;" class="pg-btn pg-btn-lg" id="ChangeURL" val="5">import 5 </a> 
    </div>
    <div class="pg-modal-btn-wrap">
        <a href="javascript:;" class="pg-btn pg-btn-lg" id="ChangeURL" val="6">import 6 </a> 
    </div>


<!DOCTYPE html>  
<html>  
 <head>  
  <title>How to Import SQL File in Mysql Database using PHP</title>  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  
 </head>  
 <body>  
  <br /><br />  
  <div class="container" style="width:700px;">  
   <h3 align="center">How to Import SQL File in Mysql Database using PHP</h3>  
   <br />
   <div><?php echo $message; ?></div>
   <form method="post" class="form" enctype="multipart/form-data">
    <p><label>Select Sql File</label>
    <input type="file" name="database" value="" /></p>
    <br />
    <input type="button" name="import" class="btn btn-info" id="ChangeURL" value="Import" />
   </form>
  </div>  
 </body>  
</html>