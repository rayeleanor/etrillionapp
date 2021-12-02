<div class="row">
    
	<div class="col-md-12">
		<section class="panel">
			<header class="panel-heading">
				<h4 class="panel-title"><i class="fa fa-search"></i><?=translate('select_criteria')?></h4>
			</header>
			<div class="tabs-custom">
				<div class="tab-content">
					<div id="list" class="tab-pane active">
						<div class="mb-md">
              <?= form_open('multi_class_student/index'); ?>
              <div class="box-body">
                <div class="row">
                  <div class="col-lg-4 col-md-4">
                    <div class="form-group">
                      <label for="exampleInputEmail1"><?=translate('branch')?></label><small class="req"> *</small>
                      <select autofocus="" id="branch_id" name="branch_id" onchange="getClassByBranch(this.value)" class="form-control" >
                        <option value=""><?=translate('select')?></option>
                        <?php
                        foreach ($branchlist as $branch) {
                          ?>
                          <option value="<?php echo $branch['id'] ?>" <?php
                          if (set_value('branch_id') == $branch['id']) {
                            echo "selected=selected";
                          }
                          ?>><?php echo $branch['name'] ?></option>
                              <?php
                            }
                            ?>
                      </select>
                      <span class="text-danger"><?=form_error('class_id')?></span>
                    </div>
                  </div>
                  <div class="col-lg-4 col-md-4">
                    <div class="form-group">
                      <label for="exampleInputEmail1"><?=translate('class')?></label><small class="req"> *</small>
                      <select autofocus="" id="class_id" name="class_id" onchange="getSectionByClass(this.value,0)" class="form-control" >
                        <option value=""><?=translate('select_branch_first')?></option>
                      </select>
                      <span class="text-danger"><?=form_error('class_id')?></span>
                    </div>
                  </div>
                  <div class="col-lg-4 col-md-4">
                    <div class="form-group">
                      <label for="exampleInputEmail1"><?=translate('section')?></label><small class="req"> *</small>
                      <select  id="section_id" name="section_id" class="form-control" >
                        <option value=""><?=translate('select_class_first')?></option>
                      </select>
                      <span class="text-danger"><?=form_error('section_id')?></span>
                    </div>
                  </div>
                  <div class="col-sm-12">
                    <button type="submit" class="btn btn-primary btn-sm pull-right"><i class="fa fa-search"></i> <?=translate('search')?></button>
                  </div>
                </div>
              </div>
              <?= form_close() ?>
            </div>
          </div>
        </div>
      </div>
    </section>
			<?php
			if (isset($students)) {
				?>

		<section class="panel">
			<header class="panel-heading">
				<h4 class="panel-title"><i class="fa fa-search"></i><?=translate('criteria')?></h4>
			</header>
			<div class="tabs-custom">
				<div class="tab-content">
					<div id="list" class="tab-pane active">
						<div class="mb-md">
						<div class="row">
							<?php
							foreach ($students as $student_key => $student_value) {
								?>
								<?= form_open('multi_class_student/save', array('class' => 'update')); ?>
									<div class="col-md-6">
										<div class="panel panel-info">
											<div class="panel-body panelheight">

												<?php
											echo $student_value['fullname']." (".$student_value['register_no'].")";
												?>
												<input type="hidden" value="<?php echo $student_value['id'] ?>" name="student_id">
												<input type="hidden" value="<?php echo $student_value['branch_id'] ?>" name="branch_id">
												<input type="hidden" value="<?php echo count($student_value['student_sessions']) + 1; ?>" name="nxt_row" class="nxt_row">
												<div class="row">
													<div class="text-center">

														<div class="col-xs-12 col-xs-offset-0 col-sm-3 col-sm-offset-9">
															<?php if(get_permission('multi_class_student', 'is_add')){ ?>
															<button type="button" class="btn btn-default btn-sm pull-right addrow addrow-mb2010">
																<i class="fa fa-plus"></i>
															</button>
														<?php }?>
														</div>
													</div>
												</div>
												<div class="append_row pluscolmn">

													<?php
													if (!empty($student_value['student_sessions'])) {
														$count = 1;
														foreach ($student_value['student_sessions'] as $student_session_key => $student_session_value) {
															?>
															<div class="row">
																<input type="hidden" name="row_count[]" value="<?php echo $count; ?>">
																<div class="col-sm-5 col-lg-5 col-md-4">
																	<div class="form-group">
																		<label for="email"><?=translate('class')?></label> 
																		<select name="class_id_<?php echo $count; ?>" class="form-control class_id" >
																			<option value=""><?=translate('select')?></option>
																			<?php
																			foreach ($classlist as $class) {
																				?>
																				<option value="<?php echo $class['id'] ?>" <?php echo set_select('class_id_' . $count, $class['id'], ($class['id'] == $student_session_value->class_id) ? true : false); ?>><?php echo $class['name'] ?></option>
																				<?php
																			}
																			?>
																		</select>
																	</div>
																</div>
																<div class="col-sm-5 col-lg-5 col-md-4">
																	<label for="email"><?=translate('section')?></label>
																	<div class="form-group">
																		<select name="section_id_<?php echo $count; ?>" class="form-control section_id">
																			<option value=""><?=translate('select')?></option>
																			<?php
																			// echo getSectionByClasses($classes, $student_session_value->class_id, $student_session_value->section_id);
																			?>
																		</select>

																	</div>
																</div>
																<div class="col-sm-2 col-lg-2 col-md-4">
																	<div class="form-group"><label for="email" style="opacity: 0;"><?=translate("actino")?></label>
																		<?php if(get_permission('multi_class_student', 'is_delete')){ ?>
																		<button class="btn btn-sm btn-danger rmv_row" type="button"><?=translate('remove')?></button>
																	<?php } ?>
																	</div>
																</div>
															</div>

															<?php
															$count++;
														}
													}
													?>

												</div>
											</div>
											<div class="panel-footer" style="margin: 0">
												<div class="row text-center">

										<div class="col-xs-12 col-xs-offset-0 col-sm-3 col-sm-offset-9">
														<?php if(get_permission('multi_class_student', 'can_edit')){ ?>
                            <input type="submit" class="btn btn-default btn-sm pull-right update-btn" value="<?=translate('update')?>">
													<?php } ?>
													</div>
												</div>
											</div>
										</div>
									</div>
								<?= form_close()?>
								<?php
							}
							?>

						</div>
					</div>


				</div>
						</div>
					</div>
				</div>
			</div>
		</section>
				<?php
			} else {
				
			}
			?>
	</div>
</div>


<?php

function getSectionByClasses($classes, $class_selected, $section_selected) {

    $options = "";
    foreach ($classes as $key => $value) {
        if ($value['id'] == $class_selected) {
            if (!empty($value['sections'])) {
                foreach ($value['sections'] as $section_key => $section_value) {
                    $selected = "";
                    if ($section_value['section_id'] == $section_selected) {
                        $selected = "selected='selected'";
                    }
                    $options .= "<option value='" . $section_value['section_id'] . "' " . $selected . ">" . $section_value['name'] . "</option>";
                }
            }
        }
    }
    return $options;
}
?>

<script type="text/javascript">
    // this is the id of the form

    $(document).on('submit', '.update', function (e) {
        var submit_btn = $(this).find("button[type=submit]");
        e.preventDefault(); // avoid to execute the actual submit of the form.

        var form = $(this);
        var url = form.attr('action');

        $.ajax({
            type: "POST",
            url: url,
            data: form.serialize(), // serializes the form's elements.
            dataType: "json",
            beforeSend: function () {
                submit_btn.button('loading');
            },
            success: function (data)
            {
                if (data.status == 1) {
                    alertMsg(data.message);
                }
            },
            error: function (xhr) { // if error occured
                alert("Error occured.please try again");
            },
            complete: function () {
                submit_btn.button('reset');
            }
        });


    });

</script>
<script type="text/javascript">
 $(document).on('click', '.rmv_row', function (e) {
        $(this).closest( "div.row" ).remove();
    });

    var class_id = '<?php echo set_value('class_id', 0) ?>';
    var section_id = '<?php echo set_value('section_id', 0) ?>';
    getSectionByClass(class_id, section_id);
    $(document).on('change', '#class_id', function (e) {
        $('#section_id').html("");
        var class_id = $(this).val();
        getSectionByClass(class_id, 0);
    });

    $(document).on('change', '.class_id', function (e) {        
        var class_id = $(this).val();
        console.log(class_id);
        var target_dropdown = $(this).closest("div.row").find('select.section_id');
        target_dropdown.html("");
        var div_data = '<option value=""><?=translate("select")?></option>';
        $.ajax({
            type: "POST",
            url:  base_url + 'ajax/getSectionByMultiClass',
            data: {'class_id': class_id},
            dataType: "json",
            beforeSend: function () {
                target_dropdown.html("").addClass('dropdownloading');
            },
            success: function (data) {
                $.each(data, function (i, obj)
                {
                    var sel = "";
                    if (section_id == obj.section_id) {
                        sel = "selected";
                    }
                    div_data += "<option value=" + obj.section_id + ">" + obj.section_name + "</option>";
                });
                target_dropdown.append(div_data);
            },
            complete: function () {
                target_dropdown.removeClass('dropdownloading');
            }
        });
    });

    function getSectionByClass(class_id, section_id) {
        if (class_id != 0 && class_id !== "") {
            $('#section_id').html("");
            var div_data = '<option value=""><?=translate("select")?></option>';
            $.ajax({
                type: "GET",
                url: base_url + 'ajax/getSectionByMultiClass',
                data: {'class_id': class_id},
                dataType: "json",
                beforeSend: function () {
                    $('#section_id').addClass('dropdownloading');
                },
                success: function (data) {
                    $.each(data, function (i, obj)
                    {
                        var sel = "";
                        if (section_id == obj.section_id) {
                            sel = "selected";
                        }
                        div_data += "<option value=" + obj.section_id + " " + sel + ">" + obj.section_name + "</option>";
                    });
                    $('#section_id').append(div_data);
                },
                complete: function () {
                    $('#section_id').removeClass('dropdownloading');
                }
            });
        }
    }

    $(document).on('click', '.addrow', function () {
        var container = $(this).closest(".panel-body").find('.append_row');
        var nxt_row = $(this).closest(".panel-body").find('.nxt_row').val();
        var new_class_dropdown = $('#class_dropdown').html().replace("class_id", "class_id_" + nxt_row);
        var new_section_dropdown = $('#section_dropdown').html().replace("section_id", "section_id_" + nxt_row);
        var $newDiv = $('<div>').addClass('row').append(
                $('<input>', {type: 'hidden', name: 'row_count[]', val: parseInt(nxt_row)})).append(
                $('<div>').addClass('col-sm-5 col-lg-5 col-md-4').append($('<div>').addClass('form-group').append($('<label>').html('<?php echo $this->lang->line("class"); ?>')).append(new_class_dropdown))
                ).append(
                $('<div>').addClass('col-sm-5 col-lg-5 col-md-4').append($('<div>').addClass('form-group').append($('<label>').html('<?php echo $this->lang->line("section"); ?>')).append(new_section_dropdown))
                ).append(
                $('<div>').addClass('col-sm-2 col-lg-2 col-md-4').append($('<div>').addClass('form-group').append($('<label>',{ css: {'opacity': 0}}).html('Action')).append(
                      
                    <?php
                      if(get_permission('multi_class_student','is_delete')){ ?>
                  
                    $('<button>').html('<?=translate("remove")?>').addClass('btn btn-sm btn-danger rmv_row')
                    <?php }
                    ?>
                    )));

        $(this).closest(".panel-body").find('.nxt_row').val(parseInt(nxt_row) + 1);
        $newDiv.appendTo(container);

    });
</script>
<script type="text/template" id="class_dropdown">

    <select name="class_id" class="form-control class_id">
    <option value=""><?=translate("select")?></option>
    <?php
    foreach ($classlist as $class) {
        ?>
        <option value="<?php echo $class['id'] ?>"><?php echo $class['name'] ?></option>
        <?php
    }
    ?>
    </select>
</script>
<script type="text/template" id="section_dropdown">

    <select name="section_id" class="form-control section_id" autocomplete="off">
    <option value=""><?=translate("select")?></option>
    </select>
</script>