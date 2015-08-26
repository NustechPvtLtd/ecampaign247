    
<p><?php echo lang('index_subheading');?></p>

<div id="infoMessage"><?php echo $message;?></div>

<table id="user-dataTable" class="table table-striped table-bordered  no-wrap" cellspacing="0" width="100%">

    <thead>
        <tr>
            <th><?php echo lang('index_fname_th');?></th>
            <th><?php echo lang('index_lname_th');?></th>
            <th><?php echo lang('index_email_th');?></th>
            <th><?php echo lang('index_groups_th');?></th>
            <th><?php echo lang('index_active_plan_th');?></th>
            <th><?php echo lang('index_status_th');?></th>
            <th><?php echo lang('index_created_on_th');?></th>
            <th><?php echo lang('index_last_login_th');?></th>
            <th><?php echo lang('index_action_th');?></th>
        </tr>
    </thead>

    <tfoot>
        <tr>
            <th><?php echo lang('index_fname_th');?></th>
            <th><?php echo lang('index_lname_th');?></th>
            <th><?php echo lang('index_email_th');?></th>
            <th><?php echo lang('index_groups_th');?></th>
            <th><?php echo lang('index_active_plan_th');?></th>
            <th><?php echo lang('index_status_th');?></th>
            <th><?php echo lang('index_created_on_th');?></th>
            <th><?php echo lang('index_last_login_th');?></th>
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
                        <?php echo anchor("login/edit_group/".$group->id, htmlspecialchars($group->description,ENT_QUOTES,'UTF-8')) ;?>&nbsp;&nbsp;&nbsp;
                    <?php endforeach?>
                </td>
                <td>
                    <?php echo htmlspecialchars(ucfirst($user->plans->name),ENT_QUOTES,'UTF-8') ;?>
                </td>
                <td><?php echo ($user->active) ? anchor("login/deactivate/".$user->id, lang('index_active_link')) : anchor("login/activate/". $user->id, lang('index_inactive_link'));?></td>
                <td><?php echo htmlspecialchars(date("jS M, Y, g:i a", $user->created_on),ENT_QUOTES,'UTF-8');?></td>
                <td><?php echo htmlspecialchars(($user->last_login)?date("jS M, Y, g:i a", $user->last_login):'--',ENT_QUOTES,'UTF-8');?></td>
                <td><?php 
                    echo anchor("user/profile/".$user->id, 'Edit').'&nbsp';
                    echo anchor("#", 'Login', array('onclick'=>"ajaxLogin({$user->id})")) ;
                ?></td>
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
    function ajaxLogin(user_id){
        $.blockUI();
        $.post('<?php echo site_url('ajaxLogin');?>',{id:user_id},function(data){
            $.unblockUI();
            window.location = data;
        });
    }
</script>
