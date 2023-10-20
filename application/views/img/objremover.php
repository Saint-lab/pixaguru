 
 <div class="pg-header-row" style="width: 1000px !important;">
  <div class="card col-md-4 p-3" style="margin-left: -30px!important;width: 300px !important;">
   <div class="containerdd mt-5">
    <form action="<?php echo base_url(); ?>images/bkRemovePost" method="post"  enctype="multipart/form-data" class="mb-3">
      <h6 class="text-center mb-5">Object Remover</h6>

      <div class="user-image mb-3 text-center">
        <div class="imgGallery"> 
          <!-- Image preview -->
        </div>
      </div>

      <div class="user-image mb-3 text-center">
        <div class="imgGallery2"> 
          <!-- Image preview -->
        </div>
      </div>

      <div class="custom-file mb-4">
        <input type="file" name="fileUpload1" class="custom-file-input" id="chooseFile" style="display: none" id="fipt" required="">
        <label class="custom-file-label ml-4 ddd" for="chooseFile">Click to select a file for Upload</label>
      </div>
      <div class="custom-file">
        <input type="file" name="fileUpload2" class="custom-file-input" id="chooseFile2" style="display: none" id="fipt2" required="">
        <label class="custom-file-label ml-4 ddd2" for="chooseFile2">Click to upload Mask photo </label>
      </div>

      <button type="submit" name="submit" class="btn btn-primary btn-block mt-4" style="display: none;margin-left: 30px !important;" id="sbtn">
       Generate
      </button>
    </form>
   </div>
 </div>
 <div class="col-md-8" style="width: 400px !important;">
   <?php //var_dump($images); die();   ?>
   <table class="dataTable pg-table">
          <thead>
            <tr>
              
              <th> <?php echo 'Generated Image'; ?></th>
             
              <th> <?php echo 'Actions'; ?></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($images as $key => $image) { ?>
              <tr>
                <td><img src="<?= base_url($image['image_url']);?>" alt="Generated Image" style="width:100px;height: 80px;"></td>
                              <td>
                  <a href="<?= base_url('download/image/'.$image['id'].'/objectRemover'); ?>" class="btn btn-primary p-2">Download</a>
                  <a href="<?= base_url('delete/image/'.$image['id'].'/objectRemover'); ?>" class="btn btn-danger p-2">Delete</a>
                </td>
              </tr>
              
          <?php  }   ?>
          </tbody>
        </table>
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