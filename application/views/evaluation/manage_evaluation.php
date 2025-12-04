<?php
if(!empty($id)){
    $qry = $this->db->get_where("evaluation_list",array('id'=>$id));
    $meta = array();
    foreach($qry->result_array() as $row){
        foreach($row as $key => $val){
            $meta[$key] = $val;
        }
    }
}
?>
<div class="container-fluid">
    <div class="col-md-12 mb2 mt2">

        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">

        <!-- School Year Field -->
        <div class="styled-form-group">
            <label for="school_year">School Year</label>
            <input type="text" 
                   id="school_year" 
                   name="school_year" 
                   class="styled-input" 
                   placeholder="e.g., 2025-2026" 
                   value="<?php echo isset($meta['school_year']) ? $meta['school_year'] : "" ?>" 
                   required>
        </div>

        <!-- Semester Field -->
        <div class="styled-form-group">
            <label for="semester">Semester</label>
            <input type="text" 
                   id="semester" 
                   name="semester" 
                   class="styled-input" 
                   placeholder="e.g., First Semester, Second Semester" 
                   value="<?php echo isset($meta['semester']) ? $meta['semester'] : "" ?>" 
                   required>
        </div>

    </div>
</div>

<script>
$(document).ready(function(){
    $('#school_year').trigger('focus')
    $('input, textarea').trigger('blur')
    $('input, textarea').trigger('change')

    $('#manage_evaluation').submit(function(e){
        e.stopImmediatePropagation();
        e.preventDefault()
        var frmData = $(this).serialize();
        start_load()
        $.ajax({
            url:'<?php echo base_url('evaluation/save_evaluation') ?>',
            method:'POST',
            data:frmData,
            error:err=>{ console.log(err) },
            success:function(resp){
                if(resp > 0){
                    location.replace('<?php echo base_url('evaluation/evaluation_view/') ?>'+resp)
                }
            }
        })
    })
})
</script>

<style>
/* 🎨 Maroon & Gold Theme */
.bg-maroon { background-color: #800000 !important; }
.text-maroon { color: #800000 !important; }
.text-gold { color: #FFD700 !important; }

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
}
.styled-input:focus {
    border-color: #FFD700;
    box-shadow: 0 0 8px rgba(255, 215, 0, 0.8);
    background: #fffdf5;
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
