 
 <div class="pg-header-row" style="width: 1000px !important;">
  <div class="card col-md-4 p-3" style="margin-left: -30px!important;width: 300px !important;">
   <div class="containerdd mt-2">
    <form action="<?php echo base_url(); ?>admin/uploadmediaPost" method="post"  enctype="multipart/form-data" class="mb-3">
      <h6 class="text-center mb-5">Media Files</h6>

      
       <div class="form-group mb-2">
        <label for="name">Template Name</label>
        <input type="text" name="name" class="form-control">
       </div>
       <div class="form-group mb-4">
         <label for="type">Type</label>
         <select name="type" class="form-control" required="">
          <option value="0" readonly>choose Media Type</option>
           <option value="mockup">Mockup Studio</option>
           <option value="boxshort">BoxShort Studio</option>
           <option value="bundle">Bundle Studio</option>
           <option value="logo">Logo Studio</option>
         </select>
       </div>
      <div class="custom-file form-group">
        <input type="file" name="fileUpload" class="custom-file-input" id="chooseFile" style="display: none" id="fipt" required="">
        <label class="form-control custom-file-label ml-4 ddd" for="chooseFile">Click to select a file for Upload</label>
      </div>

      <div class="user-image mb-3 text-center">
        <div class="imgGallery"> 
          <!-- Image preview -->
        </div>
      </div>

      <button type="submit" name="submit" class="btn btn-primary btn-block mt-4 form-control" style="display: none;" id="sbtn">
       Submit
      </button>
    </form>
   </div>
 </div>
 <div class="col-md-8" style="width: 500px !important;">
   <?php //var_dump($images); die();   ?>
   <table class="dataTable pg-table">
          <thead style="width: 100%;">
            <tr>
              
              <th> <?php echo 'Images'; ?></th>
             <th> <?php echo 'Type'; ?></th>
              <th> <?php echo 'Actions'; ?></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($images as $key => $image) { ?>
              <tr>
                <td><img src="<?= base_url($image['thumb']);?>" alt="Generated Image" style="width:100px;height: 80px;"></td>
                              <td>
                  <td><?= $image['type'] ?></td>
                  <td>              
                  <a href="<?= base_url('admin/deleteMedia/'.$image['template_id']); ?>" class="btn btn-danger p-2">Delete</a>
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
        document.getElementById("sbtn").style.display = "inline-block";
        $(".ddd").hide();
      });
    });    
  </script>