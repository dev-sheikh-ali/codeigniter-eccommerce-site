  <div class="container-login">
          <h2>The Wardrobe</h2>
          <div class="intro-text">
              <h1>Sign in</h1>
              <p>Welcome Back.</p>
          </div>
          <form action="<?= route_to('login.check'); ?> " method="post" autocomplete="off" id="login">
          <?= csrf_field(); ?>
          <?php if(!empty(session()->getFlashdata('fail'))) : ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('fail'); ?></div>
          <?php endif ?>
            <div class="inputs">
            <span class="text-danger"><?= isset($validation) ? display_error($validation, 'email') : ''?></span>
              <div class="input">
                <input type="text" name="email" id="email" placeholder = "Email" value = "<?= set_value('email');?>"/>
              </div>
              <span class="text-danger error-text email_error"></span>
              <span class="text-danger"><?= isset($validation) ? display_error($validation, 'password') : ''?></span>
              <div class="input">
                <input type="password" name="password" id="password" placeholder = "Password" value = "<?= set_value('password');?>"/>
              </div>  
              <span class="text-danger error-text password_error"></span>
          
            </div>
          <a href="#" class="forgot-pass-link">Forgot password?</a>
          <br><br>
            <button  type="submit" name="login_user" id="sign-in-btn" class="btn-block">Sign in</button>
            <p class="join-link">New Here? <a href="<?= site_url('auth/register')?>">Join Us</a></p> 
          </form>  
    </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <script src="assets/js/form_validation.js"></script>

  </body>
</html>
