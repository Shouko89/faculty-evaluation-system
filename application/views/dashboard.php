<div class="col-lg-12">
  <div class="card">
    <div class="card-body">
      <div class="row">

        <!-- Total Students -->
        <div class="col-xl-4 col-md-6 mb-xl-0 mb-4">
          <div class="card card-cascade cascading-admin-card dash-card">
            <div class="card-body">
              <div class="admin-up">
                <div class="data">
                  <p class="text-uppercase">Total Students</p>
                  <span class="float-left dash-sum-icon"><i class="fa fa-users"></i></span>
                  <h4 class="font-weight-bold text-right">
                    <?php echo $this->db->query("SELECT * FROM student_list where status = 1 ".($_SESSION['login_user_type'] != 1? " and department_id = {$_SESSION['login_department_id']} " : ''))->num_rows(); ?>
                  </h4>
                </div>
              </div>
            </div>
            <div class="card-footer">
              <div class='col-md-12'>
                <a href="<?php echo base_url('student/list') ?>" class="row justify-content-between">
                  <span>View</span><span class="fa fa-angle-right"></span>
                </a>
              </div>
            </div>
          </div>
        </div>

        <!-- Total Faculty -->
        <div class="col-xl-4 col-md-6 mb-xl-0 mb-4">
          <div class="card card-cascade cascading-admin-card dash-card">
            <div class="card-body">
              <div class="admin-up">
                <div class="data">
                  <p class="text-uppercase">Total Faculty</p>
                  <span class="float-left dash-sum-icon"><i class="fa fa-user-tie"></i></span>
                  <h4 class="font-weight-bold text-right">
                    <?php echo $this->db->query("SELECT * FROM faculty_list where status = 1 ".($_SESSION['login_user_type'] != 1? " and department_id = {$_SESSION['login_department_id']} " : ''))->num_rows(); ?>
                  </h4>
                </div>
              </div>
            </div>
            <div class="card-footer">
              <div class='col-md-12'>
                <a href="<?php echo base_url('faculty') ?>" class="row justify-content-between">
                  <span>View</span><span class="fa fa-angle-right"></span>
                </a>
              </div>
            </div>
          </div>
        </div>

        <!-- Total Courses -->
        <div class="col-xl-4 col-md-6 mb-xl-0 mb-4">
          <div class="card card-cascade cascading-admin-card dash-card">
            <div class="card-body">
              <div class="admin-up">
                <div class="data">
                  <p class="text-uppercase">Total Courses</p>
                  <span class="float-left dash-sum-icon"><i class="fa fa-scroll"></i></span>
                  <h4 class="font-weight-bold text-right">
                    <?php echo $this->db->query("SELECT * FROM courses where status = 1 ".($_SESSION['login_user_type'] != 1? " and department_id = {$_SESSION['login_department_id']} " : ''))->num_rows(); ?>
                  </h4>
                </div>
              </div>
            </div>
            <div class="card-footer">
              <div class='col-md-12'>
                <a href="<?php echo base_url('course') ?>" class="row justify-content-between">
                  <span>View</span><span class="fa fa-angle-right"></span>
                </a>
              </div>
            </div>
          </div>
        </div>

      </div> <!-- row -->
    </div>
  </div>
</div>

<style>
/* === DASHBOARD CARDS MAROON & GOLD THEME === */
.dash-card {
  background: maroon;
  color: #FFD700;
  border-radius: 12px;
  transition: transform 0.2s, box-shadow 0.3s;
  box-shadow: 0 4px 8px rgba(0,0,0,0.25);
}

.dash-card .card-body {
  background: maroon;
  color: #FFD700;
}

.dash-card p {
  font-size: 0.85rem;
  font-weight: bold;
  color: #FFD700;
}

.dash-card h4 {
  font-size: 4rem;
  color: #FFD700;
}

.dash-sum-icon {
  font-size: 4rem;
  color: #FFD700;
}

.dash-card .card-footer {
  background: #FFD700;
  color: maroon;
  font-weight: bold;
  text-align: center;
  border-top: none;
}

.dash-card .card-footer a {
  color: maroon;
  text-decoration: none;
  font-weight: bold;
  transition: color 0.3s;
}

.dash-card .card-footer a:hover {
  color: #800000;
}

.dash-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 16px rgba(0,0,0,0.4);
}
</style>
