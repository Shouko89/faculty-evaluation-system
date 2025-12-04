<?php
$meta = array();
if (!empty($id)) {
    $meta = $this->db->query("SELECT * FROM courses WHERE id = ?", [$id])->row_array();
}
?>
<div class="col-md-12 mb2 mt2">
    <div class="card shadow-lg border-0 rounded-lg">
        <!-- Card Header -->
        <h5 class="card-header bg-maroon text-gold py-4 d-flex align-items-center justify-content-between">
            <!-- Back Button -->
            <a href="<?php echo base_url('course/index') ?>" class="text-gold" style="text-decoration:none;">
                <i class="fa fa-arrow-left"></i>
            </a>

            <!-- Title -->
            <strong class="flex-grow-1 text-center">
                <?php echo isset($id) && $id > 0 ? "Manage Course" : "New Course" ?>
            </strong>

            <!-- Empty placeholder for spacing -->
            <span style="width:20px;"></span>
        </h5>

        <!-- Card Body -->
        <div class="card-body px-lg-5 pt-4">
            <form action="" id="manage-course">

                <input type="hidden" id="id" name="id" value="<?php echo $id ?>">

                <!-- Department Select -->
                <?php if ($_SESSION['login_user_type'] == 1): ?>
                    <div class="styled-form-group">
                        <label for="department_id">Department</label>
                        <select name="department_id" id="department_id" class="styled-input select2" required>
                            <option disabled selected value="">🔽 Please select a department</option>
                            <?php
                            $qry = $this->db->query("SELECT * FROM department_list WHERE status = 1 ORDER BY department ASC");
                            foreach ($qry->result_array() as $row):
                                ?>
                                <option value="<?php echo $row['id'] ?>" <?php echo isset($meta['department_id']) && $meta['department_id'] == $row['id'] ? 'selected' : '' ?>>
                                    <?php echo $row['department'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                <?php else: ?>
                    <input type="hidden" id="department_id" name="department_id"
                        value="<?php echo $_SESSION['login_department_id'] ?>">
                <?php endif; ?>

                <!-- Course Name -->
                <div class="styled-form-group">
                    <label for="name">Course Name</label>
                    <input type="text" id="name" name="name" class="styled-input"
                        placeholder="e.g. Introduction to Computer Science"
                        value="<?php echo isset($meta['course']) ? $meta['course'] : "" ?>" required>
                </div>

                <!-- Description -->
                <div class="styled-form-group">
                    <label for="description">Description</label>
                    <textarea id="description" class="styled-input textarea" rows="3" name="description"
                        placeholder="Briefly describe this course (e.g. Covers basics of programming and algorithms)"
                        required><?php echo isset($meta['description']) ? $meta['description'] : "" ?></textarea>
                </div>

                <!-- Save Button -->
                <div class="styled-form-group text-center">
                    <button class="btn btn-maroon my-4 col-md-3" type="submit">
                        <i class="fa fa-save"></i> Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        // Enable Select2 with placeholder + search
        $('.select2').select2({
            width: '100%',
            placeholder: "Select Department",
            allowClear: true
        });

        $('#name').trigger('focus')
        $('input, textarea, select').trigger('blur')
        $('textarea, select').trigger('change')

        $('#manage-course').submit(function (e) {
            e.preventDefault()
            var frmData = $(this).serialize();
            $('button[type="submit"]').attr('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Saving ...')
            $.ajax({
                url: '<?php echo base_url('course/save_course') ?>',
                method: 'POST',
                data: frmData,
                error: err => {
                    console.log(err);
                    alert("An error occurred. Please try again.");
                    $('button[type="submit"]').attr('disabled', false).html('<i class="fa fa-save"></i> Save');
                },
                success: function (resp) {
                    if (resp == 1) {
                        location.replace('<?php echo base_url('course/index/1') ?>')
                    } else {
                        alert("Failed to save course. Please try again.");
                        $('button[type="submit"]').attr('disabled', false).html('<i class="fa fa-save"></i> Save');
                    }
                }
            })
        })
    })
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

    /* ===== Styled Input Fields ===== */
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
        box-shadow: 0 0 8px rgba(255, 215, 0, 0.7);
        background: #fffdf5;
    }

    .styled-input.textarea {
        min-height: 80px;
        resize: vertical;
    }

    /* ===== Dropdown Styling (with select2 support) ===== */
    .styled-input.select2,
    .styled-input select {
        width: 100%;
        border: 2px solid #800000;
        border-radius: 6px;
        padding: 10px 12px;
        font-size: 15px;
        color: #333;
        background: #fffbe6;
        appearance: none;
        outline: none;
        transition: all 0.3s ease-in-out;
        cursor: pointer;
    }

    .styled-input.select2:focus,
    .styled-input select:focus {
        border-color: #FFD700;
        box-shadow: 0 0 8px rgba(255, 215, 0, 0.7);
        background: #fffdf5;
    }

    /* Custom arrow for native selects */
    .styled-input select {
        background-image: url("data:image/svg+xml;utf8,<svg fill='%23800000' height='20' viewBox='0 0 24 24' width='20' xmlns='http://www.w3.org/2000/svg'><path d='M7 10l5 5 5-5z'/></svg>");
        background-repeat: no-repeat;
        background-position: right 12px center;
        background-size: 18px 18px;
        padding-right: 40px;
    }

    .select2-container--default .select2-selection--single {
        background-color: #fffbe6 !important;
        border: 2px solid #800000 !important;
        border-radius: 6px !important;
        height: 42px !important;
        padding: 6px 12px !important;
        font-size: 15px !important;
        color: #333 !important;
        display: flex;
        align-items: center;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        top: 8px !important;
        right: 10px !important;
    }

    .select2-container--default .select2-selection--single:focus,
    .select2-container--default .select2-selection--single:active {
        border-color: #FFD700 !important;
        box-shadow: 0 0 8px rgba(255, 215, 0, 0.7) !important;
    }

    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: #800000 !important;
        color: #FFD700 !important;
    }

    .select2-dropdown {
        border: 2px solid #800000 !important;
        border-radius: 6px !important;
    }

    /* ===== Buttons ===== */
    .btn-maroon {
        background-color: #800000;
        color: #FFD700;
        border: none;
        border-radius: 6px;
        padding: 10px 18px;
        font-weight: bold;
        transition: 0.3s ease-in-out;
    }

    .btn-maroon:hover {
        background-color: #600000;
        color: #fff;
    }

    /* 🛠 Fix extra blank space under Select2 search box */
    .select2-container--default .select2-search--dropdown {
        padding: 4px 6px !important;
        margin: 0 !important;
    }

    .select2-container--default .select2-search--dropdown .select2-search__field {
        padding: 6px 8px !important;
        border: 2px solid #800000 !important;
        border-radius: 6px !important;
        background: #fffdf5 !important;
    }

    .select2-container--default .select2-results {
        margin-top: 0 !important;
        padding-top: 0 !important;
    }
</style>