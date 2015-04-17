
<p><?php echo lang('index_subheading');?></p>

<div id="infoMessage"><?php echo $message;?></div>

<table id="user-dataTable" class="table table-striped table-bordered  no-wrap" cellspacing="0" width="100%">
    
    <thead>
        <tr>
            <th><?php echo lang('index_fname_th');?></th>
            <th><?php echo lang('index_lname_th');?></th>
            <th><?php echo lang('index_email_th');?></th>
            <th><?php echo lang('index_groups_th');?></th>
            <th><?php echo lang('index_status_th');?></th>
            <th><?php echo lang('index_action_th');?></th>
        </tr>
    </thead>

    <tfoot>
        <tr>
            <th><?php echo lang('index_fname_th');?></th>
            <th><?php echo lang('index_lname_th');?></th>
            <th><?php echo lang('index_email_th');?></th>
            <th><?php echo lang('index_groups_th');?></th>
            <th><?php echo lang('index_status_th');?></th>
            <th><?php echo lang('index_action_th');?></th>
        </tr>
    </tfoot>
    
    <tbody>
        <?php foreach ($users as $user):?>
            <tr>
                <td><?php echo htmlspecialchars($user->first_name,ENT_QUOTES,'UTF-8');?></td>
                <td><?php echo htmlspecialchars($user->last_name,ENT_QUOTES,'UTF-8');?></td>
                <td><?php echo htmlspecialchars($user->email,ENT_QUOTES,'UTF-8');?></td>
                <td>
                    <?php foreach ($user->groups as $group):?>
                        <?php echo anchor("login/edit_group/".$group->id, htmlspecialchars($group->name,ENT_QUOTES,'UTF-8')) ;?>&nbsp;&nbsp;&nbsp;
                    <?php endforeach?>
                </td>
                <td><?php echo ($user->active) ? anchor("login/deactivate/".$user->id, lang('index_active_link')) : anchor("login/activate/". $user->id, lang('index_inactive_link'));?></td>
                <td><?php echo anchor("login/edit_user/".$user->id, 'Edit') ;?></td>
            </tr>
        <?php endforeach;?>
    </tbody>

</table>

<p><?php echo anchor('create-user', lang('index_create_user_link'), array('class' => 'btn btn-primary'))?> <?php echo anchor('create-group', lang('index_create_group_link'), array('class' => 'btn btn-primary'))?></p>

<script>
    $(document).ready( function () {
        $("#user-dataTable").DataTable({
            ordering: true,
            "pageLength": 10,
            responsive: true
        });
    } );
</script>