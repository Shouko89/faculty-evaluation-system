<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title><?php echo ucwords($title) ?></title>

  <?php include 'header.php' ?>
  
  <style>
    /* Base body */
    body,
    html {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(135deg, #f8f2f0 0%, #f0e6e3 100%);
      color: #3c3c3c;
      line-height: 1.6;
    }

    /* Toast */
    #dynamic_toast .badge-type {
      background-color: #800000 !important;
      color: #FFD700 !important;
      border-radius: 0.5rem;
      box-shadow: 0 4px 12px rgba(128, 0, 0, 0.2);
    }

    #dynamic_toast .icon-place {
      color: #FFD700 !important;
    }

    /* Card */
    .card {
      border-radius: 1rem;
      border: 1px solid #800000;
      box-shadow: 0 8px 25px rgba(128, 0, 0, 0.15);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      overflow: hidden;
    }

    .card:hover {
      box-shadow: 0 12px 30px rgba(128, 0, 0, 0.2);
    }

    /* Card headers */
    .card .card-body h4,
    .card .card-body h5 {
      color: #800000;
      font-weight: 700;
      margin-bottom: 1.5rem;
    }

    /* Input fields */
    .md-form {
      margin-bottom: 1.5rem;
    }

    .md-form input.form-control,
    .md-form textarea.form-control {
      border: 2px solid #800000;
      border-radius: 0.75rem;
      padding: 0.75rem 1rem;
      transition: all 0.3s ease;
      background-color: #fff8f6;
      color: #3c3c3c;
      font-size: 1rem;
    }

    .md-form input.form-control:focus,
    .md-form textarea.form-control:focus {
      border-color: #FFD700;
      box-shadow: 0 0 0 3px rgba(255, 215, 0, 0.3);
      background-color: #fff !important;
    }

    /* Input labels */
    .md-form label {
      color: #800000;
      font-weight: 600;
      margin-bottom: 0.5rem;
      transition: all 0.3s ease;
    }

    .md-form input.form-control:focus + label,
    .md-form textarea.form-control:focus + label {
      color: #a83232;
    }

    /* Buttons */
    .btn-primary {
      background-color: #800000 !important;
      color: #FFD700 !important;
      border-radius: 0.75rem;
      font-weight: 600;
      transition: all 0.3s ease;
      padding: 0.75rem 1.5rem;
      border: none;
      box-shadow: 0 4px 10px rgba(128, 0, 0, 0.2);
    }

    .btn-primary:hover {
      background-color: #a83232 !important;
      color: #FFD700 !important;
      transform: translateY(-2px);
      box-shadow: 0 6px 15px rgba(128, 0, 0, 0.3);
    }

    .btn-primary:active {
      transform: translateY(0);
    }

    /* Faculty selector buttons */
    #faculties {
      display: flex;
      flex-wrap: wrap;
      gap: 0.75rem;
      margin-bottom: 2rem;
    }

    #faculties button {
      flex: 1 0 auto;
      min-width: 200px;
      transition: all 0.3s ease;
      border-radius: 1rem;
      padding: 0.75rem 1.25rem;
      font-weight: 500;
      border: 2px solid #800000;
      background-color: white !important;
      color: #800000 !important;
    }

    #faculties button:hover {
      background-color: #f8f2f0;
      transform: translateY(-2px);
    }

    #faculties button.active {
      background-color: #800000 !important;
      color: #FFD700 !important;
      border: 2px solid #FFD700 !important;
      box-shadow: 0 4px 10px rgba(128, 0, 0, 0.3);
    }

    /* Rating scale items */
    .rating-field input[type="radio"] {
      display: none;
    }

    .rating-field input[type="radio"] + label {
      display: inline-block;
      border: 2px solid #800000;
      border-radius: 0.75rem;
      padding: 0.5rem 1rem;
      margin: 0 0.25rem;
      cursor: pointer;
      transition: all 0.3s ease;
      font-weight: 600;
      min-width: 50px;
      text-align: center;
    }

    .rating-field input[type="radio"]:hover + label {
      background-color: rgba(128, 0, 0, 0.1);
    }

    .rating-field input[type="radio"]:checked + label {
      background-color: #800000;
      color: #FFD700;
      border-color: #FFD700;
      box-shadow: 0 0 0 2px rgba(255, 215, 0, 0.3);
    }

    /* Question items */
    .question-item {
      border-top: 1px solid rgba(128, 0, 0, 0.2);
      padding: 1.5rem 0;
      transition: background-color 0.3s ease;
    }

    .question-item:hover {
      background-color: rgba(255, 248, 246, 0.5);
    }

    .question-text {
      margin-bottom: 1rem;
      font-size: 1.1rem;
    }

    /* Textarea field */
    .textarea-field textarea.md-textarea {
      border: 2px solid #800000;
      border-radius: 0.75rem;
      background-color: #fff8f6;
      padding: 1rem;
      color: #3c3c3c;
      transition: all 0.3s ease;
    }

    .textarea-field textarea.md-textarea:focus {
      border-color: #FFD700;
      box-shadow: 0 0 0 3px rgba(255, 215, 0, 0.3);
      background-color: #fff;
    }

    /* Criteria items */
    .criteria-item {
      margin-bottom: 2rem;
      padding: 1.5rem;
      background-color: white;
      border-radius: 0.75rem;
      box-shadow: 0 4px 12px rgba(128, 0, 0, 0.1);
    }

    .criteria-item b {
      font-size: 1.2rem;
      color: #800000;
      display: block;
      margin-bottom: 1rem;
      padding-bottom: 0.5rem;
      border-bottom: 2px solid rgba(128, 0, 0, 0.1);
    }

    /* Footer */
    .page-footer {
      background-color: #800000 !important;
      color: #FFD700 !important;
    }

    /* Progress bar */
    .progress-bar {
      background-color: #FFD700 !important;
      border-radius: 10px;
    }

    /* Main content spacing */
    main {
      padding-top: 2rem !important;
    }

    /* Form elements */
    #evaluation-field {
      list-style-type: none;
      padding-left: 0;
    }

    #evaluation-field ul {
      padding-left: 1.5rem;
      margin-top: 1rem;
    }

    /* Rating scale legend */
    .rating-legend {
      background: linear-gradient(to right, #fff8f6, #f0e6e3);
      border-radius: 0.75rem;
      padding: 1rem 1.5rem;
      margin-bottom: 2rem;
      border: 1px solid rgba(128, 0, 0, 0.2);
    }

    .rating-legend b {
      color: #800000;
      display: block;
      margin-bottom: 0.5rem;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
      #faculties button {
        min-width: 100%;
      }
      
      .card-body {
        padding: 1.5rem;
      }
      
      .criteria-item {
        padding: 1rem;
      }
    }

    /* Loading animation */
    @keyframes pulse {
      0% { opacity: 1; }
      50% { opacity: 0.5; }
      100% { opacity: 1; }
    }
    
    .loading-pulse {
      animation: pulse 1.5s ease-in-out infinite;
    }

    /* Modal styles */
    .modal-content {
      border: 2px solid #800000;
      border-radius: 10px;
    }

    .modal-header {
      background: #800000;
      color: #FFD700;
      border-bottom: 2px solid #FFD700;
    }

    .modal-title {
      font-weight: bold;
    }

    .modal-footer {
      border-top: 1px solid #800000;
    }

    /* Loading modal */
    #load_modal {
      background: rgba(128, 0, 0, 0.4) !important;
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      height: 100%;
      width: 100%;
      justify-content: center;
      align-items: center;
      z-index: 2000;
    }

    #load_modal .card {
      border: 2px solid #FFD700;
      border-radius: 10px;
    }

    #load_modal .spinner-border {
      color: #800000;
      width: 3rem;
      height: 3rem;
    }

    #load_modal small b {
      color: #800000;
    }

    /* Toast positioning */
    #dynamic_toast{
      position: absolute;
      width: 20.2rem;
      right: 10px;
    }
    #dynamic_toast.show{
      z-index:9999
    }

    .sidebar-fixed{
      z-index:1040
    }
  </style>
</head>

<body class="grey lighten-3">
   <!-- Toast -->
  <div role="alert" aria-live="assertive" aria-atomic="true" class="toast"  id="dynamic_toast">
  
  <div class="toast-body badge-success badge-type">
    <span class="mr-2"><i class="fa fa-check badge-success badge-type icon-place"></i></span>
    <span class="msg-field"></span>
  </div>
</div>
<!-- toast -->
  <!--Main Navigation-->
  <header>
     <?php include 'top_bar.php' ?>
  </header>
  <!--Main Navigation-->

  <!--Main layout-->
  <main class="pt-5" style="padding-left:unset">
    <div class="container-fluid mt-5">
      <!-- Faculty Selection -->
      <div class="card mb-4">
        <div class="card-body">
          <h4 class="mb-4">Select Faculty to Evaluate</h4>
          <div id="faculties">
            <?php 
            $evaluated = $this->db->query("SELECT distinct(faculty_id) from answers where evaluation_id= '".$_SESSION['sy_id']."' and chairperson_id = {$_SESSION['login_id']} ");
            $evaluated_arr= array_column($evaluated->result_array(),"faculty_id","faculty_id");
            $fid =isset($_GET['fid']) && !in_array($_GET['fid'],$evaluated_arr) ? $_GET['fid'] : '';
            $fname_arr = array();
              $qry = $this->db->query("SELECT * FROM faculty_list where id in (SELECT r.faculty_id from restriction_list r inner join curriculum_level_list cl where r.evaluation_id= '".$_SESSION['sy_id']."' and cl.department_id = '".$_SESSION['login_department_id']."' and cl.course_id = '".$_SESSION['login_course_id']."' ) ".(count($evaluated_arr) > 0 ? " and id not in (".(implode(',',$evaluated_arr)).")" : '' ));
             
              foreach($qry->result_array() as $row):
                $fname_arr[$row['id']] = ucwords($row['firstname']. ' '. $row['lastname'].' '.$row['name_pref']);
            ?>
              <button type="button" class="btn btn-primary <?php echo (isset($_GET['fid']) && $_GET['fid'] == $row['id']) ? "active" : (empty($fid) ? "active" : ""); ?>" data-id='<?php echo $row['id'] ?>'>
  <?php echo ucwords($row['firstname']. ' '. $row['lastname'].' '.$row['name_pref']) ?></button>
              <?php 
              if(empty($fid) && $qry->num_rows() > 0 ){
                $fid = $row['id'];
              }
              endforeach; 
              if(!empty($fid)):
              $criteria_arr = array();
              $criteria = $this->db->query("SELECT * FROM criteria where status = 1 and id in (SELECT criteria_id from question_list where evaluation_id = {$_SESSION['sy_id']} and question_for = 2 ) order by order_by asc");
              foreach($criteria->result_array() as $row):
                  $criteria_arr[]=$row;
              endforeach; 
            endif;
              ?>
          </div>
        </div>
      </div>

      <?php if(!empty($fid)): ?>
      <form id="answer-frm"> 
        <!-- Chairperson and Faculty Information -->
        <div class="card mb-4">
          <div class="card-body">
            <h4 class="mb-4">Evaluation Information</h4>
            <div class="row">
              <div class="col-md-6">
                <div class="md-form">
                  <input type="hidden" name="eid" value="<?php echo $_SESSION['sy_id'] ?>">
                  <input type="hidden" name="faculty_id" value="<?php echo $fid ?>">
                  <input type="text" class="form-control" name="other_details['name']" id="name" value="<?php echo $_SESSION['login_lastname'].', '.$_SESSION['login_firstname'].' '.$_SESSION['login_middlename'] ?>" readonly>
                  <label for="name" class="control-label">Chairperson Name</label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="md-form">
                  <input type="text" class="form-control" name="other_details['faculty']" value="<?php echo $fname_arr[$fid] ?>" id="faculty" readonly>
                  <label for="faculty" class="control-label">Faculty Member</label>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Evaluation Form -->
        <div class="card">
          <div class="card-body">
            <div class="text-center mb-4">
              <h4><b><?php echo "SY : ".$_SESSION['sy_school_year']." ".$_SESSION['sy_semester']. " SEMESTER" ?></b></h4>
            </div>
            <hr>
            
            <!-- Rating Legend -->
            <div class="rating-legend">
              <b>Rating Scale:</b>
              <div class="d-flex flex-wrap">
                <div class="mr-4 mb-1">5 = Outstanding</div>
                <div class="mr-4 mb-1">4 = Very Satisfactory</div>
                <div class="mr-4 mb-1">3 = Satisfactory</div>
                <div class="mr-4 mb-1">2 = Fair</div>
                <div class="mb-1">1 = Poor</div>
              </div>
            </div>
            
            <!-- Evaluation Questions -->
            <ul class="" id="evaluation-field"></ul>
            
            <!-- Comment Section -->
            <hr>
            <div class="form-group mt-4">
              <label for="comment" class="control-label font-weight-bold">Additional Comments</label>
              <textarea name="comment" id="comment" cols="30" rows="5" class="form-control" placeholder="Please provide any additional feedback or comments about the faculty member..."></textarea>
            </div>
            
            <!-- Submit Button -->
            <button class="btn btn-primary btn-block btn-lg mt-4">Submit Evaluation</button>
          </div>
        </div>
      </form>
      <?php elseif($qry->num_rows() == 0 && $evaluated->num_rows() == 0): ?>
        <!-- No Faculty Message -->
        <div class="container-fluid">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-body text-center py-5">
                <h4><b>There is no assigned faculty assigned under your course/program for <?php echo $_SESSION['sy_school_year'].' '.$_SESSION['sy_semester'] ?> SEMESTER Evaluation yet. Thank you</b></h4>
                <p class="mt-3">Please check back later or contact your administrator if you believe this is an error.</p>
              </div>
            </div>
          </div>
        </div>
      <?php else: ?>
        <!-- Evaluation Complete Message -->
        <div class="container-fluid">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-body text-center py-5">
                <h4><b>You are done evaluating the faculties for SY <?php echo $_SESSION['sy_school_year'].' '.$_SESSION['sy_semester'] ?> SEMESTER. Thank you</b></h4>
                <div class="mt-4">
                  <i class="fa fa-check-circle fa-4x text-success mb-3"></i>
                </div>
                <p class="mt-3">Your feedback is valuable and helps improve the quality of education.</p>
              </div>
            </div>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </main>

  <!-- Hidden Templates -->
  <div id="rating_clone" style="display:none">
    <div class="question-item mb-2">
      <div class="question-item-row">
        <div class="col-md-12 question-text"><strong></strong></div>
        <div class="rating-field">
          <input type="hidden" name="qid[]">
          <input type="hidden" name="question[]">
          <input type="hidden" name="type[]">
          <span class="opt-group d-flex flex-wrap"></span>
        </div>
      </div>
    </div>
  </div>

  <div id="textare_clone" style="display:none">
    <div class="question-item mb-2">
      <div class="question-item-row">
        <input type="hidden" name="qid[]">
        <input type="hidden" name="question[]">
        <input type="hidden" name="type[]">
        <div class="col-md-12 question-text"><strong></strong></div>
        <div class="textarea-field mt-3">
          <div class="md-form">
            <textarea class="md-textarea form-control" rows="4" placeholder="Write your answer here..."></textarea>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--Main layout-->

  <!--Footer-->
  <footer class="page-footer text-center font-small primary-color-dark darken-2 mt-4 wow fadeIn" style="padding-left:unset">
    <div class="footer-copyright py-3">
      © <?php echo date("Y"); ?> All Rights Reserved
    </div>
  </footer>

  <!-- Modals -->
  <div id="load_modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-body text-center p-5">
          <div class="spinner-border text-info loading-pulse" role="status" style="width: 3rem; height: 3rem;">
            <span class="sr-only">Loading...</span>
          </div>
          <h5 class="mt-3">Please wait...</h5>
          <p>We're processing your request</p>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="frm_modal" role='dialog'>
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action=""></form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" id='submit' onclick="">Save</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
  </div>
</body>

<script>
$('input').trigger('focus').trigger('blur')
$(document).ready(function(){
  load_criteria();
 
  $('#answer-frm').submit(function(e){
    e.preventDefault()
    start_load()
    $.ajax({
      url:"<?php echo base_url("chairperson/save_chairperson_evaluation") ?>",
      method:"POST",
      data:$(this).serialize(),
      error:err=>{
        console.log(err)
        Dtoast("An error occured.","danger")
        end_load()
      },
      success:function(resp){
        if(resp == 1){
     Dtoast("Evaluation successfully submitted",'success')
          setTimeout(function(){
            location.reload()
          },1000)
        }
      }
    })
  })

})
$('#faculties button').click(function(){
  start_load()
  location.href ='<?php echo base_url('chairperson') ?>?fid='+$(this).attr('data-id')
})

window.load_criteria = function(){
  if('<?php echo empty($fid) ?>' == 1){
    return false;
  }
      var criteria = <?php echo json_encode($criteria_arr) ?>;
      Object.keys(criteria).map(function(k){
          var li=$('<li class="criteria-item"></li>')
          li.attr('data-id',criteria[k].id)
          li.append('<b>'+criteria[k].criteria+'</b>')
          li.append('<div class="qf"></div>')
          if($('#evaluation-field li[data-id="'+criteria[k].parent_id+'"]').length > 0){
              var ul = $('<ul></ul>');
              ul.append(li)
              $('#evaluation-field').append(ul)
          }else{
            $('#evaluation-field').append(li)
          }
      })
    load_questions();

  }

window.start_load = function(){

      $('#load_modal').css({display:'flex'})

}
window.end_load = function(){

  $('#load_modal').hide()


}
  window.frmModal =function($frm_name='',$title='',$url='',$params={}){
      start_load()
      $.ajax({
        url:$url,
        method:'POST',
        data:$params,
        error:err=>console.log(err),
        success:function(content){
          $('#frm_modal .modal-body form').html(content)
          $('#frm_modal .modal-body form').attr('id',$frm_name)
          $('#frm_modal .modal-title').html($title)
          $('#frm_modal #submit').attr('onclick','$("#'+$frm_name+'").submit()')
          $('#frm_modal').modal('show')
          end_load()
        }
      })
  }
  function delete_data(msg = '',cfunc = '',parameters= []){
    
    parameters = parameters.join(",");
    $('#delete_modal #submit').html('Continue')
      $('#delete_modal #submit').removeAttr('disabled')
    $('#delete_modal #delete_content').html(msg);
    $('#delete_modal #submit').attr('onclick','this_go("'+cfunc+'",['+parameters+'])');
    $('#delete_modal').modal('show')
  
  }
  function this_go(cfunc = '',parameters= []){
    console.log(cfunc)
    parameters = parameters.join(",");
      $('#delete_modal #submit').html('Please wait...');
      $('#delete_modal #submit').attr('disabled',true);
      window[cfunc](parameters)
    }
    window.load_questions = function(){
      start_load();
      $.ajax({
          url:'<?php echo base_url('chairperson/load_evaluation') ?>',
          method:'POST',
          data:{},
          error:err=>{
                  console.log(err)
                  Dtoast('An error occured','error');
                  end_load();
              },
        success:function(resp){
          if(typeof resp != undefined){
                resp= JSON.parse(resp)
                if(Object.keys(resp).length >0){
                    Object.keys(resp).map(k=>{
                        var q = resp[k].question;
                        var t = resp[k].type;
                        var id = resp[k].id;
                        var c = resp[k].criteria_id;

                        var item = '';
                        var item_count = $('#evaluation-field .question-item').length + 1;
                        if(t == 1){
                            item =  $('#rating_clone .question-item').clone()
                            for( var i = 1 ; i <= 5; i++ ){
                                //   console.log(i)
                                item.find('.opt-group').append('<span class="mx-2"><input type="radio" id="rating-'+i+'-'+item_count+'" name="answer['+id+']" value="'+i+'" readonly/><label for="rating-'+i+'-'+item_count+'"> '+i+'</label></span>')
                            }
                                
                        }else{
                            item =  $('#textare_clone .question-item').clone()
                        }
                                item.find('[name="qid[]"]').val(id)
                                item.find('[name="question[]"]').val(q)
                                item.find('[name="type[]"]').val(t)
                                item.find('[name="criteria_id[]"]').val(c)
                                item.find('.question-text strong').html(q)
                                console.log(c)
                                $('#evaluation-field li[data-id="'+c+'"] .qf').append(item)

                    })
                }

                end_load();
            }
            },
            complete:function(){
            }
        })
    }
  window.Dtoast = ($message='',type='success')=>{
    // console.log('toast');
    $('#dynamic_toast .msg-field').html($message);
    if(type == 'info'){
      var badge = 'badge-info';
      var ico = 'fa-info';
    }else if(type == 'success'){
      var badge = 'badge-success';
      var ico = 'fa-check';
    }else  if(type == 'error'){
      var badge = 'badge-danger';
      var ico = 'fa-exclamation-triangle';
    }else  if(type == 'warning'){
      var badge = 'badge-warning';
      var ico = 'fa-exclamation-triangle';
    }
    $("#dynamic_toast .badge-type").removeClass('badge-success')
    $("#dynamic_toast .badge-type").removeClass('badge-warning')
    $("#dynamic_toast .badge-type").removeClass('badge-danger')
    $("#dynamic_toast .badge-type").removeClass('badge-info')

    $("#dynamic_toast .icon-place").removeClass('fa-check')
    $("#dynamic_toast .icon-place").removeClass('fa-info')
    $("#dynamic_toast .icon-place").removeClass('fa-exclamation-triangle')
    $("#dynamic_toast .icon-place").removeClass('fa-exclamation-triangle')

    $('#dynamic_toast .badge-type').addClass(badge)
    $('#dynamic_toast .icon-place').addClass(ico)

    
    $('#dynamic_toast .msg-field').html($message)
    // $('#dynamic_toast').show()
    $('#dynamic_toast').toast({'delay':2000}).toast('show');
  }
</script>
</html>