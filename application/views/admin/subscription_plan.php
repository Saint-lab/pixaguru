<div class="pg-screen-container">
    <div class="pg-page-title-head">
        <h3><?php echo html_escape($this->lang->line('ltr_sub_plan_title')); ?>  (<?php echo $recordsTotal; ?>)</h3>
        <a href="#create_subscription_plan_popup" class="pg-popup-link pg-btn"><?php echo html_escape($this->lang->line('ltr_sub_plan_add')); ?></a>
    </div>
    <div class="pg-content-wrapper">
        <div class="pg-table-wrap">
            <div class="table-responsive">
                <table id="subscription_table" class="pg-table">
                    <thead>
                        <tr>
                          <th><?php echo html_escape($this->lang->line('ltr_sub_plan_t_sno')); ?></th>
                          <th><?php echo html_escape($this->lang->line('ltr_sub_plan_t_plan_name')); ?></th>
                          <th><?php echo html_escape($this->lang->line('ltr_sub_plan_t_price')); ?></th>
                          <th><?php echo html_escape($this->lang->line('ltr_sub_plan_currency')); ?></th>
                          <th><?php echo html_escape($this->lang->line('ltr_sub_plan_interval')); ?></th>
                          <th><?php echo html_escape($this->lang->line('ltr_sub_plan_action')); ?></th>
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
<div id="create_subscription_plan_popup" class="pg-modal-wrapper mfp-hide">
    <div class="pg-modal-inner-row">
        <div class="pg-modal-title-wrap">
            <h3><?php echo html_escape($this->lang->line('ltr_sub_plan_sub_title')); ?></h3>
        </div>
        <div class="pg-modal-body">
            <form id="pricing_plan_form" action="" method="POST">
                <div class="pg-input-holder">
                    <label for="plan_name"><?php echo html_escape($this->lang->line('ltr_sub_plan_name_label')); ?></label>
                    <input type="text"  value="" id="plan_name" name="plan_name">
                </div>
                <div class="pg-input-holder">
                    <label for="currency_set"><?php echo html_escape($this->lang->line('ltr_sub_plan_currency_label')); ?></label>
                    <select  id="currency_set" name="currency_set">
                        <option value="USD" selected="selected"><?php echo html_escape($this->lang->line('ltr_sub_plan_us_dollar')); ?></option>
                        <option value="EUR"><?php echo html_escape($this->lang->line('ltr_sub_plan_ero')); ?></option>
                        <option value="GBP"><?php echo html_escape($this->lang->line('ltr_sub_plan_pound')); ?></option>
                        <option value="DZD"><?php echo html_escape($this->lang->line('ltr_sub_plan_dzd')); ?></option>
                        <option value="ARP"><?php echo html_escape($this->lang->line('ltr_sub_plan_arp')); ?></option>
                        <option value="AUD"><?php echo html_escape($this->lang->line('ltr_sub_plan_aud')); ?></option>
                        <option value="ATS"><?php echo html_escape($this->lang->line('ltr_sub_plan_ats')); ?></option>
                        <option value="BSD"><?php echo html_escape($this->lang->line('ltr_sub_plan_bsd')); ?></option>
                        <option value="BBD"><?php echo html_escape($this->lang->line('ltr_sub_plan_bbd')); ?></option>
                        <option value="BEF"><?php echo html_escape($this->lang->line('ltr_sub_plan_bef')); ?></option>
                        <option value="BMD"><?php echo html_escape($this->lang->line('ltr_sub_plan_bmd')); ?></option>
                        <option value="BRR"><?php echo html_escape($this->lang->line('ltr_sub_plan_brr')); ?></option>
                        <option value="BGL"><?php echo html_escape($this->lang->line('ltr_sub_plan_bgl')); ?></option>
                        <option value="CAD"><?php echo html_escape($this->lang->line('ltr_sub_plan_cad')); ?></option>
                        <option value="CLP"><?php echo html_escape($this->lang->line('ltr_sub_plan_clp')); ?></option>
                        <option value="CNY"><?php echo html_escape($this->lang->line('ltr_sub_plan_cny')); ?></option>
                        <option value="CYP"><?php echo html_escape($this->lang->line('ltr_sub_plan_cyp')); ?></option>
                        <option value="CSK"><?php echo html_escape($this->lang->line('ltr_sub_plan_csk')); ?></option>
                        <option value="DKK"><?php echo html_escape($this->lang->line('ltr_sub_plan_dkk')); ?></option>
                        <option value="NLG"><?php echo html_escape($this->lang->line('ltr_sub_plan_nlg')); ?></option>
                        <option value="XCD"><?php echo html_escape($this->lang->line('ltr_sub_plan_xcd')); ?></option>
                        <option value="EGP"><?php echo html_escape($this->lang->line('ltr_sub_plan_egp')); ?></option>
                        <option value="FJD"><?php echo html_escape($this->lang->line('ltr_sub_plan_fjd')); ?></option>
                        <option value="FIM"><?php echo html_escape($this->lang->line('ltr_sub_plan_fim')); ?></option>
                        <option value="FRF"><?php echo html_escape($this->lang->line('ltr_sub_plan_frf')); ?></option>
                        <option value="DEM"><?php echo html_escape($this->lang->line('ltr_sub_plan_dem')); ?></option>
                        <option value="XAU"><?php echo html_escape($this->lang->line('ltr_sub_plan_xau')); ?></option>
                        <option value="GRD"><?php echo html_escape($this->lang->line('ltr_sub_plan_grd')); ?></option>
                        <option value="HKD"><?php echo html_escape($this->lang->line('ltr_sub_plan_hkd')); ?></option>
                        <option value="HUF"><?php echo html_escape($this->lang->line('ltr_sub_plan_huf')); ?></option>
                        <option value="ISK"><?php echo html_escape($this->lang->line('ltr_sub_plan_isk')); ?></option>
                        <option value="INR"><?php echo html_escape($this->lang->line('ltr_sub_plan_inr')); ?></option>
                        <option value="IDR"><?php echo html_escape($this->lang->line('ltr_sub_plan_idr')); ?></option>
                        <option value="IEP"><?php echo html_escape($this->lang->line('ltr_sub_plan_iep')); ?></option>
                        <option value="ILS"><?php echo html_escape($this->lang->line('ltr_sub_plan_ils')); ?></option>
                        <option value="ITL"><?php echo html_escape($this->lang->line('ltr_sub_plan_itl')); ?></option>
                        <option value="JMD"><?php echo html_escape($this->lang->line('ltr_sub_plan_jmd')); ?></option>
                        <option value="JPY"><?php echo html_escape($this->lang->line('ltr_sub_plan_jpy')); ?></option>
                        <option value="JOD"><?php echo html_escape($this->lang->line('ltr_sub_plan_jod')); ?></option>
                        <option value="KRW"><?php echo html_escape($this->lang->line('ltr_sub_plan_krw')); ?></option>
                        <option value="LBP"><?php echo html_escape($this->lang->line('ltr_sub_plan_lbp')); ?></option>
                        <option value="LUF"><?php echo html_escape($this->lang->line('ltr_sub_plan_luf')); ?></option>
                        <option value="MYR"><?php echo html_escape($this->lang->line('ltr_sub_plan_myr')); ?></option>
                        <option value="MXP"><?php echo html_escape($this->lang->line('ltr_sub_plan_mxp')); ?></option>
                        <option value="NLG"><?php echo html_escape($this->lang->line('ltr_sub_plan_nlg')); ?></option>
                        <option value="NZD"><?php echo html_escape($this->lang->line('ltr_sub_plan_nzd')); ?></option>
                        <option value="NOK"><?php echo html_escape($this->lang->line('ltr_sub_plan_nok')); ?></option>
                        <option value="PKR"><?php echo html_escape($this->lang->line('ltr_sub_plan_pkr')); ?></option>
                        <option value="XPD"><?php echo html_escape($this->lang->line('ltr_sub_plan_xpd')); ?></option>
                        <option value="PHP"><?php echo html_escape($this->lang->line('ltr_sub_plan_php')); ?></option>
                        <option value="XPT"><?php echo html_escape($this->lang->line('ltr_sub_plan_xpt')); ?></option>
                        <option value="PLZ"><?php echo html_escape($this->lang->line('ltr_sub_plan_plz')); ?></option>
                        <option value="PTE"><?php echo html_escape($this->lang->line('ltr_sub_plan_pte')); ?></option>
                        <option value="ROL"><?php echo html_escape($this->lang->line('ltr_sub_plan_rol')); ?></option>
                        <option value="RUR"><?php echo html_escape($this->lang->line('ltr_sub_plan_rur')); ?></option>
                        <option value="SAR"><?php echo html_escape($this->lang->line('ltr_sub_plan_sar')); ?></option>
                        <option value="XAG"><?php echo html_escape($this->lang->line('ltr_sub_plan_xag')); ?></option>
                        <option value="SGD"><?php echo html_escape($this->lang->line('ltr_sub_plan_sgd')); ?></option>
                        <option value="SKK"><?php echo html_escape($this->lang->line('ltr_sub_plan_skk')); ?></option>
                        <option value="ZAR"><?php echo html_escape($this->lang->line('ltr_sub_plan_zar')); ?></option>
                        <option value="KRW"><?php echo html_escape($this->lang->line('ltr_sub_plan_krw')); ?></option>
                        <option value="ESP"><?php echo html_escape($this->lang->line('ltr_sub_plan_esp')); ?></option>
                        <option value="XDR"><?php echo html_escape($this->lang->line('ltr_sub_plan_xdr')); ?></option>
                        <option value="SDD"><?php echo html_escape($this->lang->line('ltr_sub_plan_sdd')); ?></option>
                        <option value="SEK"><?php echo html_escape($this->lang->line('ltr_sub_plan_sek')); ?></option>
                        <option value="CHF"><?php echo html_escape($this->lang->line('ltr_sub_plan_chf')); ?></option>
                        <option value="TWD"><?php echo html_escape($this->lang->line('ltr_sub_plan_twd')); ?></option>
                        <option value="THB"><?php echo html_escape($this->lang->line('ltr_sub_plan_thb')); ?></option>
                        <option value="TTD"><?php echo html_escape($this->lang->line('ltr_sub_plan_ttd')); ?></option>
                        <option value="TRL"><?php echo html_escape($this->lang->line('ltr_sub_plan_trl')); ?></option>
                        <option value="VEB"><?php echo html_escape($this->lang->line('ltr_sub_plan_veb')); ?></option>
                        <option value="ZMK"><?php echo html_escape($this->lang->line('ltr_sub_plan_zmk')); ?></option>
                        <option value="EUR"><?php echo html_escape($this->lang->line('ltr_sub_plan_eur')); ?></option>
                        <option value="XCD"><?php echo html_escape($this->lang->line('ltr_sub_plan_xcd')); ?></option>
                        <option value="XDR"><?php echo html_escape($this->lang->line('ltr_sub_plan_xdr')); ?></option>
                        <option value="XAG"><?php echo html_escape($this->lang->line('ltr_sub_plan_xag')); ?></option>
                        <option value="XAU"><?php echo html_escape($this->lang->line('ltr_sub_plan_xau')); ?></option>
                        <option value="XPD"><?php echo html_escape($this->lang->line('ltr_sub_plan_xpd')); ?></option>
                        <option value="XPT"><?php echo html_escape($this->lang->line('ltr_sub_plan_xpt')); ?></option>
                    </select>
                </div>
                <div class="pg-input-holder">
                    <label for="price_plans"><?php echo html_escape($this->lang->line('ltr_sub_plan_mrp')); ?></label>
                    <input type="text"  value="" id="price_plans" name="price_plans">
                </div>  
                <div class="pg-input-holder">
                    <label for="interval_set"><?php echo html_escape($this->lang->line('ltr_sub_plan_interval')); ?></label>
                    <select  id="interval_set" name="interval_set">
                        <option value="7" selected="selected"><?php echo html_escape($this->lang->line('ltr_sub_plan_week')); ?></option>
                        <option value="31"><?php echo html_escape($this->lang->line('ltr_sub_plan_month')); ?></option>
                        <option value="365"><?php echo html_escape($this->lang->line('ltr_sub_plan_year')); ?></option>
                    </select>  
                </div>
                <div class="pg-input-holder">
                   <label for="plane_description"><?php echo html_escape($this->lang->line('ltr_sub_plan_desc')); ?></label>
                   <textarea id="plane_description" name="plane_description" rows="4" cols="50"></textarea>
                </div>
                <div class="pg-input-holder">
                    <button type="submit" class="pg-btn pg-btn-lg" id="create_pricing_plan"><?php echo html_escape($this->lang->line('ltr_sub_plan_creat_pln')); ?></button> 
                </div>
            </form>
        </div> 
    </div>
</div>