<div class="col-md-12 mt1 mb1">
    <div class="row">
        <a href="<?php echo base_url('student/manage') ?>" class="btn btn-maroon float-right">
            <i class="fa fa-plus"></i> New Student
        </a>
    </div>
</div>

<div class="col-md-12 mt1 mb1">
    <div class="row">

        <div class="card col-md-12 shadow-lg border-0 rounded-lg">
            <div class="card-body">
                <div class="page-header mb-4">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h2 class="page-title text-maroon mb-0">
                                Student List
                            </h2>
                        </div>
                        <!-- <div class="col-md-6 text-md-end">
                            <div class="header-stats">
                                <span class="badge bg-maroon text-gold px-3 py-2">
                                    <i class="fa fa-list me-1"></i>
                                    <span id="user-count">0</span> Users
                                </span>
                            </div>
                        </div> -->
                    </div>
                </div>
                <table class="table table-bordered table-striped" width="100%" id="student-field">

                    <colgroup>
                        <col width="5%">
                        <col width="10%">
                        <col width="30%">
                        <col width="20%">
                        <col width="20%">
                        <col width="15%">
                    </colgroup>

                    <thead class="bg-maroon text-gold">
                        <tr>
                            <th>#</th>
                            <th>ID #</th>
                            <th>Name</th>
                            <th>Department</th>
                            <th>Level/Section</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>

            </div>
        </div>

    </div>
</div>

<script>
    window.load_student = function () {
        $('#student-field').dataTable().fnDestroy();
        $('#student-field tbody').html('<tr><td colspan="6">Loading data.</td></tr>')
        $.ajax({
            url: '<?php echo base_url('student/load_list') ?>',
            method: 'POST',
            data: {},
            error: err => console.log(err),
            success: function (resp) {
                if (resp) {
                    if (typeof resp != undefined) {
                        $('#student-field tbody').html('')
                        resp = JSON.parse(resp)
                        var i = 0;
                        Object.keys(resp).map(k => {
                            i++;
                            var tr = $('<tr>')
                            tr.append('<td>' + i + '</td>')
                            tr.append('<td>' + resp[k].student_code + '</td>')
                            tr.append('<td class="text-maroon fw-bold">' + resp[k].name + '</td>')
                            tr.append('<td>' + resp[k].dname + ' Department</td>')
                            tr.append('<td>' + resp[k].cl + '</td>')
                            tr.append('<td><button type="button" class="btn btn-gold btn-circle edit_student" data-id="' + resp[k].id + '"><i class="fa fa-edit"></i></button> <button type="button" class="btn btn-maroon btn-circle remove_student" data-id="' + resp[k].id + '"><i class="fa fa-trash"></i></button></td>')

                            $('#student-field tbody').append(tr)
                        })
                    }
                }
            },
            complete: () => {
                $('#student-field').dataTable()
                $('.edit_student').each(function (e) {
                    $(this).click(function () {
                        location.replace('<?php echo base_url() ?>student/manage/' + $(this).attr('data-id'))
                    })
                })
                $('.remove_student').each(function (e) {
                    $(this).click(function () {
                        delete_data('Are you sure to delete this data?', 'remove_student', [$(this).attr('data-id')])
                    })
                })
            }
        })
    }

    function remove_student($id = '') {
        $.ajax({
            url: '<?php echo base_url() ?>student/remove',
            method: 'POST',
            data: { id: $id },
            error: err => {
                console.log(err)
                Dtoast('An error occured.', 'error')
            },
            success: function (resp) {
                if (resp == 1) {
                    Dtoast('Data successfully deleted.', 'success')
                    load_student()
                    $('.modal').modal('hide')
                }
            }
        })
    }

    $(document).ready(function () {
        if ('<?php echo $this->session->flashdata('action_save_student') ?>' == 1)
            Dtoast("Data successfully added", 'success');
        load_student();
    })
</script>

<style>
    /* 🎨 Maroon & Gold Theme */
    .bg-maroon {
        background-color: #800000 !important;
    }

    .text-gold {
        color: #FFD700 !important;
    }

    .card {
        border: 1px solid #FFD700;
        border-radius: 8px;
    }

    /* ===== Table Styling ===== */
    table.dataTable thead th {
        background-color: #800000;
        color: #FFD700;
        font-weight: bold;
    }

    table.dataTable tbody td {
        vertical-align: middle;
    }

    table.dataTable tbody tr:nth-child(odd) {
        background-color: #fffbe6;
    }

    table.dataTable tbody tr:nth-child(even) {
        background-color: #fffdf5;
    }

    /* ===== Buttons ===== */
    .btn-maroon {
        background-color: #800000;
        color: #FFD700;
        border: none;
        border-radius: 6px;
        padding: 6px 12px;
        transition: 0.3s ease-in-out;
    }

    .btn-maroon:hover {
        background-color: #600000;
        color: #fff;
    }

    /* Action Buttons */
    .btn-outline-danger {
        border: 2px solid #800000;
        color: #800000;
        transition: 0.3s ease-in-out;
    }

    .btn-outline-danger:hover {
        background-color: #800000;
        color: #FFD700;
    }

    .btn-circle {
        border-radius: 50% !important;
        width: 36px;
        height: 36px;
        padding: 0;
        text-align: center;
        font-size: 14px;
        line-height: 36px;
    }

    /* ===== Themed Buttons ===== */
    .btn-maroon {
        background-color: #800000;
        color: #FFD700;
        border: none;
        transition: 0.3s;
    }

    .btn-gold {
        background-color: #FFD700;
        color: #800000;
        border: none;
        transition: 0.3s;
    }

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

    .fw-bold {
        font-weight: bold !important;
    }

    .text-maroon {
        color: #800000 !important;
    }
</style>