<h4 class="p-5 mt-3 mb-2">AI Image Libery</h4>
<div class="content mt-3">
			<!-- table start -->
            <div class="content mt-3">
            <div class="animated fadeIn">
                <div class="row">
					<div class="col-lg-12">
                     
                  <div class="row">
          <div class="col-lg-10" style="margin-left: 15px;">
            <input type="text" class="form-control" id="search-image" placeholder="Search Al Image..." name="search-image">  
          </div>
          <div class="col-lg-1">
              <button class="btn btn-primary img-btn" style="margin-left: -15px;">Seach</button>
          </div>
      </div>
       <div class="row img-holder" style="margin-top: 10px;">

     </div> 
     <div class="row nextImg" style="padding:16px 8px;margin-top: 10px;">
       <div class="pixover" id="next1" style="display:inline-block;width:4%;padding:10px;border:solid 1px #34e36e;color:#515452;border-radius:5px;cursor:pointer;text-align:center;margin-left:25px;" onclick="pixNext('1');">
           <b>1</b>
        </div>
       </div>  
                   
                </div> 
          


            </div>
         
        </div>
			<!-- table end -->

            </div> 
            
            <!--  Add METHOD MODAL -->
        <div id="addModal" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    
                    <div style="width:100%;">
                   
                     <img src="" id="model_img" style="width:100%; height:auto;padding:8px;">   
                    
                    </div>
                </div>
            </div>
        </div>

<script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

<!-- <script src="{{url('js/jquery-3.2.1.min.js')}}"></script> -->
<script type="text/javascript">
  // Pixabay Image Script
var nextcounter = 1;
var API_KEY = '26242218-b7299cb77fa16ccee2d43f544';
var pixurl = "https://pixabay.com/api/?key="+API_KEY+"&q="+encodeURIComponent('white cat');
$.getJSON(pixurl, function(data){
    let count = 0;
if (parseInt(data.totalHits) > 0){
    $.each(data.hits, function(i, hit){ 
        $(".img-holder").append('<div class="col-3" id="pick'+i+'" style="cursor:pointer;" data-img="'+hit.webformatURL+'"><img src="'+hit.webformatURL+'" alt="'+hit.tags+'" class="pixover" style="padding:10px;width:100%;height:250px;"></div>');
        let btnPress = "#pick"+i;
        
        $(btnPress).on('click', function(){
            var modal = $('#addModal');
           $("#model_img").attr("src", hit.webformatURL);
            modal.modal('show');
        });
      });
}
else{
    $(".img-holder").append('<div class="col-8" style="color:red;font-size:2em"><p>Images not Found</p></div>');
}

if (parseInt(data.totalHits) > 19){
    nextcounter = nextcounter + 1;
  $(".nextImg").append('<div class="pixover" id="next'+nextcounter+'" style="display:inline-block;width:4%;padding:10px;border:solid 1px #34e36e;color:#515452;border-radius:5px;cursor:pointer;text-align:center;margin-left:25px;" onclick="pixNext('+nextcounter+');"><b>'+nextcounter+'</b></div>');  
}
    
});


//search paxibay image function
 $(".img-btn").on('click', function(){
     var nextSearch = 1;
  var searchValue = $("#search-image").val();  
  var API_KEY = '26242218-b7299cb77fa16ccee2d43f544';
var pixurl = "https://pixabay.com/api/?key="+API_KEY+"&q="+encodeURIComponent(searchValue);
$(".img-holder").empty();
$(".nextImg").empty();
$(".nextImg").append('<div class="pixover" id="next'+nextSearch+'" style="display:inline-block;width:4%;padding:10px;border:solid 1px #34e36e;color:#515452;border-radius:5px;cursor:pointer;text-align:center;margin-left:25px;" onclick="pixNext('+nextSearch+');"><b>'+nextSearch+'</b></div>');  
$.getJSON(pixurl, function(data){
    let count = 0;
if (parseInt(data.totalHits) > 0){
    $.each(data.hits, function(i, hit){ 
        $(".img-holder").append('<div class="col-3" id="pick'+i+'" style="cursor:pointer;"><img src="'+hit.webformatURL+'" alt="'+hit.tags+'" class="pixover" style="padding:10px;width:100%;height:250px;"></div>');
        let btnPress = "#pick"+i;
        $(btnPress).on('click', function(){
    var modal = $('#addModal');
           $("#model_img").attr("src", hit.webformatURL);
            modal.modal('show');
        });
      });
}
else{
    $(".img-holder").append('<div class="col-8" style="color:red;font-size:2em"><p>Images not Found</p></div>');
    
}
  if (parseInt(data.totalHits) > 19){
    nextSearch = nextSearch + 1;
  $(".nextImg").append('<div class="pixover" id="next'+nextSearch+'" style="display:inline-block;width:4%;padding:10px;border:solid 1px #34e36e;color:#515452;border-radius:5px;cursor:pointer;text-align:center;margin-left:25px;" onclick="pixNext('+nextSearch+');"><b>'+nextSearch+'</b></div>');  
}
});
});


 function pixNext(page){
    var searchValue = $("#search-image").val();
    if(searchValue == ""){
        searchValue = 'red roses';
    }
 var API_KEY = '26242218-b7299cb77fa16ccee2d43f544';
var pixurl = "https://pixabay.com/api/?key="+API_KEY+"&q="+encodeURIComponent(searchValue)+"&page="+page;
$(".img-holder").empty();
$.getJSON(pixurl, function(data){
    let count = 0;
    $(".pixover").css('border', 'solid 1px #34e36e');
    $(".pixover").css('background-color','');
    $(".pixover").css('color','#515452');
    let next = "#next"+page;
    $(next).css('background-color','#34e36e');
    $(next).css('color','#ffffff');
if (parseInt(data.totalHits) > 0){
    $.each(data.hits, function(i, hit){
        
        $(".img-holder").append('<div class="col-3" id="pick'+i+'" style="cursor:pointer;"><img src="'+hit.webformatURL+'" alt="'+hit.tags+'" class="pixover" style="padding:10px;width:100%;height:250px;"></div>');
        let btnPress = "#pick"+i;
        
        $(btnPress).on('click', function(){
     var modal = $('#addModal');
           $("#model_img").attr("src", hit.webformatURL);
            modal.modal('show');
    });
      });
}
else{
    $(".img-holder").append('<div class="col-8" style="color:red;font-size:2em"><p>No more Image</p></div>');
}
if (parseInt(data.totalHits) > 19){
    nextcounter = nextcounter + 1;
  $(".nextImg").append('<div class="pixover" id="next'+nextcounter+'" style="display:inline-block;width:4%;padding:10px;border:solid 1px #34e36e;color:#515452;border-radius:5px;cursor:pointer;text-align:center;margin-left:25px;" onclick="pixNext('+nextcounter+');"><b>'+nextcounter+'</b></div>');  
}
});

}
</script>