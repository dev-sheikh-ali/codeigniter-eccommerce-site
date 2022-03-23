  <div class="container-register">
            <h2>The Wardrobe</h2>
            <div class="intro-text">
                <h1>Join Us</h1>
                <p>Create your The Wardrobe Member profile and get first access to the very best of products.</p>
                <p style="font-weight: bold;">WELCOME ABOARD.</p>

            </div>
            <form action="<?= route_to('register.save'); ?>" method="post" autocomplete='off' id ='registration'>
                <?= csrf_field(); ?>
                <?php if(!empty(session()->getFlashdata('fail'))) : ?>
                    <div class="alert alert-danger"><?= session()->getFlashdata('fail'); ?></div>
                <?php endif ?>
                <?php if(!empty(session()->getFlashdata('success'))): ?>
                    <div class="alert alert-danger"><?= session()->getFlashdata('success'); ?></div>
                <?php endif ?>

            <div class="inputs">
                <span class="text-danger"><?= isset($validation) ? display_error($validation, 'firstname') : ''?></span>
                <div class="input">
                    <input type="text" name="firstname" id="firstname" placeholder = "First Name" value = "<?= set_value('firstname');?>"/>
                </div>
                <span class="text-danger"><?= isset($validation) ? display_error($validation, 'lastname') : ''?></span>
                <div class="input">
                    <input type="text" name="lastname" id="lastname" placeholder = "Last Name" value = "<?= set_value('lastname');?>"/>
                </div>
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
                <span class="text-danger"><?= isset($validation) ? display_error($validation, 'cpassword') : ''?></span>
                <div class="input">
                    <input type="password" name="cpassword" id="confirm_password" placeholder = "Confirm Password" value = "<?= set_value('cpassword');?>"/>
                </div>
                <span class="text-danger"><?= isset($validation) ? display_error($validation, 'gender') : ''?></span>
                <div class="inputs gender">
                    <p class="text-center">Gender.</p>
                    <span class="reg-label">
                        <input type="radio" name="gender" id="female" value="female" <?php echo set_radio('gender','female');?>>
                        <label  for="female"><i class="fa fa-venus" aria-hidden="true"></i></label>
                    </span>
                    <span class="reg-label">
                        <input type="radio" name="gender" id="male" value="male"  <?php echo set_radio('gender','male');?> >
                        <label  for="male"><i class="fa fa-mars" aria-hidden="true"></i></label>
                    </span>
                </div>
                <span class="text-danger"><?= isset($validation) ? display_error($validation, 'role') : ''?></span>
                <input type="hidden" name="role" id="role" value= '1'/>
                <span class="text-danger error-text role_error"></span>  
            </div>
          <br>
          <button type="submit" name="register_user" id="sign-in-btn" class="btn-block">Register</button>
          <p class="join-link">Already a Member? <a href="<?= site_url('auth')?>">Sign in</a></p>
          </form>  
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <!-- <script src="assets/js/form_validation.js"></script> -->

    </body>
</html>
