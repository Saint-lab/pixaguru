<div class="pg-screen-container">
    <div class="container">
        <div class="row">
			<?php if(!count($adduser)){ ?>
            <div class="pg-empty-campain-wrap">
                <div class="pg-empty-campain">
                    <span class="pg-empty-icon">
                        <img src="<?php echo base_url(); ?>assets/images/empty-folder.png" alt="">
                    </span>
                    <h3> <?php echo html_escape($this->lang->line('ltr_mng_user_empty_title')); ?> </h3>
                    <p> <?php echo html_escape($this->lang->line('ltr_mng_user_empty_desc')); ?></p>
                    <a href="#add_new_user" class="pg-popup-link pg-btn pg-btn-lg mt-3"> <?php echo html_escape($this->lang->line('ltr_mng_user_empty_btn')); ?></a>
                </div>
            </div>
			<?php }else{ ?>
				<div class="col-md-12">
					<div class="ed_heading">
						<h3> <?php echo html_escape($this->lang->line('ltr_mng_user_title')); ?> (<span class="campaign_count"><?php echo count($adduser); ?></span>) <a href="#add_new_user" class="pg-popup-link pg-btn pull-right"> <?php echo html_escape($this->lang->line('ltr_mng_user_add_user')); ?></a></h3>
					</div>
				</div>
				<?php for($i=0;$i<count($adduser);$i++){ ?>
					<div class="col-md-4">
						<div class="pg-manage-user-wrapper">
							<div class="image">
								<img src="<?php echo base_url() . $adduser[$i]['profile_pic']; ?>" alt="">
								 <span class="initials"><?php echo get_first_letter( $adduser[$i]['name'] ); ?></span>
							</div>
							<div class="user_detail">
								<h3><?php echo $adduser[$i]['name']; ?></h3>
								<p><?php echo $adduser[$i]['email']; ?></p>
								<div class="ed_user_action">
									<a href="" class="ed_sub_user_delete" data-sub_user="<?php echo $adduser[$i]['sub_user_id']; ?>"> <?php echo html_escape($this->lang->line('ltr_mng_user_user_del')); ?></a>
								</div>
							</div>
						</div>
					</div>
				<?php } ?>
			<?php } ?>
        </div>
    </div>
</div>
<div id="add_new_user" class="pg-modal-wrapper mfp-hide">
    <div class="pg-modal-inner-row">
        <div class="pg-modal-title-wrap">
            <h3><?php echo html_escape($this->lang->line('ltr_mng_user_ad_new')); ?></h3>
        </div>
        <div class="pg-modal-body">
			<div class="ed_radio_group inline">
				<div class="ed_radio">
					<input type="radio" id="radio_id1" name="user_type" checked value="new" class="ed_user_type">
					<label for="radio_id1"><?php echo html_escape($this->lang->line('ltr_mng_user_new_user_title')); ?></label>
				</div>
				<div class="ed_radio">
					<input type="radio" id="radio_id2" name="user_type" value="exist" class="ed_user_type">
					<label for="radio_id2"> <?php echo html_escape($this->lang->line('ltr_mng_user_existing_user')); ?></label>
				</div>
			</div>
            <div class="pg-input-holder ed_new_user">
                <label> <?php echo html_escape($this->lang->line('ltr_mng_user_name')); ?></label>
                <input type="text" class="form-control ed_manage_user" value="" name="name">
            </div>
            <div class="pg-input-holder">
                <label> <?php echo html_escape($this->lang->line('ltr_mng_user_mail')); ?></label>
                <input type="email" class="form-control ed_manage_user" value="" name="email">
            </div>
            <div class="pg-input-holder ed_new_user">
                <label> <?php echo html_escape($this->lang->line('ltr_mng_user_pws')); ?></label>
                <input type="password" class="form-control ed_manage_user" name="password" value="" id="">
            </div>
            <div class="pg-input-holder ed_new_user">
                <div class="pg-checkbox">
                    <input type="checkbox" id="send_user_detail" checked="" value="1" class="ed_manage_user" name="send_mail">
                    <label for="send_user_detail"><?php echo html_escape($this->lang->line('ltr_mng_user_msg_title')); ?> </label>
                </div>
            </div>
            <div class="pg-modal-btn-wrap">
                <a href="" class="pg-btn pg-btn-lg ed_manage_user_create"> <?php echo html_escape($this->lang->line('ltr_mng_user_create_btn')); ?></a> 
            </div>
        </div> 
    </div>
</div>