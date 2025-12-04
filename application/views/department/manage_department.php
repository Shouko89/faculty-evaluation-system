<?php
if (!empty($id)) {
    $qry = $this->db->query("SELECT * FROM department_list where id = '$id' ");
    $meta = array();
    foreach ($qry->result_array() as $row) {
        foreach ($row as $key => $val) {
            $meta[$key] = $val;
        }
    }
}
?>
<div class="col-md-12 mb2 mt2">
    <div class="card shadow-lg border-0 rounded-lg">
        <!-- Card Header -->
        <!-- Card Header -->
        <h5 class="card-header bg-maroon text-gold text-center py-4 d-flex align-items-center justify-content-between">
            <!-- Back Button -->
            <a href="<?php echo base_url('department/index') ?>" class="text-gold" style="text-decoration:none;">
                <i class="fa fa-arrow-left"></i>
            </a>

            <!-- Title -->
            <strong class="flex-grow-1 text-center">
                <?php echo isset($id) && $id > 0 ? "Manage Department" : "New Department" ?>
            </strong>

            <!-- Empty placeholder to balance flex (so title stays centered) -->
            <span style="width:20px;"></span>
        </h5>

        <!-- Card Body -->
        <div class="card-body px-lg-5 pt-4">
            <form action="" id="manage-department">

                <input type="hidden" id="id" name="id" value="<?php echo $id ?>">

                <!-- Department Name -->
                <div class="styled-form-group">
                    <label for="name">Department Name</label>
                    <input type="text" id="name" name="name" class="styled-input"
                        placeholder="Enter department name (e.g., Computer Science)"
                        value="<?php echo isset($meta['department']) ? $meta['department'] : "" ?>" required>
                </div>

                <!-- Description -->
                <div class="styled-form-group">
                    <label for="description">Description</label>
                    <textarea id="description" class="styled-input textarea" rows="3" name="description"
                        placeholder="Enter a short description of the department"
                        required><?php echo isset($meta['description']) ? $meta['description'] : "" ?></textarea>
                </div>

                <!-- Save Button -->
                <center>
                    <button class="btn btn-maroon my-4 col-md-3" type="submit">
                        <i class="fa fa-save"></i> Save
                    </button>
                </center>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#name').trigger('focus')
        $('input, textarea').trigger('blur')
        $('textarea').trigger('change')

        $('#manage-department').submit(function (e) {
            e.preventDefault()
            var frmData = $(this).serialize();
            $('button[type="submit"]').attr('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Saving ...')
            $.ajax({
                url: '<?php echo base_url('department/save_department') ?>',
                method: 'POST',
                data: frmData,
                error: err => { console.log(err) },
                success: function (resp) {
                    if (resp == 1) {
                        location.replace('<?php echo base_url('department/index/1') ?>')
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
</style>