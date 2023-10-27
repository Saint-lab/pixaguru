<h3 class="text-center mb-4 font">Colorization</h3>

<div class="pg-header-row" style="width: 100% !important;">
  <div class="card col-md-4 p-3 imgviews" >
   <div class="containerdd mt-5" style="max-width:100%;">
    <form action="<?php echo base_url(); ?>images/colorizationPost" method="post"  enctype="multipart/form-data" class="mb-3 imgform">
      <div class="user-image mb-3 text-center imgpreview">
        <div class="imgGallery"> 
          <!-- Image preview -->
        </div>
        <div style="text-align:center">
          <button type="submit" name="submit" class="btn btn-primary btn-block mt-4 imgbtn" id="sbtn">Generate</button>
        </div>
      </div>

      <div class="custom-file">
        <input type="file" name="fileUpload" class="custom-file-input" id="chooseFile" style="display: none" id="fipt">
        <label class="custom-file-label ml-4 ddd" for="chooseFile">
          <img src="<?php echo base_url(); ?>assets/images/bkremover/upload-image.png" class="image"></img><br>
          Click to select a file for Upload
        </label>
      </div>

    </form>
   </div>
 </div>
 <div class="col-lg-8 col-md-12 col-sm-12" style="width: 500px !important;">
      <div class="card" style="border-top: solid 4px #4b8ed1;border-right: 0;border-bottom: 0;border-left: 0">
        <div class="card-body">
          <div class="d-flex">
            <div class="w-100">
              <h3 class="card-title fs-16 mt-3 mb-4"><i class="fa-solid fa-image-landscape mr-4 text-success"></i>Generated Images</h3>             
            </div>  
                  
          </div>
          <!-- SET DATATABLE -->
          <table id='resultsTable' class='table' width='100%'>
            <thead>
              <tr>
                <th width="15%">Image</th> 
                <th width="5%" style="vertical-align:middle;text-align:center;">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($images as $key => $image) { ?>
              <tr>
                <td><img src="<?= base_url($image['image_url']);?>" alt="Generated Image" style="width:100px;height: 80px;cursor: pointer;" class="viewBtn" data-img="<?= base_url($image['image_url']);?>" data-original="<?php echo base_url().$image['original']; ?>"></td>
                <td style="vertical-align:middle;text-align:center;">
                  <a href="<?= base_url('download/image/'.$image['id'].'/colorization'); ?>" title="Download"  style="color:black;"><i    class="fa fa-download" style="font-size: 35px;"></i></a>
                  <a href="<?= base_url('delete/image/'.$image['id'].'/colorization'); ?>" title="Delete"  style="color:red;"><i class="fa fa-trash" style="font-size: 35px;margin-left:15px"></i></a>
                </td>
              </tr>
              
          <?php  }   ?>
            </tbody>
        </table> <!-- END SET DATATABLE --> 
        </div>
      </div>
    </div>
  </div>
  <div id="updateBtn" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Generated Image</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div style="width:100%;position:relative;">
                   
                   <img src="" id="model_img" style="width:100%; height:489.34px;-webkit-user-drag: none;">
                   <div style="position:absolute;left:0;top:0;width:50%;height:100%;z-index:5;max-width:498px;transition: all 0.5s linear;min-width:0" class="containerd">
                      <div style="position:absolute;left:0;top:0;width:100%;height:100%;overflow:hidden;z-index:2;transition: all 0.5s linear;max-width:498px;min-width:5px;transition-delay:0s;border-right:3px solid white" class="wrapper">
                          
                          <div style="width:498px;height: 489.34px;"><img src="" id="original-img" alt="Generated Image" style="width:498px;height: 489.34px;-webkit-user-drag: none;">
                          </div>
                      </div>
                      <img src="https://cfcdn.apowersoft.info/astro/picwish/_astro/diff-indicator-circle.6e223cd4.svg" alt="" style="position:absolute;right:-20px;top:50%;-webkit-user-drag: none;z-index:4;min-width:46px;min-height:46px;cursor:pointer;" class="preview" title="drag">
                    </div>
                  </div> 
                  
                  </div>
              </div>
          </div>
      </div>

<script>
let startX;
let startY;

function onDrag(e) {
  let diffX = e.clientX - startX;
  let style = getComputedStyle(container);
  let wstyle = getComputedStyle(wrapper);
  let wwidth = parseInt(wstyle.width);
  let width = parseInt(style.width);
  container.style.width = width + diffX + 'px';
  wrapper.style.width = wwidth + diffX + 'px';
  
}
let container = document.querySelector('.containerd');
let preview = document.querySelector('.preview');
let wrapper = document.querySelector('.wrapper');
let underlay = document.getElementById('model_img');
preview.addEventListener('mousedown', function(e) {
  startX = e.clientX;
  startY = e.clientY;
  container.addEventListener('mousemove', onDrag);
  preview.addEventListener('mousemove', onDrag);
  wrapper.addEventListener('mousemove', onDrag);
  underlay.addEventListener('mousemove', onDrag);
});
preview.addEventListener('mouseup', function(e) {
  preview.removeEventListener('mousemove', onDrag);
  wrapper.removeEventListener('mousemove', onDrag);
  underlay.removeEventListener('mousemove', onDrag);
  container.removeEventListener('mousemove', onDrag);
});
</script>
<script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>

<script type="text/javascript">
  $('.viewBtn').on('click', function () {
            console.log('yes');
            var modal = $('#updateBtn');
           var lmg = $(this).data('img');
           var original = $(this).data('original');
           $("#original-img").attr("src", original);

            $("#model_img").attr("src", lmg);
           modal.modal('show');
        });
</script>
  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

  <script>
    $(function() {
    
    var multiImgPreview = function(input, imgPreviewPlaceholder) {

        if (input.files) {
            var filesAmount = input.files.length;

             for (i = 0; i < filesAmount; i++) {
                var reader = new FileReader();

                reader.onload = function(event) {
                    $($.parseHTML('<img>')).attr('src', event.target.result).appendTo(imgPreviewPlaceholder);
                }

                reader.readAsDataURL(input.files[i]);
            }
        }

    };

      $('#chooseFile').on('change', function() {
        multiImgPreview(this, 'div.imgGallery');
        document.getElementById("sbtn").style.display = "inline-block";
        $(".ddd").hide();
      });
    });
  </script>