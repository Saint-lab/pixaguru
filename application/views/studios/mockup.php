<?php 
    $data = json_decode($template[0]['template_data']) ;
    $styles = $data -> styles ?? "" ;
?>

<div class="page-content">

    <div class="editor" id="editor">

        <div class="preview" id="preview">

            <img class="mockup-img" height="auto" src=<?php echo base_url().$template[0]['thumb']; ?> />
            <!-- <img style="<?=$styles; ?>" class="img-file"  id="img-file">  -->

            <img class="img-file"  id="img-file"> 


        </div>

        <div> 

            <input accept="image/*"  hidden type="file" id="mockup-upload"/>
            
            <!--our custom file upload button-->
            <label  class="btn btn-primary" for="mockup-upload">Upload</label>

            <button class="btn btn-success" >Create from scratch </button>

        </div>

    </div>


</div>





<script src="https://cdn.jsdelivr.net/npm/html-to-image@1.11.11/dist/html-to-image.min.js"></script>

<script src="<?php echo base_url(); ?>assets/js/studio.js"></script> 
