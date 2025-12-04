<div class="col-md-12 mt1 mb1">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-body">
                    <!-- Page Header -->
                    <div class="page-header mb-4">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h2 class="page-title text-maroon mb-0">
                                    Evaluation Results
                                </h2>
                            </div>
                            <!-- <div class="col-md-6 text-md-end">
                                <div class="header-stats">
                                    <span class="badge bg-maroon text-gold px-3 py-2">
                                        <i class="fa fa-list me-1"></i>
                                        <span id="faculty-count">0</span> Faculty
                                    </span>
                                </div>
                            </div> -->
                        </div>
                    </div>

                    <table class="table table-bordered table-hover table-striped" width="100%" id="faculty-field">
                        <thead class="bg-maroon text-gold">
                            <tr>
                                <th width="5%">#</th>
                                <th>Name</th>
                                <?php if ($_SESSION['login_user_type'] == 1): ?>
                                    <th>Department</th>
                                <?php endif; ?>
                                <th width="30%">Evaluation</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
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
    .btn-student {
        background-color: #800000;
        color: #FFD700;
        border: none;
        border-radius: 0.5rem;
        padding: 0.5rem 1rem;
        font-weight: 600;
        transition: 0.3s;
    }

    .btn-student:hover {
        background-color: #660000;
        color: #FFD700;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(128, 0, 0, 0.3);
    }

    .btn-chairperson {
        background-color: #FFD700;
        color: #800000;
        border: none;
        border-radius: 0.5rem;
        padding: 0.5rem 1rem;
        font-weight: 600;
        transition: 0.3s;
    }

    .btn-chairperson:hover {
        background-color: #E6C200;
        color: #800000;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(255, 215, 0, 0.3);
    }

    /* Card Styling */
    .card {
        border: 1px solid #e0e0e0;
        border-radius: 0.75rem;
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
        /* light gold hover */
    }

    /* Page Header Styling */
    .page-header {
        padding-bottom: 1rem;
        border-bottom: 2px solid #FFD700;
        margin-bottom: 1.5rem;
    }

    .page-title {
        font-size: 1.8rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
    }

    .page-subtitle {
        font-size: 0.95rem;
        color: #6c757d;
    }

    .header-stats .badge {
        font-size: 0.9rem;
        font-weight: 600;
        border-radius: 0.5rem;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .page-title {
            font-size: 1.5rem;
        }

        .page-header .row {
            text-align: center;
        }

        .header-stats {
            margin-top: 1rem;
        }

        .btn-student,
        .btn-chairperson {
            display: block;
            width: 100%;
            margin-bottom: 0.5rem;
        }
    }

    /* Text alignment */
    .text-center {
        text-align: center !important;
    }

    /* Table text styling */
    .fw-bold {
        font-weight: bold !important;
    }

    /* Button spacing */
    .mr-2 {
        margin-right: 0.5rem !important;
    }

    /* Modal styling */
    .modal-header {
        background-color: #800000 !important;
        border-bottom: 2px solid #FFD700 !important;
    }

    .modal-title {
        color: #FFD700 !important;
        font-weight: bold;
        text-align: start;
        width: 100%;
    }
</style>

<script>
    window.load_faculty = function () {
        $('#faculty-field').dataTable().fnDestroy();
        $('#faculty-field tbody').html('<tr><td colspan="6">Loading data...</td></tr>')
        $.ajax({
            url: '<?php echo base_url('faculty/load_list') ?>',
            method: 'POST',
            data: {},
            error: err => console.log(err),
            success: function (resp) {
                if (resp) {
                    if (typeof resp != undefined) {
                        $('#faculty-field tbody').html('')
                        resp = JSON.parse(resp)
                        var i = 0;
                        Object.keys(resp).map(k => {
                            i++;
                            var tr = $('<tr>')
                            tr.append('<td class="text-center">' + i + '</td>')
                            tr.append('<td class="text-maroon fw-bold">' + resp[k].name + '</td>')
                            if (<?php echo $_SESSION['login_user_type'] ?> == 1)
                                tr.append('<td class="text-maroon">' + resp[k].dname + ' Department</td>')
                            tr.append('<td class="text-center">' +
                                '<button type="button" class="btn btn-student waves-effect view_student_eval mr-2" data-id="' + resp[k].id + '">Student</button>' +
                                '<button type="button" class="btn btn-chairperson waves-effect view_chairperson_eval" data-id="' + resp[k].id + '">Chairperson</button>' +
                                '</td>')

                            $('#faculty-field tbody').append(tr)
                        })

                        // Update faculty count
                        $('#faculty-count').text(i);
                    }
                }
            },
            complete: () => {
                $('#faculty-field').dataTable()
                $('.view_student_eval').each(function () {
                    $(this).click(function () {
                        location.href = '<?php echo base_url('evaluation/result_student/') ?>' + $(this).attr('data-id')
                    })
                })
                $('.view_chairperson_eval').each(function () {
                    $(this).click(function () {
                        location.href = '<?php echo base_url('evaluation/result_chairperson/') ?>' + $(this).attr('data-id')
                    })
                })
                $('.remove_faculty').each(function () {
                    $(this).click(function () {
                        delete_data('Are you sure to delete this data?', 'remove_faculty', [$(this).attr('data-id')])
                    })
                })
            }
        })
    }

    function remove_faculty($id = '') {
        $.ajax({
            url: '<?php echo base_url() ?>faculty/remove',
            method: 'POST',
            data: { id: $id },
            error: err => {
                console.log(err)
                Dtoast('An error occured.', 'error')
            },
            success: function (resp) {
                if (resp == 1) {
                    Dtoast('Data successfully deleted.', 'success')
                    load_faculty()
                    $('.modal').modal('hide')
                }
            }
        })
    }

    $(document).ready(function () {
        if ('<?php echo $this->session->flashdata('action_fac') ?>' == 1)
            Dtoast("Data successfully added", 'success');
        load_faculty();
    })
</script>