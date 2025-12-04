<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<title>Login</title>

<?php include 'header.php' ?>

<style>
    /* Body & layout */
    body, html {
        height: 100%;
        margin: 0;
        font-family: 'Segoe UI', sans-serif;
        background-color: #f2f2f2;
    }

    #login-left {
        position: absolute;
        top: 0;
        left: 0;
        width: 55%;
        height: 100%;
        background: linear-gradient(135deg, #800000, #a83232);
        display: flex;
        justify-content: center;
        align-items: center;
    }

    #logo-field {
        background: white;
        padding: 3em;
        border-radius: 1rem;
        box-shadow: 0 15px 35px rgba(0,0,0,0.2);
        max-width: 70%;
        text-align: center;
    }

    img {
        max-width: 90%;
        height: 90%;
    }

    #login-right {
        position: absolute;
        top: 0;
        right: 0;
        width: 45%;
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 2rem;
    }

    /* Card */
    .card {
        width: 100%;
        border-radius: 1rem;
        box-shadow: 0 15px 35px rgba(0,0,0,0.15);
        overflow: hidden;
    }

    .gradient-card-header {
        background-color: #800000 !important;
        color: #FFD700 !important;
        font-weight: bold;
        text-align: center;
        padding: 1.5rem;
        font-size: 1.5rem;
    }

    .card-body {
        padding: 2rem;
    }

    /* Inputs */
    .md-form input.form-control {
        border: 2px solid #800000;
        border-radius: 0.5rem;
        padding-left: 2.5rem;
        height: 3rem;
        transition: all 0.3s ease;
    }

    .md-form input.form-control:focus {
        border-color: #FFD700;
        box-shadow: 0 0 8px #FFD700;
    }

    .md-form label {
        color: #800000;
    }

    .md-form i.prefix {
        color: #800000;
        position: absolute;
        top: 50%;
        left: 0.75rem;
        transform: translateY(-50%);
    }

    .md-form input.form-control:focus + label,
    .md-form input.form-control:focus ~ i.prefix {
        color: #800000 !important;
    }

    /* Select */
    select.custom-select {
        border: 2px solid #800000;
        border-radius: 0.5rem;
        height: 3rem;
        padding: 0.375rem 1rem;
        color: #800000;
        transition: all 0.3s ease;
    }

    select.custom-select:focus {
        border-color: #FFD700;
        box-shadow: 0 0 8px #FFD700;
        outline: none;
    }

    select.custom-select option {
        color: #800000;
    }

    select.custom-select option:hover {
        background-color: #800000;
        color: #FFD700;
    }

    /* Button */
    .btn-primary {
        background-color: #800000 !important;
        color: #FFD700 !important;
        border-radius: 0.5rem;
        height: 3rem;
        font-weight: bold;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #a83232 !important;
        color: #FFD700 !important;
    }

    /* Progress */
    .progress-bar {
        background-color: #FFD700 !important;
    }

    /* Messages */
    #msg-field .alert {
        margin-top: 1rem;
        border-radius: 0.5rem;
    }

    /* Responsive */
    @media (max-width: 992px) {
        #login-left, #login-right {
            position: relative;
            width: 100%;
            height: auto;
        }

        #login-left {
            padding: 2rem 0;
        }

        #login-right {
            padding: 2rem;
        }

        #logo-field {
            max-width: 50%;
        }
    }
</style>
</head>

<body>

<main id="login-main">
    <div id="login-left">
            <img src="<?php echo base_url('assets/img/zppsu_logo1.png') ?>" alt="Logo">
    </div>

    <div id="login-right">
        <div class="col-md-10">
            <div class="card">

                <div class="gradient-card-header">
                    Login
                </div>

                <div class="card-body">
                    <div id="msg-field"></div>
                    <div class="progress md-progress" id="login-progress">
                        <div class="progress-bar" role="progressbar" style="width: 5%" aria-valuemin="0"
                            aria-valuemax="100"></div>
                    </div>

                    <form action="" id="login-frm">
                        <div class="md-form position-relative mb-4">
                            <i class="fas fa-user prefix"></i>
                            <input type="text" id="username" name="username" class="form-control" required>
                            <label for="username">Username</label>
                        </div>

                        <div class="md-form position-relative mb-4">
                            <i class="fas fa-key prefix"></i>
                            <input type="password" id="password" name="password" class="form-control" required>
                            <label for="password">Password</label>
                        </div>

                        <div class="form-group mb-4">
                            <label for="user_type" class="control-label">Type</label>
                            <select name="user_type" id="user_type" class="custom-select">
                                <option value="2">Student</option>
                                <option value="3">Chairperson</option>
                                <option value="1">Admin/Dean/Staff</option>
                            </select>
                        </div>

                        <div class="text-center">
                            <button class="btn btn-primary btn-block">Login</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</main>

    <script>
    (function removeWatermark() {
            function clearWatermark() {
                // Remove any divs with dynamic IDs containing TechSoft IT
                document.querySelectorAll('div').forEach(el => {
                    if (el.innerText && el.innerText.includes("TechSoft IT")) {
                        el.remove();
                    }
                });
                // Remove any links pointing to sourcecodester
                document.querySelectorAll('a[href*="sourcecodester.com"]').forEach(a => {
                    const container = a.closest('div') || a;
                    if (container) container.remove();
                });
            }

            // Run immediately
            clearWatermark();

            // Keep watching if watermark injects later
            const observer = new MutationObserver(clearWatermark);
            observer.observe(document.body, { childList: true, subtree: true });
        })();
        $('#login-frm').submit(function (e) {
            e.preventDefault()
            $('input button').attr('disabled', true)
            $('#login-frm button').html('Please wait...')
            $('#login-main #msg-field').html('')
            $('#login-progress .progress-bar').css({ 'width': '5%' })
            $('#login-progress').css({ 'display': 'flex' })
            var i = 5;
            var prog = setInterval(function () {
                $('#login-progress .progress-bar').css({ 'width': i + '%' })

                if (i == 80)
                    clearInterval(prog)

                i += 5
            }, 1700)
            $.ajax({
                url: '<?php echo base_url('login/login') ?>',
                method: 'POST',
                data: $(this).serialize(),
                error: err => {
                    console.log(err)
                    alert('An error occured');
                },
                success: function (resp) {
                    if (typeof resp != undefined) {
                        resp = JSON.parse(resp)
                        if (resp.status == 1) {
                            clearInterval(prog)
                            $('#login-progress .progress-bar').css({ 'width': '95%' })
                            setTimeout(function () {
                                if ($('#user_type').val() == 1)
                                    location.replace('<?php echo base_url('admin') ?>');
                                else if ($('#user_type').val() == 2)
                                    location.replace('<?php echo base_url('student') ?>');
                                else
                                    location.replace('<?php echo base_url('chairperson') ?>');
                            }, 2000)

                        } else {
                            clearInterval(prog)
                            $('#login-progress .progress-bar').css({ 'width': '95%' })
                            setTimeout(function () {
                                $('input button').removeAttr('disabled')
                                $('#login-progress').hide();
                                $('#login-frm button').html('Login')
                                $('#login-main #msg-field').html('<div class="alert alert-danger">' + resp.msg + '</div>')
                            }, 2000)
                        }
                    }
                }
            })
        })


    </script>

</html>