<div class = "create-emp-title">
    <?php echo img($images['img_store_logo']) ?>
</div>

<div class="inputform">
    <?php echo form_open('general/loginAuth'); ?>
    <table border="1">
        <tr>
            <td class = "input_form_head"><?php echo img($images['img_user_name']) ?></td>
            <td><input type="text" name="name" style="width:200px; height:30px;" required></td>
        </tr>
        <tr>
            <td class = "input_form_head"><?php echo img($images['img_password']) ?></td>
            <td><input type="password" name="password" style="width:200px; height:30px;" required></td>
        </tr>
    </table>
    <div align="center">
        <button type="submit" class="input_button"><?php echo img($images['img_login']) ?></button>
    </div>
    <?php echo form_close(); ?>
</div>
