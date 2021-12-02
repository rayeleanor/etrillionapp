<div class="row">
	<div class="col-md-12">
		<section class="panel">
			<header class="panel-heading">
				<h4 class="panel-title"><i class="fas fa-user-graduate"></i> <?php echo translate('edit_fields_control');?></h4>
			</header>
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
									foreach($controlstudentform as $row):
										?>
									<tr>
										<td><?=translate($row['field_label'])?></td>
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
					url: base_url + "control_student_form/status",
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