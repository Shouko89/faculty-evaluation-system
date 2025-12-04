<?php
if (!empty($id)) {
    $qry = $this->db->get_where("chairperson_list", array('id' => $id));
    $meta = array();
    foreach ($qry->result_array() as $row) {
        foreach ($row as $key => $val) {
            $meta[$key] = $val;
        }
    }
}
?>
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

    /* Keep original checkbox styles */
    input[type="checkbox"],
    #rlabel {
        cursor: pointer
    }

    #rlabel:hover {
        text-decoration: underline
    }

    /* ===== Dropdown Styling (Maroon & Gold) ===== */
    .styled-input.select2,
    .styled-input select {
        width: 100%;
        border: 2px solid #800000;
        border-radius: 6px;
        padding: 10px 12px;
        font-size: 15px;
        color: #333;
        background: #fffbe6;
        /* subtle gold tint */
        appearance: none;
        /* remove default arrow */
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

    /* Add custom arrow for select */
    .styled-input.select2,
    .styled-input select {
        background-image: url("data:image/svg+xml;utf8,<svg fill='%23800000' height='20' viewBox='0 0 24 24' width='20' xmlns='http://www.w3.org/2000/svg'><path d='M7 10l5 5 5-5z'/></svg>");
        background-repeat: no-repeat;
        background-position: right 12px center;
        background-size: 18px 18px;
    }

    /* Style the dropdown items (for select2 plugin) */
    .select2-container--default .select2-selection--single {
        background-color: #fffbe6;
        border: 2px solid #800000;
        border-radius: 6px;
        height: 42px;
        padding: 6px 12px;
        font-size: 15px;
        color: #333;
    }

    .select2-container--default .select2-selection--single:focus {
        border-color: #FFD700;
        box-shadow: 0 0 8px rgba(255, 215, 0, 0.7);
    }

    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: #800000;
        color: #FFD700;
    }

    .select2-dropdown {
        border: 2px solid #800000;
        border-radius: 6px;
    }
</style>

<div class="col-md-12 mb2 mt2">
    <div class="card shadow-lg border-0 rounded-lg">
        <h5 class="card-header bg-maroon text-gold py-4 d-flex align-items-center justify-content-between">
            <a href="<?php echo base_url('chairperson/list') ?>" class="text-gold" style="text-decoration:none;">
                <i class="fa fa-arrow-left"></i>
            </a>
            <span class="font-weight-bold">
                <?php echo isset($id) && $id > 0 ? "Manage Chairperson" : "New Chairperson" ?>
            </span>
            <div></div>
        </h5>

        <div class="card-body px-lg-5 pt-4">
            <form action="" id="manage-chairperson">
                <input type="hidden" name="id" value="<?php echo $id ?>">

                <div class="styled-form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="lname">Last Name</label>
                            <input type="text" id="lname" name="lname" class="styled-input"
                                value="<?php echo isset($meta['lastname']) ? $meta['lastname'] : "" ?>" required
                                placeholder="Enter last name">
                        </div>
                        <div class="col-md-4">
                            <label for="fname">First Name</label>
                            <input type="text" id="fname" name="fname" class="styled-input"
                                value="<?php echo isset($meta['firstname']) ? $meta['firstname'] : "" ?>" required
                                placeholder="Enter first name">
                        </div>
                        <div class="col-md-2">
                            <label for="middlename">Middle Name</label>
                            <input type="text" id="middlename" name="middlename" class="styled-input"
                                value="<?php echo isset($meta['middlename']) ? $meta['middlename'] : "" ?>"
                                placeholder="Optional">
                        </div>
                        <div class="col-md-2"><br></div>
                    </div>
                </div>

                <div class="row">
                    <div class="styled-form-group col-md-4">
                        <label for="id_code">ID #</label>
                        <input type="text" id="id_code" name="id_code" class="styled-input"
                            value="<?php echo isset($meta['id_code']) ? $meta['id_code'] : "" ?>" required
                            placeholder="Enter chairperson ID">
                    </div>

                    <?php if ($_SESSION['login_user_type'] == 1): ?>
                        <div class="styled-form-group col-md-4">
                            <label for="department_id">Department</label>
                            <?php $dept = $this->db->query("SELECT * from department_list where status = 1"); ?>
                            <select id="department_id" name="department_id" class="styled-input select2" required
                                data-placeholder="Select department">
                                <?php if (empty($id)): ?>
                                    <option value="" selected disabled>Select Department</option>
                                <?php endif; ?>
                                <?php foreach ($dept->result_array() as $row): ?>
                                    <option value="<?php echo $row['id'] ?>" <?php echo (isset($meta['department_id']) && $meta['department_id'] == $row['id']) ? "selected" : "" ?>>
                                        <?php echo $row['department'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <?php else: ?>
                        <input type="hidden" id="department_id" name="department_id"
                            value="<?php echo $_SESSION['login_department_id'] ?>">
                    <?php endif; ?>

                    <div class="styled-form-group col-md-4">
                        <label for="course_id">Course</label>
                        <?php
                        $course = $this->db->query("SELECT * from courses where status = 1 " . ($_SESSION['login_user_type'] != 1 ? " and department_id = {$_SESSION['login_department_id']}" : ''));
                        ?>
                        <select id="course_id" name="course_id" class="styled-input select2" required
                            data-placeholder="Select course">
                            <?php if (empty($id)): ?>
                                <option value="" selected disabled>Select Course</option>
                            <?php endif; ?>
                            <?php foreach ($course->result_array() as $row): ?>
                                <option value="<?php echo $row['id'] ?>" <?php echo (isset($meta['course_id']) && $meta['course_id'] == $row['id']) ? "selected" : "" ?>>
                                    <?php echo $row['course'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="styled-form-group col-md-4">
                        <div id="msg"></div>
                    </div>
                </div>

                <?php if ($id > 0): ?>
                    <div class="styled-form-group">
                        <label>Auto Generated Password</label>
                        <p><b><?php echo isset($meta['auto_generated']) ? $meta['auto_generated'] : '' ?></b></p>
                    </div>
                    <div class="styled-form-group">
                        <label for="regen" id="rlabel">
                            <input type="checkbox" name='regen' value="1" id="regen">
                            <small><i>Check to reset password</i></small>
                        </label>
                    </div>
                <?php endif; ?>

                <div class="styled-form-group text-center">
                    <button class="btn btn-maroon btn-sm my-4 col-md-3" type="submit">
                        <i class="fa fa-save"></i> Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $('#cl_id').change(function () {
        $('[name="department_id"]').val($('#cl_id option[value="' + $(this).val() + '"]').attr('data-did'))
    })
    $('.select2').select2({
        width: '100%'
    })
    $('input').trigger('focus')
    $('input, textarea').trigger('blur')
    $(document).ready(function () {
        if ('<?php echo $this->session->flashdata('action_save_chairperson') ?>' == 1)
            Dtoast("Data successfully added", 'success');
        $('#manage-chairperson').submit(function (e) {
            e.preventDefault()
            start_load()
            $('#msg').html('')
            var frmData = $(this).serialize();
            console.log(frmData)
            $('button[type="submit"]').attr('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Saving ...')
            $.ajax({
                url: '<?php echo base_url('chairperson/save_chairperson') ?>',
                method: 'POST',
                data: frmData,
                error: err => { console.log(err) },
                success: function (resp) {
                    resp = JSON.parse(resp)
                    if (resp.status == 1) {
                        if ('<?php echo $id ?>' > 0)
                            location.reload();
                        else {
                            location.replace('<?php echo base_url('chairperson/list') ?>')
                        }
                    } else {
                        $('#msg').html('<div class="alert alert-danger">' + resp.msg + '</div>')
                        end_load()
                    }
                }
            })
        })
    })
</script>