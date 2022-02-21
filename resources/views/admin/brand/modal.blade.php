<div class="modal fade" id="modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="form-title"></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="form" action="#" method="post">
            <div class="modal-body" id="form-modal">
                <input type="hidden" name="id" value="">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="brand" value="" placeholder="Brand Name" required>
                    <label for="floatingInput">Brand Name</label>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="form-group">
                    <label for="floatingInput">Logo</label>
                    <input type="file" class="form-control" name="logo" value="" placeholder="Brand Name" required>
                    <div class="invalid-feedback"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary btn-submit">Submit</button>
            </div>
        </form>
      </div>
    </div>
</div>