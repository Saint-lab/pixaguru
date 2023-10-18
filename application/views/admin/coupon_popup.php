<?php if(!empty($coupon_code)){ ?>
<div class="pg-modal-wrapper">
    <div class="pg-modal-inner-row">
        <div class="pg-modal-title-wrap">
            <h3><?php echo html_escape($this->lang->line('ltr_coupon_popup_title')); ?></h3>
        </div>
        <div class="pg-modal-body">
            <form id="update_coupon_form" action="" method="POST">
                <div class="pg-input-holder">
                    <label><?php echo html_escape($this->lang->line('ltr_coupon_popup_offer_name')); ?></label>
                    <input type="text"  value="<?php if(isset($coupon_code[0]['offer_name'])): echo $coupon_code[0]['offer_name']; endif; ?>" id="offer_name" name="offer_name">
                </div>
                <div class="pg-input-holder">
                    <label><?php echo html_escape($this->lang->line('ltr_coupon_popup_coupon_code')); ?></label>
                    <input type="text"  value="<?php if(isset($coupon_code[0]['coupon_code'])): echo $coupon_code[0]['coupon_code']; endif; ?>" id="coupone_code" name="coupone_code" readonly>
                    <a href="javascript:void(0)" id="generated_code"><?php echo html_escape($this->lang->line('ltr_coupon_popup_generate')); ?></a>
                </div>
                <div class="pg-input-holder">
                    <label><?php echo html_escape($this->lang->line('ltr_coupon_popup_discount_set')); ?></label>
                    <select  id="discount_set" name="discount_set">
                        <option value="percentage" <?php if(isset($coupon_code[0]['discount_set']) && $coupon_code[0]['discount_set']=='percentage'): echo 'selected'; endif; ?>><?php echo html_escape($this->lang->line('ltr_coupon_popup_percentage')); ?></option>
                        <option value="Pricebased" <?php if(isset($coupon_code[0]['discount_set']) && $coupon_code[0]['discount_set']=='Pricebased'): echo 'selected'; endif; ?>><?php echo html_escape($this->lang->line('ltr_coupon_popup_price')); ?></option>
                    </select>
                </div>
                <div class="pg-input-holder">
                    <label><?php echo html_escape($this->lang->line('ltr_coupon_popup_dis_price')); ?></label>
                    <input type="number"  value="<?php if(isset($coupon_code[0]['discount_per_price'])): echo $coupon_code[0]['discount_per_price']; endif; ?>" id="discount_per_price" name="discount_per_price">
                </div>
                <div class="pg-input-holder">
                    <label><?php echo html_escape($this->lang->line('ltr_coupon_popup_create_time')); ?></label>
                    <input type="text"  value="<?php if(isset($coupon_code[0]['discount_create_time'])): echo $coupon_code[0]['discount_create_time']; endif; ?>" id="discount_create_time" name="discount_create_time">
                    <span class="pg-datepicer-note"><?php echo html_escape($this->lang->line('ltr_coupon_popup_time_not')); ?></span>
                </div> 
                <div class="pg-input-holder">
                    <label><?php echo html_escape($this->lang->line('ltr_coupon_popup_ex_time')); ?></label>
                    <input type="text"  value="<?php if(isset($coupon_code[0]['discount_create_time'])): echo $coupon_code[0]['discount_create_time']; endif; ?>" id="discount_expire_time" name="discount_expire_time">
                    <span class="pg-datepicer-note"><?php echo html_escape($this->lang->line('ltr_coupon_popup_ex_time_note')); ?></span>
                </div>
                <div class="pg-input-holder text-center">
                    <input type="hidden"  value="<?php if(isset($coupon_code[0]['cp_id'])): echo $coupon_code[0]['cp_id']; endif; ?>" id="coupon_id">
                    <button type="submit" class="pg-btn pg-btn-lg" id="update_coupon_code"><?php echo html_escape($this->lang->line('ltr_coupon_popup_update')); ?></button> 
                </div>
            </form>
        </div> 
    </div>
</div>
<?php } ?> 