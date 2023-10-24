<h3 class="text-center mb-4 font">Object Remover</h3>
 
 <div class="pg-header-row" style="width: 100% !important;">
  <div class="card col-md-4 objrmviews" >
   <div class="containerdd" style="max-width:100%;height:100%;">
    <form action="<?php echo base_url(); ?>images/objectRemoverPost" method="post"  enctype="multipart/form-data" class="mb-3 imgform">

      <div class="custom-file firstimg">
        <div class="user-image mb-3 text-center">
          <div class="imgGallery1" style="width:100%;">
            <!-- Image preview -->
          </div>
        </div>
        <input type="file" name="fileUpload1" class="custom-file-input" id="chooseFile" style="display: none" id="fipt" required="">
        <label class="custom-file-label ml-4 ddd" for="chooseFile">
          <img src="<?php echo base_url(); ?>assets/images/bkRemover/upload-image.png" class="image"></img><br>
          Click to select a file for Upload</label>
      </div>
      <div class="custom-file firstimg" style="border-top: 3px dashed rgba(0,0,0,.125);padding-top: 15px">
        <div class="user-image text-center">
          <div class="imgGallery2" style="width:100%"> 
            <!-- Image preview -->
          </div>
        </div>
        <input type="file" name="fileUpload2" class="custom-file-input" id="chooseFile2" style="display: none" id="fipt2" required="">
        <label class="custom-file-label ml-4 ddd2" for="chooseFile2">
          <img src="<?php echo base_url(); ?>assets/images/bkRemover/upload-image.png" class="image"></img><br>  
          Click to upload Mask photo </label>
      </div>

      <div style="text-align:center">
        <button type="submit" name="submit" class="btn btn-primary btn-block mt-2 imgbtn" id="sbtn" style="margin-bottom: 10px !important;">Generate</button>
      </div>
    </form>
   </div>
 </div>
 <div class="col-lg-8 col-md-12 col-sm-12" style="width: 500px !important;">
      <div class="card" style="border-top: solid 3px #4b8ed1;border-right: 0;border-bottom: 0;border-left: 0">
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
                <td><img src="<?= base_url($image['image_url']);?>" alt="Generated Image" style="width:100px;height: 80px;cursor: pointer;" class="viewBtn" data-img="<?= base_url($image['image_url']);?>"></td>
                <td style="vertical-align:middle;text-align:center;">
                  <a href="<?= base_url('download/image/'.$image['id'].'/objectRemover'); ?>" title="Download"  style="color:black;"><i    class="fa fa-download" style="font-size: 35px;"></i></a>
                  <a href="<?= base_url('delete/image/'.$image['id'].'/objectRemover'); ?>" title="Delete"  style="color:red;"><i class="fa fa-trash" style="font-size: 35px;margin-left:15px"></i></a>
                </td>
              </tr>
              
          <?php  }   ?>
            </tbody>
        </table> <!-- END SET DATATABLE --> 
        </div>
      </div>
    </div>
</div>
  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

  <script>
    $(function() {
    // Multiple images preview with JavaScript
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
        multiImgPreview(this, 'div.imgGallery1');
        //document.getElementById("sbtn").style.display = "inline-block";
        $(".ddd").hide();
      });

      $('#chooseFile2').on('change', function() {
        multiImgPreview(this, 'div.imgGallery2');
        document.getElementById("sbtn").style.display = "inline-block";
        $(".ddd2").hide();
      });


    });    
  </script>