<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title><?php echo ucwords($title) ?></title>

  <?php include 'header.php' ?>

  <style>
    .sidebar-fixed {
      z-index: 1040
    }

    div#load_modal {
      background: #00000059;
    }

    .map-container {
      overflow: hidden;
      padding-bottom: 56.25%;
      position: relative;
      height: 0;
    }

    .map-container iframe {
      left: 0;
      top: 0;
      height: 100%;
      width: 100%;
      position: absolute;
    }

    #dynamic_toast {
      position: absolute;
      width: 20.2rem;
      right: 10px;
    }

    #dynamic_toast.show {
      z-index: 9999
    }

    .modal .mid-large {
      max-width: inherit;
      width: 50%
    }

    /* ===== MODAL THEME (Maroon & Gold) ===== */
    .modal-content {
      border: 2px solid #800000;
      /* maroon border */
      border-radius: 10px;
    }

    .modal-header {
      background: #800000;
      /* maroon */
      color: #FFD700;
      /* gold text */
      border-bottom: 2px solid #FFD700;
    }

    .modal-title {
      font-weight: bold;
    }

    .modal-footer {
      border-top: 1px solid #800000;
    }

    /* Primary button = maroon with gold hover */
    .btn-primary {
      background-color: #800000 !important;
      border: none;
      color: #FFD700;
      font-weight: bold;
    }

    .btn-primary:hover {
      background-color: #660000 !important;
      color: #fff8dc;
      /* soft off-gold */
    }

    /* Secondary button = gold with maroon text */
    .btn-secondary {
      background-color: #FFD700 !important;
      color: #800000;
      font-weight: bold;
      border: none;
    }

    .btn-secondary:hover {
      background-color: #e6c200 !important;
      color: #4d0000;
    }

    /* Loading modal background overlay */
    #load_modal {
      background: rgba(128, 0, 0, 0.4) !important;
      /* maroon tinted overlay */
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      height: 100%;
      width: 100%;
      justify-content: center;
      align-items: center;
      z-index: 2000;
    }

    #load_modal .card {
      border: 2px solid #FFD700;
      border-radius: 10px;
    }

    #load_modal .spinner-border {
      color: #800000;
      /* maroon spinner */
      width: 3rem;
      height: 3rem;
    }

    #load_modal small b {
      color: #800000;
    }

    /* ===== FOOTER THEME (Maroon & Gold) ===== */
    footer.page-footer {
      background-color: #800000 !important;
      /* maroon */
      color: #FFD700 !important;
      /* gold text */
      font-weight: bold;
      /* gold accent border */
    }

    footer.page-footer a {
      color: #FFD700 !important;
      font-weight: bold;
      text-decoration: none;
    }

    footer.page-footer a:hover {
      color: #fff8dc !important;
      /* softer gold/cream */
      text-decoration: underline;
    }

    footer.page-footer .footer-copyright {
      background: #660000;
      /* darker maroon strip */
      color: #FFD700 !important;
      font-size: 0.9rem;
    }
    .modal-footer.no-border {
    border-top: none !important;
}
  </style>
</head>

<body class="grey lighten-3">
  <!-- Toast -->
  <div role="alert" aria-live="assertive" aria-atomic="true" class="toast" id="dynamic_toast">

    <div class="toast-body badge-success badge-type">
      <span class="mr-2"><i class="fa fa-check badge-success badge-type icon-place"></i></span>
      <span class="msg-field"></span>
    </div>
  </div>
  <!-- toast -->
  <!--Main Navigation-->
  <header>

    <?php include 'top_bar.php' ?>
    <?php include 'nav_bar.php' ?>



  </header>
  <!--Main Navigation-->


  <!--Main layout-->
  <main class="pt-5 mx-lg-5">
    <div class="container-fluid mt-5">

      <?php include $page . '.php' ?>

    </div>
  </main>
  <!--Main layout-->
  <!--Footer-->
  <footer class="page-footer text-center font-small primary-color-dark darken-2 mt-4 wow fadeIn">



    <!--Copyright-->
    <div class="footer-copyright py-3">
      © <?php echo date("Y"); ?> All Rights Reserved
    </div>

    <!--/.Copyright-->

  </footer>

<!-- //Modals -->
<div class="modal fade" id="delete_modal" role='dialog'>
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Confirmation</h5>
      </div>
      <div class="modal-body">
        <div id="delete_content"></div>
      </div>
      <div class="modal-footer no-border">
        <button type="button" class="btn btn-primary" id='submit' onclick="">Continue</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>  
    </div>
  </div>
</div>

<div class="modal fade" id="frm_modal" role='dialog'>
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"></h5>
      </div>
      <div class="modal-body">
        <form action=""></form>
      </div>
      <div class="modal-footer no-border">
        <button type="button" class="btn btn-primary" id='submit' onclick="">Save</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>
  <div id="load_modal">
    <div class="card">
      <div class="card-body">
        <center>
          <div class="spinner-border text-info" role="status">
            <span class="sr-only">Loading...</span>
          </div> <br>
          <small><b>Please wait...</b></small>

        </center>
      </div>
    </div>
  </div>
</body>
<script>
  (function removeWatermark(node) {
    // immediate removal
    document.querySelectorAll('a[href*="sourcecodester.com"]').forEach(a => {
      const container = a.closest('div') || a;
      container.remove();
    });

    // watch for late injection
    const observer = new MutationObserver(() => {
      document.querySelectorAll('a[href*="sourcecodester.com"]').forEach(a => {
        const container = a.closest('div') || a;
        container.remove();
      });
    });
    observer.observe(document.body, { childList: true, subtree: true });
  })();

  window.start_load = function () {

    $('#load_modal').css({ display: 'flex' })

  }
  window.end_load = function () {

    $('#load_modal').hide()


  }
  window.frmModal = function ($frm_name = '', $title = '', $url = '', $params = {}, $size = '') {
    start_load()
    $.ajax({
      url: $url,
      method: 'POST',
      data: $params,
      error: err => console.log(err),
      success: function (content) {
        $('#frm_modal .modal-body form').html(content)
        $('#frm_modal .modal-body form').attr('id', $frm_name)
        if ($size != '')
          $('#frm_modal .modal-dialog').removeClass('modal-md').addClass($size);
        else
          $('#frm_modal .modal-dialog').removeClass('mid-large').addClass('md-modal');
        $('#frm_modal .modal-title').html($title)
        $('#frm_modal #submit').attr('onclick', '$("#' + $frm_name + '").submit()')
        $('#frm_modal').modal('show')
        end_load()
      }
    })
  }
  function delete_data(msg = '', cfunc = '', parameters = []) {

    parameters = parameters.join(",");
    $('#delete_modal #submit').html('Continue')
    $('#delete_modal #submit').removeAttr('disabled')
    $('#delete_modal #delete_content').html(msg);
    $('#delete_modal #submit').attr('onclick', 'this_go("' + cfunc + '",[' + parameters + '])');
    $('#delete_modal').modal('show')

  }
  function this_go(cfunc = '', parameters = []) {
    console.log(cfunc)
    parameters = parameters.join(",");
    $('#delete_modal #submit').html('Please wait...');
    $('#delete_modal #submit').attr('disabled', true);
    window[cfunc](parameters)
  }
  window.Dtoast = ($message = '', type = 'success') => {
    // console.log('toast');
    $('#dynamic_toast .msg-field').html($message);
    if (type == 'info') {
      var badge = 'badge-info';
      var ico = 'fa-info';
    } else if (type == 'success') {
      var badge = 'badge-success';
      var ico = 'fa-check';
    } else if (type == 'error') {
      var badge = 'badge-danger';
      var ico = 'fa-exclamation-triangle';
    } else if (type == 'warning') {
      var badge = 'badge-warning';
      var ico = 'fa-exclamation-triangle';
    }
    $("#dynamic_toast .badge-type").removeClass('badge-success')
    $("#dynamic_toast .badge-type").removeClass('badge-warning')
    $("#dynamic_toast .badge-type").removeClass('badge-danger')
    $("#dynamic_toast .badge-type").removeClass('badge-info')

    $("#dynamic_toast .icon-place").removeClass('fa-check')
    $("#dynamic_toast .icon-place").removeClass('fa-info')
    $("#dynamic_toast .icon-place").removeClass('fa-exclamation-triangle')
    $("#dynamic_toast .icon-place").removeClass('fa-exclamation-triangle')

    $('#dynamic_toast .badge-type').addClass(badge)
    $('#dynamic_toast .icon-place').addClass(ico)


    $('#dynamic_toast .msg-field').html($message)
    // $('#dynamic_toast').show()
    $('#dynamic_toast').toast({ 'delay': 2000 }).toast('show');
  }


</script>

</html>