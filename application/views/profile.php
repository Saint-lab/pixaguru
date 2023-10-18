<div class="pg-screen-container pg-wp-profile-wrapper">
	<div class="pg-page-title-head">
		<h3><?php echo html_escape($this->lang->line('ltr_profile_page_title')); ?></h3>
	</div>
	<div class="pg-content-wrapper">
        <div class="pg-from-wrapper">
            <form action="<?php echo base_url(); ?>profile/update" method="post" id="ed_profile_update_form" enctype="multipart/form-data">
                <div class="row justify-content-between">
                    <div class="col-xl-12 col-lg-12">
                        <div class="pg-profile-image-box">
                            <div class="pg-profile-image">
                                <input type="hidden" value="0" name="profile_pic_remove">
                                <input type="file" name="pic_file">
                                <div class="overlay"></div>
                                <img src="<?php echo base_url() . $this->session->userdata( 'profile_pic' ); ?>?q=<?php echo time(); ?>" alt="">
                                <span class="initials"><?php echo get_first_letter( $this->session->userdata( 'name' ) ); ?></span>
                                <div class="pg-remove-profile-img" title="Remove Profile Image">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" viewBox="0 0 212.982 212.982" xml:space="preserve" width="50px" height="50px"><g id="Close"><path d="M131.804,106.491l75.936-75.936c6.99-6.99,6.99-18.323,0-25.312 c-6.99-6.99-18.322-6.99-25.312,0l-75.937,75.937L30.554,5.242c-6.99-6.99-18.322-6.99-25.312,0c-6.989,6.99-6.989,18.323,0,25.312 l75.937,75.936L5.242,182.427c-6.989,6.99-6.989,18.323,0,25.312c6.99,6.99,18.322,6.99,25.312,0l75.937-75.937l75.937,75.937 c6.989,6.99,18.322,6.99,25.312,0c6.99-6.99,6.99-18.322,0-25.312L131.804,106.491z"/></g></svg>
                                </div>
                            </div>
                            <h3><?php echo isset($user[0]['name']) ? $user[0]['name'] : '';?></h3>
                        </div>
                    </div>
                    <div class="col-xl-12 col-lg-12">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="pg-profile-title">
                                    <h3><?php echo html_escape($this->lang->line('ltr_profile_title')); ?></h3>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                                <div class="col-lg-12">
                                    <div class="pg-input-holder">
                                        <label><?php echo html_escape($this->lang->line('ltr_profile_name')); ?></label>
                                        <input type="text"  name="name" value="<?php echo isset($user[0]['name']) ? $user[0]['name'] : '';?>">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="pg-input-holder">
                                        <label><?php echo html_escape($this->lang->line('ltr_profile_mail')); ?></label>
                                        <input type="text"  value="<?php echo isset($user[0]['email']) ? $user[0]['email'] : '';?>" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="pg-input-holder">
                                        <label><?php echo html_escape($this->lang->line('ltr_profile_phone')); ?></label>
                                        <input type="text"  name="phone_no" value="<?php echo isset($user[0]['phone_no']) ? $user[0]['phone_no'] : '';?>">
                                    </div>
                                </div>
                                <div class="clearfix"></div><br>
                                <div class="col-lg-12">
                                    <div class="pg-profile-title">
                                        <h3><?php echo html_escape($this->lang->line('ltr_profile_chng_pws')); ?></h3>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="pg-input-holder">
                                        <label><?php echo html_escape($this->lang->line('ltr_profile_pws')); ?></label>
                                        <input type="password"  value="" name="password" id="ed_password">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="pg-input-holder">
                                        <label>Confirm Password</label>
                                        <input type="password"  value="" name="confirm_password" id="ed_confirm_password">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <button name="profile_update" value="update" class="pg-btn"><?php echo html_escape($this->lang->line('ltr_profile_btn')); ?></button>
                                </div>
                        </div>
                    </div>
                    
                </div>
            </form>
		</div>
	</div>
</div>