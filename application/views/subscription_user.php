<div class="pg-screen-container">
    <div class="pg-page-title-head">
        <h3><?php echo html_escape($this->lang->line('ltr_subscribe_user_title')); ?> (<?php echo $recordsTotal; ?>)</h3>
    </div>
    <div class="pg-content-wrapper">
        <div class="pg-table-wrap">
            <div class="table-responsive">
                <table id="subscription_table_list_user" class="pg-table">
                    <thead>
                        <tr>
                          <th><?php echo html_escape($this->lang->line('ltr_subscribe_user_sno')); ?></th>
                          <th><?php echo html_escape($this->lang->line('ltr_subscribe_user_planId')); ?></th>
                          <th><?php echo html_escape($this->lang->line('ltr_subscribe_user_p_mail')); ?></th>
                          <th><?php echo html_escape($this->lang->line('ltr_subscribe_user_pay_method')); ?></th>
                          <th><?php echo html_escape($this->lang->line('ltr_subscribe_user_plan_currency')); ?></th>
                          <th><?php echo html_escape($this->lang->line('ltr_subscribe_user_paln_amnt')); ?></th>
                          <th><?php echo html_escape($this->lang->line('ltr_subscribe_user_subscriptionId')); ?></th>
                          <th><?php echo html_escape($this->lang->line('ltr_subscribe_user_plan_interval')); ?></th>
                          <th><?php echo html_escape($this->lang->line('ltr_subscribe_user_plan_period_start')); ?></th>
                          <th><?php echo html_escape($this->lang->line('ltr_subscribe_user_plan_period_end')); ?></th>
                        </tr>
                    </thead>
                    <tbody>
					</tbody>
                </table>
            </div>
        </div>
    </div>
</div>  
