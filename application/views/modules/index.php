<div class="row">
	<div class="col-md-12">
		
		<section class="panel appear-animation" data-appear-animation="<?php echo $global_config['animations']; ?>" data-appear-animation-delay="100">
			<div class="tabs-custom">
				<ul class="nav nav-tabs">
					<li class="active">
						<a href="#system" data-toggle="tab">
							<i class="fas fa-chalkboard-teacher"></i> 
						<span class="hidden-xs"> <?=translate('system')?></span>
						</a>
					
					</li>
					<li>
						<a href="#student" data-toggle="tab">
						<i class="fas fa-paint-roller"></i>
						<span class="hidden-xs"> <?=translate('student')?></span>
						</a>
					
					</li>
					<li>
						<a href="#parent" data-toggle="tab">
						<i class="fab fa-uikit"></i>
						<span class="hidden-xs"> <?=translate('parent')?></span>
						</a>
					</li>
				</ul>

				<div class="tab-content">
					<div class="tab-pane box active" id="system">						
						<div class="tabs-custom">
							<div class="tab-content">
								<div id="list" class="tab-pane active">
									<div class="mb-md">
										<table class="table table-bordered table-hover table-condensed mb-none table_custom">
											<thead>
												<tr>
													<th><?=translate('label')?></th>
													<th><?=translate('status_(_turn_on_if_field_is_required)')?></th>
												</tr>
											</thead>
											<tbody>
												<?php
												foreach($systemmodules as $row):
													?>
												<tr>
													<td><?=translate($row['module_name'])?></td>
													<td>
														<div class="material-switch ml-xs">
															<input class="customfield-switch" id="switch_<?=$row['id']?>" data-id="<?=$row['id']?>" name="customfield_switch<?=$row['id']?>" 
															type="checkbox" <?php echo ($row['status'] == 1 ? 'checked' : ''); ?> />
															<label for="switch_<?=$row['id']?>" class="label-primary"></label>
														</div>
													</td>
												</tr>
												<?php endforeach; ?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="tab-pane box" id="student">						
						<div class="tabs-custom">
							<div class="tab-content">
								<div id="list" class="tab-pane active">
									<div class="mb-md">
										<table class="table table-bordered table-hover table-condensed mb-none table_custom">
											<thead>
												<tr>
													<th><?=translate('label')?></th>
													<th><?=translate('status_(_turn_on_if_field_is_required)')?></th>
												</tr>
											</thead>
											<tbody>
												<?php
												foreach($studentmodules as $row):
													?>
												<tr>
													<td><?=translate($row['module_name'])?></td>
													<td>
														<div class="material-switch ml-xs">
															<input class="customfield-switch" id="switch_<?=$row['id']?>" data-id="<?=$row['id']?>" name="customfield_switch<?=$row['id']?>" 
															type="checkbox" <?php echo ($row['status'] == 1 ? 'checked' : ''); ?> />
															<label for="switch_<?=$row['id']?>" class="label-primary"></label>
														</div>
													</td>
												</tr>
												<?php endforeach; ?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="tab-pane box" id="parent">						
						<div class="tabs-custom">
							<div class="tab-content">
								<div id="list" class="tab-pane active">
									<div class="mb-md">
										<table class="table table-bordered table-hover table-condensed mb-none table_custom">
											<thead>
												<tr>
													<th><?=translate('label')?></th>
													<th><?=translate('status_(_turn_on_if_field_is_required)')?></th>
												</tr>
											</thead>
											<tbody>
												<?php
												foreach($parentmodules as $row):
													?>
												<tr>
													<td><?=translate($row['module_name'])?></td>
													<td>
														<div class="material-switch ml-xs">
															<input class="customfield-switch" id="switch_<?=$row['id']?>" data-id="<?=$row['id']?>" name="customfield_switch<?=$row['id']?>" 
															type="checkbox" <?php echo ($row['status'] == 1 ? 'checked' : ''); ?> />
															<label for="switch_<?=$row['id']?>" class="label-primary"></label>
														</div>
													</td>
												</tr>
												<?php endforeach; ?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function () {
		// custom field status
		$(".customfield-switch").on("change", function() {
			var state = $(this).prop('checked');
			var id = $(this).data('id');
			console.log(id);
			if (state != null) {
				$.ajax({
					type: 'POST',
					url: base_url + "modules/status",
					data: {
						id: id,
						status: state
					},
					dataType: "json",
					success: function(data) {
						if(data.status == true) {
							alertMsg(data.msg);
						} else {
							window.location.href = base_url + "dashboard";
						}
					}
				});
			}
		});

		$('#field_type').on('change', function() {
			var field_type = $(this).val();
			if (field_type == "dropdown") {
				$('#checkbox_type').hide("slow");
				$('#common_type').hide("slow");
				$('#dropdown_type').show("slow");
			} else if (field_type == "checkbox") {
				$('#dropdown_type').hide("slow");
				$('#common_type').hide("slow");
				$('#checkbox_type').show("slow");
			} else {
				$('#checkbox_type').hide("slow");
				$('#dropdown_type').hide("slow");
				$('#common_type').show("slow");
			}
		});
	});
</script>