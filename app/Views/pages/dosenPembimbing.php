<?= $this->extend('layout/templateHome'); ?>

<?= $this->section('content'); ?>

<?= view('layout/templateSidebar', ['menus' => $menu]); ?>

<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Data Dosen Pembimbing</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="/home"><?= $breadcrumb[0]; ?></a></div>
        <div class="breadcrumb-item"><a href="/dataRumahSakit"><?= $breadcrumb[1]; ?></a></div>
        <div class="breadcrumb-item active"><?= $breadcrumb[2]; ?></div>
      </div>
    </div>
    <div class="section-body">
      <div class="card">
        <div class="card-header">
          <button class="btn btn-icon icon-left btn-primary" data-toggle="modal" data-target="#tambahDosenPembimbing"><i class="fas fa-plus"></i> Tambah Data</button>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th width="5%" style="text-align:center" scope="col">No.</th>
                  <th scope="col">NIDN</th>
                  <th width="10%" scope="col">Nama Dan Gelar</th>
                  <th scope="col">Email</th>
                  <th scope="col">No. Telp</th>
                  <th scope="col">Alamat</th>
                  <th scope="col">Bagian</th>
                  <th width="20%" style="text-align:center" scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style="text-align:center" scope="row">1</td>
                  <td>1602060125</td>
                  <td>Prof. Dr. Thariq Nurhidayat, M.A</td>
                  <td>thariq@umsu.ac.id</td>
                  <td>081328556584</td>
                  <td>Jalan Rajawali No 19</td>
                  <td>Bagian Spesialis Penyakit Dalam</td>
                  <td style="text-align:center">
                    <button class="btn btn-icon icon-left btn-info" data-toggle="modal" data-target="#editDosenPembimbing"><i class="fas fa-edit"></i></button>
                    <button class="btn btn-icon icon-left btn-danger" data-toggle="modal" data-target="#hapusDosenPembimbing"><i class="fas fa-trash"></i></button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
</div>
</section>
</div>

<!-- start modal tambah  -->
<div class="modal fade" tabindex="-1" role="dialog" id="tambahDosenPembimbing">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah<strong> Data Dosen Pembimbing</strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label>NIDN</label>
          <input type="text" class="form-control">
        </div>
        <div class="form-group">
          <label>Nama Dan Gelar</label>
          <input type="text" class="form-control">
        </div>
        <div class="form-group">
          <label>Email</label>
          <input type="text" class="form-control">
        </div>
        <div class="form-group">
          <label>No. Telp</label>
          <div class="input-group">
            <div class="input-group-prepend">
              <div class="input-group-text">
                <i class="fas fa-phone"></i>
              </div>
            </div>
            <input type="text" class="form-control phone-number">
          </div>
        </div>
        <div class="form-group">
          <label>Alamat</label>
          <input type="text" class="form-control">
        </div>
        <div class="form-group">
          <label>Bagian</label>
          <select class="form-control select2">
            <option>Option 1</option>
            <option>Option 2</option>
            <option>Option 3</option>
          </select>
        </div>
      </div>
      <div class="modal-footer bg-whitesmoke br">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
<!-- end modal tambah -->

<!-- start modal edit  -->
<div class="modal fade" tabindex="-1" role="dialog" id="editDosenPembimbing">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit<strong> Data Dosen Pembimbing</strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label>NIDN</label>
          <input type="text" class="form-control">
        </div>
        <div class="form-group">
          <label>Nama Dan Gelar</label>
          <input type="text" class="form-control">
        </div>
        <div class="form-group">
          <label>Email</label>
          <input type="text" class="form-control">
        </div>
        <div class="form-group">
          <label>No. Telp</label>
          <div class="input-group">
            <div class="input-group-prepend">
              <div class="input-group-text">
                <i class="fas fa-phone"></i>
              </div>
            </div>
            <input type="text" class="form-control phone-number">
          </div>
        </div>
        <div class="form-group">
          <label>Alamat</label>
          <input type="text" class="form-control">
        </div>
        <div class="form-group">
          <label>Bagian</label>
          <select class="form-control select2">
            <option>Option 1</option>
            <option>Option 2</option>
            <option>Option 3</option>
          </select>
        </div>
      </div>
      <div class="modal-footer bg-whitesmoke br">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
<!-- end modal edit -->

<!-- start modal hapus  -->
<div class="modal fade" tabindex="-1" role="dialog" id="hapusDosenPembimbing">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Hapus<strong> Data Dosen Pembimbing</strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Apakah kamu benar ingin menghapus data Dosen Pembimbing?</p>
        <p class="text-warning"><small>This action cannot be undone</small></p>
      </div>
      <div class="modal-footer bg-whitesmoke br">
        <button type="button" class="btn btn-danger">Delete</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
</div>
<!-- end modal hapus -->

<?= view('layout/templateFooter'); ?>

<?= $this->endSection(); ?>