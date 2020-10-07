
<div class="box30">
    <div class="box-title"> <?php echo img($images['img_info']) ?></div>
    <p>現在お知らせはありません。</p>
</div>



<div class = "attend-title">
    <?php echo img($images['img_input_attend']) ?>
</div>

<table class="attend-table">
    <thead>
    <tr>
        <th> <?php echo img($images['img_emp_no']) ?></th>
        <th> <?php echo img($images['img_emp_name']) ?></th>
        <th> <?php echo img($images['img_in_time']) ?></th>
        <th> <?php echo img($images['img_out_time']) ?></th>
        <th> <?php echo img($images['img_in']) ?></th>
        <th> <?php echo img($images['img_out']) ?></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($result as $res): ?>
        <?php echo form_open('Attend/create'); ?>
        <tr>
            <td><?php echo $res['emp_id']; ?></td>
            <td><?php echo $res['name']; ?></td>
            <td><?php echo $res['punch_in']; ?></td>
            <td><?php echo $res['punch_out'] ?></td>
            <td><button type="submit" class="submit-button" id ="punch_in" name="punch_in" value="1"><?php echo img($images['img_in_button']) ?></button></td>
            <td><button type="submit" class="submit-button" id ="punch_out" name="punch_out" value="2"><?php echo img($images['img_out_button']) ?></button></td>
            <input type="hidden" name="id" value=<?php echo $res['id']?>>
            <input type="hidden" name="emp_id" value=<?php echo $res['emp_id']; ?>>
            <input type="hidden" name="user_name" value=<?php echo $res['name']; ?>>
            <input type="hidden" name="punch_in_time" value=<?php echo $res['punch_in']; ?>>
            <input type="hidden" name="punch_out_time" value =<?php echo $res['punch_out'] ?>>
        </tr>
        </form>
    <?php endforeach; ?>
    </tbody>
</table>

