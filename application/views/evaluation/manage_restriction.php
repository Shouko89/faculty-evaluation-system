<?php
if($fid > 0){
    $qry = $this->db->query("SELECT * from restriction_list where faculty_id = $fid and evaluation_id = $eid ");
    $cids = array_column($qry->result_array(),'curriculum_id','id');
}
?>
<div class="container-fluid">
    <div class="col-lg-12">

        <input type="hidden" name="eid" value="<?php echo $eid ?>">

        <!-- Form Card -->
        <div class="card shadow-sm rounded-lg p-3 mb-3">
            <div class="row">

                <!-- Faculty Selection -->
                <div class="col-md-4 mb-3 styled-form-group">
                    <label for="faculty_id" class="text-maroon font-weight-bold">Faculty</label>
                    <select name="faculty_id" id="faculty_id" class="select2 styled-input" required>
                        <option value=""></option>
                        <?php 
                            $faculty = $this->db->query("SELECT *,concat(firstname,' ', lastname,' ',name_pref) as name 
                                FROM faculty_list 
                                WHERE status = 1 AND id NOT IN (SELECT faculty_id FROM restriction_list WHERE evaluation_id = '$eid' AND faculty_id!='$fid')");
                            foreach($faculty->result_array() as $row):
                        ?>
                            <option value="<?php echo $row['id'] ?>" <?php echo isset($fid) && $fid == $row['id'] ? 'selected' : '' ?>>
                                <?php echo ucwords($row['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Class Selection -->
                <div class="col-md-4 mb-3 styled-form-group">
                    <label for="cl_id" class="text-maroon font-weight-bold">Class</label>
                    <select id="cl_id" class="select2 styled-input" required>
                        <?php 
                            $cl = $this->db->query("SELECT c.*,concat(co.course,' ',`year`,'-',section) as cls,co.department_id 
                                FROM curriculum_level_list c 
                                INNER JOIN courses co ON co.id = c.course_id 
                                WHERE c.status = 1");
                            foreach($cl->result_array() as $row):
                        ?>
                            <option value="<?php echo $row['id'] ?>" <?php echo isset($cids) && in_array($row['id'],$cids) ?"selected" : '' ?>> 
                                <?php echo $row['cls'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Subject Selection -->
                <div class="col-md-4 mb-3 styled-form-group">
                    <label for="subject" class="text-maroon font-weight-bold">Subject</label>
                    <select id="subject" class="select2 styled-input" required>
                        <?php 
                            $subject = $this->db->query("SELECT * FROM `subjects` WHERE status = 1");
                            foreach($subject->result_array() as $row):
                        ?>
                            <option value="<?php echo $row['id'] ?>"> <?php echo $row['subject'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

            </div>

            <button class="btn btn-maroon btn-sm float-right mt-2" type="button" id="add_to_list">
                Add to List
            </button>
        </div>

        <!-- Restriction List Table -->
        <div class="card shadow-sm rounded-lg p-3">
            <h5 class="text-maroon font-weight-bold mb-3">Restriction List</h5>
            <table class="table table-bordered mb-0" id="r-list">
                <thead class="bg-maroon text-gold">
                    <tr>
                        <th>Class</th>
                        <th>Subject</th>
                        <th width="5%"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $list = $this->db->query("SELECT r.*,concat(co.course,' ' ,c.`year`,'-',c.section) as cl,s.subject 
                        FROM restriction_list r 
                        INNER JOIN curriculum_level_list c ON c.id = r.curriculum_id 
                        INNER JOIN courses co ON co.id = c.course_id 
                        INNER JOIN subjects s ON s.id = r.subject_id 
                        WHERE r.evaluation_id = '$eid' AND r.faculty_id ='$fid'  
                        ORDER BY concat(co.course,' ' ,c.`year`,'-',c.section) ASC ");
                    foreach($list->result_array() as $row):
                    ?>
                    <tr>
                        <td><input name="cl_id[]" type="hidden" value="<?php echo $row['curriculum_id'] ?>"><?php echo $row['cl'] ?></td>
                        <td><input name="subject_id[]" type="hidden" value="<?php echo $row['subject_id'] ?>"><?php echo $row['subject'] ?></td>
                        <td><button class="btn btn-outline-danger btn-sm" type="button" onclick="rem_this($(this))"><i class="fa fa-times"></i></button></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </div>
</div>

<style>
/* Maroon & Gold Theme */
.text-maroon { color: #800000 !important; }
.text-gold { color: #FFD700 !important; }
.bg-maroon { background-color: #800000 !important; }
.btn-maroon {
    background-color: #800000;
    color: #FFD700;
    border: none;
    border-radius: 6px;
    padding: 6px 12px;
    font-weight: bold;
    transition: 0.3s;
}
.btn-maroon:hover { background-color: #600000; color: #fff; }

/* ===== Select2 & Input Styling ===== */
.styled-input {
    width: 100%;
    border: 2px solid #800000;
    border-radius: 6px;
    padding: 8px 10px;
    font-size: 14px;
    color: #333;
    outline: none;
    transition: all 0.3s ease-in-out;
    background: #fffbe6;
}
.styled-input:focus, .select2-container--default .select2-selection--single:focus {
    border-color: #FFD700 !important;
    box-shadow: 0 0 8px rgba(255, 215, 0, 0.7);
    background: #fffdf5;
}

/* Table header */
#r-list thead th { border-color: #FFD700 !important; }

/* Select2 dropdown maroon/gold hover */
.select2-container--default .select2-results__option--highlighted {
    background-color: #800000 !important;
    color: #FFD700 !important;
}
</style>

<script>
$('#faculty_id, #cl_id, #subject').select2({
    placeholder: 'Please select here',
    width: '100%',
});

$('#add_to_list').click(function(){
    if($('#cl_id').val() == '' || $('#subject').val() == ''){
        alert_toast("Please select a class and subject first.",'warning')
        return false;
    }
    var tr = $('<tr></tr>');
    var cl_id = $('#cl_id').val();
    var subject = $('#subject').val();
    var className = $('#cl_id').find('option[value="'+cl_id+'"]').text();
    var subjectName = $('#subject').find('option[value="'+subject+'"]').text();
    tr.append('<td><input name="cl_id[]" type="hidden" value="'+cl_id+'">'+className+'</td>');
    tr.append('<td><input name="subject_id[]" type="hidden" value="'+subject+'">'+subjectName+'</td>');
    tr.append('<td><button class="btn btn-outline-danger btn-sm" type="button" onclick="rem_this($(this))"><i class="fa fa-times"></i></button></td>');
    $('#r-list tbody').append(tr);
});

function rem_this(_this){
    _this.closest('tr').remove();
}

$(document).ready(function(){
    $('#manage_restriction').submit(function(e){
        e.preventDefault();
        start_load();
        $.ajax({
            url:'<?php echo base_url('evaluation/save_restriction') ?>',
            method:'POST',
            data:$(this).serialize(),
            success:function(resp){
                if(resp == 1){
                    location.reload();
                }else{
                    Dtoast('An error occured','error');
                    end_load();
                }
            }
        });
    });
});
</script>
