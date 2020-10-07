<div class = "attend-title">
    <?php echo img($images['img_re_emp_logo']) ?>
</div>

<table class="attend-table pc-width">
    <thead>
    <tr>
        <th> <?php echo img($images['img_emp_no']) ?></th>
        <th> <?php echo img($images['img_emp_name']) ?></th>
        <th> <?php echo img($images['img_re_create']) ?></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($employee as $emp): ?>
        <?php echo form_open('Admin/returnUser'); ?>
        <tr>
            <td><?php echo $emp['emp_id']; ?></td>
            <td><?php echo $emp['name']; ?></td>
            <td><button type="submit" class="submit-button" id ="punch_in" name="commit" value="1"><?php echo img($images['img_re_create_button']) ?></button></td>
            <input type="hidden" name="emp_id" value=<?php echo $emp['emp_id']; ?>>
        </tr>
        </form>
    <?php endforeach; ?>
    </tbody>
</table>
