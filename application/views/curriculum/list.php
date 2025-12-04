<div class="col-md-12 mt1 mb1">
    <div class="row">
        <a href="<?php echo base_url('curriculum/manage') ?>" class="btn btn-maroon float-right">
            <i class="fa fa-plus"></i> New Level
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
                            <h2 class="page-title text-maroon mb-0">Curriculum Levels
                            </h2>
                        </div>
                        <!-- <div class="col-md-6 text-md-end">
                            <div class="header-stats">
                                <span class="badge bg-maroon text-gold px-3 py-2">
                                    <i class="fa fa-list me-1"></i>
                                    <span id="curriculum-count">0</span> Levels
                                </span>
                            </div>
                        </div> -->
                    </div>
                </div>

                <table class="table table-bordered table-hover table-striped" width="100%" id="curriculum-field">
                    <colgroup>
                        <col width="5%">
                        <col width="30%">
                        <col width="30%">
                        <col width="20%">
                        <col width="15%">
                    </colgroup>
                    <thead class="bg-maroon text-gold">
                        <tr>
                            <th>#</th>
                            <th>Course</th>
                            <th>Year Level</th>
                            <th>Section</th>
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
    window.load_curriculum = function () {
        $('#curriculum-field').dataTable().fnDestroy();
        $('#curriculum-field tbody').html('<tr><td colspan="5">Loading data...</td></tr>');
        $.ajax({
            url: '<?php echo base_url('curriculum/load_list') ?>',
            method: 'POST',
            data: {},
            error: err => console.log(err),
            success: function (resp) {
                if (resp) {
                    if (typeof resp != undefined) {
                        $('#curriculum-field tbody').html('');
                        resp = JSON.parse(resp);
                        var i = 0;
                        Object.keys(resp).map(k => {
                            i++;
                            var tr = $('<tr>');
                            tr.append('<td>' + i + '</td>');
                            tr.append('<td class="text-maroon fw-bold">' + resp[k].course + '</td>');
                            tr.append('<td class="text-maroon">' + resp[k].year + '</td>');
                            tr.append('<td class="text-maroon">' + resp[k].section + '</td>');
                            tr.append(`
<td class="text-center">
    <button type="button" class="btn btn-gold btn-circle edit_curriculum mr-2" data-id="`+ resp[k].id + `">
        <i class="fa fa-edit"></i>
    </button>
    <button type="button" class="btn btn-maroon btn-circle remove_curriculum" data-id="`+ resp[k].id + `">
        <i class="fa fa-trash"></i>
    </button>
</td>
                        `);
                            $('#curriculum-field tbody').append(tr);
                        });

                        // Update curriculum count
                        $('#curriculum-count').text(i);
                    }
                }
            },
            complete: () => {
                $('#curriculum-field').dataTable();
                $('.edit_curriculum').click(function () {
                    location.replace('<?php echo base_url() ?>curriculum/manage/edit/' + $(this).attr('data-id'));
                });
                $('.remove_curriculum').click(function () {
                    delete_data('Are you sure to delete this data?', 'remove_curriculum', [$(this).attr('data-id')]);
                });
            }
        });
    }

    function remove_curriculum($id = '') {
        start_load();

        $.ajax({
            url: '<?php echo base_url() ?>curriculum/remove',
            method: 'POST',
            data: { id: $id },
            error: err => {
                console.log(err);
                Dtoast('An error occurred.', 'error');
                end_load();
            },
            success: function (resp) {
                end_load();
                resp = resp.trim();
                if (resp == 1) {
                    Dtoast('Data successfully deleted.', 'success');
                    load_curriculum();
                    $('.modal').modal('hide');
                } else {
                    Dtoast('Failed to delete data.', 'error');
                    console.log('Delete response:', resp);
                }
            }
        });
    }

    $(document).ready(function () {
        if ('<?php echo $this->session->flashdata('action_cur') ?>' == 1)
            Dtoast("Data successfully added", 'success');
        load_curriculum();
    });
</script>

<style>
    /* 🎨 Maroon & Gold Theme for Curriculum Table */
    .bg-maroon {
        background-color: #800000 !important;
    }

    .text-gold {
        color: #FFD700 !important;
    }

    .text-maroon {
        color: #800000 !important;
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

    .btn-maroon {
        background-color: #800000;
        color: #FFD700;
        border: none;
    }

    .btn-maroon:hover {
        background-color: #600000;
        color: #fff;
    }

    .btn-circle {
        border-radius: 50%;
        width: 36px;
        height: 36px;
        padding: 0;
        display: inline-flex;
        justify-content: center;
        align-items: center;
    }

    .table thead th {
        border-color: #FFD700 !important;
        text-align: center;
    }

    .table-hover tbody tr:hover {
        background-color: #fff3cd;
    }

    .card {
        border: 1px solid #e0e0e0;
    }

    .rounded-lg {
        border-radius: 0.75rem !important;
    }

    .shadow-lg {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }

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

    /* Table text styling */
    .fw-bold {
        font-weight: bold !important;
    }

    /* Button spacing */
    .mr-2 {
        margin-right: 0.5rem !important;
    }
</style>