<div class="col-md-12 mt1 mb1">
    <div class="row">
        <a href="<?php echo base_url('chairperson/manage') ?>" class="btn btn-maroon float-right">
            <i class="fa fa-plus"></i> New Chairperson
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
Chairperson List
                            </h2>
                        </div>
                        <!-- <div class="col-md-6 text-md-end">
                            <div class="header-stats">
                                <span class="badge bg-maroon text-gold px-3 py-2">
                                    <i class="fa fa-list me-1"></i>
                                    <span id="chairperson-count">0</span> Chairpersons
                                </span>
                            </div>
                        </div> -->
                    </div>
                </div>

                <table class="table table-bordered table-hover table-striped" width="100%" id="chairperson-field">
                    <thead class="bg-maroon text-gold">
                        <tr>
                            <th>#</th>
                            <th>ID #</th>
                            <th>Name</th>
                            <?php if ($_SESSION['login_user_type'] == 1): ?>
                                <th>Department</th>
                            <?php endif; ?>
                            <th>Course</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    window.load_chairperson = function () {
        $('#chairperson-field').dataTable().fnDestroy();
        $('#chairperson-field tbody').html('<tr><td colspan="6">Loading data...</td></tr>')
        $.ajax({
            url: '<?php echo base_url('chairperson/load_list') ?>',
            method: 'POST',
            data: {},
            error: err => console.log(err),
            success: function (resp) {
                if (resp) {
                    if (typeof resp != undefined) {
                        $('#chairperson-field tbody').html('')
                        resp = JSON.parse(resp)
                        var i = 0;
                        Object.keys(resp).map(k => {
                            i++;
                            var tr = $('<tr>')
                            tr.append('<td>' + i + '</td>')
                            tr.append('<td class="text-maroon">' + resp[k].id_code + '</td>')
                            tr.append('<td class="text-maroon fw-bold">' + resp[k].name + '</td>')
                            if (<?php echo $_SESSION['login_user_type'] ?> == 1)
                                tr.append('<td class="text-maroon">' + resp[k].dname + '</td>')
                            tr.append('<td class="text-maroon">' + resp[k].cname + '</td>')
                            tr.append(
                                '<td class="text-center">' +
                                '<button type="button" class="btn btn-gold btn-circle edit_chairperson mr-2" data-id="' + resp[k].id + '"><i class="fa fa-edit"></i></button>' +
                                '<button type="button" class="btn btn-maroon btn-circle remove_chairperson" data-id="' + resp[k].id + '"><i class="fa fa-trash"></i></button>' +
                                '</td>'
                            )
                            $('#chairperson-field tbody').append(tr)
                        })
                        
                        // Update chairperson count
                        $('#chairperson-count').text(i);
                    }
                }
            },
            complete: () => {
                $('#chairperson-field').dataTable()
                $('.edit_chairperson').each(function (e) {
                    $(this).click(function () {
                        location.replace('<?php echo base_url() ?>chairperson/manage/' + $(this).attr('data-id'))
                    })
                })
                $('.remove_chairperson').each(function (e) {
                    $(this).click(function () {
                        delete_data('Are you sure to delete this data?', 'remove_chairperson', [$(this).attr('data-id')])
                    })
                })
            }
        })
    }
    
    function remove_chairperson($id = '') {
        $.ajax({
            url: '<?php echo base_url() ?>chairperson/remove',
            method: 'POST',
            data: { id: $id },
            error: err => {
                console.log(err)
                Dtoast('An error occured.', 'error')
            },
            success: function (resp) {
                if (resp == 1) {
                    Dtoast('Data successfully deleted.', 'success')
                    load_chairperson()
                    $('.modal').modal('hide')
                }
            }
        })
    }
    
    $(document).ready(function () {
        if ('<?php echo $this->session->flashdata('action_save_chairperson') ?>' == 1)
            Dtoast("Data successfully added", 'success');
        load_chairperson();
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
        background-color: #800000 !important;
        color: #FFD700 !important;
        text-align: center;
        border-color: #FFD700 !important;
    }

    .table td {
        vertical-align: middle !important;
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