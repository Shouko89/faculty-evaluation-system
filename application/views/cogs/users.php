<div class="container-fluid">
    <div class="col-lg-12">
        <!-- New User Button -->
        <div class="row">
            <div class="col-md-12">
                <button class="btn btn-maroon float-right" type="button" id="new_user">
                    <i class="fa fa-plus"></i> New User
                </button>
            </div>
        </div>

        <div class="card shadow-lg border-0 rounded-lg">
            <div class="card-body">
                <!-- Page Header -->
                <div class="page-header mb-4">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h2 class="page-title text-maroon mb-0">
                                Users List
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

                <table class="table table-bordered table-hover table-striped" width="100%" id="user-field">
                    <colgroup>
                        <col width="5%">
                        <col width="30%">
                        <col width="30%">
                        <col width="20%">
                    </colgroup>
                    <thead class="bg-maroon text-gold">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Username</th>
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
    window.load_users = function () {
        $('#user-field').dataTable().fnDestroy();
        $('#user-field tbody').html('<tr><td colspan="4">Loading data...</td></tr>');
        $.ajax({
            url: '<?php echo base_url('cogs/users_list') ?>',
            method: 'GET',
            error: err => console.log(err),
            success: function (resp) {
                if (resp) {
                    $('#user-field tbody').html('');
                    try {
                        resp = JSON.parse(resp);
                    } catch (e) {
                        console.log("Invalid JSON response", resp);
                        return;
                    }
                    var i = 0;
                    Object.keys(resp).map(k => {
                        i++;
                        var tr = $('<tr>');
                        tr.append('<td>' + i + '</td>');
                        tr.append('<td class="text-maroon fw-bold">' + resp[k].name + '</td>');
                        tr.append('<td class="text-maroon">' + resp[k].username + '</td>');
                        tr.append(`
                        <td class="text-center">
                            <button type="button" class="btn btn-gold btn-circle edit_user mr-2" data-id="${resp[k].id}">
                                <i class="fa fa-edit"></i>
                            </button>
                            <button type="button" class="btn btn-maroon btn-circle remove_user" data-id="${resp[k].id}">
                                <i class="fa fa-trash"></i>
                            </button>
                        </td>
                    `);
                        $('#user-field tbody').append(tr);
                    });

                    // Update user count
                    $('#user-count').text(i);
                }
            },
            complete: () => {
                $('#user-field').dataTable();

                // Edit action
                $('.edit_user').each(function () {
                    $(this).click(function () {
                        frmModal('manage-users', "Edit User", "<?php echo base_url('cogs/manage_users/') ?>" + $(this).attr('data-id'));
                    });
                });

                // Delete action
                $('.remove_user').each(function () {
                    $(this).click(function () {
                        delete_data('Are you sure to delete this user?', 'remove_user', [$(this).attr('data-id')]);
                    });
                });
            }
        })
    }

    // Actual delete function
    function remove_user($id = '') {
        start_load(); // show loader
        $.ajax({
            url: '<?php echo base_url() ?>cogs/delete_user/' + $id,
            method: 'POST',
            error: err => {
                console.log(err);
                Dtoast('An error occurred.', 'error');
                end_load(); // close loader
            },
            success: function (resp) {
                try {
                    resp = JSON.parse(resp);
                    if (resp.status == 1) {
                        Dtoast(resp.msg, 'success');
                        load_users();

                        // ✅ close the modal after delete
                        $('.modal').modal('hide');
                    } else {
                        Dtoast(resp.msg, 'error');
                    }
                } catch (e) {
                    console.log("Invalid server response", resp);
                    Dtoast('Unexpected server response.', 'error');
                }
            },
            complete: function () {
                end_load(); // always stop loader
            }
        })
    }

    $(document).ready(function () {
        load_users();
        $('#new_user').click(function () {
            frmModal('manage-users', "New User", "<?php echo base_url('cogs/manage_users') ?>");
        });
    });
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

    .border-gold {
        border: 1px solid #FFD700 !important;
    }

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

    .table thead th {
        text-align: center;
        border-color: #FFD700 !important;
    }

    .table-hover tbody tr:hover {
        background-color: #fff3cd;
        /* light gold hover */
    }

    /* 🎨 Circle Action Buttons */
    .btn-circle {
        border-radius: 50% !important;
        width: 36px;
        height: 36px;
        padding: 0;
        text-align: center;
        font-size: 14px;
        line-height: 36px;
    }

    /* 🎨 Themed Modal Header */
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
    .table-bordered {
        border: 1px solid #dee2e6;
    }

    .table-bordered th,
    .table-bordered td {
        border: 1px solid #dee2e6;
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: rgba(0, 0, 0, 0.02);
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

    /* Button spacing */
    .mr-2 {
        margin-right: 0.5rem !important;
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

    /* New User Button Styling */
    #new_user {
        margin-bottom: 1rem;
    }
</style>