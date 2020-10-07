
    <div class = "attend-title">
        <?php echo img($images['img_check_time']) ?>
    </div>

    <table class="attend-table">
        <thead>
        <tr>
            <th><?php echo img($images['img_emp_no']) ?></th>
            <th><?php echo img($images['img_emp_name']) ?></th>
            <th><?php echo img($images['img_total_attend_time']) ?></th>
            <th><?php echo img($images['img_total_attend_day']) ?></th>
        </tr>
        </thead>
        <tbody>
            <?php foreach ($result as $res): ?>
                <tr>
                    <td><?php echo $res['emp_id']; ?></td>
                    <td><?php echo $res['name']; ?></td>
                    <td><?php echo $res['workingTime']; ?></td>
                    <td><?php echo $res['workingDay']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="select-bar">
        <p><?php echo img($images['img_between_search']) ?></p>
        <?php echo form_open('admin/year_search'); ?>
            <select name="year">
                <?php for($i = $startYear;$i <= $endYear; $i++){ ?>
                    <option name='year' value=<?php echo $i; ?>><?php echo $i."年"; ?></option>
                <?php } ?>
            </select>
        <div align="center">
            <button type="submit" class="input_button"><?php echo img($images['img_search']) ?></button>
        </div>
        <?php echo form_close(); ?>
    </div>
