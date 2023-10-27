  <h3 class="text-center mb-4 font">Enhencement</h3>
 <div class="pg-header-row" style="width: 100% !important;">
  <div class="card col-md-4 p-3 imgviews">
   <div class="containerdd mt-5" style="width:100%;">
    <form action="<?php echo base_url(); ?>images/enhencementPost" method="post"  enctype="multipart/form-data" class="mb-3 imgform">
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
                  <a href="<?= base_url('download/image/'.$image['id'].'/enhencement'); ?>" title="Download"  style="color:black;"><i    class="fa fa-download" style="font-size: 35px;"></i></a>
                  <a href="<?= base_url('delete/image/'.$image['id'].'/enhencement'); ?>" title="Delete"  style="color:red;"><i class="fa fa-trash" style="font-size: 35px;margin-left:15px"></i></a>
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
        multiImgPreview(this, 'div.imgGallery');
        document.getElementById("sbtn").style.display = "inline-block";
        $(".ddd").hide();
      });
    });    
  </script>