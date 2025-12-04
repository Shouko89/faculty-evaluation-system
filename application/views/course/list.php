<div class="col-md-12 mt1 mb1">
    <div class="row">
        <a href="<?php echo base_url('course/manage') ?>" class="btn btn-maroon float-right">
            <i class="fa fa-plus"></i> New Course
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
                                Course List
                            </h2>
                        </div>
                        <!-- <div class="col-md-6 text-md-end">
                            <div class="header-stats">
                                <span class="badge bg-maroon text-gold px-3 py-2">
                                    <i class="fa fa-list me-1"></i>
                                    <span id="course-count">0</span> Courses
                                </span>
                            </div>
                        </div> -->
                    </div>
                </div>

                <table class="table table-bordered table-hover table-striped" width="100%" id="course-field">
                    <thead class="bg-maroon text-gold">
                        <tr>
                            <th>#</th>
                            <?php if ($_SESSION['login_user_type'] == 1): ?>
                                <th>Department</th>
                            <?php endif; ?>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="table-body-maroon"></tbody>
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
    }

    .btn-maroon:hover {
        background-color: #600000;
        color: #fff;
    }

    .btn-gold {
        background-color: #FFD700;
        color: #800000;
        border: none;
    }

    .btn-gold:hover {
        background-color: #e6c200;
        color: #fff;
    }

    /* Table styling */
    .table thead th {
        border-color: #FFD700 !important;
        text-align: center;
    }

    .table-hover tbody tr:hover {
        background-color: #fff3cd;
        /* light gold hover */
    }

    /* Action buttons */
    .btn-circle {
        border-radius: 50% !important;
        width: 36px;
        height: 36px;
        padding: 0;
        text-align: center;
        font-size: 14px;
        line-height: 36px;
    }

    .modal-header {
        background-color: #800000 !important;
        border-bottom: 2px solid #FFD700 !important;
    }

    .modal-title {
        color: #FFD700 !important;
        font-weight: bold;
        text-align: center;
        width: 100%;
        text-align: start;
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

    /* Card enhancements */
    .card {
        border: 1px solid #e0e0e0;
    }

    .rounded-lg {
        border-radius: 0.75rem !important;
    }

    .shadow-lg {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }

    /* Text alignment */
    .text-center {
        text-align: center !important;
    }

    .float-right {
        float: right !important;
    }

    /* Table text styling */
    .fw-bold {
        font-weight: bold !important;
    }
</style>

<script>
    window.load_course = function () {
        $('#course-field tbody').html('<tr><td colspan="4">Loading data...</td></tr>')
        $.ajax({
            url: '<?php echo base_url('course/load_list') ?>',
            method: 'POST',
            data: {},
            error: err => console.log(err),
            success: function (resp) {
                if (resp) {
                    if (typeof resp != undefined) {
                        $('#course-field tbody').html('')
                        resp = JSON.parse(resp)
                        var i = 0;
                        Object.keys(resp).map(k => {
                            i++;
                            var tr = $('<tr>')
                            tr.append('<td>' + i + '</td>')
                            if (<?php echo $_SESSION['login_user_type'] ?> == 1)
                                tr.append('<td class="text-maroon fw-bold">' + resp[k].department + '</td>')
                            tr.append('<td class="text-maroon fw-bold">' + resp[k].course + '</td>')
                            tr.append('<td class="text-maroon">' + resp[k].description + '</td>')
                            tr.append(`
    <td class="text-center">
        <button type="button" 
            class="btn btn-gold btn-circle edit_course mr-2" 
            data-id="`+ resp[k].id + `">
            <i class="fa fa-edit"></i>
        </button>
        <button type="button" 
            class="btn btn-maroon btn-circle remove_course" 
            data-id="`+ resp[k].id + `">
            <i class="fa fa-trash"></i>
        </button>
    </td>
`);

                            $('#course-field tbody').append(tr)
                        })

                        // Update course count
                        $('#course-count').text(i);
                    }
                }
            },
            complete: () => {
                $('.edit_course').each(function (e) {
                    $(this).click(function () {
                        location.replace('<?php echo base_url() ?>course/manage/edit/' + $(this).attr('data-id'))
                    })
                })
                $('.remove_course').each(function (e) {
                    $(this).click(function () {
                        delete_data('Are you sure to delete this data?', 'remove_dept', [$(this).attr('data-id')])
                    })
                })
                $('#course-field').dataTable()
            }
        })
    }

    function remove_dept($id = '') {
        $.ajax({
            url: '<?php echo base_url() ?>course/remove',
            method: 'POST',
            data: { id: $id },
            error: err => {
                console.log(err)
                Dtoast('An error occured.', 'error')
            },
            success: function (resp) {
                if (resp == 1) {
                    Dtoast('Data successfully deleted.', 'success')
                    load_course()
                    $('.modal').modal('hide')
                }
            }
        })
    }

    $(document).ready(function () {
        if ('<?php echo $this->session->flashdata('action_dept') ?>' == 1)
            Dtoast('Data successfully Saved.', 'success')

        load_course();
    })
</script>