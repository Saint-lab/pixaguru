<div class="pg-screen-container">
    <div class="pg-page-title-head">
        <h3><?php echo html_escape($this->lang->line('ltr_sub_list_title')); ?> (<?php echo $recordsTotal; ?>)</h3>
    </div>
    <div class="pg-content-wrapper">
        <div class="pg-table-wrap">
            <div class="table-responsive">
                <table id="subscription_table_list" class="pg-table">
                    <thead>
                        <tr>
                          <th><?php echo html_escape($this->lang->line('ltr_sub_list_table_sno')); ?></th>
                          <th><?php echo html_escape($this->lang->line('ltr_sub_list_table_plnId')); ?></th>
                          <th><?php echo html_escape($this->lang->line('ltr_sub_list_table_payer_mail')); ?></th>
                          <th><?php echo html_escape($this->lang->line('ltr_sub_list_table_pay_method')); ?></th>
                          <th><?php echo html_escape($this->lang->line('ltr_sub_list_table_pln_currency')); ?></th>
                          <th><?php echo html_escape($this->lang->line('ltr_sub_list_table_plan_amt')); ?></th>
                          <th><?php echo html_escape($this->lang->line('ltr_sub_list_table_stripe_id')); ?></th>
                          <th><?php echo html_escape($this->lang->line('ltr_sub_list_table_plan_interval')); ?></th>
                          <th><?php echo html_escape($this->lang->line('ltr_sub_list_table_period_start')); ?></th>
                          <th><?php echo html_escape($this->lang->line('ltr_sub_list_table_period_end')); ?></th>
                        </tr>
                    </thead>
                    <tbody>
					</tbody>
                </table>
            </div>
        </div>
    </div>
</div> 