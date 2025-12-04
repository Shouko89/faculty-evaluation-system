<?php
$fname = $this->db->query("SELECT concat(lastname,' ',name_pref,', ',firstname) as name from faculty_list where id = $fid ")->row()->name;
$sy = $this->db->query('SELECT * FROM evaluation_list where status = 1 and is_default = 1 ')->row();
foreach ($sy as $k => $v) {
    $e_arr[$k] = $v;
}
$class = $this->db->query("SELECT r.*,concat(co.course,' ',cl.year,'-',cl.section,' - ',s.subject) as class,cl.id as cl_id,s.subject,cl.department_id FROM restriction_list r  inner join curriculum_level_list cl on cl.id = r.curriculum_id inner join subjects s on s.id = r.subject_id inner join courses co on co.id = cl.course_id where cl.status = 1 and r.evaluation_id = '{$e_arr['id']}' and r.faculty_id = $fid " . ($_SESSION['login_user_type'] != 1 ? " and cl.department_id = '{$_SESSION['login_department_id']}' " : ""));
// var_dump($class)
$rid = isset($_GET['rid']) ? $_GET['rid'] : '';
$cl_id = isset($_GET['cl_id']) ? $_GET['cl_id'] : '';
$sid = isset($_GET['sid']) ? $_GET['sid'] : '';

// Initialize variables to prevent undefined errors
$criteria_arr = array();
$ave = array();
$count = array();
$total = 0;
$ti = 0;
$i = 0;

// Check if the currently selected class has evaluations
$hasEvaluations = false;
if (!empty($cl_id) && !empty($sid)) {
    $answers_qry = $this->db->query("SELECT a.* FROM answers a WHERE a.evaluation_id = '{$e_arr['id']}' AND a.student_id IN (SELECT id FROM student_list where cl_id = '$cl_id' and status = 1) AND a.subject_id = '$sid' ");
    $hasEvaluations = $answers_qry->num_rows() > 0;
}

function getInterpretationColor($interpretation)
{
    switch ($interpretation) {
        case 'Poor':
            return 'text-danger';
        case 'Fair':
            return 'text-warning';
        case 'Satisfactory':
        case 'Very Satisfactory':
        case 'Outstanding':
            return 'text-maroon';
        default:
            return '';
    }
}

?>
<div class="col-lg-12">
    <div class="card shadow-lg border-0 rounded-lg">
        <?php if ($class->num_rows() <= 0): ?>
            <!-- No Classes Assigned Message -->
            <div class="card-body text-center py-5">
                <div class="mb-4">
                    <i class="fa fa-users-slash fa-4x text-muted mb-3"></i>
                </div>
                <h4 class="text-maroon mb-3">No Assigned Classes</h4>
                <p class="text-muted">This faculty hasn't been assigned to any class yet.</p>
                <p class="text-muted">Please contact the administrator for class assignments.</p>
            </div>
        <?php else: ?>
            <!-- Page Header -->
            <div class="card-header bg-maroon text-gold">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h4 class="mb-0">Student's Evaluation Result</h4>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <button class="btn btn-gold btn-sm" id="print"><i class="fa fa-print"></i> Print Summary
                            Result</button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <!-- Faculty Info -->
                <div class="faculty-info mb-4 p-3 bg-light rounded">
                    <h5 class="text-maroon mb-2"><b>Faculty: <?php echo $fname ?></b></h5>
                    <hr class="my-2">
                    <label for="" class="control-label text-maroon"><b>Select Class</b></label>
                    <div class="row mt-2">
                        <?php
                        $hasValidClass = false;
                        foreach ($class->result_array() as $row):
                            // Check if this class has evaluations
                            $student = $this->db->query("SELECT * FROM student_list where cl_id = '{$row['cl_id']}' ");
                            $answers_qry = $this->db->query("SELECT a.* FROM answers a WHERE a.evaluation_id = '{$e_arr['id']}' AND a.student_id IN (SELECT id FROM student_list where cl_id = '{$row['cl_id']}' and status = 1) AND a.subject_id = '{$row['subject_id']}' ");

                            if (empty($rid) && $answers_qry->num_rows() > 0) {
                                $rid = $row['id'];
                                $cl_id = $row['cl_id'];
                                $sid = $row['subject_id'];
                                $hasValidClass = true;
                            }
                            if (empty($rid) && !$hasValidClass) {
                                $rid = $row['id'];
                                $cl_id = $row['cl_id'];
                                $sid = $row['subject_id'];
                            }
                            ?>
                            <div class="col-auto mb-2">
                                <button
                                    class="btn <?php echo empty($rid) ? "btn-maroon" : ($rid == $row['id'] ? "btn-maroon" : "btn-outline-maroon") ?> btn-sm class_btn"
                                    data-rid='<?php echo $row['id'] ?>' data-sid='<?php echo $row['subject_id'] ?>'
                                    data-cl_id='<?php echo $row['cl_id'] ?>' type="button">
                                    <i class="fa fa-book me-1"></i><?php echo $row['class'] ?>
                                </button>
                            </div>
                            <?php
                            $dept = $this->db->query("SELECT * FROM department_list where id = {$row['department_id']} ")->row();
                            $dname = $dept->description;
                            // $dlogo = $dept->img_logo;
                            $subject = $row['subject'];
                        endforeach;
                        ?>
                    </div>
                </div>

                <?php if (!$hasEvaluations): ?>
                    <!-- No Evaluations Message -->
                    <div class="text-center py-5">
                        <div class="mb-4">
                            <i class="fa fa-clipboard-list fa-4x text-muted mb-3"></i>
                        </div>
                        <h4 class="text-maroon mb-3">No Evaluation Results Available</h4>
                        <p class="text-muted">There are no evaluation results for the selected class yet.</p>
                        <p class="text-muted">Please select another class from the options above.</p>
                    </div>
                <?php else:
                    // Initialize all arrays properly
                    $criteria_arr = array();
                    $ans = array(); // Initialize answers array
                    $ave = array(); // Initialize averages array
                    $criteria_q = array(); // Initialize criteria questions array
            
                    $criteria = $this->db->query("SELECT * FROM criteria where id in (SELECT criteria_id from question_list where evaluation_id = '{$e_arr['id']}' and question_for = 1 ) and status = 1 order by order_by asc");
                    $question = $this->db->query("SELECT * from question_list where evaluation_id = '{$e_arr['id']}' and question_for = 1");

                    // Build criteria array
                    foreach ($criteria->result_array() as $row):
                        $criteria_arr[$row['order_by']] = $row;
                        if ($row['parent_id'] > 0) {
                            $data = $controller->get_parent($row['parent_id']);
                            foreach ($data as $v) {
                                $criteria_arr[$v['order_by']] = $v;
                            }
                        }
                    endforeach;
                    ksort($criteria_arr);

                    // Get all students for this class
                    $student = $this->db->query("SELECT * FROM student_list where cl_id = '$cl_id' and status = 1");

                    // Get answers and organize by student and criteria
                    $answers_qry = $this->db->query("SELECT a.*, c.id as cid, q.id as qid FROM answers a 
                                                    INNER JOIN question_list q on q.id = a.question_id 
                                                    INNER JOIN criteria c on c.id = q.criteria_id 
                                                    WHERE a.evaluation_id = '{$e_arr['id']}'  
                                                    AND a.student_id IN (SELECT id FROM student_list where cl_id = '$cl_id' and status = 1) 
                                                    AND q.type = 1 
                                                    AND a.subject_id = '$sid'")->result_array();

                    // Initialize answer arrays
                    foreach ($student->result_array() as $srow) {
                        foreach ($criteria->result_array() as $crow) {
                            $ans[$srow['id']][$crow['id']] = 0;
                            $ans_count[$srow['id']][$crow['id']] = 0;
                        }
                    }

                    // Process answers
                    foreach ($answers_qry as $row) {
                        if (isset($ans[$row['student_id']][$row['cid']])) {
                            $ans[$row['student_id']][$row['cid']] += $row['answer'];
                            $ans_count[$row['student_id']][$row['cid']]++;
                        }
                    }

                    // Build criteria questions array
                    foreach ($question->result_array() as $row):
                        $criteria_q[$row['criteria_id']][] = $row;
                    endforeach;

                    $i = 1;

                    // Calculate summary data for the Average Summary section
                    $summary_data = array();
                    $overall_total = 0;
                    $criteria_count = 0;

                    foreach ($criteria->result_array() as $crow) {
                        $total_score = 0;
                        $total_responses = 0;

                        foreach ($student->result_array() as $srow) {
                            if (isset($ans[$srow['id']][$crow['id']]) && $ans_count[$srow['id']][$crow['id']] > 0) {
                                $total_score += $ans[$srow['id']][$crow['id']] / $ans_count[$srow['id']][$crow['id']];
                                $total_responses++;
                            }
                        }

                        $average = $total_responses > 0 ? $total_score / $total_responses : 0;
                        $summary_data[$crow['id']] = array(
                            'criteria' => $crow['criteria'],
                            'average' => $average,
                            'parent_id' => $crow['parent_id']
                        );
                        $overall_total += $average;
                        $criteria_count++;
                    }

                    $overall_average = $criteria_count > 0 ? $overall_total / $criteria_count : 0;
                    ?>

                    <!-- Evaluation Result Table -->
                    <div class="section-card mb-4">
                        <h5 class="text-maroon mb-3"><i class="fa fa-table me-2"></i><b>Evaluation Result</b></h5>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="bg-maroon text-gold">
                                    <tr>
                                        <th width="50px" class="text-center">No.</th>
                                        <?php foreach ($criteria->result_array() as $row): ?>
                                            <th width="150px"><?php echo $row['criteria'] ?></th>
                                            <th width="100px" class="text-center">Average</th>
                                        <?php endforeach; ?>
                                        <th width="150px" class="text-center">Total Average</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Reset averages for this calculation
                                    $ave = array();
                                    $total_student_averages = array();

                                    foreach ($student->result_array() as $srow):
                                        $taverage = 0;
                                        $c = 0;
                                        $student_total = 0;
                                        $criteria_count = 0;
                                        ?>
                                        <tr>
                                            <td class="text-center"><?php echo $i++ ?></td>
                                            <?php
                                            foreach ($criteria->result_array() as $crow):
                                                $ccount = isset($criteria_q[$crow['id']]) ? count($criteria_q[$crow['id']]) : 0;

                                                if ($ccount > 0 && isset($ans[$srow['id']][$crow['id']]) && $ans_count[$srow['id']][$crow['id']] > 0) {
                                                    // Calculate average for this criteria
                                                    $score = $ans[$srow['id']][$crow['id']];
                                                    $answer_count = $ans_count[$srow['id']][$crow['id']];
                                                    $average = $answer_count > 0 ? $score / $answer_count : 0;
                                                } else {
                                                    $score = 0;
                                                    $average = 0;
                                                }

                                                $taverage += $average;
                                                $c++;
                                                $student_total += $average;
                                                $criteria_count++;

                                                // Accumulate for mean calculation
                                                if (!isset($ave[$crow['id']]))
                                                    $ave[$crow['id']] = 0;
                                                $ave[$crow['id']] += $average;
                                                ?>
                                                <td class="text-center bg-warning text-maroon">
                                                    <b><?php echo number_format($score, 2) ?></b>
                                                </td>
                                                <td class="text-center"><?php echo number_format($average, 2) ?></td>
                                            <?php endforeach; ?>
                                            <?php
                                            $student_final_average = $criteria_count > 0 ? $student_total / $criteria_count : 0;
                                            $total_student_averages[] = $student_final_average;
                                            ?>
                                            <td class="text-center bg-light text-maroon">
                                                <b><?php echo number_format($student_final_average, 2) ?></b>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot class="bg-maroon text-gold">
                                    <tr>
                                        <th class="text-center">Mean Score</th>
                                        <?php
                                        $student_count = $student->num_rows();
                                        $total_mean = 0;
                                        $ti = 0;
                                        foreach ($criteria->result_array() as $row):
                                            $ti++;
                                            $mean = $student_count > 0 ? $ave[$row['id']] / $student_count : 0;
                                            $total_mean += $mean;
                                            ?>
                                            <th></th>
                                            <th class="text-center"><?php echo number_format($mean, 2) ?></th>
                                        <?php endforeach; ?>
                                        <?php
                                        $overall_mean = $student_count > 0 ? array_sum($total_student_averages) / $student_count : 0;
                                        ?>
                                        <th class="text-center"><?php echo number_format($overall_mean, 2) ?></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <!-- Evaluation Result Average Summary -->
                    <div class="section-card mb-4">
                        <h5 class="text-maroon mb-3"><i class="fa fa-chart-bar me-2"></i><b>Evaluation Result Average
                                Summary</b></h5>
                        <table class="table table-bordered table-hover" id='criteria-list'>
                            <thead class="bg-maroon text-gold">
                                <tr>
                                    <th>Criteria</th>
                                    <th class="text-center">Average</th>
                                    <th class="text-center">Interpretation</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Display summary data directly in PHP instead of using JavaScript
                                foreach ($summary_data as $criteria_id => $data):
                                    $interpretation = getInterpretation($data['average']);
                                    $colorClass = getInterpretationColor($interpretation);
                                    $margin = $data['parent_id'] > 0 ? 'style="margin-left: 25px;"' : '';
                                    ?>
                                    <tr>
                                        <td>
                                            <p <?php echo $margin ?> class="text-dark"><b><?php echo $data['criteria'] ?></b></p>
                                        </td>
                                        <td class="text-center"><?php echo number_format($data['average'], 5) ?></td>
                                        <td class="text-center fw-bold <?php echo $colorClass; ?>">
                                            <b><?php echo $interpretation; ?></b>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot class="bg-maroon text-gold">
                                <tr>
                                    <?php
                                    $overallInterpretation = getInterpretation($overall_average);
                                    $overallColor = getInterpretationColor($overallInterpretation);
                                    ?>
                                    <th colspan="3" class="text-center ">
                                        Overall Average:
                                        <b><?php echo number_format($overall_average, 2); ?></b>
                                        (<span
                                            class="<?php echo $overallInterpretation; ?>"><b><?php echo $overallInterpretation; ?></b></span>)
                                    </th>
                                </tr>
                            </tfoot>

                        </table>
                    </div>


                    <!-- Evaluation Comments -->
                    <div class="section-card">
                        <h5 class="text-maroon mb-3"><i class="fa fa-comments me-2"></i><b>Evaluation Comments</b></h5>
                        <?php
                        $ci = 1;
                        $comments = $this->db->query("SELECT c.* FROM comments c inner join restriction_list r on r.id = c.restriction_id where c.evaluation_id= {$e_arr['id']} and c.restriction_id = $rid and r.curriculum_id = $cl_id and r.subject_id = $sid ");
                        ?>
                        <table class="table table-bordered table-hover" id="comments">
                            <thead class="bg-maroon text-gold">
                                <tr>
                                    <th class="text-center" width="5%">#</th>
                                    <th>Comment</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($comments->result_array() as $row): ?>
                                    <tr>
                                        <td class="text-center"><?php echo $ci++; ?></td>
                                        <td><?php echo $row['comment'] ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Print Header (Hidden) -->
<div id="print-header">
    <div class="row justify-content-center">
        <div><img src="<?php echo base_url('assets/img/chmsc_logo.gif') ?>" width="65px" height="65px" alt=""></div>
        <div class="text-center">
            <p>Republic of the Philippines</p>
            <p><b>ZAMBOANGA PENINSULA POLYTECHNIC STATE UNIVERSITY</b></p>
            <p>R.T. Lim Boulevard, Baliwasan, Zamboanga City</p>
            <?php if (isset($dname)): ?>
                <p><b><?php echo strtoupper($dname) ?></b></p>
            <?php endif; ?>
        </div>
    </div>
    <h4 class="text-center"><b>STUDENT'S EVALUATION OF FACULTY</b></h4>
    <table width="100%" class='noborder'>
        <tr>
            <td width="50%">
                <p>Name of Faculty: <b><?php echo $fname ?></b></p>
                <p>Subject: <b><?php echo $subject ?></b></p>
            </td>
            <td width="50%">
                <p>Sem: <b><?php echo $e_arr['semester'] ?></b></p>
                <p>S.Y.: <b><?php echo $e_arr['school_year'] ?></b></p>
            </td>
        </tr>
    </table>
</div>

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

    /* Buttons */
    .btn-maroon {
        background-color: #800000;
        color: #FFD700;
        border: none;
        transition: 0.3s;
    }

    .btn-maroon:hover {
        background-color: #600000;
        color: #fff;
    }

    .btn-gold {
        background-color: #FFD700;
        color: #800000;
        border: none;
        transition: 0.3s;
    }

    .btn-gold:hover {
        background-color: #e6c200;
        color: #fff;
    }

    .btn-outline-maroon {
        background-color: transparent;
        color: #800000;
        border: 2px solid #800000;
        transition: 0.3s;
    }

    .btn-outline-maroon:hover {
        background-color: #800000;
        color: #FFD700;
    }

    /* Card Styling */
    .card {
        border-radius: 0.75rem;
        border: 1px solid #e0e0e0;
    }

    .rounded-lg {
        border-radius: 0.75rem !important;
    }

    .shadow-lg {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }

    /* Table Styling */
    .table thead th {
        text-align: center;
        border-color: #FFD700 !important;
    }

    .table-hover tbody tr:hover {
        background-color: #fff3cd;
    }

    .table-bordered {
        border: 1px solid #dee2e6;
    }

    .table-bordered th,
    .table-bordered td {
        border: 1px solid #dee2e6;
    }

    /* Section Cards */
    .section-card {
        padding: 1.5rem;
        border: 1px solid #e0e0e0;
        border-radius: 0.5rem;
        margin-bottom: 1.5rem;
        background: #fff;
    }

    .faculty-info {
        background: linear-gradient(135deg, #fff8f0 0%, #fff0e0 100%);
        border-left: 4px solid #800000;
    }

    /* Print Header */
    #print-header {
        display: none
    }

    /* Responsive */
    @media (max-width: 768px) {
        .table-responsive {
            font-size: 0.875rem;
        }

        .btn-sm {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
        }
    }

    /* Text alignment */
    .text-center {
        text-align: center !important;
    }

    .float-right {
        float: right !important;
    }

    /* Background colors */
    .bg-warning {
        background-color: #FFD700 !important;
    }

    .bg-light {
        background-color: #f8f9fa !important;
    }

    .fw-bold {
        font-weight: bold !important;
    }
</style>

<noscript>
    <style>
        p {
            margin: unset
        }

        #print-header img {
            margin: .5em
        }

        .text-center {
            text-align: center
        }

        .text-right {
            text-align: right
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table tr,
        table td,
        table th {
            border: 1px solid
        }

        table.noborder tr,
        table.noborder td,
        table.noborder th {
            border: unset
        }

        .row {
            display: flex;
            flex-wrap: wrap;
        }

        .justify-content-center {
            -ms-flex-pack: center !important;
            justify-content: center !important;
        }
    </style>
</noscript>

<script>
    // Print function - always available
    $('#print').click(function () {
        var ns = $('noscript').clone()
        var _header = $('#print-header').clone()
        var table = $('#criteria-list').clone()
        var table2 = $('#comments').clone()
        var _div = $('<div></div')
        _div.append(table)
        _div.append('<br>')
        _div.append(table2)
        var nw = window.open("", "_blank", "width=900,height=700");
        nw.document.write(ns.html())
        nw.document.write(_header.html())
        nw.document.write(_div.html())
        nw.document.close()
        nw.print()
        setTimeout(() => {
            nw.close()
        }, 500);
    })

    // Navigation function - always available
    $('.class_btn').click(function () {
        start_load()
        location.href = '<?php echo base_url('evaluation/result_student/' . $fid . '?rid=') ?>' + $(this).attr('data-rid') + '&cl_id=' + $(this).attr('data-cl_id') + '&sid=' + $(this).attr('data-sid')
    })

    // Interpretation function for JavaScript (if needed elsewhere)
    function getInterpretation(score) {
        if (!isFinite(score) || score === 0) return 'N/A';
        if (score <= 1.79) return 'Poor';
        if (score <= 2.59) return 'Fair';
        if (score <= 3.93) return 'Satisfactory';
        if (score <= 4.19) return 'Very Satisfactory';
        return 'Outstanding';
    }
</script>

<?php
// PHP function for interpretation
function getInterpretation($score)
{
    if (!is_finite($score) || $score === 0)
        return 'N/A';
    if ($score <= 1.79)
        return 'Poor';
    if ($score <= 2.59)
        return 'Fair';
    if ($score <= 3.93)
        return 'Satisfactory';
    if ($score <= 4.19)
        return 'Very Satisfactory';
    return 'Outstanding';
}
?>