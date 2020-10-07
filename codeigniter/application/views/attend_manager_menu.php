
        <div class = "attend-title">
            <?php echo img($images['img_fix_menu']) ?>
        </div>

        <table class="attend-table pc-width">
            <thead>
                <tr>
                    <th><?php echo img($images['img_emp_no']) ?></th>
                    <th><?php echo img($images['img_emp_name']) ?></th>
                    <th><?php echo img($images['img_start_day']) ?></th>
                    <th><?php echo img($images['img_finish_day']) ?></th>
                    <th><?php echo img($images['img_reflection']) ?></th>
                    <th><?php echo img($images['img_delete']) ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $res): ?>
                    <?php echo form_open('admin/fix_attend'); ?>
                        <tr>
                            <td><?php echo $res['emp_id']; ?></td>
                            <td><?php echo $res['name']; ?></td>
                            <td><input type="datetime-local" name="punch_in" value=<?php echo $res['punch_in']; ?>></td>
                            <td><input type="datetime-local" name="punch_out" value=<?php echo $res['punch_out'] ?> min=<?php echo $res['punch_in']; ?>></td>
                            <td><button type="submit" class="submit-button" name="commit" value="1"><?php echo img($images['img_reflection_button']) ?></button></td>
                            <td><button type="submit" class="submit-button" name="delete" value="2"><?php echo img($images['img_delete_button']) ?></button></td>
                            <input type="hidden" name="id" value=<?php echo $res['id']; ?>>
                            <input type="hidden" name="emp_id" value=<?php echo $res['emp_id']; ?>>
                            <input type="hidden" name="user_name" value=<?php echo $res['name']; ?>>
                        </tr>
                    <?php echo form_close(); ?>
                <?php endforeach; ?>
            </tbody>
        </table>

