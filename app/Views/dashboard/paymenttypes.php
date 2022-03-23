<?= $this->extend('layout/dashboard-layout'); ?>
<?= $this->section('content'); ?>

<div class="row">
     <div class="col-md-8">
          <div class="card">
             <div class="card-body">
             <h4 class="header-title">List of Payment Types</h4>
             <div class="data-tables datatable-primary">
                <table class="table table-hover text-center" id="paymenttypes-table">
                    <thead>
                         <th>#</th>
                         <th>Payment Type name</th>
                         <th>Description</th>
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
              <div class="card-header"> <h4 class="header-title">Add new Payment Types</h4></div>
              <div class="card-body">
                  <form action="<?= route_to('add.paymenttype'); ?>" method="post" id="add-paymenttype-form" autocomplete="off">
                  <?= csrf_field(); ?>
                      <div class="form-group">
                         <label for="">Payment Type name</label>
                         <input type="text" class="form-control" name="paymenttypename" placeholder="Enter payment type name.">
                         <span class="text-danger error-text paymenttypename_error"></span>
                      </div>
                      <div class="form-group">
                         <label for="">Description</label>
                         <textarea name="paymenttypedescription" class="form-control" cols="30" rows="5" placeholder="Enter description."></textarea>
                         <span class="text-danger error-text paymenttypedescription_error"></span>
                      </div>
                      <div class="form-group">
                         <button type="submit" class="btn btn-block btn-success">Save</button>
                      </div>
                  </form>
              </div>
          </div>
     </div>
  </div>

<?= $this->include('modals/editPaymenttypeModal'); ?>
<?= $this->endSection(); ?>
<?= $this->section('scripts'); ?>
 <script>

 var csrfName = $('meta.csrf').attr('name'); //CSRF TOKEN NAME
 var csrfHash = $('meta.csrf').attr('content'); //CSRF HASH
 
   //ADD NEW PAYMENT TYPE.
   $('#add-paymenttype-form').submit(function(e){
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
                         $('#paymenttypes-table').DataTable().ajax.reload(null, false);
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


   $('#paymenttypes-table').DataTable({
       "processing":true,
       "serverSide":true,
       "ajax":"<?= route_to('get.all.paymenttypes'); ?>",
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


   $(document).on('click','#updatePaymenttypeBtn', function(){
       var paymenttype_id = $(this).data('id');
        
        $.post("<?= route_to('get.paymenttype.info') ?>",{paymenttype_id:paymenttype_id, [csrfName]:csrfHash}, function(data){
               // alert(data.results.paymenttype_name);

            $('.editPaymenttype').find('form').find('input[name="ptid"]').val(data.results.paymenttype_id);
            $('.editPaymenttype').find('form').find('input[name="paymenttypename"]').val(data.results.paymenttype_name);
            $('.editPaymenttype').find('form').find('textarea[name="paymenttypedescription"]').val(data.results.description);
            $('.editPaymenttype').find('form').find('span.error-text').text('');
            $('.editPaymenttype').modal('show');
        },'json');

    
   });

   $('#update-paymenttype-form').submit(function(e){
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
                    $('#paymenttypes-table').DataTable().ajax.reload(null, false);
                     $('.editPaymenttype').modal('hide');
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


   $(document).on('click', '#deletePaymenttypeBtn', function(){
       var paymenttype_id = $(this).data('id');
       var url = "<?= route_to('delete.paymenttype'); ?>";

       swal.fire({

           title:'Are you sure?',
           html:'You want to delete this payment type!',
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

                $.post(url,{[csrfName]:csrfHash, paymenttype_id:paymenttype_id}, function(data){
                     if(data.code == 1){
                        $('#paymenttypes-table').DataTable().ajax.reload(null, false);
                     }else{
                         alert(data.msg);
                     }
                },'json');
            }
       });
   });


 </script>

<?= $this->endSection(); ?>