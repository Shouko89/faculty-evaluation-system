<?php
$sy = $this->db->query('SELECT * FROM evaluation_list where status = 1 and is_default = 1 ')->row();
foreach ($sy as $k => $v) {
    $e_arr[$k] = $v;
}
$courses = $this->db->query("SELECT *,cl.course_id FROM restriction_list r inner join curriculum_level_list cl on cl.id = r.curriculum_id where r.faculty_id = $fid and r.evaluation_id = {$e_arr['id']} ");
$c_arr = array_column($courses->result_array(), 'course_id', 'course_id');
if (count($c_arr) > 0) {
    $class = $this->db->query("SELECT *,concat(lastname,', ',firstname,' ',middlename) as name from chairperson_list where course_id in (" . implode(",", $c_arr) . ") " . ($_SESSION['login_user_type'] != 1 ? " and department_id = '{$_SESSION['login_department_id']}' " : ""))->result_array();
}
// var_dump($class)
$cid = isset($_GET['cid']) ? $_GET['cid'] : '';

// Get faculty name for print header
$fname = $this->db->query("SELECT concat(lastname,' ',name_pref,', ',firstname) as name from faculty_list where id = $fid ")->row()->name;
?>
<style>
    /* 🎨 Maroon & Gold Theme */
    .bg-maroon {
        background-color: #800000 !important;
    }

    .text-maroon {
        color: #800000 !important;
    }
.fw-bold {
    font-weight: bold !important;
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

<div class="col-lg-12">
    <div class="card shadow-lg border-0 rounded-lg">
        <?php if (count($c_arr) <= 0): ?>
            <div class="card-body text-center py-5">
                <h4 class="text-maroon">No assigned chairperson evaluation yet.</h4>
            </div>
        <?php else: ?>
            <!-- Page Header -->
            <div class="card-header bg-maroon text-gold">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h4 class="mb-0">Chairperson's Evaluation Result of Faculty</h4>
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
                    <label for="" class="control-label text-maroon"><b>Select Chairperson</b></label>
                    <div class="row mt-2">
                        <?php foreach ($class as $row): ?>
                            <div class="col-auto mb-2">
                                <button
                                    class="btn <?php echo empty($cid) ? "btn-maroon" : ($cid == $row['id'] ? "btn-maroon" : "btn-outline-maroon") ?> btn-sm class_btn"
                                    data-cid='<?php echo $row['id'] ?>' type="button">
                                    <i class="fa fa-user me-1"></i><?php echo $row['name'] ?>
                                </button>
                            </div>
                            <?php
                            if (empty($cid))
                                $cid = $row['id'];
                            ?>
                        <?php endforeach; ?>
                    </div>
                </div>

                <?php
                if (count($c_arr) > 0):
                    $criteria = array();
                    $ans = array();
                    $count = array();
                    $criteria_qry = $this->db->query("SELECT * FROM criteria where id in (SELECT criteria_id from question_list where evaluation_id = '{$e_arr['id']}' and question_for = 2 ) order by order_by asc");
                    foreach ($criteria_qry->result_array() as $row):
                        $criteria[$row['order_by']] = $row;
                        if ($row['parent_id'] > 0) {
                            $data = $controller->get_parent($row['parent_id']);
                            foreach ($data as $v) {
                                $criteria[$v['order_by']] = $v;
                            }
                        }
                    endforeach;
                    ksort($criteria);
                    $question = $this->db->query("SELECT * from question_list where evaluation_id = '{$e_arr['id']}' and question_for = 2");

                    $answers_qry = $this->db->query("SELECT a.*,c.id as cid FROM answers a inner join question_list q on q.id = a.question_id inner join criteria c on c.id = q.criteria_id where a.evaluation_id = '{$e_arr['id']}'  and a.chairperson_id ={$cid} and a.faculty_id='$fid' and q.type = 1  ")->result_array();
                    foreach ($answers_qry as $row) {
                        if (!isset($ans[$row['cid']]))
                            $ans[$row['cid']] = 0;
                        if (!isset($count[$row['cid']]))
                            $count[$row['cid']] = 0;
                        $count[$row['cid']] += 1;
                        $ans[$row['cid']] += $row['answer'];
                    }
                    foreach ($question->result_array() as $row):
                        $criteria_q[$row['criteria_id']][] = $row;
                    endforeach;
                    $i = 1;
                    ?>

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
                            <tbody></tbody>
<tfoot class="bg-maroon text-gold">
    <tr>
        <th colspan="3" class="text-center" id="overall-summary"></th>
    </tr>
</tfoot>


                        </table>
                    </div>
                <?php else: ?>
                    <h4 class="text-center text-maroon">No Class Assigned to selected faculty for
                        <?php echo 'SY ' . $e_arr['school_year'] . ' ' . $e_arr['semester'] . " Semester" ?>
                    </h4>
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
        </div>
    </div>
    <h4 class="text-center"><b>CHAIRPERSON'S EVALUATION OF FACULTY</b></h4>
    <table width="100%" class='noborder'>
        <tr>
            <td width="50%">
                <p>Name of Faculty: <b><?php echo $fname ?></b></p>
                <p>Sem: <b><?php echo $e_arr['semester'] ?></b></p>
            </td>
            <td width="50%">
                <p>Chairperson: <b><?php echo isset($class[0]['name']) ? $class[0]['name'] : '' ?></b></p>
                <p>S.Y.: <b><?php echo $e_arr['school_year'] ?></b></p>
            </td>
        </tr>
    </table>
</div>

<script>
    $('#print').click(function () {
        var ns = $('noscript').clone()
        var _header = $('#print-header').clone()
        var table = $('#criteria-list').clone()
        var _div = $('<div></div')
        _div.append(table)
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

    var criteria = '<?php echo json_encode($criteria) ?>';
    var ans = '<?php echo json_encode($ans) ?>';
    var count = '<?php echo json_encode($count) ?>';
    criteria = JSON.parse(criteria);
    count = JSON.parse(count);
    ans = JSON.parse(ans);
    var oa = 0;
    var i = 0;

// function to map score to interpretation
function getInterpretation(score) {
    if (!isFinite(score) || score === 0) return 'N/A';
    if (score <= 1.79) return 'Poor';
    if (score <= 2.59) return 'Fair';
    if (score <= 3.93) return 'Satisfactory';
    if (score <= 4.19) return 'Very Satisfactory';
    return 'Outstanding';
}

// function to get color class for interpretation
function getInterpretationColor(interpretation) {
    switch (interpretation) {
        case 'Poor': return 'text-danger fw-bold';
        case 'Fair': return 'text-warning fw-bold';
        case 'Satisfactory': return 'text-maroon fw-bold';
        case 'Very Satisfactory': return 'text-maroon fw-bold';
        case 'Outstanding': return 'text-maroon fw-bold';
        default: return '';
    }
}

if (Object.keys(criteria).length > 0) {
    Object.keys(criteria).map(k => {
        i++;
        var level = $('#criteria-list tbody tr[data-id="' + criteria[k].parent_id + '"]').length > 0 
            ? $('#criteria-list tbody tr[data-id="' + criteria[k].parent_id + '"]').attr('data-level') 
            : 0;
        level++;

        var margin = 25 * parseFloat(level);
        var ave = ans[criteria[k].id] / count[criteria[k].id];
        oa = parseFloat(oa) + parseFloat(ans[criteria[k].id] != undefined ? ave : 0);
        var tr = $('<tr class="text-dark" data-id="' + criteria[k].id + '" data-parent_id="' + criteria[k].parent_id + '" data-level="' + level + '"></tr>');
        var interpretation = getInterpretation(ave);
        var colorClass = getInterpretationColor(interpretation);

        tr.append('<td><p style="margin-left:' + margin + 'px;display: list-item;list-style: square;" class="text-dark"><b>' + criteria[k].criteria + '</b></p></td>');
        tr.append('<td class="text-center">' + (ans[criteria[k].id] != undefined ? parseFloat(ave).toLocaleString("en-US", { style: "decimal", maximumFractionDigits: 5, minimumFractionDigits: 5 }) : '') + '</td>');
        tr.append('<td class="text-center ' + colorClass + '">' + (ans[criteria[k].id] != undefined ? interpretation : '') + '</td>');
        
        if ($('#criteria-list tbody tr[data-parent_id="' + criteria[k].parent_id + '"]').length > 0) {
            $('#criteria-list tbody tr[data-parent_id="' + criteria[k].parent_id + '"]').last().after(tr);
            return false;
        }
        if ($('#criteria-list tbody tr[data-id="' + criteria[k].parent_id + '"]').length > 0)
            $('#criteria-list tbody tr[data-id="' + criteria[k].parent_id + '"]').after(tr);
        else {
            $('#criteria-list tbody ').append(tr);
        }
    });
    var overallAvg = oa / i;
    var overallInterpretation = getInterpretation(overallAvg);
    var overallColor = getInterpretationColor(overallInterpretation);

    $('#overall-summary').html(
    'Overall Average: <b>' + 
    parseFloat(overallAvg).toLocaleString("en-US", { style: "decimal", maximumFractionDigits: 2, minimumFractionDigits: 2 }) + 
'</b> (<span class="' + overallInterpretation + '"><b>' + overallInterpretation + '</b></span>)'
);

}

    $('.class_btn').click(function () {
        start_load()
        location.href = '<?php echo base_url('evaluation/result_chairperson/' . $fid . '?cid=') ?>' + $(this).attr('data-cid')
    })
</script>