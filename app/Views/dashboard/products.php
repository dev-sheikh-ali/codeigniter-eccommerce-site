<?= $this->extend('layout/dashboard-layout'); ?>
<?= $this->section('content'); ?>

<div class="row">
     <div class="col-md-8">
          <div class="card">
             <div class="card-body">
             <h4 class="header-title">List of Products</h4>
             <div class="data-tables datatable-primary">
                <table class="table table-hover text-center" id="products-table">
                    <thead>
                         <th>#</th>
                         <th>Product name</th>
                         <th>Products Description</th>
                         <th>Products Image</th>
                         <th>Unit Price</th>
                         <th>Available Quantity</th>
                         <th>Sub-category ID</th>
                         <th>Created At</th>
                         <th>Updated At</th>
                         <th>Added By</th>
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
          <div class="card-header"> <h4 class="header-title">Add new Product</h4></div>
              <div class="card-body">
                  <form action="<?= route_to('add.product'); ?>" method="post" id="add-product-form" autocomplete="off" enctype="multipart/form-data" >
                  <?= csrf_field(); ?>
                      <div class="form-group">
                         <label for="">Product name</label>
                         <input type="text" class="form-control" name="productname" placeholder="Enter product name.">
                         <span class="text-danger error-text productname_error"></span>
                      </div>
                      <div class="form-group">
                         <label for="">Description</label>
                         <textarea name="productdescription" class="form-control" cols="30" rows="5" placeholder="Enter description."></textarea>
                         <span class="text-danger error-text productdescription_error"></span>
                      </div>
                      <div class="form-group">
                         <label for="">Product Image</label>
                         <input type="file" class="form-control" name="productimage" placeholder="Enter product image.">
                         <span class="text-danger error-text productimage_error"></span>
                      </div>
                      <div class="form-group">
                         <label for="">Unit Price</label>
                         <input type="number" class="form-control" name="unitprice" placeholder="Enter unit price.">
                         <span class="text-danger error-text unitprice_error"></span>
                      </div>
                      <div class="form-group">
                         <label for="">Available Quantity</label>
                         <input type="number" class="form-control" name="availablequantity" placeholder="Enter available quantity.">
                         <span class="text-danger error-text availablequantity_error"></span>
                      </div>
                      <div class="form-group">
                         <label for="">Sub-Category</label>
                          <select name="subcategory" class="form-control subcategory" id="subcategory">
                                <option value="">Select Sub-Category</option>
                                <?php
                                 foreach($sub_category as $row)
                                 {
                                    echo '<option value="'.$row["subcategory_id"].'">'.$row["subcategory_name"].'</option>';
                                    
                                 }
                                ?> 
                            </select>
                            <span class="text-danger error-text subcategory_error"></span>
                     </div>

                      <div class="form-group">
                         <button type="submit" class="btn btn-block btn-success">Save</button>
                      </div>
                  </form>
              </div>
          </div>
     </div>
  </div>

<?= $this->endSection(); ?>
<?= $this->section('scripts'); ?>
 <script>

 var csrfName = $('meta.csrf').attr('name'); //CSRF TOKEN NAME
 var csrfHash = $('meta.csrf').attr('content'); //CSRF HASH
 
   //ADD NEW USER.
   $('#add-product-form').submit(function(e){
       // e.preventDefault();
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
                         $('#products-table').DataTable().ajax.reload(null, false);
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


   $('#product-table').DataTable({
       "processing":true,
       "serverSide":true,
       "ajax":"<?= route_to('get.all.products'); ?>",
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


   $(document).on('click','#updateProductBtn', function(){
       var user_id = $(this).data('id');
        
        $.post("<?= route_to('get.product.info') ?>",{product_id:product_id, [csrfName]:csrfHash}, function(data){
            //    alert(data.results.first_name);

            $('.editProduct').find('form').find('input[name="pid"]').val(data.results.product_id);
            $('.editProduct').find('form').find('input[name="productname"]').val(data.results.product_name);
            $('.editProduct').find('form').find('input[name="productdescription"]').val(data.results.product_description);
            $('.editProduct').find('form').find('input[name="productimage"]').val(data.results.product_image);
            $('.editProduct').find('form').find('input[name="unitprice"]').val(data.results.unit_price);
            $('.editProduct').find('form').find('input[name="availablequantity"]').val(data.results.available_quantity);
            $('.editProduct').find('form').find('input[name="subcategory"]').val(data.results.subcategory_id);
            $('.editProduct').find('form').find('span.error-text').text('');
            $('.editProduct').modal('show');
        },'json');

    
   });

   $('#update-product-form').submit(function(e){
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
                    $('#products-table').DataTable().ajax.reload(null, false);
                     $('.editProduct').modal('hide');
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


   $(document).on('click', '#deleteProductBtn', function(){
       var user_id = $(this).data('id');
       var url = "<?= route_to('delete.product'); ?>";

       swal.fire({

           title:'Are you sure?',
           html:'You want to delete this product',
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

                $.post(url,{[csrfName]:csrfHash, product_id:product_id}, function(data){
                     if(data.code == 1){
                        $('#products-table').DataTable().ajax.reload(null, false);
                     }else{
                         alert(data.msg);
                     }
                },'json');
            }
       });
   });


 </script>

<?= $this->endSection(); ?>