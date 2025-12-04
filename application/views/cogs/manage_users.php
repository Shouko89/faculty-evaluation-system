<?php
if(!empty($id)){
$user = $this->db->get_where('users',array('id'=>$id));
foreach($user->row() as $k=> $v){
    $$k = $v;
}
}
?>

<div class="container-fluid">
    <div class="col-lg-12">
        <input type="hidden" name="id" value="<?php echo $id ?>">
        <div id="msg"></div>
        
        <!-- First Name Field -->
        <div class="styled-form-group">
            <label for="firstname">First Name</label>
            <input type="text" 
                   class="styled-input" 
                   name="firstname" 
                   value="<?php echo isset($firstname) ? $firstname : '' ?>" 
                   placeholder="Enter first name" 
                   required>
        </div>

        <!-- Middle Name Field -->
        <div class="styled-form-group">
            <label for="middlename">Middle Name</label>
            <input type="text" 
                   class="styled-input" 
                   name="middlename" 
                   value="<?php echo isset($middlename) ? $middlename : '' ?>" 
                   placeholder="Enter middle name (optional)">
        </div>

        <!-- Last Name Field -->
        <div class="styled-form-group">
            <label for="lastname">Last Name</label>
            <input type="text" 
                   class="styled-input" 
                   name="lastname" 
                   value="<?php echo isset($lastname) ? $lastname : '' ?>" 
                   placeholder="Enter last name" 
                   required>
        </div>

        <!-- Username Field -->
        <div class="styled-form-group">
            <label for="username">Username</label>
            <input type="text" 
                   class="styled-input" 
                   name="username" 
                   value="<?php echo isset($username) ? $username : '' ?>" 
                   placeholder="Enter username" 
                   required>
        </div>

        <!-- Password Field -->
        <div class="styled-form-group">
            <label for="password">Password</label>
            <input type="password" 
                   class="styled-input" 
                   name="password" 
                   value="" 
                   placeholder="Enter password" 
                   <?php echo $id > 0 ? '' : 'required' ?>>
            <?php if($id > 0): ?>
                <small><i>Leave this blank if you don't want to update the password</i></small>
            <?php endif; ?>
        </div>

        <?php if($_SESSION['login_user_type'] == 1): ?>
        <!-- User Type Field -->
        <div class="styled-form-group">
            <label for="user_type">User Type</label>
            <select name="user_type" class="styled-input select2">
                <option value="1" <?php echo isset($user_type) && $user_type == 1 ? "selected": '' ?>>Admin</option>
                <option value="2" <?php echo isset($user_type) && $user_type == 2 ? "selected": '' ?>>Staff</option>
                <option value="3" <?php echo isset($user_type) && $user_type == 3 ? "selected": '' ?>>Dean</option>
            </select>
        </div>

        <!-- Department Field -->
        <div class="styled-form-group" id="not-admin" style="display:none">
            <label for="department_id">Department</label>
            <select name="department_id" class="styled-input select2">
                <option value="0" <?php echo isset($department_id) && $department_id == 0 ? "selected": '' ?>>N/A</option>
                <?php 
                    $dept = $this->db->get_where("department_list",array("status"=>1));
                    foreach($dept->result_array() as $row):
                ?>
                <option value="<?php echo $row['id'] ?>" <?php echo isset($department_id) && $department_id == $row['id'] ? "selected": '' ?>><?php echo $row['department'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <?php endif; ?>
    </div>
</div>

<script>
$(document).ready(function(){
    // Enable Select2 with search
    $('.select2').select2({
        width: '100%',
        placeholder: "Select Option",
        allowClear: true
    });

    $('input').trigger('focus')
    $('input, textarea').trigger('blur')
    $('input, textarea').trigger('change')

    $('[name="user_type"]').change(function(){
        if($(this).val() > 1){
            $('#not-admin').show()
        }else{
            $('#not-admin').hide()
        }
    })
    
    $('[name="user_type"]').trigger('change')
    
    $('#manage-users').submit(function(e){
        e.preventDefault()
        start_load()
        $('#msg').html('')
        $.ajax({
            url:'<?php echo base_url('cogs/save_users') ?>',
            method:'POST',
            data:$(this).serialize(),
            error:err=>{
                console.log(err)
                Dtoast("An error occured","error")
                    end_load()
                
            },
            success:function(resp){
                resp = JSON.parse(resp)
                if(resp.status == 1){
                    Dtoast("User's Data Successfully Saved","success")
                    setTimeout(function(){
                        location.reload();
                    },1000)
                }else{
                    $('#msg').html('<div class="alert alert-danger">'+resp.msg+'</div>')
                    end_load()
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
.text-maroon {
    color: #800000 !important;
}
.text-gold {
    color: #FFD700 !important;
}

/* ===== Input & Textarea Styling ===== */
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
    background: #fffbe6; /* subtle gold background */
    box-sizing: border-box;
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

/* ===== Select2 Styling (Maroon & Gold) ===== */
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

/* ===== Button Styling ===== */
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

/* Alert message styling */
.alert {
    border-radius: 6px;
    padding: 10px 12px;
    margin-top: 10px;
}

.alert-danger {
    background-color: #f8d7da;
    border: 1px solid #f5c6cb;
    color: #721c24;
}

/* Small text styling */
small {
    color: #666;
    font-style: italic;
    margin-top: 5px;
    display: block;
}

/* Container spacing */
.container-fluid {
    padding: 15px;
}

.col-lg-12 {
    padding: 0 15px;
}
</style>