<?php 
if(!empty($id)){
    $qry = $this->db->get_where("faculty_list",array('id'=>$id));
    $meta = array();
    foreach($qry->result_array() as $row){
        foreach($row as $key => $val){
            $meta[$key] = $val;
        }
    }
}
?>
<div class="col-md-12 mb2 mt2">

    <input type="hidden" name="id" value="<?php echo $id ?>">

    <!-- Last Name -->
    <div class="styled-form-group">
        <label for="lname">Last Name</label>
        <input type="text" 
               id="lname" 
               name="lname" 
               class="styled-input" 
               placeholder="e.g. Dela Cruz" 
               value="<?php echo isset($meta['lastname']) ? $meta['lastname'] : "" ?>" 
               required>
    </div>

    <!-- First Name -->
    <div class="styled-form-group">
        <label for="fname">First Name</label>
        <input type="text" 
               id="fname" 
               name="fname" 
               class="styled-input" 
               placeholder="e.g. Juan" 
               value="<?php echo isset($meta['firstname']) ? $meta['firstname'] : "" ?>" 
               required>
    </div>

    <!-- Prefix -->
    <div class="styled-form-group">
        <label for="pref">Prefix <small>(SR., Jr.)</small></label>
        <input type="text" 
               id="pref" 
               name="pref" 
               class="styled-input" 
               placeholder="e.g. Jr." 
               value="<?php echo isset($meta['name_pref']) ? $meta['name_pref'] : "" ?>">
    </div>

    <!-- Department -->
    <?php if($_SESSION['login_user_type'] == 1): ?>
    <div class="styled-form-group">
        <label for="department">Department</label>
        <?php
            $dept = $this->db->query("SELECT * from department_list where status = 1");
        ?>
        <select id="department" 
                name="department" 
                class="styled-input select2" 
                required>
            <?php if(empty($id)): ?>
                <option value="" selected disabled>Select Department</option>
            <?php endif; ?>
            <?php
                foreach($dept->result_array() as $row){
                    if(isset($meta['department_id']) && $meta['department_id'] == $row['id'])
                        echo "<option value='".$row['id']."' selected>".$row['department']."</option>";
                    else
                        echo "<option value='".$row['id']."'>".$row['department']."</option>";
                }
            ?>
        </select>
    </div>
    <?php else: ?>
    <input type="hidden" id="department" name="department" value="<?php echo $_SESSION['login_department_id'] ?>">
    <?php endif; ?>

</div>


<script>
$(document).ready(function(){
    // Enable Select2 with search
    $('.select2').select2({
        width: '100%',
        placeholder: "Select Department",
        allowClear: true
    });

    $('input').trigger('focus')
    $('input, textarea').trigger('blur')
    $('input, textarea').trigger('change')

    $('#manage-faculty').submit(function(e){
        e.preventDefault()
        var frmData = $(this).serialize();
        start_load()
        $.ajax({
            url:'<?php echo base_url('faculty/save_faculty') ?>',
            method:'POST',
            data:frmData,
            error:err=>{ console.log(err)},
            success:function(resp){
                if(resp == 1){
                    location.reload()
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
    background: #fffbe6;
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
</style>
