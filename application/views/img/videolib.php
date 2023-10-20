<h4 class="p-5 mt-3 mb-2">AI Video Libery</h4>

			<!-- table start -->
            <div class="content mt-3">
            <div class="animated fadeIn">
                <div class="row">
					<div class="col-lg-12">
                     
                  <div class="row">
          <div class="col-lg-10" style="margin-left: 15px;">
            <input type="text" class="form-control" id="search-vid" placeholder="Search Al Video..." name="search-image-v">  
          </div>
          <div class="col-lg-1">
              <button class="btn btn-primary vid-btn" style="margin-left: -15px;">Seach</button>
          </div>
      </div>
       <div class="row vid-holder" style="margin-top:20px;">
        
 </div> 
     <div class="ar-row nextVid" style="padding:16px 8px;">
       <div class="pixover" id="nextv1" style="display:inline-block;width:4%;padding:10px;border:solid 1px #34e36e;color:#515452;border-radius:5px;cursor:pointer;text-align:center;margin-left:25px;" onclick="nextVideo('1');">
           <b>1</b>
        </div>
        
      </div>  
                   
                </div> 
          


            </div>
         
        </div>
			<!-- table end -->

            </div>
          

<script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
<script type="text/javascript">
 // Paxibay Video Script
var API_KEY = '26242218-b7299cb77fa16ccee2d43f544';
var pixlink = "https://pixabay.com/api/videos/?key="+API_KEY+"&q="+encodeURIComponent('animal');
var vidcounter = 1;
$.getJSON(pixlink, function(data){
    let count = 0;
if (parseInt(data.totalHits) > 0){
    $.each(data.hits, function(i, hit){ 
       
        $(".vid-holder").append('<div class="col-3" style=""><iframe src="'+hit.videos.small.url+'" style="height:200px;width:98%;border:0px;padding:4px 2px;" loading="eager"></iframe></div>');
        
      });
}
else{
    $(".vid-holder").append('<div class="col-8" style="color:red;font-size:2em"><p>Video not Found</p></div>');
}
if (parseInt(data.totalHits) > 19){
    vidcounter = vidcounter + 1;
  $(".nextVid").append('<div class="pixover" id="nextv'+vidcounter+'" style="display:inline-block;width:4%;padding:10px;border:solid 1px #34e36e;color:#515452;border-radius:5px;cursor:pointer;text-align:center;margin-left:25px;" onclick="nextVideo('+vidcounter+');"><b>'+vidcounter+'</b></div>');  
}

});

//search paxibay video function
 $(".vid-btn").on('click', function(){
  var searchValue = $("#search-vid").val();  
  var API_KEY = '26242218-b7299cb77fa16ccee2d43f544';
var pixlink = "https://pixabay.com/api/videos/?key="+API_KEY+"&q="+encodeURIComponent(searchValue);
seacrhVidNext = 1;
$(".vid-holder").empty();
$(".nextVid").empty();
$(".nextVid").append('<div class="pixover" id="next'+seacrhVidNext+'" style="display:inline-block;width:4%;padding:10px;border:solid 1px #34e36e;color:#515452;border-radius:5px;cursor:pointer;text-align:center;margin-left:25px;" onclick="pixNext('+seacrhVidNext+');"><b>'+seacrhVidNext+'</b></div>');  
$.getJSON(pixlink, function(data){
    let count = 0;
if (parseInt(data.totalHits) > 0)
    $.each(data.hits, function(i, hit){ 
        $(".vid-holder").append('<div class="col-3" style=""><iframe src="'+hit.videos.small.url+'" style="height:200px;width:98%;border:0px;padding:4px 2px;" loading="eager"></iframe></div>');
      });
else
    $(".vid-holder").append('<div class="ar-col-8" style="color:red;font-size:2em"><p>Video not Found</p></div>');
    
if (parseInt(data.totalHits) > 19){
    seacrhVidNext = seacrhVidNext + 1;
  $(".nextVid").append('<div class="pixover" id="nextv'+seacrhVidNext+'" style="display:inline-block;width:4%;padding:10px;border:solid 1px #34e36e;color:#515452;border-radius:5px;cursor:pointer;text-align:center;margin-left:25px;" onclick="nextVideo('+seacrhVidNext+');"><b>'+seacrhVidNext+'</b></div>');  
}    
});



});

function nextVideo(page){
 var searchValue = $("#search-vid").val();
     if(searchValue == ""){
        searchValue = 'animal';
    }
  var API_KEY = '26242218-b7299cb77fa16ccee2d43f544';
var pixlink = "https://pixabay.com/api/videos/?key="+API_KEY+"&q="+encodeURIComponent(searchValue)+"&page="+page;
$(".vid-holder").empty();
 $(".pixover").css('border', 'solid 1px #34e36e');
    $(".pixover").css('background-color','');
    $(".pixover").css('color','#515452');
    let next = "#nextv"+page;
    $(next).css('background-color','#34e36e');
    $(next).css('color','#ffffff');
$.getJSON(pixlink, function(data){
    let count = 0;
    
   
if (parseInt(data.totalHits) > 0)
    $.each(data.hits, function(i, hit){ 
        
      $(".vid-holder").append('<div class="col-3" style=""><iframe src="'+hit.videos.small.url+'" style="height:200px;width:98%;border:0px;padding:4px 2px;" loading="eager"></iframe></div>');
      });
else
    $(".vid-holder").append('<div class="col-8" style="color:red;font-size:2em"><p>No Video not Found</p></div>');
    
if (parseInt(data.totalHits) > 19){
    vidcounter = vidcounter + 1;
  $(".nextVid").append('<div class="pixover" id="nextv'+vidcounter+'" style="display:inline-block;width:4%;padding:10px;border:solid 1px #34e36e;color:#515452;border-radius:5px;cursor:pointer;text-align:center;margin-left:25px;" onclick="nextVideo('+vidcounter+');"><b>'+vidcounter+'</b></div>');  
}    
});
    
}
</script>
