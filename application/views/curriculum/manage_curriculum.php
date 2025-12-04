<?php
if (!empty($id)) {
    $qry = $this->db->get_where("curriculum_level_list", array('id' => $id));
    $meta = array();
    foreach ($qry->result_array() as $row) {
        foreach ($row as $key => $val) {
            $meta[$key] = $val;
        }
    }
}
?>
<div class="col-12 my-3">
    <div class="card shadow-lg border-0 rounded-lg">
        <!-- Card Header -->
        <h5 class="card-header bg-maroon text-gold d-flex align-items-center justify-content-between py-3 px-4">
            <!-- Back Button -->
            <a href="<?php echo base_url('curriculum') ?>" class="text-gold" style="text-decoration:none;">
                <i class="fa fa-arrow-left"></i>
            </a>

            <!-- Title -->
            <strong class="flex-grow-1 text-center mx-2">
                <?php echo isset($id) && $id > 0 ? "Manage Curriculum" : "New Curriculum" ?>
            </strong>

            <!-- Placeholder for flex alignment -->
            <span style="width:20px;"></span>
        </h5>

        <!-- Card Body -->
        <div class="card-body px-4 py-4">
            <form action="" id="manage-curriculum">

                <input type="hidden" name="id" value="<?php echo $id ?>">
                <input type="hidden" name="department_id"
                    value="<?php echo isset($meta['department_id']) ? $meta['department_id'] : '' ?>">

                <!-- Course Dropdown -->
                <div class="styled-form-group">
                    <label for="course_id">Course</label>
                    <select name="course_id" id="course_id" class="styled-input select2-dropdown" required>
                        <option value="" disabled selected>Select a course</option>
                        <?php
                        $qry = $this->db->query("SELECT * FROM courses WHERE status = 1 ORDER BY course ASC");
                        foreach ($qry->result_array() as $row):
                            ?>
                            <option value="<?php echo $row['id'] ?>" <?php echo isset($meta['course_id']) && $meta['course_id'] == $row['id'] ? 'selected' : '' ?>
                                data-did="<?php echo $row['department_id'] ?>">
                                <?php echo $row['course'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Year & Section -->
                <div class="row g-3">
                    <div class="col-md-2">
                        <div class="styled-form-group">
                            <label for="year">Year Level</label>
                            <input type="number" id="year" name="year" class="styled-input"
                                value="<?php echo isset($meta['year']) ? $meta['year'] : "" ?>"
                                placeholder="e.g., 1, 2, 3, 4" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="styled-form-group">
                            <label for="section">Section</label>
                            <input type="text" id="section" name="section" class="styled-input"
                                value="<?php echo isset($meta['section']) ? $meta['section'] : "" ?>"
                                placeholder="e.g., A, B, C" required>
                        </div>
                    </div>
                </div>

                <!-- Save Button -->
                <div class="text-center mt-4">
                    <button class="btn btn-maroon col-md-3 py-2" type="submit">
                        <i class="fa fa-save"></i> Save
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<!-- Include jQuery & Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function () {
    // Initialize Select2 with maroon-gold theme and search
    $('#course_id').select2({
        width: '100%',
        placeholder: "Select a course",
        allowClear: true
    });

    // Update department_id on course change
    $('#course_id').change(function () {
        $('[name="department_id"]').val($('#course_id option[value="' + $(this).val() + '"]').attr('data-did'))
    });

    // Submit form via AJAX
    $('#manage-curriculum').submit(function (e) {
        e.preventDefault();
        start_load();
        var frmData = $(this).serialize();
        $.ajax({
            url: '<?php echo base_url('curriculum/save_curriculum') ?>',
            method: 'POST',
            data: frmData,
            error: err => { console.log(err); end_load(); },
            success: function (resp) {
                end_load();
                if (resp == 1) {
                    location.replace('<?php echo base_url('curriculum') ?>')
                } else if (resp == 2) {
                    Dtoast("Level and Section already exist.", "warning")
                }
            }
        });
    });
});
</script>

<style>
/* 🎨 Maroon & Gold Theme */
.bg-maroon { background-color: #800000 !important; }
.text-gold { color: #FFD700 !important; }
.card { border: 1px solid #FFD700; border-radius: 8px; }
.shadow-lg { box-shadow: 0 1rem 3rem rgba(0,0,0,.175)!important; }

/* ===== Styled Input Fields ===== */
.styled-form-group { margin-bottom: 1.25rem; position: relative; }
.styled-form-group label { font-weight: bold; color: #800000; display: block; margin-bottom: 0.5rem; }
.styled-input, select.styled-input {
    width: 100%;
    border: 2px solid #800000;
    border-radius: 6px;
    padding: 0.55rem 0.75rem;
    font-size: 0.95rem;
    color: #333;
    outline: none;
    transition: all 0.3s ease-in-out;
    background: #fffbe6;
}
.styled-input:focus, select.styled-input:focus {
    border-color: #FFD700;
    box-shadow: 0 0 8px rgba(255, 215, 0, 0.7);
    background: #fffdf5;
}

/* ===== Buttons ===== */
.btn-maroon { background-color: #800000; color: #FFD700; border: none; border-radius: 6px; padding: 10px 18px; font-weight: bold; transition: 0.3s ease-in-out; }
.btn-maroon:hover { background-color: #600000; color: #fff; }

/* ===== Select2 Dropdown Maroon & Gold Theme ===== */
.select2-container--default .select2-selection--single {
    background-color: #fffbe6 !important;
    border: 2px solid #800000 !important;
    border-radius: 6px !important;
    height: 42px !important;
    padding: 6px 12px !important;
    font-size: 0.95rem !important;
    color: #333 !important;
    display: flex;
    align-items: center;
}
.select2-container--default .select2-selection--single .select2-selection__arrow { top: 8px !important; right: 10px !important; }
.select2-container--default .select2-selection--single:focus,
.select2-container--default .select2-selection--single:active {
    border-color: #FFD700 !important;
    box-shadow: 0 0 8px rgba(255, 215, 0, 0.7) !important;
}
.select2-container--default .select2-results__option--highlighted[aria-selected] { background-color: #800000 !important; color: #FFD700 !important; }
.select2-dropdown { border: 2px solid #800000 !important; border-radius: 6px !important; }
.select2-container--default .select2-search--dropdown { padding: 4px 6px !important; margin: 0 !important; }
.select2-container--default .select2-search--dropdown .select2-search__field {
    padding: 6px 8px !important;
    border: 2px solid #800000 !important;
    border-radius: 6px !important;
    background: #fffdf5 !important;
}
.select2-container--default .select2-results { margin-top: 0 !important; padding-top: 0 !important; }
</style>
