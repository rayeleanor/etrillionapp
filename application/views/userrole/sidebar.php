<aside id="sidebar-left" class="sidebar-left">
	<div class="sidebar-header">
		<div class="sidebar-title">
			Main
		</div>
	</div>

	<div class="nano">
        <div class="nano-content">
            <nav id="menu" class="nav-main" role="navigation">
                <ul class="nav nav-main">
<?php if (is_student_loggedin()) {
    ?>
                    <!-- dashboard -->
                    <li class="<?php if ($sub_page == 'userrole/dashboard') echo 'nav-active'; ?>">
                        <a href="<?=base_url('dashboard')?>">
                            <i class="icons icon-grid"></i><span><?=translate('dashboard')?></span>
                        </a>
                    </li>
<?php } elseif (is_parent_loggedin()) {  ?>

                    <li class="nav-parent <?php if ($main_menu == 'dashboard') echo 'nav-expanded nav-active'; ?>">
                        <a>
                            <i class="icons icon-grid"></i><span><?=translate('dashboard')?></span>
                        </a>
                        <ul class="nav nav-children">
                            <li class="<?php if ($sub_page == 'userrole/dashboard' && empty(get_activeChildren_id())) echo 'nav-active'; ?>">
                                <a href="<?=base_url('parents/my_children')?>">
                                    <i class="fab fa-slideshare"></i><span><?=translate('my_children')?></span>
                                </a>
                            </li>
                            <?php if (!empty(get_activeChildren_id())): ?>
                                <li class="<?php if ($sub_page == 'userrole/dashboard') echo 'nav-active'; ?>">
                                    <a href="<?=base_url('dashboard'); ?>">
                                        <i class="fas fa-tachometer-alt"></i><span><?=translate('dashboard')?></span>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
<?php
} 
if ((is_parent_loggedin() && !empty(get_activeChildren_id())) || is_student_loggedin()) {
?>
                    <?php
                        if(is_parent_loggedin()){
                            $type = 'parent';
                        }
                        if(is_student_loggedin()){
                            $type = 'student';
                        }
                        if($this->app_lib->getCustomTable('modules', "module_name='teachers' AND module_type='$type'")['status'] == 1){
                    ?>
                    <!-- teachers -->
                    <li class="<?php if ($main_menu == 'teachers') echo 'nav-active'; ?>">
                        <a href="<?=base_url('userrole/teachers')?>">
                            <i class="icon-people icons"></i><span><?=translate('teachers')?></span>
                        </a>
                    </li>
                    <?php }?>

                    <!-- academic -->
                    <?php
                        if($this->app_lib->getCustomTable('modules', "module_name='academic' AND module_type='$type'")['status'] == 1){
                    ?>
                    <li class="nav-parent <?php if ($main_menu == 'academic') echo 'nav-expanded nav-active'; ?>">
                        <a>
                            <i class="icons icon-home" aria-hidden="true"></i><span><?=translate('academic')?></span>
                        </a>
                        <ul class="nav nav-children">
                            <!-- subject -->
                            <li class="<?php if ($sub_page == 'userrole/subject') echo 'nav-active'; ?>">
                                <a href="<?=base_url('userrole/subject')?>">
                                    <i class="fas fa-book-reader"></i><?=translate('subject')?>
                                </a>
                            </li>
							
							<!-- class schedule -->
							<li class="<?php if ($sub_page == 'userrole/class_schedule') echo 'nav-active'; ?> ">
								<a href="<?=base_url('userrole/class_schedule')?>">
									<i class="fas fa-dna"></i><span><?=translate('class') . " " . translate('schedule')?></span>
								</a>
							</li>
                        </ul>
                    </li>
                    <?php } ?>
<?php if (is_student_loggedin()) {
                        if($this->app_lib->getCustomTable('modules', "module_name='live_class_rooms' AND module_type='$type'")['status'] == 1){
                    ?>
                    <li class="<?php if ($main_menu == 'live_class') echo 'nav-active';?>">
                        <a href="<?=base_url('userrole/live_class')?>">
                            <i class="icons icon-earphones-alt"></i><span><?=translate('live_class_rooms')?></span>
                        </a>
                    </li>
<?php } } ?>
                    <!-- leave -->
                    <?php
                        if($this->app_lib->getCustomTable('modules', "module_name='leave_application' AND module_type='$type'")['status'] == 1){
                    ?>
                    <li class="<?php if ($main_menu == 'leave') echo 'nav-active'; ?>">
                        <a href="<?=base_url('userrole/leave_request')?>">
                            <i class="icons icon-docs"></i><span><?=translate('leave_application')?></span>
                        </a>
                    </li>
                    <?php } ?>

                    <!-- attachments upload -->
                    <?php
                        if($this->app_lib->getCustomTable('modules', "module_name='attachments_book' AND module_type='$type'")['status'] == 1){
                    ?>
                    <li class="<?php if ($main_menu == 'attachments') echo 'nav-active'; ?> ">
                        <a href="<?=base_url('userrole/attachments')?>">
                            <i class="icons icon-cloud-upload"></i><span><?=translate('attachments_book')?></span>
                        </a>
                    </li>
                    <?php } ?>
                    
                    <!-- homework -->
                    <?php
                        if($this->app_lib->getCustomTable('modules', "module_name='homework' AND module_type='$type'")['status'] == 1){
                    ?>
                    <li class="<?php if ($main_menu == 'homework') echo 'nav-active'; ?> ">
                        <a href="<?=base_url('userrole/homework')?>">
                            <i class="icons icon-note"></i><span><?=translate('homework')?></span>
                        </a>
                    </li>
                    <?php } ?>

                    <!-- exam master -->
                    <?php
                        if($this->app_lib->getCustomTable('modules', "module_name='exam_master' AND module_type='$type'")['status'] == 1){
                    ?>
                    <li class="nav-parent <?php if ($main_menu == 'exam') echo 'nav-expanded nav-active'; ?>">
                            <a>
                            <i class="icons icon-book-open" aria-hidden="true"></i><span><?=translate('exam_master')?></span>
                        </a>
                        <ul class="nav nav-children">
							<!-- exam schedule -->
							<li class="<?php if ($sub_page == 'userrole/exam_schedule') echo 'nav-active'; ?> ">
								<a href="<?=base_url('userrole/exam_schedule')?>">
									<i class="fas fa-dna"></i><span><?=translate('exam') . " " . translate('schedule')?></span>
								</a>
							</li>
					
                            <!-- marks -->
                            <li class="<?php if ($sub_page == 'userrole/report_card') echo 'nav-active'; ?>">
                                <a href="<?=base_url('userrole/report_card')?>">
                                    <i class="fas fa-marker"></i><span><?=translate('report_card')?></span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <?php } ?>

                    <!-- supervision -->
                    <?php
                        if($this->app_lib->getCustomTable('modules', "module_name='supervision' AND module_type='$type'")['status'] == 1){
                    ?>
                    <li class="nav-parent <?php if ($main_menu == 'supervision')  echo 'nav-expanded nav-active'; ?>">
                        <a>
                            <i class="icons icon-feed" aria-hidden="true"></i><span><?=translate('supervision')?></span>
                        </a>
                        <ul class="nav nav-children">
                            <!-- hostels -->
                            <li class="<?php if ($sub_page == 'userrole/hostels') echo 'nav-active';?>">
                                <a href="<?=base_url('userrole/hostels')?>">
                                    <i class="fas fa-store-alt"></i><span><?=translate('hostel')?></span>
                                </a>
                            </li>

                            <!-- transport -->
                            <li class="<?php if ($sub_page == 'userrole/transport_route') echo 'nav-active'; ?>">
                                <a href="<?=base_url('userrole/route')?>">
                                    <i class="fas fa-bus"></i><span><?=translate('transport')?></span>
                                </a>
                            </li>

                        </ul>
                    </li>
                    <?php } ?>

                    <!-- attendance control -->
                    <?php
                        if($this->app_lib->getCustomTable('modules', "module_name='attendance' AND module_type='$type'")['status'] == 1){
                    ?>
                    <li class="<?php if ($main_menu == 'attendance') echo ' nav-active'; ?>">
                        <a href="<?=base_url('userrole/attendance')?>">
                            <i class="icons icon-chart"></i><span><?=translate('attendance')?></span>
                        </a>
                    </li>
                    <?php } ?>

                    <?php
                        if($this->app_lib->getCustomTable('modules', "module_name='library' AND module_type='$type'")['status'] == 1){
                    ?>
                    <li class="nav-parent <?php if ($main_menu == 'library') echo 'nav-expanded nav-active';?>">
                        <a>
                            <i class="icons icon-notebook"></i><span><?=translate('library')?></span>
                        </a>
                        <ul class="nav nav-children">
                            <li class="<?php if ($sub_page == 'userrole/book') echo 'nav-active';?>">
                                <a href="<?=base_url('userrole/book')?>">
                                    <span><i class="fas fa-caret-right"></i><?=translate('books') . " " . translate('list')?></span>
                                </a>
                            </li>
                            <li class="<?php if ($sub_page == 'userrole/book_request') echo 'nav-active';?>">
                                <a href="<?=base_url('userrole/book_request')?>">
                                    <span><i class="fas fa-caret-right"></i>Issued Book</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <?php } ?>

                    <!-- events -->
                    <?php
                        if($this->app_lib->getCustomTable('modules', "module_name='events' AND module_type='$type'")['status'] == 1){
                    ?>
                    <li class="<?php if ($sub_page == 'userrole/event') echo 'nav-active'; ?> ">
                        <a href="<?=base_url('userrole/event')?>">
                            <i class="icons icon-speech"></i><span><?=translate('events')?></span>
                        </a>
                    </li>
                    <?php } ?>

                   <!-- fees history -->
                    <?php
                        if($this->app_lib->getCustomTable('modules', "module_name='fee_history' AND module_type='$type'")['status'] == 1){
                    ?>
                    <li class="<?php if ($main_menu == 'fees') echo 'nav-active';?> ">
                        <a href="<?=base_url('userrole/invoice')?>">
                            <i class="icons icon-calculator"></i><span><?=translate('fees_history')?></span>
                        </a>
                    </li>
                    <?php } ?>

                    <!-- message -->
                    <?php
                        if($this->app_lib->getCustomTable('modules', "module_name='message' AND module_type='$type'")['status'] == 1){
                    ?>
                    <li class="<?php if ($main_menu == 'message') echo 'nav-active'; ?> ">
                        <a href="<?=base_url('communication/mailbox/inbox')?>">
                            <i class="icons icon-envelope-open"></i><span><?=translate('message')?></span>
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </nav>
        </div>
<?php } ?>
		<script>
			// maintain scroll position
			if (typeof localStorage !== 'undefined') {
				if (localStorage.getItem('sidebar-left-position') !== null) {
					var initialPosition = localStorage.getItem('sidebar-left-position'),
						sidebarLeft = document.querySelector('#sidebar-left .nano-content');
					sidebarLeft.scrollTop = initialPosition;
				}
			}
		</script>
	</div>
</aside>
<!-- end sidebar -->