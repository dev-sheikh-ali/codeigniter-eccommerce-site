<?= $this->extend('layout/dashboard-layout'); ?>
<?= $this->section('content'); ?>

<div class="row">
     <div class="col-md-8">
          <div class="card">
             <div class="card-body">
             <h4 class="header-title">List of Sub-Categories</h4>
             <div class="data-tables datatable-primary">
                <table class="table table-hover text-center" id="subcategories-table">
                    <thead>
                         <th>#</th>
                         <th>Sub-Category name</th>
                         <th>Category id</th>
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
          <div class="card-header"> <h4 class="header-title">Add new Sub-Category</h4></div>
              <div class="card-body">
                  <form action="<?= route_to('add.subcategory'); ?>" method="post" id="add-subcategory-form" autocomplete="off">
                  <?= csrf_field(); ?>
                      <div class="form-group">
                         <label for="">Sub-Category name</label>
                         <input type="text" class="form-control" name="subcategoryname" placeholder="Enter sub-category name.">
                         <span class="text-danger error-text subcategoryname_error"></span>
                      </div>
                      <div class="form-group">
                         <label for="">Category</label>
                          <select name="category" class="form-control category" id="category">
                                <option value="">Select Category</option>
                                <?php
                                 foreach($category as $row)
                                 {
                                    echo '<option value="'.$row["category_id"].'">'.$row["category_name"].'</option>';
                                    
                                 }
                                ?> 
                            </select>
                            <span class="text-danger error-text category_error"></span>
                     </div>
                      <div class="form-group">
                         <button type="submit" class="btn btn-block btn-success">Save</button>
                      </div>
                  </form>
              </div>
          </div>
     </div>
  </div>

<?= $this->include('modals/editSubCategoryModal'); ?>
<?= $this->endSection(); ?>
<?= $this->section('scripts'); ?>
 <script>

 var csrfName = $('meta.csrf').attr('name'); //CSRF TOKEN NAME
 var csrfHash = $('meta.csrf').attr('content'); //CSRF HASH
 
   //ADD NEW SUB-CATEGORY.
   $('#add-subcategory-form').submit(function(e){
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
                         $('#subcategories-table').DataTable().ajax.reload(null, false);
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


   $('#subcategories-table').DataTable({
       "processing":true,
       "serverSide":true,
       "ajax":"<?= route_to('get.all.subcategories'); ?>",
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


   $(document).on('click','#updateSubCategoryBtn', function(){
       var subcategory_id = $(this).data('id');
        
        $.post("<?= route_to('get.subcategory.info') ?>",{subcategory_id:subcategory_id, [csrfName]:csrfHash}, function(data){
            //    alert(data.results.subcategory_name);

            $('.editSubCategory').find('form').find('input[name="scid"]').val(data.results.subcategory_id);
            $('.editSubCategory').find('form').find('input[name="subcategoryname"]').val(data.results.subcategory_name);
            $('.editSubCategory').find('form').find('input[name="subcategoryname"]').val(data.results.subcategory_name);
            $('.editSubCategory').find('form').find('span.error-text').text('');
            $('.editSubCategory').modal('show');
        },'json');

    
   });

   $('#update-subcategory-form').submit(function(e){
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
                    $('#subcategories-table').DataTable().ajax.reload(null, false);
                     $('.editSubCategory').modal('hide');
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


   $(document).on('click', '#deleteSubCategoryBtn', function(){
       var subcategory_id = $(this).data('id');
       var url = "<?= route_to('delete.subcategory'); ?>";

       swal.fire({

           title:'Are you sure?',
           html:'You want to delete this sub-category',
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

                $.post(url,{[csrfName]:csrfHash, subcategory_id:subcategory_id}, function(data){
                     if(data.code == 1){
                        $('#subcategories-table').DataTable().ajax.reload(null, false);
                     }else{
                         alert(data.msg);
                     }
                },'json');
            }
       });
   });


 </script>

<?= $this->endSection(); ?>