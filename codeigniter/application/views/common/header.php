<body>

<div class = "area">
    <header>
        <?php
            if(isset($_SESSION['store_id'])){
                echo anchor('attend/index',img($images['img_header']));
            }elseif(!isset($_SESSION['store_id'])){
                echo img($images['img_header']);
            }
        ?>
        <?php
            //ログインボタンの表示
            if(isset($_SESSION['store_id']) && !isset($_SESSION['name'])){
                echo anchor('Admin/adminLoginOpen',img($images['img_login_button']));
            }elseif (isset($_SESSION['name'])){
                echo anchor('Admin/logout',img($images['img_logout_button']));
            }
            ?>
        <div class="top-menu">
            <?php if(isset($_SESSION['name'])){ ?>
            <ul>
                <!-- 従業員管理 -->
                <li><?php echo anchor('Admin/select_user_open',img($images['img_emp_regist'])); ?></li>
                <!-- 勤怠修正 -->
                <li><?php echo anchor('admin/attend_manager_open',img($images['img_attend_fix'])); ?></li>
                <!-- 勤務時間確認 -->
                <li><?php echo anchor('admin/attend_confirmation_open',img($images['img_attend_check_time'])); ?></li>
                <!-- シフト管理 -->
                <li><?php echo anchor('shift/shift_open',img($images['img_shift_menu'])); ?></li>
            </ul>
            <?php }?>
        </div>
    </header>
