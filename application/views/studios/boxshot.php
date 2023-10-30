<?php 
    $data = json_decode($template[0]['template_data']);
    $styles = $data -> styles ?? "" ;
?>

<div class="page-content">


    <div class="editor">

        <img style="<?=$styles; ?>" class="img-file-1" id="img-file-1"> 

        <img style="<?=$styles; ?>" class="img-file-2" id="img-file-2">

        <img style="<?=$styles; ?>" class="img-file-3" id="img-file-3">

        <img class="mockup-img" height="auto" src=<?php echo base_url().$template[0]['thumb']; ?> />


        <div> 

            <input accept="image/*"  hidden type="file" id="box-upload-1"/>
            
            <!--our custom file upload button-->
            <label  class="btn btn-primary" for="box-upload-1">Upload</label>

            <button class="btn btn-success" >Create from scratch </button>

        </div>

    </div>

</div>

<script src="<?php echo base_url(); ?>assets/js/studio.js"></script> 
