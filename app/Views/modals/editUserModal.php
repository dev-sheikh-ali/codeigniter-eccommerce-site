<div class="modal fade editUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit User.</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                    <form action="<?= route_to('update.user'); ?>" method="post" id="update-user-form">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="uid">
                    <div class="form-group">
                         <label for="">First name</label>
                         <input type="text" class="form-control" name="firstname" placeholder="Enter first name.">
                         <span class="text-danger error-text firstname_error"></span>
                      </div>
                      <div class="form-group">
                         <label for="">Last name</label>
                         <input type="text" class="form-control" name="lastname" placeholder="Enter last name.">
                         <span class="text-danger error-text lastname_error"></span>
                      </div>
                      <div class="form-group">
                         <label for="">Email</label>
                         <input type="email" class="form-control" name="email" placeholder="Enter email.">
                         <span class="text-danger error-text email_error"></span>
                      </div>
                      <div class="form-group">
                         <label for="">Password</label>
                         <input type="password" class="form-control" name="password" placeholder="Enter password.">
                         <span class="text-danger error-text password_error"></span>
                      </div>
                      <div class="form-group">
                         <label for="">Confirm password</label>
                         <input type="password" class="form-control" name="confirm_password" placeholder="Reenter same password.">
                         <span class="text-danger error-text confirm_password_error"></span>
                      </div>
                      <div class="form-group form-control">
                      <label for="">Gender</label> 
                      <span>
                            <label  for="female"><i class="fa fa-venus" aria-hidden="true"></i></label>
                            <input type="radio"  name="gender" id="female" value="female" <?php echo set_radio('gender','female');?>>
                      </span>
                      <span>
                            <label  for="male"><i class="fa fa-mars" aria-hidden="true"></i></label>
                            <input type="radio"  name="gender" id="male" value="male" <?php echo set_radio('gender','male');?>>
                      </span>
                      <span class="text-danger error-text gender_error"></span>
                      </div>
                      <div class="form-group">
                         <label for="">Role</label>
                            <select name="role" id="role" class="form-control role">
                                <option value="">Select Role</option>
                                <?php
                                 foreach($role as $row)
                                 {
                                    echo '<option value="'.$row["role_id"].'">'.$row["role_name"].'</option>';
                                    
                                 }
                                ?> 
                            </select>
                            <span class="text-danger error-text role_error"></span>
                     </div>
                           <div class="form-group">
                              <button type="submit" class="btn btn-block btn-success">Save Changes</button>
                           </div>
                    </form>
            </div>
        </div>
    </div>
</div>