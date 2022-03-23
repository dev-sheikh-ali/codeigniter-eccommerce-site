<?= $this->extend('layout/dashboard-layout'); ?>
<?= $this->section('content'); ?>
  
  <div class="row">
     <div class="col-md-8">
          <div class="card">
             <div class="card-body">
             <h4 class="header-title">List of Users <i class='fa fa-users'></i></h4>
             <div class="data-tables datatable-primary">
                    <table class="table table-hover text-center" id="users-table">
                        <thead>
                             <th>#</th>
                             <th>First name</th>
                             <th>Last name</th>
                             <th>Email</th>
                             <th>Gender</th>
                             <th>Role</th>
                              <th>Actions</th>
                        </thead>
                    <tbody></tbody>
                </table>
             </div>
             </div>
          </div>
     </div>
     <div class="col-md-4">
          <div class="card">
              <div class="card-header"> <h4 class="header-title">Add new User <i class='fa fa-user-plus'></i></h4></div>
              <div class="card-body">
                  <form action="<?= route_to('add.user'); ?>" method="post" id="add-user-form" autocomplete="off">
                  <?= csrf_field(); ?>
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
                         <button type="submit" class="btn btn-block btn-success"><i class="fa fa-user-plus"></i>  Save</button>
                      </div>
                  </form>
              </div>
          </div>
     </div>
  </div>

<?= $this->include('modals/editUserModal'); ?>
<?= $this->endSection(); ?>
<?= $this->section('scripts'); ?>
 <script>

 var csrfName = $('meta.csrf').attr('name'); //CSRF TOKEN NAME
 var csrfHash = $('meta.csrf').attr('content'); //CSRF HASH
 
   //ADD NEW USER.
   $('#add-user-form').submit(function(e){
        e.preventDefault();
        var form = this;
        $.ajax({
           url:$(form).attr('action'),
           method:$(form).attr('method'),
           data:new FormData(form),
           processData:false,
           dataType:'json',
           contentType:false,
           beforeSend:function(){
              $(form).find('span.error-text').text('');
           },
           success:function(data){
                 if($.isEmptyObject(data.error)){
                     if(data.code == 1){
                         $(form)[0].reset();
                         $('#users-table').DataTable().ajax.reload(null, false);
                     }else{
                         alert(data.msg);
                     }
                 }else{
                     $.each(data.error, function(prefix, val){
                         $(form).find('span.'+prefix+'_error').text(val);
                     });
                 }
           }
        });
   });


   $('#users-table').DataTable({
       "processing":true,
       "serverSide":true,
       "ajax":"<?= route_to('get.all.users'); ?>",
       "dom":"lBfrtip",
       stateSave:true,
       info:true,
       "iDisplayLength":5,
       "pageLength":5,
       "aLengthMenu":[[5,10,25,50,-1],[5,10,25,50,"All"]],
       "fnCreatedRow": function(row, data, index){
           $('td',row).eq(0).html(index+1);
       }
   });


   $(document).on('click','#updateUserBtn', function(){
       var user_id = $(this).data('id');
        
        $.post("<?= route_to('get.user.info') ?>",{user_id:user_id, [csrfName]:csrfHash}, function(data){
            //    alert(data.results.first_name);

            $('.editUser').find('form').find('input[name="uid"]').val(data.results.user_id);
            $('.editUser').find('form').find('input[name="firstname"]').val(data.results.first_name);
            $('.editUser').find('form').find('input[name="lastname"]').val(data.results.last_name);
            $('.editUser').find('form').find('input[name="email"]').val(data.results.email);
            $('.editUser').find('form').find('input[name="gender"]').val(data.results.gender);
            $('.editUser').find('form').find('input[name="role"]').val(data.results.role);
            $('.editUser').find('form').find('span.error-text').text('');
            $('.editUser').modal('show');
        },'json');

    
   });

   $('#update-user-form').submit(function(e){
       e.preventDefault();
       var form = this;

       $.ajax({
           url: $(form).attr('action'),
           method:$(form).attr('method'),
           data: new FormData(form),
           processData: false,
           dataType:'json',
           contentType:false,
           beforeSend:function(){
               $(form).find('span.error-text').text('');
           },
           success:function(data){

               if($.isEmptyObject(data.error)){

                   if(data.code == 1){
                    $('#users-table').DataTable().ajax.reload(null, false);
                     $('.editUser').modal('hide');
                   }else{
                       alert(data.msg);
                   }

               }else{
                   $.each(data.error, function(prefix, val){
                       $(form).find('span.'+prefix+'_error').text(val);
                   });
               }
           }
       });
   });


   $(document).on('click', '#deleteUserBtn', function(){
       var user_id = $(this).data('id');
       var url = "<?= route_to('delete.user'); ?>";

       swal.fire({

           title:'Are you sure?',
           html:'You want to delete this user',
           showCloseButton:true,
           showCancelButton:true,
           cancelButtonText:'Cancel',
           confirmButtonText:'Yes, delete',
           cancelButtonColor:'#d33',
           confirmButtonColor:'#556eeb',
           width:300,
           allowOutsideClick:false

       }).then(function(result){
            if(result.value){

                $.post(url,{[csrfName]:csrfHash, user_id:user_id}, function(data){
                     if(data.code == 1){
                        $('#users-table').DataTable().ajax.reload(null, false);
                     }else{
                         alert(data.msg);
                     }
                },'json');
            }
       });
   });


 </script>

<?= $this->endSection(); ?>