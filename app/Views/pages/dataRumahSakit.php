<?= $this->extend('layout/templateHome'); ?>

<?= $this->section('content'); ?>

<?= view('layout/templateSidebar', ['menus' => $menu]); ?>

<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Data Rumah Sakit</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="/home"><?= $breadcrumb[0]; ?></a></div>
        <div class="breadcrumb-item"><a href="/dataRumahSakit"><?= $breadcrumb[1]; ?></a></div>
        <div class="breadcrumb-item active"><?= $breadcrumb[2]; ?></div>
      </div>
    </div>
    <div class="section-body">
      <div class="card">
        <div class="card-header">
          <button class="btn btn-icon icon-left btn-primary" data-toggle="modal" data-target="#tambahRumkit"><i class="fas fa-plus"></i> Tambah Data</button>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th style="text-align:center" scope="col">No.</th>
                  <th scope="col">Nama Rumah Sakit</th>
                  <th scope="col">Alamat</th>
                  <th width="15%" scope="col">No. Telp</th>
                  <th width="15%" style="text-align:center" scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style="text-align:center" scope="row">1</td>
                  <td>Rumah Sakit Islam Malahayati</td>
                  <td>Jl. Pangeran Diponegoro No.2 - 4, Petisah Tengah, Kec. Medan Petisah, Kota Medan, Sumatera Utara 20112</td>
                  <td>(061) 4518766</td>
                  <td style="text-align:center">
                    <button class="btn btn-icon icon-left btn-info" data-toggle="modal" data-target="#editRumkit"><i class="fas fa-edit"></i></button>
                    <button class="btn btn-icon icon-left btn-danger" data-toggle="modal" data-target="#hapusRumkit"><i class="fas fa-trash"></i></button>
                  </td>
                </tr>
                <tr>
                  <td style="text-align:center" scope="row">2</td>
                  <td>RS Columbia Asia Medan</td>
                  <td>Jl. Listrik No.2A, Petisah Tengah, Kec. Medan Petisah, Kota Medan, Sumatera Utara 20112</td>
                  <td>(061) 4566368</td>
                  <td style="text-align:center">
                    <button class="btn btn-icon icon-left btn-info" data-toggle="modal" data-target="#editRumkit"><i class="fas fa-edit"></i></button>
                    <button class="btn btn-icon icon-left btn-danger" data-toggle="modal" data-target="#hapusRumkit"><i class="fas fa-trash"></i></button>
                  </td>
                </tr>
                <tr>
                  <td style="text-align:center" scope="row">3</td>
                  <td>Rumah Sakit Umum Pusat H. Adam Malik</td>
                  <td>Jl. Bunga Lau No.17, Kemenangan Tani, Kec. Medan Tuntungan, Kota Medan, Sumatera Utara 20136</td>
                  <td>(061) 8360143</td>
                  <td style="text-align:center">
                    <button class="btn btn-icon icon-left btn-info" data-toggle="modal" data-target="#editRumkit"><i class="fas fa-edit"></i></button>
                    <button class="btn btn-icon icon-left btn-danger" data-toggle="modal" data-target="#hapusRumkit"><i class="fas fa-trash"></i></button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
  </section>
</div>

<!-- start modal tambah  -->
<div class="modal fade" tabindex="-1" role="dialog" id="tambahRumkit">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah<strong> Data Rumah Sakit</strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label>Nama Rumah Sakit</label>
          <input type="text" class="form-control">
        </div>
        <!-- <div class="form-group"> -->
        <!-- <label>Koordinat Rumah Sakit di Google Maps</label>
          <input type="text" class="form-control"> -->
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="latitude">Koordinat Latitude</label>
            <input type="text" class="form-control" id="latitude" placeholder="3.5864943722830582">
          </div>
          <div class="form-group col-md-6">
            <label for="longitude">Koordinat Longitude</label>
            <input type="text" class="form-control" id="longitude" placeholder="98.67253290816205">
          </div>
        </div>
        <!-- </div> -->
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
<div class="modal fade" tabindex="-1" role="dialog" id="editRumkit">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit<strong> Data Rumah Sakit</strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label>Nama Rumah Sakit</label>
          <input type="text" class="form-control">
        </div>
        <!-- <div class="form-group">
          <label>Koordinat Rumah Sakit di Google Maps</label>
          <input type="text" class="form-control">
        </div> -->
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="latitude">Koordinat Latitude</label>
            <input type="text" class="form-control" id="latitude" placeholder="3.5864943722830582">
          </div>
          <div class="form-group col-md-6">
            <label for="longitude">Koordinat Longitude</label>
            <input type="text" class="form-control" id="longitude" placeholder="98.67253290816205">
          </div>
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
<div class="modal fade" tabindex="-1" role="dialog" id="hapusRumkit">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Hapus<strong> Data Rumah Sakit</strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Apakah kamu benar ingin menghapus data Rumah Sakit?</p>
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