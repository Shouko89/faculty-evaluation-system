<div class="col-md-12 mt1 mb1">
    <div class="row">
        <a href="<?php echo base_url('department/manage') ?>" class="btn btn-maroon float-right">
            <i class="fa fa-plus"></i> New Department
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
                                </i>Department List
                            </h2>
                        </div>
                        <!-- <div class="col-md-6 text-md-end">
                            <div class="header-stats">
                                <span class="badge bg-maroon text-gold px-3 py-2">
                                    <i class="fa fa-list me-1"></i>
                                     <span id="department-count">0</span> Departments 
                                </span>
                            </div>
                        </div> -->
                    </div>
                </div>

                <table class="table table-bordered table-hover table-striped" width="100%" id="department-field">
                    <thead class="bg-maroon text-gold">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Description</th>
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
    window.load_department = function () {
        $('#department-field tbody').html('<tr><td colspan="4">Loading data...</td></tr>')
        $.ajax({
            url: '<?php echo base_url('department/load_list') ?>',
            method: 'POST',
            error: err => console.log(err),
            success: function (resp) {
                if (resp) {
                    if (typeof resp != undefined) {
                        $('#department-field tbody').html('')
                        resp = JSON.parse(resp)
                        var i = 0;
                        Object.keys(resp).map(k => {
                            i++;
                            var tr = $('<tr>')
                            tr.append('<td>' + i + '</td>')
                            tr.append('<td class="text-maroon fw-bold">' + resp[k].department + '</td>')
                            tr.append('<td class="text-maroon">' + resp[k].description + '</td>')

                            tr.append(`
<td class="text-center">
    <button type="button" class="btn btn-gold btn-circle edit_department" data-id="`+ resp[k].id + `">
        <i class="fa fa-edit"></i>
    </button>
    <button type="button" class="btn btn-maroon btn-circle remove_department" data-id="`+ resp[k].id + `">
        <i class="fa fa-trash"></i>
    </button>
</td>

                        `)
                            $('#department-field tbody').append(tr)
                        })

                        // Update department count
                        $('#department-count').text(i);
                    }
                }
            },
            complete: () => {
                $('.edit_department').click(function () {
                    location.replace('<?php echo base_url() ?>department/manage/edit/' + $(this).attr('data-id'))
                })
                $('.remove_department').click(function () {
                    delete_data('Are you sure to delete this data?', 'remove_dept', [$(this).attr('data-id')])
                })
                $('#department-field').dataTable()
            }
        })
    }

    function remove_dept($id = '') {
        $.ajax({
            url: '<?php echo base_url() ?>department/remove',
            method: 'POST',
            data: { id: $id },
            error: err => {
                console.log(err)
                Dtoast('An error occured.', 'error')
            },
            success: function (resp) {
                if (resp == 1) {
                    Dtoast('Data successfully deleted.', 'success')
                    load_department()
                    $('.modal').modal('hide')
                }
            }
        })
    }

    $(document).ready(function () {
        if ('<?php echo $this->session->flashdata('action_dept') ?>' == 1)
            Dtoast('Data successfully Saved.', 'success')
        load_department();
    })
</script>

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

    .btn-gold {
        background-color: #FFD700;
        color: #800000;
        border: none;
    }

    .btn-gold:hover {
        background-color: #e6c200;
        color: #fff;
    }

    /* Delete Button (Maroon) */
    .btn-maroon {
        background-color: #800000;
        color: #FFD700;
        border: none;
    }

    .btn-maroon:hover {
        background-color: #600000;
        color: #fff;
    }

    .table thead th {
        border-color: #FFD700 !important;
    }

    .table-hover tbody tr:hover {
        background-color: #fff3cd;
        /* light gold hover */
    }

    .modal-header {
        background-color: #800000 !important;
        /* Maroon background */
        border-bottom: 2px solid #FFD700 !important;
        /* Gold underline */
    }

    .modal-title {
        color: #FFD700 !important;
        /* Gold text */
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

    /* Circle buttons */
    .btn-circle {
        border-radius: 50% !important;
        width: 36px;
        height: 36px;
        padding: 0;
        text-align: center;
        font-size: 14px;
        line-height: 36px;
    }

    .text-maroon {
        color: #800000 !important;
    }

    .fw-bold {
        font-weight: bold !important;
    }
</style>