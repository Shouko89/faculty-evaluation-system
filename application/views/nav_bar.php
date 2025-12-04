<!-- Sidebar -->

<?php
$home = (stripos($title, 'home') !== false) ? "active" : '';
$department = (stripos($title, 'department') !== false) ? "active" : '';
$course = (stripos($title, 'course') !== false) ? "active" : '';
$criteria = (stripos($title, 'criteria') !== false) ? "active" : '';
$subject = (stripos($title, 'subject') !== false) ? "active" : '';
$student = (stripos($title, 'student') !== false) ? "active" : '';
$chair = (stripos($title, 'chair') !== false || stripos($title, 'chairperson') !== false) ? "active" : '';
$faculty = (stripos($title, 'faculty') !== false) ? "active" : '';
$curriculum = (stripos($title, 'curriculum') !== false) ? "active" : '';
$evaluation = (stripos($title, 'evaluation') !== false && stripos($title, 'result') === false) ? "active" : '';
$result = (stripos($title, 'result') !== false) ? "active" : '';
$users = (stripos($title, 'users') !== false) ? "active" : '';
?>



<div class="sidebar-fixed position-fixed">

  <center><a class="logo-wrapper waves-effect">
      <img src="<?php echo base_url('assets/img/chmsc_logo.gif') ?>" class="" alt=""
        style="max-width:100%;max-height : 15vh !important">
    </a>
  </center>
  <div class="list-group list-group-flush">
    <a href="<?php echo base_url('admin') ?>"
      class="list-group-item list-group-item-action waves-effect <?php echo $home ?>">
      <i class="fas fa-tachometer-alt mr-3"></i>Dashboard
    </a>
    <?php if ($_SESSION['login_user_type'] == 1): ?>

      <a href="<?php echo base_url('department') ?>"
        class="list-group-item list-group-item-action waves-effect <?php echo $department ?>">
        <i class="fas fa-building mr-3"></i>Department</a>
    <?php endif; ?>

    <a href="<?php echo base_url('subject') ?>"
      class="list-group-item list-group-item-action waves-effect <?php echo $subject ?>">
      <i class="fas fa-th-list mr-3"></i>Subjects</a>
    <a href="<?php echo base_url('course') ?>"
      class="list-group-item list-group-item-action waves-effect <?php echo $course ?>">
      <i class="fas fa-scroll mr-3"></i>Courses</a>
    <a href="<?php echo base_url('curriculum') ?>"
      class="list-group-item list-group-item-action waves-effect <?php echo $curriculum ?>">
      <i class="fas fa-graduation-cap mr-3"></i>Level & Section</a>
    <a href="<?php echo base_url('faculty') ?>"
      class="list-group-item list-group-item-action waves-effect <?php echo $faculty ?>">
      <i class="fas fa-user-tie mr-3"></i>Faculty</a>
    <a href="<?php echo base_url('criteria') ?>"
      class="list-group-item list-group-item-action waves-effect <?php echo $criteria ?>">
      <i class="fas fa-list mr-3"></i>Criteria</a>
    <a href="<?php echo base_url('chairperson/list') ?>"
      class="list-group-item list-group-item-action waves-effect <?php echo $chair ?>">
      <i class="fas fa-user-tie mr-3"></i>Chairperson</a>
    <a href="<?php echo base_url('evaluation') ?>"
      class="list-group-item list-group-item-action waves-effect <?php echo $evaluation ?>">
      <i class="fas fa-star mr-3"></i>Evaluation</a>
    <a href="<?php echo base_url('evaluation/result') ?>"
      class="list-group-item list-group-item-action waves-effect <?php echo $result ?>">
      <i class="fas fa-list-alt mr-3"></i>Result</a>
    <a href="<?php echo base_url('student/list') ?>"
      class="list-group-item list-group-item-action waves-effect <?php echo $student ?>">
      <i class="fas fa-user mr-3"></i>Student</a>
    <?php if ($_SESSION['login_user_type'] == 1): ?>
      <a href="<?php echo base_url('cogs/users') ?>"
        class="list-group-item list-group-item-action waves-effect <?php echo $users ?>">
        <i class="fas fa-user-friends mr-3"></i>Users</a>
    <?php endif; ?>
  </div>

</div>
<style>
  .sidebar-fixed {
    background: maroon !important;
    color: #FFD700;
    /* gold */
  }

  .sidebar-fixed .list-group-item {
    background: transparent;
    color: #FFD700;
    border: none;
    transition: background 0.3s, color 0.3s;
  }

  .sidebar-fixed .list-group-item:hover {
    background: #FFD700 !important;
    color: maroon !important;
    font-weight: bold;
  }

  .sidebar-fixed .active {
    background: #FFD700 !important;
    color: maroon !important;
    font-weight: bold;
  }

  #sidebar-list a {
    min-height: 7vh;
  }

  #sidebar-list {
    height: calc(100% - 10rem);
    overflow: auto;
  }
</style>
<!-- Sidebar -->