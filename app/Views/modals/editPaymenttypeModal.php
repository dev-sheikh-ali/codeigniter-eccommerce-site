<div class="modal fade editPaymenttype" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Payment Type.</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                    <form action="<?= route_to('update.paymenttype'); ?>" method="post" id="update-paymenttype-form">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="ptid">
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
                          <button type="submit" class="btn btn-block btn-success">Save Changes</button>
                       </div>
                    </form>
            </div>
        </div>
    </div>
</div>