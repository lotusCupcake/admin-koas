<!-- start modal P2KM  -->
<?php foreach ($mahasiswa as $mhs) : ?>
    <div class="modal fade" tabindex="-1" role="dialog" id="nilaiP2KM<?= $mhs->kelompokDetNim ?>">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Penilaian <strong>P2KM</strong></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="#" method="post">
                    <?= csrf_field() ?>
                    <div class="modal-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="text-align:center" scope="col" rowspan="2">No.</th>
                                    <th scope="col" rowspan="2">Komponen</th>
                                    <th scope="col" colspan="<?= $penilaianP2KM[0]->komponenSkorMax; ?>">Nilai</th>
                                    <th rowspan="2">Bobot</th>
                                </tr>
                                <tr>
                                    <?php for ($i = 1; $i <= $penilaianP2KM[0]->komponenSkorMax; $i++) : ?>
                                        <th><?= $i; ?></th>
                                    <?php endfor ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($penilaianP2KM as $komp) : ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $komp->komponenNama ?></td>
                                        <?php for ($i = 1; $i <= $penilaianP2KM[0]->komponenSkorMax; $i++) : ?>
                                            <td><input type="radio" id="<?= $komp->komponenNama . $i; ?>" name="<?= $komp->komponenNama ?>" value="<?= $i ?>"></td>
                                        <?php endfor ?>
                                        <td><?= $komp->komponenBobot ?></td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                    <div class=" modal-footer bg-whitesmoke br">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach ?>
<!-- end modal P2KM-->

<!-- start modal P2K  -->
<?php foreach ($mahasiswa as $mhs) : ?>
    <div class="modal fade" tabindex="-1" role="dialog" id="nilaiP2K<?= $mhs->kelompokDetNim ?>">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Penilaian <strong>P2K</strong></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="#" method="post">
                    <?= csrf_field() ?>
                    <div class="modal-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="text-align:center" scope="col" rowspan="2">No.</th>
                                    <th scope="col" rowspan="2">Komponen</th>
                                    <th scope="col" colspan="<?= $penilaianP2K[0]->komponenSkorMax; ?>">Nilai</th>
                                    <th rowspan="2">Bobot</th>
                                </tr>
                                <tr>
                                    <?php for ($i = 1; $i <= $penilaianP2K[0]->komponenSkorMax; $i++) : ?>
                                        <th><?= $i; ?></th>
                                    <?php endfor ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($penilaianP2K as $komp) : ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $komp->komponenNama ?></td>
                                        <?php for ($i = 1; $i <= $penilaianP2K[0]->komponenSkorMax; $i++) : ?>
                                            <td><input type="radio" id="<?= $komp->komponenNama . $i; ?>" name="<?= $komp->komponenNama ?>" value="<?= $i ?>"></td>
                                        <?php endfor ?>
                                        <td><?= $komp->komponenBobot ?></td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                    <div class=" modal-footer bg-whitesmoke br">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach ?>
<!-- end modal P2K-->

<!-- start modal Journal Reading  -->
<?php foreach ($mahasiswa as $mhs) : ?>
    <div class="modal fade" tabindex="-1" role="dialog" id="nilaijournalreading<?= $mhs->kelompokDetNim ?>">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Penilaian <strong>Journal Reading</strong></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="#" method="post">
                    <?= csrf_field() ?>
                    <div class="modal-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="text-align:center" scope="col" rowspan="2">No.</th>
                                    <th scope="col" rowspan="2">Komponen</th>
                                    <th scope="col" colspan="<?= $penilaianJournalReading[0]->komponenSkorMax; ?>">Nilai</th>
                                    <th rowspan="2">Bobot</th>
                                </tr>
                                <tr>
                                    <?php for ($i = 1; $i <= $penilaianJournalReading[0]->komponenSkorMax; $i++) : ?>
                                        <th><?= $i; ?></th>
                                    <?php endfor ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($penilaianJournalReading as $komp) : ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $komp->komponenNama ?></td>
                                        <?php for ($i = 1; $i <= $penilaianJournalReading[0]->komponenSkorMax; $i++) : ?>
                                            <td><input type="radio" id="<?= $komp->komponenNama . $i; ?>" name="<?= $komp->komponenNama ?>" value="<?= $i ?>"></td>
                                        <?php endfor ?>
                                        <td><?= $komp->komponenBobot ?></td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                    <div class=" modal-footer bg-whitesmoke br">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach ?>
<!-- end modal Journal Reading-->

<!-- start modal tinjauan pustaka  -->
<?php foreach ($mahasiswa as $mhs) : ?>
    <div class="modal fade" tabindex="-1" role="dialog" id="nilaitinjauanpustaka<?= $mhs->kelompokDetNim ?>">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Penilaian <strong>Tinjauan Pustaka</strong></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="#" method="post">
                    <?= csrf_field() ?>
                    <div class="modal-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="text-align:center" scope="col" rowspan="2">No.</th>
                                    <th scope="col" rowspan="2">Komponen</th>
                                    <th scope="col" colspan="<?= $penilaianTinjauanPustaka[0]->komponenSkorMax; ?>">Nilai</th>
                                    <th rowspan="2">Bobot</th>
                                </tr>
                                <tr>
                                    <?php for ($i = 1; $i <= $penilaianTinjauanPustaka[0]->komponenSkorMax; $i++) : ?>
                                        <th><?= $i; ?></th>
                                    <?php endfor ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($penilaianTinjauanPustaka as $komp) : ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $komp->komponenNama ?></td>
                                        <?php for ($i = 1; $i <= $penilaianTinjauanPustaka[0]->komponenSkorMax; $i++) : ?>
                                            <td><input type="radio" id="<?= $komp->komponenNama . $i; ?>" name="<?= $komp->komponenNama ?>" value="<?= $i ?>"></td>
                                        <?php endfor ?>
                                        <td><?= $komp->komponenBobot ?></td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                    <div class=" modal-footer bg-whitesmoke br">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach ?>
<!-- end modal tinjauan pustaka-->

<!-- start modal Follow Up  -->
<?php foreach ($mahasiswa as $mhs) : ?>
    <div class="modal fade" tabindex="-1" role="dialog" id="nilaiFollowUp<?= $mhs->kelompokDetNim ?>">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Penilaian <strong>Follow Up</strong></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="#" method="post">
                    <?= csrf_field() ?>
                    <div class="modal-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="text-align:center" scope="col" rowspan="2">No.</th>
                                    <th scope="col" rowspan="2">Komponen</th>
                                    <th scope="col" colspan="<?= $penilaianResponsiLaporan[0]->komponenSkorMax; ?>">Nilai</th>
                                    <th rowspan="2">Bobot</th>
                                </tr>
                                <tr>
                                    <?php for ($i = 1; $i <= $penilaianResponsiLaporan[0]->komponenSkorMax; $i++) : ?>
                                        <th><?= $i; ?></th>
                                    <?php endfor ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($penilaianResponsiLaporan as $komp) : ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $komp->komponenNama ?></td>
                                        <?php for ($i = 1; $i <= $penilaianResponsiLaporan[0]->komponenSkorMax; $i++) : ?>
                                            <td><input type="radio" id="<?= $komp->komponenNama . $i; ?>" name="<?= $komp->komponenNama ?>" value="<?= $i ?>"></td>
                                        <?php endfor ?>
                                        <td><?= $komp->komponenBobot ?></td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                    <div class=" modal-footer bg-whitesmoke br">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach ?>
<!-- end modal Follow Up-->

<!-- start modal Responsi Laporan  -->
<?php foreach ($mahasiswa as $mhs) : ?>
    <div class="modal fade" tabindex="-1" role="dialog" id="nilaiResponsiLap<?= $mhs->kelompokDetNim ?>">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Penilaian <strong>Responsi Laporan</strong></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="#" method="post">
                    <?= csrf_field() ?>
                    <div class="modal-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="text-align:center" scope="col" rowspan="2">No.</th>
                                    <th scope="col" rowspan="2">Komponen</th>
                                    <th scope="col" colspan="<?= $menu->penilaianVariable[0]->komponenSkorMax; ?>">Nilai</th>
                                    <th rowspan="2">Bobot</th>
                                </tr>
                                <tr>
                                    <?php for ($i = 1; $i <= $menu->penilaianVariable[0]->komponenSkorMax; $i++) : ?>
                                        <th><?= $i; ?></th>
                                    <?php endfor ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($menu->penilaianVariable as $komp) : ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $komp->komponenNama ?></td>
                                        <?php for ($i = 1; $i <= $menu->penilaianVariable[0]->komponenSkorMax; $i++) : ?>
                                            <td><input type="radio" id="<?= $komp->komponenNama . $i; ?>" name="<?= $komp->komponenNama ?>" value="<?= $i ?>"></td>
                                        <?php endfor ?>
                                        <td><?= $komp->komponenBobot ?></td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                    <div class=" modal-footer bg-whitesmoke br">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach ?>
<!-- end modal Responsi Laporan-->