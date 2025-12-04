<?php
if(!empty($id)){
    $qry = $this->db->get_where("student_list",array('id'=>$id));
    $meta = array();
    foreach($qry->result_array() as $row){
        foreach($row as $key => $val){
            $meta[$key] = $val;
        }
    }
}
?>
<style>
    input[type="checkbox"],
    #rlabel {
        cursor: pointer;
    }
    #rlabel:hover {
        text-decoration: underline;
    }

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

    /* ===== Select2 Styling ===== */
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
</style>

<div class="col-md-12 mb2 mt2">
    <div class="card shadow-lg border-0 rounded-lg">
        <h5 class="card-header bg-maroon text-gold text-center py-4 d-flex align-items-center justify-content-between">
            <a href="<?php echo base_url('student/list') ?>" class="text-gold" style="text-decoration:none;">
                <i class="fa fa-arrow-left"></i>
            </a>
            <strong class="flex-grow-1 text-center">
                <?php echo isset($id) && $id > 0 ? "Manage Student" : "New Student" ?>
            </strong>
            <span style="width:20px;"></span>
        </h5>

        <div class="card-body px-lg-5 pt-4">
            <form action="" id="manage-student">
                <input type="hidden" name="id" value="<?php echo $id ?>">

                <div class="row">
                    <div class="col-md-4 styled-form-group">
                        <label for="lname">Last Name</label>
                        <input type="text" id="lname" name="lname" class="styled-input"
                               value="<?php echo isset($meta['lastname']) ? $meta['lastname'] : "" ?>" required
                               placeholder="Enter student's last name">
                    </div>
                    <div class="col-md-4 styled-form-group">
                        <label for="fname">First Name</label>
                        <input type="text" id="fname" name="fname" class="styled-input"
                               value="<?php echo isset($meta['firstname']) ? $meta['firstname'] : "" ?>" required
                               placeholder="Enter student's first name">
                    </div>
                    <div class="col-md-4 styled-form-group">
                        <label for="middlename">Middle Name</label>
                        <input type="text" id="middlename" name="middlename" class="styled-input"
                               value="<?php echo isset($meta['middlename']) ? $meta['middlename'] : "" ?>"
                               placeholder="Enter student's middle name (optional)">
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-4 styled-form-group">
                        <label for="student_code">ID #</label>
                        <input type="text" id="student_code" name="student_code" class="styled-input"
                               value="<?php echo isset($meta['student_code']) ? $meta['student_code'] : "" ?>" required
                               placeholder="Enter the student ID number">
                    </div>
                    <div class="col-md-4 styled-form-group">
                        <label for="cl_id">Dept/Course/Level/Section</label>
                        <?php
                        $dept = $this->db->query("SELECT c.*,concat(co.course,' ',`year`,'-',section) as cls,co.department_id from curriculum_level_list c inner join courses co on co.id = c.course_id where c.status = 1");
                        ?>
                        <select id="cl_id" name="cl_id" class="styled-input select2" required>
                            <?php if(empty($id)): ?>
                                <option value="" selected disabled>Select Dept/Course/Level/Section</option>
                            <?php endif; ?>
                            <?php foreach($dept->result_array() as $row): ?>
                                <option value="<?php echo $row['id'] ?>" data-did="<?php echo $row['department_id'] ?>"
                                    <?php echo (isset($meta['cl_id']) && $meta['cl_id']==$row['id']) ? 'selected' : '' ?>>
                                    <?php echo $row['cls'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <input type="hidden" name="department_id"
                           value="<?php echo isset($meta['department_id']) ? $meta['department_id']: '' ?>">
                    <div class="col-md-4 styled-form-group">
                        <div id="msg"></div>
                    </div>
                </div>

                <?php if($id > 0): ?>
                    <div class="styled-form-group mt-3">
                        <label>Auto Generated Password</label>
                        <p><b><?php echo isset($meta['auto_generated']) ? $meta['auto_generated'] : '' ?></b></p>
                    </div>
                    <div class="styled-form-group mb-5">
                        <label for="regen" id="rlabel">
                            <input type="checkbox" name='regen' value="1" id="regen">
                            <small><i>Check this only when you need to reset the student password to a new generated password</i></small>
                        </label>
                    </div>
                <?php endif; ?>

                <div class="text-center styled-form-group">
                    <button class="btn btn-maroon my-4 col-md-3" type="submit">
                        <i class="fa fa-save"></i> Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$('#cl_id').change(function(){
    $('[name="department_id"]').val($('#cl_id option:selected').data('did'));
});
$('.select2').select2({ width:'100%' });

$(document).ready(function(){
    if('<?php echo $this->session->flashdata('action_save_student') ?>' == 1)
        Dtoast("Data successfully added",'success');

    $('#manage-student').submit(function(e){
        e.preventDefault();
        var btn = $(this).find('button[type="submit"]');
        $('#msg').html('');
        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Saving ...');
        var frmData = $(this).serialize();
        $.ajax({
            url:'<?php echo base_url('student/save_student') ?>',
            method:'POST',
            data:frmData,
            dataType: 'json',
            error: err => {
                console.log(err);
                $('#msg').html('<div class="alert alert-danger">An error occurred. Please try again.</div>');
                btn.prop('disabled', false).html('<i class="fa fa-save"></i> Save');
            },
            success:function(resp){
                if(resp.status == 1){
                    if('<?php echo $id ?>' > 0)
                        location.reload();
                    else
                        location.replace('<?php echo base_url('student/list') ?>');
                }else{
                    $('#msg').html('<div class="alert alert-danger">'+resp.msg+'</div>');
                    btn.prop('disabled', false).html('<i class="fa fa-save"></i> Save');
                }
            }
        })
    })
});
</script>
