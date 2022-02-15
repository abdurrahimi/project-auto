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
                <input type="hidden" name="title" value="{{$title}}">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="name" value="" placeholder="Full Name">
                    <label for="floatingInput">Full Name</label>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="form-floating mb-3">
                    <input type="email" class="form-control" name="email" value="" placeholder="name@example.com">
                    <label for="floatingInput">Email</label>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="username" value="" placeholder="name@example.com">
                    <label for="floatingInput">Username</label>
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