<div class="row">
	<!-- Criteria Form -->
	<div class="col-lg-4">
		<div class="card shadow-lg border-0 rounded-lg">
			<!-- Card Header -->
			<div class="card-header bg-maroon text-gold text-center py-3">
				<b>Criteria Form</b>
			</div>

			<!-- Card Body -->
			<div class="card-body">
				<form id="manage-criteria">
					<input type="hidden" name="id">

					<!-- Criteria Name -->
					<div class="styled-form-group">
						<label for="criteria">Criteria</label>
						<input type="text" class="styled-input" name="criteria" required>
					</div>

					<!-- Parent -->
					<div class="styled-form-group">
						<label for="parent_id">Parent</label>
						<select name="parent_id" id="parent_id" class="styled-input select2">
							<option value="0">Root</option>
							<?php
							$criteria = $this->db->get_where('criteria', array('status' => 1));
							foreach ($criteria->result_array() as $row):
								?>
								<option value="<?php echo $row['id'] ?>"><?php echo $row['criteria'] ?></option>
							<?php endforeach; ?>
						</select>
					</div>

				</form>
			</div>

			<!-- Card Footer -->
			<div class="card-footer text-center">
				<button class="btn btn-primary" form="manage-criteria" type="reset">Clear</button>
				<button class="btn btn-maroon" form="manage-criteria">
					<i class="fa fa-save"></i> Save
				</button>
			</div>
		</div>
	</div>

	<!-- Criteria Tree -->
	<div class="col-lg-8">
		<div class="card shadow-lg border-0 rounded-lg">
			<div class="card-header bg-maroon text-gold py-3">
				<b>Evaluation Criteria</b>
				<button class="btn btn-sm btn-maroon float-right" id="save-order">
					<i class="fa fa-save"></i> Save Order
				</button>
			</div>
			<div class="card-body">
				<div id="criteria-tree"></div>
			</div>
		</div>
	</div>
</div>


<script>
	function createJSTrees(jsonData) {
		$("#criteria-tree").jstree('destroy');
		$('#criteria-tree').jstree({
			plugins: ["table", "dnd", "contextmenu", "crrm", "search"],

			"table": {
				columns: [{ width: 300, header: "Name" }],
				resizable: false,
			}, core: {
				"animation": 0,
				"check_callback": true,
				"themes": { "stripes": true },
				data: jsonData
			},
			contextmenu: {
				'items': customMenu
			},
		}).on('loaded.jstree', function () {
			$("#criteria-tree").jstree('open_all');
			$('.jstree-table-cell').css('margin', 'unset !important');
			var jsonNodes = $('#criteria-tree').jstree(true).get_json('#', { flat: false });
			$.each(jsonNodes, function (i, val) {
				// if($(val).attr('id') != vtype){
				// 	// console.log($(val).attr('id'));
				// }
			})

		});
	}
	window.load_list = function () {

		$.ajax({
			async: true,
			type: "GET",
			url: "<?php echo base_url(); ?>criteria/load_list",
			dataType: "json",

			success: function (json) {
				createJSTrees(json);
			},

			error: function (xhr, ajaxOptions, thrownError) {
				alert(xhr.status);
				alert(thrownError);
			}
		});
	}
	$(document).ready(function () {
		load_list()
		if ('<?php echo (!!$this->session->flashdata('action_criteria')) ? $this->session->flashdata('action_criteria') : '' ?>' == 1) {
			Dtoast("Data successfully saved.", 'success')
		}
	})
	$('#save-order').click(function () {
		start_load()
		var treeData = $('#criteria-tree').jstree(true).get_json('#', { no_state: true, flat: true });
		// set flat:true to get all nodes in 1-level json
		var jsonData = JSON.stringify(treeData);
		$.ajax({
			method: "POST",
			url: "<?php echo base_url(); ?>criteria/save_order",
			data: { 'jsonData': jsonData },
			success: (resp) => {
				Dtoast('Order successfully updated.', 'success');
				end_load()
			}
		});
	})
	function customMenu(node) {
		var is_parent = node.original.is_parent;
		if (is_parent == 1)
			return false;
		var id = node.original.id;
		// var material = material_select();
		var items = {
			'item1': {
				'label': 'Edit',
				'action': () => {
					console.log(node.original)
					$('[name="id"]').val(node.original.id)
					$('[name="criteria"]').val(node.original.text)
					$('[name="parent_id"]').val(node.original.parent).trigger('change')
				}
			},
			'item2': {
				'label': 'Delete',
				'action': () => {
					delete_data('Are you sure you want to continue deleting this data? This process cannot be undone.', 'remove_citeria', [id]);
				}
			}
		}

		// if (node.type === 'level_1') {
		//     delete items.item2;
		// } else if (node.type === 'level_2') {
		//     delete items.item1;
		// }
		// if('<?php echo isset($_SESSION['fa_arr']['ce_btn']) ? 1 : 0 ?>' == 0)
		// 	delete items.item1
		// 	if('<?php echo isset($_SESSION['fa_arr']['cd_btn']) ? 1 : 0 ?>' == 0)
		// 	delete items.item2

		return items;
	}
	function remove_citeria($id = '') {
		$.ajax({
			url: '<?php echo base_url() ?>criteria/remove',
			method: 'POST',
			data: { id: $id },
			error: err => {
				console.log(err)
				Dtoast('An error occured.', 'error')
			},
			success: function (resp) {
				if (resp == 1) {
					Dtoast('Data successfully deleted.', 'success')
					load_list()
					$('.modal').modal('hide')
				}
			}
		})
	}
	$('#manage-criteria').on('reset', function () {
		$('input:hidden').val('')
	})
	$('#manage-criteria').submit(function (e) {
		e.preventDefault()
		start_load()
		$.ajax({
			url: '<?php echo base_url('criteria/save') ?>',
			method: 'POST',
			data: $(this).serialize(),
			success: function (resp) {
				if (resp == 1) {
					location.reload()
				}
			}
		})
	})
	$(document).ready(function () {
		// Select2 with search and placeholder
		$('.select2').select2({
			width: '100%',
			placeholder: "Select Parent Criteria",
			allowClear: true
		});
	});
</script>

<style>
	/* 🎨 Maroon & Gold Theme */
	.bg-maroon {
		background-color: #800000 !important;
	}

	.text-gold {
		color: #FFD700 !important;
	}

	.card {
		border: 1px solid #FFD700;
		border-radius: 8px;
	}

	/* ===== Input & Select Styling ===== */
	.styled-form-group {
		margin-bottom: 20px;
		position: relative;
	}

	.styled-form-group label {
		font-weight: bold;
		color: #800000;
		display: block;
		margin-bottom: 6px;
	}

	.styled-input {
		width: 100%;
		border: 2px solid #800000;
		border-radius: 6px;
		padding: 10px 12px;
		font-size: 15px;
		color: #333;
		outline: none;
		transition: all 0.3s ease-in-out;
		background: #fffbe6;
		/* subtle gold tint */
	}

	.styled-input:focus {
		border-color: #FFD700;
		box-shadow: 0 0 8px rgba(255, 215, 0, 0.8);
		background: #fffdf5;
	}

	.styled-input.textarea {
		min-height: 80px;
		resize: vertical;
	}

	/* ===== Button Styling ===== */
	.btn-maroon {
		background-color: #FFD700;
		color: #800000;
		;
		border: none;
		border-radius: 6px;
		padding: 8px 16px;
		font-weight: bold;
		transition: 0.3s ease-in-out;
	}

	.btn-maroon:hover {
		background-color: #600000;
		color: #fff;
	}

	/* ===== JSTree Styling ===== */
	#criteria-tree {
		border: 2px solid #800000;
		border-radius: 6px;
		padding: 12px;
		background: #fffdf5;
	}

	.jstree-anchor {
		color: #800000 !important;
		font-weight: 500;
	}

	.jstree-anchor.jstree-clicked {
		background: #FFD700 !important;
		color: #800000 !important;
		border-radius: 4px;
		padding: 2px 6px;
	}

	/* ===== Select2 Maroon & Gold Styling ===== */
	.select2-container--default .select2-selection--single {
		background-color: #fffbe6;
		border: 2px solid #800000;
		border-radius: 6px;
		height: 42px;
		padding: 6px 12px;
		font-size: 15px;
		color: #800000;
		font-weight: bold;
	}

	.select2-container--default .select2-selection--single:focus {
		border-color: #FFD700;
		box-shadow: 0 0 8px rgba(255, 215, 0, 0.7);
	}

	.select2-container--default .select2-selection--single .select2-selection__arrow {
		height: 40px;
		right: 10px;
	}

	.select2-container--default .select2-selection--single .select2-selection__rendered {
		line-height: 30px;
		color: #800000;
		font-weight: bold;
	}

	/* Dropdown Panel */
	.select2-dropdown {
		border: 2px solid #800000;
		border-radius: 6px;
		background: #fffdf5;
	}

	/* Search box inside dropdown */
	.select2-search--dropdown .select2-search__field {
		border: 2px solid #800000;
		border-radius: 4px;
		padding: 6px 10px;
		font-size: 14px;
		outline: none;
		color: #800000;
		font-weight: bold;
	}

	.select2-search--dropdown .select2-search__field:focus {
		border-color: #FFD700;
		box-shadow: 0 0 5px rgba(255, 215, 0, 0.7);
	}

	/* Highlighted Option */
	.select2-container--default .select2-results__option--highlighted[aria-selected] {
		background-color: #800000 !important;
		color: #FFD700 !important;
		font-weight: bold;
	}

	/* Options text */
	.select2-results__option {
		font-size: 14px;
		color: #800000;
		padding: 6px 10px;
	}
</style>