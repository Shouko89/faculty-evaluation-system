<link rel="stylesheet" href="<?php echo base_url('assets/sortable') ?>/jquery-ui.css">
<script src="<?php echo base_url('assets/sortable') ?>/jquery-ui.js"></script>

<?php
$criteria_arr = array();
$criteria = $this->db->query("SELECT * FROM criteria where status = 1 order by order_by asc");
foreach ($criteria->result_array() as $row):
    $criteria_arr[] = $row;
endforeach;
?>

<div class="col-md-12 card shadow-lg rounded-lg border-0">
    <!-- Header -->
    <div
        class="view view-cascade gradient-card-header bg-maroon text-gold d-flex flex-column flex-md-row justify-content-between align-items-center p-3">
        <h2 class="card-header-title text-light text-center mb-2 mb-md-0">
            <strong><?php echo "SY " . $meta['school_year'] ?>-<?php echo $meta['semester'] . " Sem" ?></strong>
        </h2>
        <div class="d-flex gap-2 justify-content-center mb-2 mb-md-0">
            <button class="btn btn-gold btn-sm" id="new_question"><i class="fa fa-plus"></i> New Question</button>
            <button class="btn btn-gold btn-sm" onclick="$('#questionaire-frm').submit()"><i class="fa fa-save"></i>
                Save</button>
        </div>
    </div>

    <!-- Body -->
    <div class="card-body" style="max-height:600px; overflow:auto; padding-bottom:80px;">
        <form id="questionaire-frm">
            <input type="hidden" name="id" value="<?php echo $meta['id'] ?>">
            <input type="hidden" name="question_for" value="<?php echo $for ?>">
            <ul id="evaluation-field" class="list-unstyled"></ul>
        </form>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="manage_question" tabindex="-1" aria-modal="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-maroon text-gold">
                <h5 class="modal-title">New Question</h5>
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"><i
                        class="fa fa-times"></i></button>
            </div>
            <div class="modal-body">
                <form id="question-frm">
                    <input type="hidden" name="item_id" value="">

                    <!-- Question Input -->
                    <div class="mb-3">
                        <label for="question" class="form-label text-maroon">Question</label>
                        <textarea id="question" class="form-control bg-light border border-maroon text-maroon" rows="4"
                            name="question"
                            placeholder="Type your question here (e.g., Rate the cleanliness of the classroom)"
                            required></textarea>
                        <small class="text-muted">Provide a clear and concise question for students to answer.</small>
                    </div>

                    <!-- Criteria Selection -->
                    <div class="mb-3">
                        <label class="text-maroon">Criteria</label>
                        <input type="hidden" name="criteria_id" value="">
                        <div id="criteria-tree" class="border border-maroon rounded p-2"
                            style="max-height: 250px; overflow-y:auto;"></div>
                        <small class="text-muted">Select the criteria this question belongs to.</small>
                    </div>

                    <input type="hidden" id="qtype" name="qtype" value="1" />
                </form>
            </div>

            <!-- Footer Buttons -->
            <div class="modal-footer">
                <button type="button" class="btn btn-gold" onclick="$('#question-frm').submit()"><i
                        class="fa fa-plus"></i> Add Question</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i>
                    Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Clones -->
<div id="rating_clone" style="display:none">
    <div class="question-item mb-2 border rounded p-2 bg-light d-flex justify-content-between align-items-start">
        <div class="question-content flex-grow-1">
            <div class="question-text mb-2"><strong></strong></div>
            <div class="rating-field">
                <input type="hidden" name="qid[]">
                <input type="hidden" name="question[]">
                <input type="hidden" name="type[]">
                <input type="hidden" name="criteria_id[]">
                <span class="opt-group"></span>
            </div>
        </div>
        <div class="ms-2">
            <button class="btn btn-danger btn-sm remove-field"><i class="fa fa-trash"></i></button>
        </div>
    </div>
</div>

<div id="textare_clone" style="display:none">
    <div class="question-item mb-2 border rounded p-2 bg-light d-flex justify-content-between align-items-start">
        <div class="question-content flex-grow-1">
            <div class="question-text mb-2"><strong></strong></div>
            <div class="textarea-field mt-2">
                <textarea class="form-control bg-light border border-maroon text-maroon" rows="4"
                    placeholder="Write your answer here."></textarea>
            </div>
            <input type="hidden" name="qid[]">
            <input type="hidden" name="question[]">
            <input type="hidden" name="type[]">
            <input type="hidden" name="criteria_id[]">
        </div>
        <div class="ms-2">
            <button class="btn btn-danger btn-sm remove-field"><i class="fa fa-trash"></i></button>
        </div>
    </div>
</div>

<!-- Styles -->
<style>
    .text-maroon {
        color: #800000 !important;
    }

    .text-gold {
        color: #FFD700 !important;
    }

    .bg-maroon {
        background-color: #800000 !important;
    }

    .border-maroon {
        border-color: #800000 !important;
    }

    .btn-maroon {
        background-color: #800000;
        color: #FFD700;
        border: none;
        border-radius: 6px;
        padding: 6px 12px;
        font-weight: bold;
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
        border-radius: 6px;
        padding: 6px 12px;
        font-weight: bold;
        transition: 0.3s;
    }

    .btn-gold:hover {
        background-color: #e6c200;
        color: #fff;
    }

    .question-item {
        display: flex;
        gap: 10px;
        align-items: flex-start;
    }

    .question-item .remove-field {
        position: static;
    }

    #criteria-tree .jstree-anchor {
        color: #800000;
    }

    #criteria-tree .jstree-themeicon {
        background-color: #FFD700 !important;
    }

    .ui-state-default {
        background: #fffbe6;
        border: 2px solid #800000;
        border-radius: 6px;
        padding: 8px;
        margin-bottom: 5px;
    }

    .card-body::-webkit-scrollbar {
        width: 8px;
    }

    .card-body::-webkit-scrollbar-thumb {
        background: #800000;
        border-radius: 4px;
    }

    .card-body::-webkit-scrollbar-track {
        background: #fffbe6;
    }

    .criteria-item>b {
        color: #800000;
        /* maroon color */
        font-size: 1.2rem;
        /* make it bigger */
        display: block;
        /* put each on its own line */
        margin-bottom: 5px;
        /* add a little space below */
    }

    .criteria-item ul {
        margin-left: 20px;
    }

    .criteria-item ul b {
        font-size: 1.1rem;
        color: #800000;
    }
</style>

<script>
    $(document).ready(function () {
        load_list();
        load_criteria();
        $('#criteria-tree').on("select_node.jstree", function (e, data) { $('[name="criteria_id"]').val(data.node.id); });
        $('#new_question').click(function () {
            $('#manage_question').modal('show')
        })

        $('#question-frm').submit(function (e) {
            e.preventDefault();
            start_load()
            var q = $(this).find('[name="question"]').val();
            var t = $(this).find('[name="qtype"]').val();
            var c = $(this).find('[name="criteria_id"]').val();
            var item;
            var item_count = $('#evaluation-field .question-item').length + 1;
            if (t == 1) {
                item = $('#rating_clone .question-item').clone()
                for (var i = 1; i <= 5; i++) {
                    //   console.log(i)
                    item.find('.opt-group').append('<span class="mx-2"><input type="radio" id="rating-' + i + '-' + item_count + '" name="rating[' + item_count + '][]" value="' + i + '" readonly/><label for="rating-' + i + '-' + item_count + '"> ' + i + '</label></span>')
                }

            } else {
                item = $('#textare_clone .question-item').clone()
            }
            item.find('[name="question[]"]').val(q)
            item.find('[name="type[]"]').val(t)
            item.find('[name="criteria_id[]"]').val(c)
            item.find('.question-text strong').html(q)
            $('#evaluation-field li[data-id="' + c + '"] .qf').append(item)
            $('#question-frm').get(0).reset()
            end_load();
            $('.modal').modal('hide')

            rem_func();

        })
        function createJSTrees(jsonData) {
            $("#criteria-tree").jstree('destroy');
            $('#criteria-tree').jstree({
                plugins: ["table", "dnd", "contextmenu", "crrm", "search"],

                "table": {
                    columns: [{ width: 300, header: "Name" }],
                    resizable: false,
                }, core: {
                    "animation": 0,
                    "check_callback": true,
                    "themes": { "stripes": true },
                    data: jsonData
                },
            }).on('loaded.jstree', function () {
                $("#criteria-tree").jstree('open_all');
                $('.jstree-table-cell').css('margin', 'unset !important');
                var jsonNodes = $('#criteria-tree').jstree(true).get_json('#', { flat: false });
                $.each(jsonNodes, function (i, val) {
                    // if($(val).attr('id') != vtype){
                    // 	// console.log($(val).attr('id'));
                    // }
                })

            });
        }
        function load_list() {

            $.ajax({
                async: true,
                type: "GET",
                url: "<?php echo base_url(); ?>criteria/load_list",
                dataType: "json",

                success: function (json) {
                    createJSTrees(json);
                },

                error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                }
            });
        }
        $('#questionaire-frm').submit(function (e) {
            e.preventDefault()
            start_load()
            $.ajax({
                url: '<?php echo base_url('evaluation/save_questionaire') ?>',
                method: 'POST',
                data: $(this).serialize(),
                error: err => {
                    console.log(err)
                    Dtoast('An error occured', 'error');
                    end_load();
                },
                success: function (resp) {
                    if (typeof resp != undefined) {
                        resp = JSON.parse(resp);
                        if (resp.status == 1) {
                            Dtoast(resp.msg, 'success');
                        } else {
                            Dtoast(resp.msg, 'failed');
                        }
                        end_load();
                    }
                }
            })
        })
    })
    window.load_criteria = function () {
        var criteria = <?php echo json_encode($criteria_arr) ?>;
        Object.keys(criteria).map(function (k) {
            var li = $('<li class="criteria-item"></li>')
            li.attr('data-id', criteria[k].id)
            li.append('<b>' + criteria[k].criteria + '</b>')
            li.append('<div class="qf"></div>')
            if ($('#evaluation-field li[data-id="' + criteria[k].parent_id + '"]').length > 0) {
                var ul = $('<ul></ul>');
                ul.append(li)
                $('#evaluation-field').append(ul)
            } else {
                $('#evaluation-field').append(li)
            }
        })
        load_questions();

    }
    window.load_questions = function () {
        start_load();
        $.ajax({
            url: '<?php echo base_url('evaluation/load_questions') ?>',
            method: 'POST',
            data: { id: '<?php echo $meta['id'] ?>', for: '<?php echo $for ?>' },
            error: err => {
                console.log(err)
                Dtoast('An error occured', 'error');
                end_load();
            },
            success: function (resp) {
                if (typeof resp != undefined) {
                    resp = JSON.parse(resp)
                    if (Object.keys(resp).length > 0) {
                        Object.keys(resp).map(k => {
                            var q = resp[k].question;
                            var t = resp[k].type;
                            var id = resp[k].id;
                            var c = resp[k].criteria_id;

                            var item = '';
                            var item_count = $('#evaluation-field .question-item').length + 1;
                            if (t == 1) {
                                item = $('#rating_clone .question-item').clone()
                                for (var i = 1; i <= 5; i++) {
                                    //   console.log(i)
                                    item.find('.opt-group').append('<span class="mx-2"><input type="radio" id="rating-' + i + '-' + item_count + '" name="rating[' + item_count + '][]" value="' + i + '" readonly/><label for="rating-' + i + '-' + item_count + '"> ' + i + '</label></span>')
                                }

                            } else {
                                item = $('#textare_clone .question-item').clone()
                            }
                            item.find('[name="qid[]"]').val(id)
                            item.find('[name="question[]"]').val(q)
                            item.find('[name="type[]"]').val(t)
                            item.find('[name="criteria_id[]"]').val(c)
                            item.find('.question-text strong').html(q)
                            console.log(c)
                            $('#evaluation-field li[data-id="' + c + '"] .qf').append(item)

                        })
                    }

                    end_load();
                }
            },
            complete: function () {
                rem_func();
            }
        })
    }
    function rem_func() {
        $('.remove-field').off('click').on('click', function () {
            $(this).closest('.question-item').remove()
        })
    }

</script>

<script>
    $(function () {
        $(".qf").sortable();
        $(".qf").disableSelection();
    });
</script>