<div class="modal fade editSubCategory" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Sub-Category.</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                    <form action="<?= route_to('update.subcategory'); ?>" method="post" id="update-subcategory-form">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="scid">
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
                          <button type="submit" class="btn btn-block btn-success">Save Changes</button>
                       </div>
                    </form>
            </div>
        </div>
    </div>
</div>