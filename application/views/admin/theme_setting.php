<div class="pg-screen-container pg-wp-profile-wrapper">
	<div class="pg-page-title-head">
		<h3>Theme Setting</h3>
	</div>
    <div class="pg-theme-setting-box-parent">
    <div class="pg-content-wrapper">
       <div class="pg-from-wrapper">
            <h2>Update Logo</h2>
            <form action="<?php echo base_url(); ?>theme_setting/logo_changes" method="post" id="pg_logo_image_save" enctype="multipart/form-data">
                <div class="row justify-content-between">
                    <div class="col-xl-12 col-lg-12">
                        <div class="pg-logo-image-box">
                            <div class="pg-logo-image">
                                <input type="hidden" value="0" name="logo_pic_remove">
                                <input type="file" name="logo_images_file" id="logo_images_file" accept="image/*" onchange="onFileUpload(this,'#ajaxImgUpload');">
                                <?php if(isset($logo_images[0]['data_value'])):?>
                                    <span class="initials"></span>
                                    <div class="pg-remove-logo-img" title="Remove Profile Image">
                                        <a href="javascript:void(0)" class="pg_delete_images" data-imgename="<?php echo $logo_images[0]['data_value']; ?>" data-image_type="pg_logo_image">
                                        <svg version="1.1" x="0px" y="0px" viewBox="0 0 212.982 212.982"><g id="Close"><path d="M131.804,106.491l75.936-75.936c6.99-6.99,6.99-18.323,0-25.312 c-6.99-6.99-18.322-6.99-25.312,0l-75.937,75.937L30.554,5.242c-6.99-6.99-18.322-6.99-25.312,0c-6.989,6.99-6.989,18.323,0,25.312 l75.937,75.936L5.242,182.427c-6.989,6.99-6.989,18.323,0,25.312c6.99,6.99,18.322,6.99,25.312,0l75.937-75.937l75.937,75.937 c6.989,6.99,18.322,6.99,25.312,0c6.99-6.99,6.99-18.322,0-25.312L131.804,106.491z"/></g></svg>
                                        </a>
                                    </div>
                                <?php endif; ?>
                                <div class="d-grid text-center" id="ajaxImgUpload">
                                    <?php if(isset($logo_images[0]['data_value'])): ?>
                                    <img class="mb-3"  alt="Preview Image" src="<?php echo base_url().'uploads/logo/'.$logo_images[0]['data_value']; ?>" />
                                    <?php else: ?>
                                          
                                        <h5>Drag &amp; Drop Photo Here<br>or <span>Browse</span> to Upload</h5>
                                    <?php endif; ?>                                
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12">
                            <button type="submit" class="pg-btn uploadBtn">Save</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!--Favicon  Icon -->
    <div class="pg-content-wrapper">
       <div class="pg-from-wrapper">
            <h2>Update Favicon</h2>
            <form action="<?php echo base_url(); ?>theme_setting/favicon_changes" method="post" id="pg_favicon_image_save" enctype="multipart/form-data"> 
                <div class="row justify-content-between">
                    <div class="col-xl-12 col-lg-12">
                        <div class="pg-logo-image-box">
                            <div class="pg-logo-image">
                                <input type="hidden" value="0" name="favicon_pic_remove">
                                <input type="file" name="favicon_images_file" id="favicon_images_file" accept="image/*" onchange="onFileUpload(this,'#favicon_image');">
                                <?php if(isset($favicon_images[0]['data_value'])):?>
                                    <span class="initials"></span>
                                    <div class="pg-remove-logo-img" title="Remove Profile Image">
                                        <a href="javascript:void(0)" class="pg_delete_images" data-imgename="<?php echo $favicon_images[0]['data_value']; ?>" data-image_type="pg_favicon_image">
                                        <svg version="1.1" x="0px" y="0px" viewBox="0 0 212.982 212.982"><g id="Close"><path d="M131.804,106.491l75.936-75.936c6.99-6.99,6.99-18.323,0-25.312 c-6.99-6.99-18.322-6.99-25.312,0l-75.937,75.937L30.554,5.242c-6.99-6.99-18.322-6.99-25.312,0c-6.989,6.99-6.989,18.323,0,25.312 l75.937,75.936L5.242,182.427c-6.989,6.99-6.989,18.323,0,25.312c6.99,6.99,18.322,6.99,25.312,0l75.937-75.937l75.937,75.937 c6.989,6.99,18.322,6.99,25.312,0c6.99-6.99,6.99-18.322,0-25.312L131.804,106.491z"/></g></svg>
                                        </a>
                                    </div>
                                <?php endif; ?>
                                <div class="d-grid text-center" id="favicon_image">
                                    <?php if(isset($favicon_images[0]['data_value'])): ?>
                                    <img class="mb-3" alt="Preview Image" src="<?php echo base_url().'uploads/logo/'.$favicon_images[0]['data_value']; ?>" />
                                    <?php else: ?>
                                        <h5>Drag &amp; Drop Photo Here<br>or <span>Browse</span> to Upload</h5>
                                    <?php endif; ?>                                
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12">
                            <button type="submit" class="pg-btn uploadBtn">Save</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Preloader Images Changes -->
    <div class="pg-content-wrapper">
       <div class="pg-from-wrapper">
            <h2>Update Preloader</h2>
            <form action="<?php echo base_url(); ?>theme_setting/preloader_changes" method="post" id="pg_preloader_image_save" enctype="multipart/form-data"> 
                <div class="row justify-content-between">
                    <div class="col-xl-12 col-lg-12">
                        <div class="pg-logo-image-box">
                            <div class="pg-logo-image">
                                <input type="hidden" value="0" name="preloader_pic_remove">
                                <input type="file" name="preloader_images_file" id="preloader_images_file" accept="image/*" onchange="onFileUpload(this,'#preloader_images');">
                                <?php if(isset($preloader_images[0]['data_value'])):?>
                                    <span class="initials"></span>
                                    <div class="pg-remove-logo-img" title="Remove Profile Image">
                                        <a href="javascript:void(0)" class="pg_delete_images" data-imgename="<?php echo $favicon_images[0]['data_value']; ?>" data-image_type="pg_preloader_image">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" viewBox="0 0 212.982 212.982" xml:space="preserve" width="50px" height="50px"><g id="Close"><path d="M131.804,106.491l75.936-75.936c6.99-6.99,6.99-18.323,0-25.312 c-6.99-6.99-18.322-6.99-25.312,0l-75.937,75.937L30.554,5.242c-6.99-6.99-18.322-6.99-25.312,0c-6.989,6.99-6.989,18.323,0,25.312 l75.937,75.936L5.242,182.427c-6.989,6.99-6.989,18.323,0,25.312c6.99,6.99,18.322,6.99,25.312,0l75.937-75.937l75.937,75.937 c6.989,6.99,18.322,6.99,25.312,0c6.99-6.99,6.99-18.322,0-25.312L131.804,106.491z"/></g></svg>
                                        </a>
                                    </div>
                                <?php endif; ?>
                                <div class="d-grid text-center" id="preloader_images">
                                    <?php if(isset($preloader_images[0]['data_value'])): ?>
                                    <img class="mb-3" alt="Preview Image" src="<?php echo base_url().'uploads/logo/'.$preloader_images[0]['data_value']; ?>" />
                                    <?php else: ?>
                                        <h5>Drag &amp; Drop Photo Here<br>or <span>Browse</span> to Upload</h5>
                                    <?php endif; ?>                                
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12">
                            <button type="submit" class="pg-btn uploadBtn">Save</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>