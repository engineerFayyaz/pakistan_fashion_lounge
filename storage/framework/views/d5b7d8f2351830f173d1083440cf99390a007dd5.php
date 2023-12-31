<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo e($general_setting->site_title); ?></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <link rel="manifest" href="<?php echo e(url('manifest.json')); ?>">
    <?php if(!config('database.connections.saleprosaas_landlord')): ?>
    <link rel="icon" type="image/png" href="<?php echo e(url('logo', $general_setting->site_logo)); ?>" />
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="<?php echo asset('vendor/bootstrap/css/bootstrap.min.css') ?>" type="text/css">
    <!-- login stylesheet-->
    <link rel="stylesheet" href="<?php echo asset('css/auth.css') ?>" id="theme-stylesheet" type="text/css">
    <!-- Google fonts - Roboto -->
    <link rel="preload" href="https://fonts.googleapis.com/css?family=Nunito:400,500,700" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link href="https://fonts.googleapis.com/css?family=Nunito:400,500,700" rel="stylesheet"></noscript>
    <?php else: ?>
    <link rel="icon" type="image/png" href="<?php echo e(url('../../logo', $general_setting->site_logo)); ?>" />
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="<?php echo asset('../../vendor/bootstrap/css/bootstrap.min.css') ?>" type="text/css">
    <!-- login stylesheet-->
    <link rel="stylesheet" href="<?php echo asset('../../css/auth.css') ?>" id="theme-stylesheet" type="text/css">
    <!-- Google fonts - Roboto -->
    <link rel="preload" href="https://fonts.googleapis.com/css?family=Nunito:400,500,700" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link href="https://fonts.googleapis.com/css?family=Nunito:400,500,700" rel="stylesheet"></noscript>
    <?php endif; ?>
    <style>
        .login-page,
.register-page {
    background: #f5f5f5;
    background-image: url('../images/auth/pos2.jpg');
    background-size:cover;
	width: 100%;
	min-height: auto;
	padding-bottom: 0;
	margin-left: 0
}
    </style>
  </head>
  <body>
    <div class="page login-page">
      <div class="container">
        <div class="form-outer text-center d-flex align-items-center">
          <div class="form-inner">
            <div class="logo">
                <?php if($general_setting->site_logo): ?>
                    <img src="<?php echo e(asset('assets/images/'.$general_setting->site_logo)); ?>" width="160">
                <?php else: ?>
                    <span><?php echo e($general_setting->site_title); ?></span>
                <?php endif; ?>
            </div>
            <?php if(session()->has('delete_message')): ?>
                <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('delete_message')); ?></div>
            <?php endif; ?>
            <form method="POST" action="<?php echo e(route('login')); ?>" id="login-form">
              <?php echo csrf_field(); ?>
              <div class="form-group-material">
                <input id="login-username" type="text" name="name" required class="input-material" value="">
                <label for="login-username" class="label-material"><?php echo e(trans('file.UserName')); ?></label>
                <?php if(session()->has('error')): ?>
                    <p>
                        <strong><?php echo e(session()->get('error')); ?></strong>
                    </p>
                <?php endif; ?>
              </div>

              <div class="form-group-material">
                <input id="login-password" type="password" name="password" required class="input-material" value="">
                <label for="login-password" class="label-material"><?php echo e(trans('file.Password')); ?></label>
                <?php if(session()->has('error')): ?>
                    <p>
                        <strong><?php echo e(session()->get('error')); ?></strong>
                    </p>
                <?php endif; ?>
              </div>
              <button type="submit" class="btn btn-primary btn-block"><?php echo e(trans('file.LogIn')); ?></button>
            </form>
            <?php if(!env('USER_VERIFIED')): ?>
            <!-- This three button for demo only-->
            <button type="submit" class="btn btn-success admin-btn">LogIn as Admin</button>
            <button type="submit" class="btn btn-info staff-btn">LogIn as Staff</button>
            <button type="submit" class="btn btn-dark customer-btn">LogIn as Customer</button>
            <br><br>
            <?php endif; ?>
            <a href="<?php echo e(route('password.request')); ?>" class="forgot-pass"><?php echo e(trans('file.Forgot Password?')); ?></a>
            <p class="register-section"><?php echo e(trans('file.Do not have an account?')); ?></p>
            <a href="<?php echo e(url('register')); ?>" class="signup register-section"><?php echo e(trans('file.Register')); ?></a>
          </div>
          <div class="copyrights text-center">
            <p><?php echo e(trans('file.Developed By')); ?> <span class="external"><?php echo e($general_setting->developed_by); ?></span></p>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
<?php if(!config('database.connections.saleprosaas_landlord')): ?>
<script type="text/javascript" src="<?php echo asset('vendor/jquery/jquery.min.js') ?>"></script>
<?php else: ?>
<script type="text/javascript" src="<?php echo asset('../../vendor/jquery/jquery.min.js') ?>"></script>
<?php endif; ?>
<script>
    <?php if(config('database.connections.saleprosaas_landlord')): ?>
        if(localStorage.getItem("message")) {
            alert(localStorage.getItem("message"));
            localStorage.removeItem("message");
        }
        numberOfUserAccount = <?php echo json_encode($numberOfUserAccount)?>;
        $.ajax({
            type: 'GET',
            async: false,
            url: '<?php echo e(route("package.fetchData", $general_setting->package_id)); ?>',
            success: function(data) {
                if(data['number_of_user_account'] > 0 && data['number_of_user_account'] <= numberOfUserAccount) {
                    $(".register-section").addClass('d-none');
                }
            }
        });
    <?php endif; ?>

    //switch theme code
    var theme = <?php echo json_encode($theme); ?>;
    if(theme == 'dark') {
        $('body').addClass('dark-mode');
        $('#switch-theme i').addClass('dripicons-brightness-low');
    }
    else {
        $('body').removeClass('dark-mode');
        $('#switch-theme i').addClass('dripicons-brightness-max');
    }
    $('.admin-btn').on('click', function(){
        $("input[name='name']").focus().val('admin');
        $("input[name='password']").focus().val('admin');
    });
    
    if ('serviceWorker' in navigator ) {
        window.addEventListener('load', function() {
            navigator.serviceWorker.register('/salepro/service-worker.js').then(function(registration) {
                // Registration was successful
                console.log('ServiceWorker registration successful with scope: ', registration.scope);
            }, function(err) {
                // registration failed :(
                console.log('ServiceWorker registration failed: ', err);
            });
        });
    }

    $('.admin-btn').on('click', function(){
        $("input[name='name']").focus().val('admin');
        $("input[name='password']").focus().val('admin');
    });

  $('.staff-btn').on('click', function(){
      $("input[name='name']").focus().val('staff');
      $("input[name='password']").focus().val('staff');
  });

  $('.customer-btn').on('click', function(){
      $("input[name='name']").focus().val('shakalaka');
      $("input[name='password']").focus().val('shakalaka');
  });
  // ------------------------------------------------------- //
    // Material Inputs
    // ------------------------------------------------------ //

    var materialInputs = $('input.input-material');

    // activate labels for prefilled values
    materialInputs.filter(function() { return $(this).val() !== ""; }).siblings('.label-material').addClass('active');

    // move label on focus
    materialInputs.on('focus', function () {
        $(this).siblings('.label-material').addClass('active');
    });

    // remove/keep label on blur
    materialInputs.on('blur', function () {
        $(this).siblings('.label-material').removeClass('active');

        if ($(this).val() !== '') {
            $(this).siblings('.label-material').addClass('active');
        } else {
            $(this).siblings('.label-material').removeClass('active');
        }
    });
</script>
<?php /**PATH D:\5TechSol\Projects\PFL\pakistan_fashion_lounge\pakistan_fashion_lounge\resources\views/backend/auth/login.blade.php ENDPATH**/ ?>