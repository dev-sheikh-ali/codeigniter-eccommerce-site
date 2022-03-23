<?= $this->extend('layout/dashboard-layout'); ?>
<?= $this->section('content'); ?>
<div class="row">
     <div class="col-md-8">
          <div class="card">
             <div class="card-body">
             <h4 class="header-title">List of Categories </h4>
             <div class="data-tables datatable-primary">
                <table class="table table-hover text-center" id="categories-table">
                    <thead>
                         <th>#</th>
                         <th>Category name</th>
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
          <div class="card-header"> <h4 class="header-title">Add new Category</h4></div>
              <div class="card-body">
                  <form action="<?= route_to('add.category'); ?>" method="post" id="add-category-form" autocomplete="off">
                  <?= csrf_field(); ?>
                      <div class="form-group">
                         <label for="">Category name</label>
                         <input type="text" class="form-control" name="categoryname" placeholder="Enter category name.">
                         <span class="text-danger error-text categoryname_error"></span>
                      </div>
                      <div class="form-group">
                         <button type="submit" class="btn btn-block btn-success">Save</button>
                      </div>
                  </form>
              </div>
          </div>
     </div>
  </div>

<?= $this->include('modals/editCategoryModal'); ?>
<?= $this->endSection(); ?>
<?= $this->section('scripts'); ?>
 <script>

 var csrfName = $('meta.csrf').attr('name'); //CSRF TOKEN NAME
 var csrfHash = $('meta.csrf').attr('content'); //CSRF HASH
 
   //ADD NEW CATEGORY.
   $('#add-category-form').submit(function(e){
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
                         $('#categories-table').DataTable().ajax.reload(null, false);
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


   $('#categories-table').DataTable({
       "processing":true,
       "serverSide":true,
       "ajax":"<?= route_to('get.all.categories'); ?>",
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


   $(document).on('click','#updateCategoryBtn', function(){
       var category_id = $(this).data('id');
        
        $.post("<?= route_to('get.category.info') ?>",{category_id:category_id, [csrfName]:csrfHash}, function(data){
            //    alert(data.results.category_name);

            $('.editCategory').find('form').find('input[name="cid"]').val(data.results.category_id);
            $('.editCategory').find('form').find('input[name="categoryname"]').val(data.results.category_name);
            $('.editCategory').find('form').find('span.error-text').text('');
            $('.editCategory').modal('show');
        },'json');

    
   });

   $('#update-category-form').submit(function(e){
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
                    $('#categories-table').DataTable().ajax.reload(null, false);
                     $('.editCategory').modal('hide');
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


   $(document).on('click', '#deleteCategoryBtn', function(){
       var category_id = $(this).data('id');
       var url = "<?= route_to('delete.category'); ?>";

       swal.fire({

           title:'Are you sure?',
           html:'You want to delete this category',
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

                $.post(url,{[csrfName]:csrfHash, category_id:category_id}, function(data){
                     if(data.code == 1){
                        $('#categories-table').DataTable().ajax.reload(null, false);
                     }else{
                         alert(data.msg);
                     }
                },'json');
            }
       });
   });


 </script>

<?= $this->endSection(); ?>