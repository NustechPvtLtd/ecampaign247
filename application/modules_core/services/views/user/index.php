<table class="users" action="<?php echo site_url('services/user/ajaxLoadUserGrid')?>">
  <tr>
    <th col="username">Username</th>
    <th col="first_name">First Name</th>
    <th col="last_name">Last Name</th>
    <th col="email">Email</th>
    <th col="last_login">Last Login</th>
    <th col="created_on">Created On</th>
  </tr>
</table>
<script>
  $(document).ready(function() {
    $(".users").grid();
  });
</script>