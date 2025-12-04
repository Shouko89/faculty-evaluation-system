<div class="col-lg-12">
    <div class="card shadow-lg border-0 rounded-lg">
        <div class="card-body">

            <!-- Header with Back Button -->
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-3">
                <a href="<?php echo base_url('evaluation') ?>" class="btn btn-maroon mb-2 mb-md-0">
                    <i class="fa fa-arrow-left"></i>
                </a>
                <h3 class="h3-responsive text-maroon mb-0 text-center flex-grow-1">
                    <strong><?php echo "SY " . $meta['school_year'] ?> <?php echo $meta['semester'] . ' Sem' ?></strong>
                </h3>
            </div>
            <hr style="border-top:2px solid #FFD700;">

            <!-- Action Buttons -->
            <div class="d-flex flex-wrap gap-2 mb-3">
                <a class="btn btn-maroon btn-sm"
                   href="<?php echo base_url('evaluation/manage_questionaire/') . $meta['id'] . '/1' ?>">
                    Manage Students Questionnaire <i class="fa fa-list"></i>
                </a>
                <a class="btn btn-maroon btn-sm"
                   href="<?php echo base_url('evaluation/manage_questionaire/') . $meta['id'] . '/2' ?>">
                    Manage Chairperson Questionnaire <i class="fa fa-list"></i>
                </a>
                <button class="btn btn-gold btn-sm" id="add_restriction">
                    Restrict Evaluation <i class="fa fa-list"></i>
                </button>
            </div>
            <hr style="border-top:2px solid #FFD700;">

            <!-- Search Field -->
            <div class="d-flex justify-content-center mb-3">
                <div class="input-group" style="max-width: 400px; width: 100%;">
                    <input type="text" id="filter" class="styled-input form-control" placeholder="Search Faculty Here">
                    <button class="btn bg-maroon text-gold" type="button">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </div>

            <!-- Faculty List -->
            <div class="col-12 mt-3" id="faculty-list"></div>

        </div>
    </div>
</div>

<!-- Hidden Clone Template -->
<div id="clone-faculty" style="display:none">
    <div class="alert faculty-alert shadow-sm rounded-lg d-flex flex-column justify-content-between">
        <div>
            <i class="fas fa-user-tie text-maroon"></i>
            <span><b class='name text-maroon'>Test</b></span>
        </div>
        <hr style="border-top:1px solid #FFD700;">
        <a href="javascript:void(0)" class="view_handles btn btn-sm btn-gold align-self-end">
            Handled Classes <i class="fa fa-angle-right"></i>
        </a>
    </div>
</div>

<style>
/* 🎨 Maroon & Gold Theme */
.text-maroon { color: #800000 !important; }
.text-gold { color: #FFD700 !important; }
.bg-maroon { background-color: #800000 !important; }

.btn-maroon {
    background-color: #800000;
    color: #FFD700;
    border: none;
    border-radius: 6px;
    padding: 6px 12px;
    font-weight: bold;
    transition: 0.3s;
}
.btn-maroon:hover { background-color: #600000; color: #fff; }

.btn-gold {
    background-color: #FFD700;
    color: #800000;
    border: none;
    border-radius: 6px;
    padding: 6px 12px;
    font-weight: bold;
    transition: 0.3s;
}
.btn-gold:hover { background-color: #e6c200; color: #fff; }

/* Card & Alert Styling */
.card { border: 2px solid #FFD700; border-radius: 8px; }
.faculty-alert {
    background-color: #fffbe6;
    border: 2px solid #800000;
    border-radius: 6px;
    padding: 10px;
    margin: 5px;
    flex: 1 1 25%;
    position: relative;
    min-width: 200px;
}
.faculty-alert:hover { box-shadow: 0 0 8px rgba(255, 215, 0, 0.5); }

/* Input Styling */
.styled-input { 
    width: 100%;
    border: 2px solid #800000;
    border-radius: 6px 0 0 6px;
    padding: 8px 10px;
    font-size: 14px;
    color: #333;
    outline: none;
    transition: all 0.3s ease-in-out;
    background: #fffbe6;
}
.styled-input:focus { border-color: #FFD700; box-shadow: 0 0 8px rgba(255, 215, 0, 0.7); background: #fffdf5; }

.input-group .btn {
    border: 2px solid #800000;
    border-left: none;
    border-radius: 0 6px 6px 0;
    font-weight: bold;
    transition: 0.3s;
}
.input-group .btn:hover { background-color: #600000; color: #FFD700; }

/* Flex layout for faculty list */
#faculty-list { display: flex; flex-wrap: wrap; gap: 10px; }
</style>

<script>
$('#add_restriction').click(function() {
    frmModal('manage_restriction', 'New Restriction', '<?php echo base_url('evaluation/manage_restriction/') . $meta['id'] ?>', [], 'mid-large');
});

$(document).ready(function() {
    if ('<?php echo $this->session->flashdata('action_save_restriction') ?>' == 1)
        Dtoast("Data successfully added", 'success');

    load_faculty();

    function filterFaculty() {
        var _filter = $('#filter').val().toLowerCase();
        $('#faculty-list .faculty-alert').each(function() {
            var _name = $(this).find('.name').text().toLowerCase();
            $(this).toggle(_name.includes(_filter));
        });
    }

    // Trigger on typing
    $('#filter').on('keyup', filterFaculty);

    // Trigger on search button click
    $('#filter').siblings('button').on('click', filterFaculty);
});

window.load_faculty = function() {
    start_load();
    $.ajax({
        url: '<?php echo base_url('evaluation/load_faculty') ?>',
        method: 'POST',
        data: { id: '<?php echo $meta['id'] ?>' },
        success: function(resp) {
            resp = JSON.parse(resp);
            Object.keys(resp).map(k => {
                var _f = $('#clone-faculty .alert').clone();
                _f.find('.name').text(resp[k].name);
                _f.find('.view_handles').attr('data-id', resp[k].id);
                $('#faculty-list').append(_f);
            });
        },
        complete: function() {
            end_load();
            $('.view_handles').click(function() {
                frmModal('', 'Class List of: ' + $(this).parent().find('.name').text(),
                    '<?php echo base_url('evaluation/view_handles/') . $meta['id'] . '/' ?>' + $(this).attr('data-id'));
            });
        }
    });
}
</script>
    