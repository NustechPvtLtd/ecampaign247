<div class="box box-primary no-top-border">
    <div class="box-header">
        <h4>Account Upgrade List</h4>
    </div>
    <div class="box-body">
            <div class="box-info">
                <?php echo $message;?>
            </div>
        <table id="account-upgrade-dataTable" class="table table-striped table-bordered  no-wrap" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Upgrade By</th>
                    <th>Note</th>
                    <th>Upgrade From</th>
                    <th>Upgrade To</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>Name</th>
                    <th>Upgrade By</th>
                    <th>Note</th>
                    <th>Upgrade From</th>
                    <th>Upgrade To</th>
                    <th>Date</th>
                </tr>
            </tfoot>
            <tbody>
                <?php if (!empty($upgrade_list)):?>
                <?php foreach ($upgrade_list as $list):?>
                <tr>
                    <td><?php echo htmlspecialchars($this->ion_auth->get_user_name($list->user_id),ENT_QUOTES,'UTF-8');?></td>
                    <td><?php echo htmlspecialchars(ucfirst($list->upgrade_by),ENT_QUOTES,'UTF-8');?></td>
                    <td><?php echo htmlspecialchars(ucfirst($list->notes),ENT_QUOTES,'UTF-8');?></td>
                    <td><?php echo htmlspecialchars($this->plans_model->get_plan_name($list->upgrade_from),ENT_QUOTES,'UTF-8');?></td>
                    <td><?php echo htmlspecialchars($this->plans_model->get_plan_name($list->upgrade_to),ENT_QUOTES,'UTF-8');?></td>
                    <td><?php echo date("M jS, Y",$list->date);?></td>
                </tr>
                <?php endforeach;?>
                <?php endif;?>
            </tbody>
        </table>
    </div>
    <div class="box-footer">
       <?php // echo anchor('plans/create', lang('plan_create'), array('class' => 'btn btn-primary'))?> 
    </div>
</div>
<script>
    $(document).ready( function () {
        $("#account-upgrade-dataTable").DataTable({
            ordering: true,
            "pageLength": 10,
            responsive: true
        });
    } );
</script>
