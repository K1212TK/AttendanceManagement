
      <div class = "create-emp-title">
          <?php echo img($images['img_create_emp']) ?>
      </div>

      <div class="inputform">
          <?php echo form_open('admin/regist_user'); ?>
              <table border="1">
                  <tr>
                      <td class = "input_form_head"><?php echo img($images['img_emp_name']) ?></td>
                      <td><input type="text" name="emp_name" style="width:200px; height:30px;" required></td>
                  </tr>
                  <tr>
                      <td class = "input_form_head"><?php echo img($images['img_birthday']) ?></td>
                      <td><input type="date" name="birthday" style="width:200px; height:30px;" required></td>
                  </tr>
              </table>
              <div align="center">
                  <button type="submit" class="input_button"><?php echo img($images['img_regist']) ?></button>
              </div>
          <?php echo form_close(); ?>
      </div>

