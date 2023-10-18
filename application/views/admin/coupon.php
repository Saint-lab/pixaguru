<div class="pg-screen-container">
    <div class="pg-page-title-head">
        <h3><?php echo html_escape($this->lang->line('ltr_coupon_title')); ?> (<?php echo $recordsTotal; ?>)</h3>
        <a href="#create_coupon_popup" class="pg-popup-link pg-btn"><?php echo html_escape($this->lang->line('ltr_coupon_add_new')); ?> </a>
    </div>
    <div class="pg-content-wrapper">
        <div class="pg-table-wrap">
            <div class="table-responsive">
                <table id="coupon_table" class="pg-table">
                    <thead>
                        <tr>
                            <th><?php echo html_escape($this->lang->line('ltr_coupon_table_sno')); ?></th>
                            <th><?php echo html_escape($this->lang->line('ltr_coupon_table_offer_name')); ?></th>
                            <th><?php echo html_escape($this->lang->line('ltr_coupon_table_coupn_code')); ?></th>
                            <th><?php echo html_escape($this->lang->line('ltr_coupon_table_discount_type')); ?></th>
                            <th><?php echo html_escape($this->lang->line('ltr_coupon_table_dic_price')); ?></th>
                            <th><?php echo html_escape($this->lang->line('ltr_coupon_table_creat_time')); ?></th>
                            <th><?php echo html_escape($this->lang->line('ltr_coupon_table_exp_time')); ?></th>
                            <th><?php echo html_escape($this->lang->line('ltr_coupon_table_action')); ?></th>
                        </tr>
                    </thead>
                    <tbody>
					</tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- Modal Start  -->
<div id="create_coupon_popup" class="pg-modal-wrapper mfp-hide">
    <div class="pg-modal-inner-row">
        <div class="pg-modal-title-wrap">
            <h3><?php echo html_escape($this->lang->line('ltr_coupon_generate_code')); ?></h3>
        </div>
        <div class="pg-modal-body">
            <form id="coupon_form" action="" method="POST">
                <div class="pg-input-holder">
                    <label><?php echo html_escape($this->lang->line('ltr_coupon_offer_name')); ?></label>
                    <input type="text"  value="" id="offer_name" name="offer_name">
                </div>
                <div class="pg-input-holder">
                    <label><?php echo html_escape($this->lang->line('ltr_coupon_code')); ?></label>
                    <input type="text"  value="" id="coupone_code" name="coupone_code" readonly>
                    <a href="javascript:void(0)" id="generated_code"><?php echo html_escape($this->lang->line('ltr_coupon_generate')); ?></a>
                </div>
                <div class="pg-input-holder">
                    <label><?php echo html_escape($this->lang->line('ltr_coupon_discount_set')); ?></label>
                    <select  id="discount_set" name="discount_set">
                        <option value="percentage"><?php echo html_escape($this->lang->line('ltr_coupon_percnt')); ?></option>
                        <option value="Pricebased"><?php echo html_escape($this->lang->line('ltr_coupon_price')); ?></option>
                    </select>
                </div>
                <div class="pg-input-holder">
                    <label><?php echo html_escape($this->lang->line('ltr_coupon_dis_value')); ?></label>
                    <input type="number"  value="" id="discount_per_price" name="discount_per_price">
                </div>
                <div class="pg-input-holder">
                    <label><?php echo html_escape($this->lang->line('ltr_coupon_start')); ?></label>
                    <input type="text"  value="" id="discount_create_time" name="discount_create_time">
                    <span class="pg-datepicer-note"><?php echo html_escape($this->lang->line('ltr_coupon_date_note')); ?></span>
                </div>
                <div class="pg-input-holder">
                    <label><?php echo html_escape($this->lang->line('ltr_coupon_exp_time')); ?></label>
                    <input type="text"  value="" id="discount_expire_time" name="discount_expire_time">
                    <span class="pg-datepicer-note"><?php echo html_escape($this->lang->line('ltr_coupon_time_note')); ?></span>
                </div>
                <div class="pg-input-holder">
                    <button type="submit" class="pg-btn pg-btn-lg" id="create_coupon_code"><?php echo html_escape($this->lang->line('ltr_coupon_create_coupon')); ?></button> 
                </div>
            </form>
        </div> 
    </div>
</div>