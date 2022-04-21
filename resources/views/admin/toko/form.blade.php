  <!-- Modal -->
  <div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form">
    <div class="modal-dialog" role="document">
        <form action="" method="post" class="form-horizontal" enctype="multipart/form-data">
            @csrf
            @method('post') 
        
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body">
            <div class="form-group row">
                <label for="nama_toko" class="col-md-2 col-md-offset-1 control-label">Nama Toko</label>
                <div class="col-md-6">
                    <input class="form-control" type="text" name="nama_toko" id="nama_toko" required autofocus>
                    <span class="help-block with-errors"></span>

                </div>
            </div>
            <div class="form-group row">
              <label for="alamat" class="col-md-2 col-md-offset-1 control-label">Alamat</label>
              <div class="col-md-6">
                  <input class="form-control" type="text" name="alamat" id="alamat" required autofocus>
                  <span class="help-block with-errors"></span>

              </div>
          </div>

          <div class="form-group row">
            <label for="deskripsi" class="col-md-2 col-md-offset-1 control-label">Deskripsi</label>
            <div class="col-md-6">
              <textarea class="form-control" name="deskripsi" id="deskripsi" rows="3" required></textarea>
                <span class="help-block with-errors"></span>

            </div>
        </div>

        <div class="form-group row">
          <label for="image" class="col-md-2 col-md-offset-1 control-label">Image</label>
          <div class="col-md-6">

            <input type="file" class="form-control" name="image" id="image" onchange="preview('.tampil-toko', this.files[0])">
            @error('image')
            <span class="help-block with-errors">wajib jpg</span>
            @enderror
            <span class="help-block with-errors"></span>
            <div class="tampil-toko" name="tampil-toko"></div>
          </div><br>
      </div>

        </div>
        <div class="modal-footer">
            <button class="btn btn-primary">Simpan</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </form>
    </div>
  </div>