<?php if(!empty($users)){ ?>
<div class="pg-modal-wrapper">
    <div class="pg-modal-inner-row">
        <div class="pg-modal-title-wrap">
            <h3><?php echo html_escape($this->lang->line('ltr_admin_popup_user_heding')); ?></h3>
        </div>
        <div class="pg-modal-body">
            <div class="pg-input-holder">
                <label><?php echo html_escape($this->lang->line('ltr_admin_popup_user_name')); ?></label>
                <input type="text"  value="<?php echo html_escape($users[0]['name']); ?>" id="user_name">
            </div>
            <div class="pg-input-holder">
                <label><?php echo html_escape($this->lang->line('ltr_admin_popup_user_email')); ?></label>
                <input type="text"  value="<?php echo html_escape($users[0]['email']); ?>" id="user_email">
            </div>
            <div class="pg-input-holder">
                <label><?php echo html_escape($this->lang->line('ltr_admin_popup_user_password')); ?></label>
                <input type="password"  value="" id="user_password">
				<span><?php echo html_escape($this->lang->line('ltr_admin_popup_user_notice')); ?></span>
            </div>
			<div class="pg-input-holder">
                <label><?php echo html_escape($this->lang->line('ltr_admin_popup_user_status')); ?></label>
                <select  id="status">
					<option value="1" <?php echo html_escape($users[0]['status']) == 1 ? 'selected' : ''; ?> ><?php echo html_escape($this->lang->line('ltr_admin_popup_user_active')); ?></option>
					<option value="0" <?php echo html_escape($users[0]['status']) == 0 ? 'selected' : ''; ?> ><?php echo html_escape($this->lang->line('ltr_admin_popup_user_deactive')); ?></option>
				</select>
            </div>
			<div class="pg-input-holder">
                <label><?php echo html_escape($this->lang->line('ltr_admin_popup_user_access_leave_heding')); ?></label>
                <select  id="access_level">
					<option value="1" <?php echo html_escape($users[0]['access_level']) == 1 ? 'selected' : ''; ?>><?php echo html_escape($this->lang->line('ltr_admin_popup_user_frontend')); ?></option>
					<option value="2" <?php echo html_escape($users[0]['access_level']) == 2 ? 'selected' : ''; ?> ><?php echo html_escape($this->lang->line('ltr_admin_popup_user_oto1')); ?></option>
					<option value="3" <?php echo html_escape($users[0]['access_level']) == 3 ? 'selected' : ''; ?> ><?php echo html_escape($this->lang->line('ltr_admin_popup_user_oto2')); ?></option>
					<option value="4" <?php echo html_escape($users[0]['access_level']) == 4 ? 'selected' : ''; ?> ><?php echo html_escape($this->lang->line('ltr_admin_popup_user_oto3')); ?></option>
					<option value="5" <?php echo html_escape($users[0]['access_level']) == 5 ? 'selected' : ''; ?> ><?php echo html_escape($this->lang->line('ltr_admin_popup_user_oto4')); ?></option>
				</select>
            </div>
            <div class="pg-input-holder">
                <div class="pg-checkbox">
                    <input type="checkbox" id="send_user_detail" checked="" value="1" class="ed_manage_user" name="send_mail">
                    <label for="send_user_detail"><?php echo html_escape($this->lang->line('ltr_admin_popup_user_check_message')); ?></label>
                </div>
            </div>
            <div class="pg-modal-btn-wrap">
				<input type="hidden"  value="<?php echo html_escape($users[0]['id']); ?>" id="user_id">
                <a href="" class="pg-btn pg-btn-lg" id="update_user"><?php echo html_escape($this->lang->line('ltr_admin_popup_user_btn')); ?></a> 
            </div>
        </div> 
    </div>
</div>
<?php } ?>
<?php if(!empty($sub_category)){ ?>
<div class="pg-modal-wrapper">
    <div class="pg-modal-inner-row">
        <div class="pg-modal-title-wrap">
            <h3><?php echo html_escape($this->lang->line('ltr_admin_popup_category_form_heading')); ?></h3>
        </div>
        <div class="pg-modal-body">
			<div class="pg-input-holder hide d-none">
                <label><?php echo html_escape($this->lang->line('ltr_admin_popup_category_form')); ?></label>
                <input type="text"  value="1" id="category_id">
            </div>
            <div class="pg-input-holder">
                <label><?php echo html_escape($this->lang->line('ltr_admin_popup_cat_name')); ?></label>
                <input type="text"  value="<?php echo html_escape($sub_category[0]['name']); ?>" id="subcategory_name">
                <input type="hidden"  value="<?php echo html_escape($sub_category[0]['sub_cat_id']); ?>" id="subcategory_id">
            </div>
            <div class="pg-modal-btn-wrap">
                <a href="" class="pg-btn pg-btn-lg" id="update_category"><?php echo html_escape($this->lang->line('ltr_admin_popup_cat_btn')); ?></a> 
            </div>
        </div> 
    </div>
</div>
<?php } ?>

<?php if(!empty($template)){ ?>
<div class="pg-modal-wrapper">
    <div class="pg-modal-inner-row">
        <div class="pg-modal-title-wrap">
            <h3><?php echo html_escape($this->lang->line('ltr_admin_popup_update_images')); ?></h3>
        </div>
        <div class="pg-modal-body">
            <div class="pg-input-holder">
                <label><?php echo html_escape($this->lang->line('ltr_admin_popup_image_name')); ?></label>
                <input type="text"  value="<?php echo html_escape($template[0]['template_name']); ?>" id="template_name">
            </div>
            <div class="pg-input-holder">
                <label><?php echo html_escape($this->lang->line('ltr_admin_popup_select_size')); ?></label>
                <select  id="template_size">
                    <optgroup label="WordPress Images">
                        <option value="1200x885" <?php echo html_escape($template[0]['template_size']) == '1200x885' ? 'selected' : ''; ?> >
                        <?php echo html_escape($this->lang->line('ltr_admin_popup_video_thumbnail_1200_885')); ?></option>
                        <option value="1200x1200" <?php echo html_escape($template[0]['template_size']) == '1200x1200' ? 'selected' : ''; ?> >
                        <?php echo html_escape($this->lang->line('ltr_admin_popup_video_thumbnail_squre_1200_1200')); ?></option>
                    </optgroup>
                    <optgroup label="Social Media">
                        <option value="940x940" <?php echo html_escape($template[0]['template_size']) == '940x940' ? 'selected' : ''; ?> >
                         <?php echo html_escape($this->lang->line('ltr_admin_popup_facebook_post_940_940')); ?></option>

                        <option value="628x628" <?php echo html_escape($template[0]['template_size']) == '628x628' ? 'selected' : ''; ?> >
                        <?php echo html_escape($this->lang->line('ltr_admin_popup_facebook_squre_628_628')); ?></option>

                        <option value="1080x1080" <?php echo html_escape($template[0]['template_size']) == '1080x1080' ? 'selected' : ''; ?> >
                        <?php echo html_escape($this->lang->line('ltr_admin_popup_instagram_post_1080_1080')); ?></option>

                        <option value="735x1102" <?php echo html_escape($template[0]['template_size']) == '735x1102' ? 'selected' : ''; ?> ><?php echo html_escape($this->lang->line('ltr_admin_popup_pinterest_pins_735_1102')); ?></option>

                        <option value="1024x512" <?php echo html_escape($template[0]['template_size']) == '1024x512' ? 'selected' : ''; ?> >
                        <?php echo html_escape($this->lang->line('ltr_admin_popup_twitter_post_1024_512')); ?></option>

                        <option value="497x373" <?php echo html_escape($template[0]['template_size']) == '497x373' ? 'selected' : ''; ?> >
                         <?php echo html_escape($this->lang->line('ltr_admin_popup_google_post_497_373')); ?></option>

                        <option value="851x315" <?php echo html_escape($template[0]['template_size']) == '851x315' ? 'selected' : ''; ?> >
                        <?php echo html_escape($this->lang->line('ltr_admin_popup_facebook_covers_851_315')); ?></option>

                        <option value="1500x500" <?php echo html_escape($template[0]['template_size']) == '1500x500' ? 'selected' : ''; ?> >
                        <?php echo html_escape($this->lang->line('ltr_admin_popup_twitter_header_1500_500')); ?></option>

                    </optgroup>
                    <optgroup label="AD Images">
                        <option value="1200x628" <?php echo html_escape($template[0]['template_size']) == '1200x628' ? 'selected' : ''; ?> >
                        <?php echo html_escape($this->lang->line('ltr_admin_popup_facebook_website_conversions_1200_628')); ?></option>

                        <option value="1200x900" <?php echo html_escape($template[0]['template_size']) == '1200x900' ? 'selected' : ''; ?> >
                        <?php echo html_escape($this->lang->line('ltr_admin_popup_facebook_page_post_engagements_1200_900')); ?></option>

                        <option value="1200x444" <?php echo html_escape($template[0]['template_size']) == '1200x444' ? 'selected' : ''; ?> >
                        <?php echo html_escape($this->lang->line('ltr_admin_popup_twitter_lead_gen_card_800_200')); ?></option>

                        <option value="800x200" <?php echo html_escape($template[0]['template_size']) == '800x200' ? 'selected' : ''; ?> ><?php echo html_escape($this->lang->line('ltr_admin_popup_twitter_promoted_tweet_590_295')); ?></option>

                        <option value="590x295" <?php echo html_escape($template[0]['template_size']) == '590x295' ? 'selected' : ''; ?> ><?php echo html_escape($this->lang->line('ltr_admin_popup_adwords_medium_rectangle_300_250')); ?></option>  

                        <option value="300x250" <?php echo html_escape($template[0]['template_size']) == '300x250' ? 'selected' : ''; ?> >
                        <?php echo html_escape($this->lang->line('ltr_admin_popup_adwords_large_rectangle_336_280')); ?></option>  

                        <option value="336x280" <?php echo html_escape($template[0]['template_size']) == '336x280' ? 'selected' : ''; ?> >
                        <?php echo html_escape($this->lang->line('ltr_admin_popup_adwords_large_rectangle_336_280')); ?></option> 

                        <option value="728x90" <?php echo html_escape($template[0]['template_size']) == '728x90' ? 'selected' : ''; ?> >
                        <?php echo html_escape($this->lang->line('ltr_admin_popup_adwords_leaderboard_728_90')); ?></option>

                        <option value="250x250" <?php echo html_escape($template[0]['template_size']) == '250x250' ? 'selected' : ''; ?> ><?php echo html_escape($this->lang->line('ltr_admin_popup_adwords_250_250')); ?>
                        </option>     

                        <option value="300x600" <?php echo html_escape($template[0]['template_size']) == '300x600' ? 'selected' : ''; ?> ><?php echo html_escape($this->lang->line('ltr_admin_popup_adwords_300_600')); ?>
                        </option>   

                    </optgroup>
                    <optgroup label="Website Headers">
                        <option value="1920x250" <?php echo html_escape($template[0]['template_size']) == '1920x250' ? 'selected' : ''; ?> ><?php echo html_escape($this->lang->line('ltr_admin_popup_website_headers_1920_250')); ?></option>
                    </optgroup>
                    <optgroup label="Miscellaneous">
                        <option value="1920x1080" <?php echo html_escape($template[0]['template_size']) == '1920x1080' ? 'selected' : ''; ?> ><?php echo html_escape($this->lang->line('ltr_admin_popup_gift_certificate_1920_1080')); ?></option>
                    </optgroup>

                </select>
            </div>
			<div class="pg-input-holder hide">
                <label><?php echo html_escape($this->lang->line('ltr_admin_popup_select_category')); ?></label>
                <select class="form-control get_sub_category" id="category_id">
                    <option value=""><?php echo html_escape($this->lang->line('ltr_admin_popup_select')); ?></option>
					<?php for($i=0;$i<count($category);$i++){ ?>
						<option value="<?php echo html_escape($category[$i]['cat_id']); ?>" selected><?php echo html_escape($category[$i]['name']); ?></option>
					<?php break; } ?>
                </select>
            </div>
            <div class="pg-input-holder">
                <label><?php echo html_escape($this->lang->line('ltr_admin_popup_select_category')); ?></label>
                <select  id="sub_category_id">
					<?php for($i=0;$i<count($t_sub_category);$i++){ ?>
						<option value="<?php echo html_escape($t_sub_category[$i]['sub_cat_id']); ?>" <?php echo html_escape($t_sub_category[$i]['sub_cat_id']) == $template[0]['sub_cat_id'] ? 'selected' : ''; ?> ><?php echo html_escape($t_sub_category[$i]['name']); ?></option>
					<?php } ?>
                </select>
            </div>
			<div class="pg-input-holder hide">
                <label><?php echo html_escape($this->lang->line('ltr_admin_popup_select_access_leavel')); ?></label>
                <select  id="template_access_level">
					<option value="1" <?php echo 1 == html_escape($template[0]['access_level']) ? 'selected' : ''; ?> ><?php echo html_escape($this->lang->line('ltr_admin_popup_image_frontend')); ?></option>
					<option value="2" <?php echo 2 == html_escape($template[0]['access_level']) ? 'selected' : ''; ?> ><?php echo html_escape($this->lang->line('ltr_admin_popup_image_oto1')); ?></option>
					<option value="3" <?php echo 3 == html_escape($template[0]['access_level']) ? 'selected' : ''; ?> ><?php echo html_escape($this->lang->line('ltr_admin_popup_image_oto2')); ?></option>
					<option value="4" <?php echo 4 == html_escape($template[0]['access_level']) ? 'selected' : ''; ?> ><?php echo html_escape($this->lang->line('ltr_admin_popup_image_oto3')); ?></option>
					<option value="5" <?php echo 5 == html_escape($template[0]['access_level']) ? 'selected' : ''; ?> ><?php echo html_escape($this->lang->line('ltr_admin_popup_image_oto4')); ?></option>
                </select>
            </div>
            <div class="pg-modal-btn-wrap">
				<input type="hidden" value="<?php echo html_escape($template[0]['template_id']); ?>" id="template_id">
                <a href="" class="pg-btn pg-btn-lg" id="update_template"><?php echo html_escape($this->lang->line('ltr_admin_popup_image_update')); ?></a> 
            </div>
        </div> 
    </div>
</div>
<?php } ?>

<?php if(!empty($duplicate)){ ?>
<div class="pg-modal-wrapper">
    <div class="pg-modal-inner-row">
        <div class="pg-modal-title-wrap">
            <h3><?php echo html_escape($this->lang->line('ltr_admin_popup_image_create_more_size')); ?></h3>
        </div>
        <form action="<?php echo base_url() . 'admin/copy_all_size'; ?>" method="post">
        <div class="pg-modal-body">
            <div class="pg-input-holder">
                <label><?php echo html_escape($this->lang->line('ltr_admin_popup_image_name')); ?></label>
                <input type="text"  value="" name="template_name">
            </div>
            <div class="pg-input-holder">
                <label><?php echo html_escape($this->lang->line('ltr_admin_popup_select_size')); ?></label>
                <select  name="template_size[]" multiple style="height: 313px;">
                    <optgroup label="WordPress Images">
                        <option value="1200x885" ><?php echo html_escape($this->lang->line('ltr_admin_popup_image_video_thumbnail_1200_885')); ?></option>
                        <option value="1200x1200"  ><?php echo html_escape($this->lang->line('ltr_admin_popup_video_thumbnail_squre_1200_1200')); ?></option>
                    </optgroup>
                    <optgroup label="Social Media">
                        <option value="940x940"><?php echo html_escape($this->lang->line('ltr_admin_popup_image_facebook_post_940_940')); ?></option>
                        <option value="628x628"><?php echo html_escape($this->lang->line('ltr_admin_popup_image_facebook_squre_628_628')); ?></option>
                        <option value="1080x1080"><?php echo html_escape($this->lang->line('ltr_admin_popup_image_instagram_post_1080_1080')); ?></option>
                        <option value="735x1102" ><?php echo html_escape($this->lang->line('ltr_admin_popup_image_pinterest_pins_735_1102')); ?></option>
                        <option value="1024x512" ><?php echo html_escape($this->lang->line('ltr_admin_popup_image_twitter_post_1024_512')); ?></option>
                        <option value="497x373"><?php echo html_escape($this->lang->line('ltr_admin_popup_image_google_post_497_373')); ?></option>
                        <option value="851x315"><?php echo html_escape($this->lang->line('ltr_admin_popup_image_facebook_covers_851_315')); ?></option>
                        <option value="1500x500" ><?php echo html_escape($this->lang->line('ltr_admin_popup_image_twitter_header_1500_500')); ?></option>
                    </optgroup>
                    <optgroup label="AD Images">
                        <option value="1200x628"><?php echo html_escape($this->lang->line('ltr_admin_popup_image_facebook_website_conversion_1200_628')); ?></option>
                        <option value="1200x900"><?php echo html_escape($this->lang->line('ltr_admin_popup_image_facebook_page_post_engagements_1200_900')); ?></option>
                        <option value="1200x444"><?php echo html_escape($this->lang->line('ltr_admin_popup_image_facebook_page_likes_1200_444')); ?></option>
                        <option value="800x200"><?php echo html_escape($this->lang->line('ltr_admin_popup_image_twitter_lead_gen_card_800_200')); ?></option>
                        <option value="590x295"><?php echo html_escape($this->lang->line('ltr_admin_popup_image_adwords_medium_rectangle_300_250')); ?></option>    
                        <option value="300x250"><?php echo html_escape($this->lang->line('ltr_admin_popup_image_adwords_large_reactangle_336_250')); ?></option>    
                        <option value="336x280"><?php echo html_escape($this->lang->line('ltr_admin_popup_image_adwords_large_reactangle_336_280')); ?></option>    
                        <option value="728x90"><?php echo html_escape($this->lang->line('ltr_admin_popup_image_leaderboard_adwords_728_90')); ?></option>
                        <option value="250x250"><?php echo html_escape($this->lang->line('ltr_admin_popup_image_adwords_250_250')); ?></option>                           
                        <option value="300x600"><?php echo html_escape($this->lang->line('ltr_admin_popup_image_adwords_300_600')); ?></option>                           
                    </optgroup>
                    <optgroup label="Website Headers">
                        <option value="1920x250"><?php echo html_escape($this->lang->line('ltr_admin_popup_image_website_headers_1920_250')); ?></option>
                    </optgroup>
                    <optgroup label="Miscellaneous">
                        <option value="1920x1080"><?php echo html_escape($this->lang->line('ltr_admin_popup_image_gift_certificate_1920_1080')); ?></option>
                    </optgroup>

                </select>
            </div>
            <div class="pg-modal-btn-wrap">
				<input type="hidden" value="<?php echo html_escape($template_id); ?>" name="template_id">
                <button class="pg-btn pg-btn-lg"><?php echo html_escape($this->lang->line('ltr_admin_popup_image_update_btn')); ?></button> 
            </div>
        </div> 
        </form>
    </div>
</div>
<?php } ?>