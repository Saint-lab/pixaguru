<div class="pg-screen-container">
    <div class="pg-page-title-head">
        <h3>Suggestions (<?php echo count($suggestions); ?>)</h3>
        <a href="#create_suggestions_popup" class="pg-popup-link pg-btn">Add New</a>
    </div>
    <div class="pg-content-wrapper">
        <div class="pg-table-wrap">
            <div class="table-responsive">
                <table class="data_table_id pg-table">
                    <thead>
                        <tr>
                            <th>S.N</th>
                            <th>Suggestion</th>
                            <th>Suggestion Category</th>
                            <th>Template Category</th>
                            <th>Frontend</th>
                            <th>OTO</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
						<?php for($i=0;$i<count($suggestions);$i++){ ?>
                        <tr>
                            <td><?php echo $i + 1; ?></td>
                            <td><?php echo $suggestions[$i]['question']; ?></td>
                            <td><?php echo $suggestions[$i]['sc_name']; ?></td>
                            <td><?php echo $suggestions[$i]['tsc_name']; ?></td>
                            <td><?php echo $suggestions[$i]['frontend'] == 1 ? 'Yes' : 'No'; ?></td>
                            <td><?php echo $suggestions[$i]['oto'] == 1 ? 'Yes' : 'No'; ?></td>
                            <td>
                                <div class="pg-btn-group">
                                    <a href="<?php echo base_url(). 'admin/get_popup/suggestion/'.$suggestions[$i]['suggestion_id']; ?>" class="pg-btn pg-edit-user-link"><i class="material-icons">create</i></a>
                                    <a href="" class="pg-btn ed_delete_suggestion" data-suggestion_id="<?php echo $suggestions[$i]['suggestion_id']; ?>"><i class="material-icons">delete_forever</i></a>
                                </div>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- Modal Start  -->
<div id="create_suggestions_popup" class="pg-modal-wrapper mfp-hide">
    <div class="pg-modal-inner-row">
        <div class="pg-modal-title-wrap">
            <h3>Create new Suggestions</h3>
        </div>
        <div class="pg-modal-body">
            <div class="pg-input-holder">
                <label>Suggestions Question</label>
                <input type="text"  id="suggestion_qust">
            </div>
			<div class="pg-input-holder">
                <label>Suggestions Text(ANSWER)</label>
                <textarea rows="3"  id="suggestion_txt"></textarea>
            </div>
            <div class="pg-input-holder">
                <label>Select Suggestion Category</label>
                <select  id="s_cat_id">
					<?php for($i=0;$i<count($s_categories);$i++){ ?>
						<option value="<?php echo $s_categories[$i]['s_id']; ?>"><?php echo $s_categories[$i]['name']; ?></option>
					<?php } ?>
                </select>
            </div>
			<div class="pg-input-holder">
                <label>Select Template Category</label>
                <select  id="ts_cat_id">
					<?php for($i=0;$i<count($ts_categories);$i++){ ?>
						<option value="<?php echo $ts_categories[$i]['sub_cat_id']; ?>"><?php echo $ts_categories[$i]['name']; ?></option>
					<?php } ?>
                </select>
            </div>
			<div class="pg-input-holder">
				<div class="pg-checkbox">
                    <input type="checkbox"  id="s_frontend">
                    <label for="s_frontend">Frontend</label>
                </div>
				<div class="pg-checkbox">
                    <input type="checkbox"  id="s_otos">
                    <label for="s_otos">OTOs</label>
                </div>
            </div>
            <div class="pg-modal-btn-wrap">
				<input type="hidden"  value="" id="suggestion_id">
                <a href="" class="pg-btn pg-btn-lg" id="create_suggestion">Create</a> 
            </div>
        </div> 
    </div>
</div>