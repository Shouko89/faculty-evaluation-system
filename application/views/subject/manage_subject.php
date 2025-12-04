<?php 
if(!empty($id)){
    $qry = $this->db->query("SELECT * FROM subjects where id = '$id' ");
    $meta = array();
    foreach($qry->result_array() as $row){
        foreach($row as $key => $val){
            $meta[$key] = $val;
        }
    }
}
?>
<div class="container-fluid">
    <div class="col-lg-12">

        <input type="hidden" id="id" name="id" value="<?php echo $id ?>">

        <!-- Name Field -->
        <div class="styled-form-group">
            <label for="name">Subject Name</label>
            <input type="text" 
                   id="name" 
                   name="name" 
                   class="styled-input" 
                   placeholder="Enter subject name (e.g., Mathematics, Science, English)" 
                   value="<?php echo isset($meta['subject']) ? $meta['subject'] : "" ?>" 
                   required>
        </div>

        <!-- Description Field -->
        <div class="styled-form-group">
            <label for="description">Description</label>
            <textarea id="description" 
                      class="styled-input textarea" 
                      rows="3" 
                      name="description" 
                      placeholder="Provide a short description about the subject (e.g., Covers algebra, geometry, and statistics)" 
                      required><?php echo isset($meta['description']) ? $meta['description'] : "" ?></textarea>
        </div>

    </div>
</div>

<script>
    $(document).ready(function(){
        $('#name').trigger('focus')
        $('input, textarea').trigger('blur')
        $('input, textarea').trigger('change')

        $('#manage-subject').submit(function(e){
            e.preventDefault()
            var frmData = $(this).serialize();
            start_load()
            $.ajax({
                url:'<?php echo base_url('subject/save_subject') ?>',
                method:'POST',
                data:frmData,
                error:err=>{ console.log(err)},
                success:function(resp){
                    if(resp == 1){
                        location.reload('')
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
