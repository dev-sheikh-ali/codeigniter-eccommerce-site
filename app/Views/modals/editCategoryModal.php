<div class="modal fade editCategory" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Category.</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                    <form action="<?= route_to('update.category'); ?>" method="post" id="update-category-form">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="cid">
                    <div class="form-group">
                        <label for="">Category name</label>
                        <input type="text" class="form-control" name="categoryname" placeholder="Enter category name.">
                        <span class="text-danger error-text categoryname_error"></span>
                    </div>
                        <div class="form-group">
                          <button type="submit" class="btn btn-block btn-success">Save Changes</button>
                       </div>
                    </form>
            </div>
        </div>
    </div>
</div>