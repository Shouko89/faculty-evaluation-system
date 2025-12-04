<div class="col-md-12 mt1 mb1">
    <div class="row">
        <a href="javascript:void(0)"
            onclick="frmModal('manage_evaluation','New Evaluation','<?php echo base_url('evaluation/manage') ?>')"
            class="btn btn-maroon float-right">
            <i class="fa fa-plus"> </i> New Evaluation
        </a>
    </div>
</div>

<div class="col-md-12 mt1 mb1">
    <div class="row">
        <div class="card col-md-12 shadow-lg border-0 rounded-lg">
            <div class="card-body">
                <!-- Page Header -->
                <div class="page-header mb-4">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h2 class="page-title text-maroon mb-0">
                                Evaluation List
                            </h2>
                        </div>
                        <!-- <div class="col-md-6 text-md-end">
                            <div class="header-stats">
                                <span class="badge bg-maroon text-gold px-3 py-2">
                                    <i class="fa fa-list me-1"></i>
                                    <span id="evaluation-count">0</span> Evaluations
                                </span>
                            </div>
                        </div> -->
                    </div>
                </div>

                <table class="table table-bordered table-striped table-hover" width="100%" id="evaluation-field">
                    <colgroup>
                        <col width="5%">
                        <col width="35%">
                        <col width="35%">
                        <col width="5%">
                        <col width="20%">
                    </colgroup>

                    <thead class="bg-maroon text-gold">
                        <tr>
                            <th>#</th>
                            <th>School Year</th>
                            <th>Semester</th>
                            <th>Default?</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    /* 🎨 Maroon & Gold Theme */
    .bg-maroon {
        background-color: #800000 !important;
    }

    .text-gold {
        color: #FFD700 !important;
    }

    .text-maroon {
        color: #800000 !important;
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

    /* Card */
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

    /* Table */
    .table thead th {
        border-color: #FFD700 !important;
        text-align: center;
    }

    .table-hover tbody tr:hover {
        background-color: #fff3cd;
        /* light gold hover */
    }

    /* Circle Action Buttons */
    .btn-circle {
        border-radius: 50% !important;
        width: 36px;
        height: 36px;
        padding: 0;
        text-align: center;
        font-size: 14px;
        line-height: 36px;
        display: inline-flex;
        justify-content: center;
        align-items: center;
    }

    /* Badges */
    .badge-success {
        background-color: #28a745;
        color: #fff;
        padding: 5px 10px;
        border-radius: 6px;
        font-weight: bold;
    }

    .badge-danger {
        background-color: #dc3545;
        color: #fff;
        padding: 5px 10px;
        border-radius: 6px;
        font-weight: bold;
        cursor: pointer;
        transition: 0.3s;
    }

    .badge-danger:hover {
        background-color: #c82333;
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

    .make_default {
        cursor: pointer;
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
    }

    /* Text alignment */
    .text-center {
        text-align: center !important;
    }

    .float-right {
        float: right !important;
    }

    /* Button spacing */
    .mr-2 {
        margin-right: 0.5rem !important;
    }

    /* Table text styling */
    .fw-bold {
        font-weight: bold !important;
    }
</style>

<script>
    window.load_evaluation = function () {
        $('#evaluation-field').dataTable().fnDestroy();
        $('#evaluation-field tbody').html('<tr><td colspan="5">Loading data...</td></tr>')
        $.ajax({
            url: '<?php echo base_url('evaluation/load_list') ?>',
            method: 'POST',
            data: {},
            error: err => console.log(err),
            success: function (resp) {
                if (resp) {
                    if (typeof resp != undefined) {
                        $('#evaluation-field tbody').html('')
                        resp = JSON.parse(resp)
                        var i = 0;
                        Object.keys(resp).map(k => {
                            i++;
                            var tr = $('<tr>')
                            tr.append('<td>' + i + '</td>')
                            tr.append('<td class="text-maroon fw-bold">' + resp[k].school_year + '</td>')
                            tr.append('<td class="text-maroon">' + resp[k].semester + '</td>')
                            if (resp[k].is_default == 1) {
                                tr.append('<td><center><div class="badge badge-success">Yes</div></center></td>')
                            } else {
                                tr.append('<td><center><div class="badge badge-danger make_default" data-id="' + resp[k].id + '">No</div></center></td>')
                            }
                            tr.append(
                                '<td class="text-center">' +
                                '<a href="<?php echo base_url('evaluation/evaluation_view/') ?>' + resp[k].id + '" class="btn btn-gold btn-circle view_evaluation mr-2" data-id="' + resp[k].id + '"><i class="fa fa-eye"></i></a>' +
                                '<button type="button" class="btn btn-gold btn-circle edit_evaluation mr-2" data-id="' + resp[k].id + '"><i class="fa fa-edit"></i></button>' +
                                '<button type="button" class="btn btn-maroon btn-circle remove_evaluation" data-id="' + resp[k].id + '"><i class="fa fa-trash"></i></button>' +
                                '</td>'
                            )
                            $('#evaluation-field tbody').append(tr)
                        })

                        // Update evaluation count
                        $('#evaluation-count').text(i);
                    }
                }
            },
            complete: () => {
                $('#evaluation-field').dataTable()
                $('.edit_evaluation').click(function () {
                    frmModal('manage_evaluation', 'Edit Evaluation', '<?php echo base_url('evaluation/manage/') ?>' + $(this).attr('data-id'))
                })
                $('.remove_evaluation').click(function () {
                    delete_data('Are you sure to delete this data?', 'remove_evaluation', [$(this).attr('data-id')])
                })
                $('.make_default').click(function () {
                    delete_data('Are you sure to make this as the Default Evaluation?', 'make_default', [$(this).attr('data-id')])
                })
            }
        })
    }

    function make_default($id) {
        start_load();
        $.ajax({
            url: '<?php echo base_url('evaluation/make_default') ?>',
            method: 'POST',
            data: { id: $id },
            success: function (resp) {
                if (resp == 1) { location.reload() }
            }
        })
    }

    function remove_evaluation($id = '') {
        $.ajax({
            url: '<?php echo base_url() ?>evaluation/remove',
            method: 'POST',
            data: { id: $id },
            error: err => {
                console.log(err)
                Dtoast('An error occured.', 'error')
            },
            success: function (resp) {
                if (resp == 1) {
                    Dtoast('Data successfully deleted.', 'success')
                    load_evaluation()
                    $('.modal').modal('hide')
                }
            }
        })
    }

    $(document).ready(function () {
        if ('<?php echo $this->session->flashdata('action_cur') ?>' == 1)
            Dtoast("Data successfully added", 'success');
        if ('<?php echo $this->session->flashdata('action_def') ?>' == 1)
            Dtoast("Data successfully updated", 'success');

        load_evaluation();
    })
</script>