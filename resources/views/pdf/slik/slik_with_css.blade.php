<!DOCTYPE html>
<html>

<head>
  <title>{{ $title }}</title>
  <link rel="stylesheet" href="">
  <style>
    body {
      font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
      font-size: 12px;
      color: #222;
    }

    h3 {
      font-size: 20px;
      margin: 0;
    }

    h4 {
      font-size: 16px;
      margin: 0;
    }

    h5 {
      font-size: 12px;
      margin: 0;
    }

    section {
      /* page-break-inside: avoid; */
      page-break-after: always;
    }

    .panel {
      width: 100%;
      border: 1px solid #5e72e4;
      border-top-left-radius: 10px;
      border-top-right-radius: 10px;
    }

    .panel .panel-header {
      background-color: #5e72e4;
      color: white;
      padding: 20px;
      border-top-left-radius: 5px;
      border-top-right-radius: 5px;
    }

    .panel .panel-header h3 {
      margin: 5px 0;
    }

    .panel .panel-body {
      padding: 20px;
    }

    .col-6 {
      width: 50%;
      float: left;
    }

    .padding {
      padding: 0 5px;
    }

    .bg-primary {
      background-color: #5e72e4 !important;
    }

    .bg-secondary {
      background-color: #f5f5f5 !important;
    }

    .bg-accent {
      background-color: #11cdef !important;
    }

    .bg-danger {
      background-color: #f5365c !important;
    }

    .text-primary {
      color: #5e72e4 !important;
    }

    .text-white {
      color: white !important;
    }

    .text-center {
      text-align: center;
    }

    .card {
      border: 1px solid transparent;
      border-radius: 10px;
      padding: 10px;
    }

    .card .card-title {
      font-size: 16px;
      font-weight: bold;
      color: white;
      margin: 5px 0;
    }

    .card .card-body {
      font-size: 12px;
    }

    .table-responsive {
      width: 100%;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    table td:first-child,
    table td:nth-child(2) {
      width: 1%;
      white-space: nowrap;
    }

    table.border-bottom tr {
      border-bottom: 1px solid #ddd;
    }

    table.border-bottom td {
      padding: 5px 5px;
      vertical-align: top;
    }

    table.border-bottom td:first-child {
      color: #5e72e4;
    }

    table.no-border td {
      padding: 5px 5px;
      vertical-align: top;
    }

    table.stiped {
      border-collapse: collapse;
    }

    table.table td,
    table.table th {
      border: 1px solid #ddd;
      padding: 5px 2px;
    }

    table.stiped {
      border-collapse: collapse;
    }

    table.striped tbody tr:nth-child(even) {
      background-color: #f5f5f5;
    }

    table.striped tbody tr:nth-child(odd) {
      background-color: #fff;
    }

    table.striped td,
    table.striped th {
      border: 1px solid #ddd;
      padding: 5px 2px;
    }

    table.new {
      border-collapse: collapse;
    }

    table.detail {
      width: 100%;
      border-collapse: collapse;
    }

    table.detail td {
      font-size: 8px;
    }

    table.detail td:nth-child(odd) {
      background-color: #f5f5f5;
      width: 15%;
      font-weight: bold;
      white-space: pre-wrap
    }

    table.detail td:nth-child(even) {
      width: 35%;
      white-space: pre-wrap
    }

    .p-2 {
      padding: 3px 10px;
    }
  </style>
</head>

<body>
  <div id="print">
    <section>
      <div class="panel">
        <div class="panel-header">
          <h3>SLIK - {{ @$slik['nomor_laporan'] }}</h3>
        </div>
        <div class="panel-body">
          <div class="col-6">
            <div class="padding">
              <h4 class="bg-accent text-white text-center" style="padding: 5px 0;">Data Terakhir Debitur</h4>
              <div class="table-responsive">
                <table class="border-bottom">
                  @if ($slik['tipe_slik'] == 'perusahaan')
                    <tr>
                      <td class="text-primary">Nama Badan Usaha</td>
                      <td>:</td>
                      <td><?= @$data_debitur_latest['namaLengkap'] ?></td>
                    </tr>
                    <tr>
                      <td class="text-primary">NPWP</td>
                      <td>:</td>
                      <td><?= @$data_debitur_latest['npwp'] ?></td>
                    </tr>
                    <tr>
                      <td class="text-primary">Tempat Pendirian</td>
                      <td>:</td>
                      <td><?= @$data_debitur_latest['tempatPendirian'] ?></td>
                    </tr>
                    <tr>
                      <td class="text-primary">Tanggal Update</td>
                      <td>:</td>
                      <td>
                        <?php
                        $date_time = DateTime::createFromFormat('Ymd', @$data_debitur_latest['tglAktaPendirian']);
                        if ($date_time) {
                            echo $date_time->format('d F Y');
                        } else {
                            echo '-';
                        }
                        ?>
                      </td>
                    </tr>
                    <tr>
                      <td class="text-primary">Nomor Akta Pendirian</td>
                      <td>:</td>
                      <td><?= @$data_debitur_latest['noAktaPendirian'] ?></td>
                    </tr>
                    <tr>
                      <td class="text-primary">Sektor Ekonomi</td>
                      <td>:</td>
                      <td><?= @$data_debitur_latest['sektorEkonomiKet'] ?></td>
                    </tr>
                    <tr>
                      <td class="text-primary">Negara</td>
                      <td>:</td>
                      <td><?= @$data_debitur_latest['negaraKet'] ?></td>
                    </tr>
                    <tr>
                      <td class="text-primary">Kota</td>
                      <td>:</td>
                      <td><?= @$data_debitur_latest['kabKotaKet'] ?></td>
                    </tr>
                    <tr>
                      <td class="text-primary">Kecamatan</td>
                      <td>:</td>
                      <td><?= @$data_debitur_latest['kecamatan'] ?></td>
                    </tr>
                    <tr>
                      <td class="text-primary">Kelurahan</td>
                      <td>:</td>
                      <td><?= @$data_debitur_latest['kelurahan'] ?></td>
                    </tr>
                    <tr>
                      <td class="text-primary">Alamat</td>
                      <td>:</td>
                      <td><?= @$data_debitur_latest['alamat'] ?></td>
                    </tr>
                    <tr>
                      <td class="text-primary">Pelapor</td>
                      <td>:</td>
                      <td><?= @$data_debitur_latest['pelaporKet'] ?></td>
                    </tr>
                    <tr>
                      <td class="text-primary">Alamat</td>
                      <td>:</td>
                      <td><?= @$data_debitur_latest['alamat'] ?></td>
                    </tr>
                    <tr>
                      <td class="text-primary">Tanggal Update</td>
                      <td>:</td>
                      <td>
                        <?php
                        $date_time = DateTime::createFromFormat('YmdHis', @$data_debitur_latest['tanggalUpdate']);
                        if ($date_time) {
                            echo $date_time->format('d-m-Y H:i:s');
                        } else {
                            echo '-';
                        }
                        ?>
                      </td>
                    </tr>
                  @else
                    <tr>
                      <td class="text-primary">Nama</td>
                      <td>:</td>
                      <td><?= @$data_debitur_latest['namaDebitur'] ?></td>
                    </tr>
                    <tr>
                      <td class="text-primary">Jenis Kelamin</td>
                      <td>:</td>
                      <td><?= @$data_debitur_latest['jenisKelaminKet'] ?></td>
                    </tr>
                    <tr>
                      <td class="text-primary">Nomor Identitas</td>
                      <td>:</td>
                      <td><?= @$data_debitur_latest['noIdentitas'] ?></td>
                    </tr>
                    <tr>
                      <td class="text-primary">NPWP</td>
                      <td>:</td>
                      <td><?= @$data_debitur_latest['npwp'] ?></td>
                    </tr>
                    <tr>
                      <td class="text-primary">Tempat Lahir</td>
                      <td>:</td>
                      <td><?= @$data_debitur_latest['tempatLahir'] ?></td>
                    </tr>
                    <tr>
                      <td class="text-primary">Tanggal Lahir</td>
                      <td>:</td>
                      <td><?= tgl_indo(@$data_debitur_latest['tanggalLahir']) ?></td>
                    </tr>
                    <tr>
                      <td class="text-primary">Alamat</td>
                      <td>:</td>
                      <td><?= @$data_debitur_latest['alamat'] ?></td>
                    </tr>
                    <tr>
                      <td class="text-primary">Kelurahan</td>
                      <td>:</td>
                      <td><?= @$data_debitur_latest['kelurahan'] ?></td>
                    </tr>
                    <tr>
                      <td class="text-primary">Kabupaten/Kota</td>
                      <td>:</td>
                      <td><?= @$data_debitur_latest['kecamatan'] ?></td>
                    </tr>
                    <tr>
                      <td class="text-primary">Negara</td>
                      <td>:</td>
                      <td><?= @$data_debitur_latest['negaraKet'] ?></td>
                    </tr>
                    <tr>
                      <td class="text-primary">Pekerjaan</td>
                      <td>:</td>
                      <td><?= @$data_debitur_latest['pekerjaanKet'] ?></td>
                    </tr>
                    <tr>
                      <td class="text-primary">Tempat Pekerjaan</td>
                      <td>:</td>
                      <td><?= @$data_debitur_latest['tempatBekerja'] ?></td>
                    </tr>
                    <tr>
                      <td class="text-primary">Bidang Usaha</td>
                      <td>:</td>
                      <td><?= @$data_debitur_latest['bidangUsahaKet'] ?></td>
                    </tr>
                    <tr>
                      <td class="text-primary">Pelapor</td>
                      <td>:</td>
                      <td><?= @$data_debitur_latest['pelaporKet'] ?></td>
                    </tr>
                    <tr>
                      <td class="text-primary">Tanggal Update</td>
                      <td>:</td>
                      <td>
                        <?php
                        $date_time = DateTime::createFromFormat('YmdHis', @$data_debitur_latest['pelaporKet']);
                        if ($date_time) {
                            echo $date_time->format('d-m-Y H:i:s');
                        } else {
                            echo '-';
                        }
                        ?>
                      </td>
                    </tr>
                  @endif
                </table>
              </div>
            </div>
          </div>
          <div class="right col-6">
            <div class="padding">
              <div class="table-responsive bg-secondary">
                <table class="no-border">
                  <tr>
                    <td class="text-primary">Kode Ref. Pengguna</td>
                    <td>:</td>
                    <td><?= @$slik['header']['kodeReferensiPengguna'] ?></td>
                  </tr>
                  <tr>
                    <td class="text-primary">Nomor Laporan</td>
                    <td>:</td>
                    <td><?= @$slik['nomor_laporan'] ?></td>
                  </tr>
                  <tr>
                    <td class="text-primary">Posisi Data Terakhir</td>
                    <td>:</td>
                    <td><?= tgl_indo(@$slik['posisi_data_terakhir']) ?></td>
                  </tr>
                  <tr>
                    <td class="text-primary">Tanggal Permintaan</td>
                    <td>:</td>
                    <td><?= tgl_indo(@$slik['tanggal_permintaan']) ?></td>
                  </tr>
                  <tr>
                    <td class="text-primary">Tanggal Hasil</td>
                    <td>:</td>
                    <td><?= tgl_indo(@$slik['header']['tanggalHasil']) ?></td>
                  </tr>
                  <tr>
                    <td class="text-primary">Dibuat Oleh</td>
                    <td>:</td>
                    <td><?= @$slik['header']['dibuatOleh'] ?></td>
                  </tr>
                </table>
              </div>
              <br>
              <div class="card text-white bg-danger mb-3">
                <div class="card-title">
                  Disclaimer!
                </div>
                <div class="card-body" style="">
                  Seluruh data keuangan yang disajikan di dashboard aplikasi
                  ini bersumber dari data SLIK OJK dengan tidak menambah atau mengurangi data yang ada. Data yang
                  disajikan, berdasarkan tanggal terakhir penarikan data dari aplikasi IDEB OJK. Dashboard ini hanya
                  mempermudah dalam penyajian data SLIK OJK dan tidak bertujuan untuk memberi keputusan kredit.
                </div>
              </div>

            </div>
          </div>
          <div style="clear: both;"></div>
        </div>
      </div>
    </section>

    <!--ADD_PAGE-->
    <section>
      <div class="panel">
        <div class="panel-header">
          <h3>Ringkasan Failitas</h3>
        </div>
        <div class="panel-body">

          <div class="row">
            <div class="col-md-12">
              <div class="table-responsive">
                <table class="striped" id="dtRingkasanFasilitas">
                  <thead>
                    <tr>
                      <th>Fasilitas</th>
                      <th>Kredit/Pembiayaan</th>
                      <th>Surat Berharga</th>
                      <th>Irrevocable L/C</th>
                      <th>Garansi Yang Diberikan</th>
                      <th>Fasilitas Lain</th>
                      <th>Total</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>Plafon Efektif</td>
                      <td>
                        <?= 'Rp. ' . number_format(@$slik['ringkasan_fasilitas']['plafonEfektifKreditPembiayaan'], 2, ',', '.') ?>
                      </td>
                      <td><?= 'Rp. ' . number_format(@$slik['ringkasan_fasilitas']['plafonEfektifSec'], 2, ',', '.') ?>
                      </td>
                      <td><?= 'Rp. ' . number_format(@$slik['ringkasan_fasilitas']['plafonEfektifLc'], 2, ',', '.') ?>
                      </td>
                      <td><?= 'Rp. ' . number_format(@$slik['ringkasan_fasilitas']['plafonEfektifGyd'], 2, ',', '.') ?>
                      </td>
                      <td><?= 'Rp. ' . number_format(@$slik['ringkasan_fasilitas']['plafonEfektifLain'], 2, ',', '.') ?>
                      </td>
                      <td><?= 'Rp. ' . number_format(@$slik['ringkasan_fasilitas']['plafonEfektifTotal'], 2, ',', '.') ?>
                      </td>
                    </tr>
                    <tr>
                      <td>Baki Debet</td>
                      <td>
                        <?= 'Rp. ' . number_format(@$slik['ringkasan_fasilitas']['bakiDebetKreditPembiayaan'], 2, ',', '.') ?>
                      </td>
                      <td><?= 'Rp. ' . number_format(@$slik['ringkasan_fasilitas']['bakiDebetSec'], 2, ',', '.') ?></td>
                      <td><?= 'Rp. ' . number_format(@$slik['ringkasan_fasilitas']['bakiDebetLc'], 2, ',', '.') ?></td>
                      <td><?= 'Rp. ' . number_format(@$slik['ringkasan_fasilitas']['bakiDebetGyd'], 2, ',', '.') ?></td>
                      <td><?= 'Rp. ' . number_format(@$slik['ringkasan_fasilitas']['bakiDebetLain'], 2, ',', '.') ?></td>
                      <td><?= 'Rp. ' . number_format(@$slik['ringkasan_fasilitas']['bakiDebetTotal'], 2, ',', '.') ?></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          <br><br>

          <div class="group">
            <div class="col-6">
              <div class="padding">
                <h4 class="bg-accent text-white p-2">Status Kredit:</h4>
                <table class="border-bottom">
                  <tr>
                    <td>Kredit Aktif</td>
                    <td>:</td>
                    <td>{{ count($data_kredit_aktif) }}</td>
                  </tr>
                  <tr>
                    <td>Kredit Lunas</td>
                    <td>:</td>
                    <td>{{ count($data_kredit_lunas) }}</td>
                  </tr>
                </table>
              </div>
            </div>
            <div class="col-6">
              <div class="padding">
                <h4 class="bg-accent text-white p-2">Terakhir Macet:</h4>
                <table class="border-bottom">
                  <tr>
                    <td>Tanggal Macet</td>
                    <td>:</td>
                    <td>{{ @$latest_macet['date'] }}</td>
                  </tr>
                  <tr>
                    <td>Sebab Macet</td>
                    <td>:</td>
                    <td>{{ @$latest_macet['reason'] }}</td>
                  </tr>
                </table>
              </div>
            </div>
            <div style="clear: both;"></div>
          </div>

          <br><br>

          <div class="group">
            <div class="col-6">
              <div class="padding">
                <h4 class="bg-accent text-white p-2">Jumlah Kreditur:</h4>
                <table class="border-bottom">
                  <tr>
                    <td>Bank Umum</td>
                    <td>:</td>
                    <td>
                      <div class="badge badge-danger"><?= @$slik['ringkasan_fasilitas']['krediturBankUmum'] ?></div>
                    </td>
                  </tr>
                  <tr>
                    <td>BPR/BPRS</td>
                    <td>:</td>
                    <td>
                      <div class="badge badge-danger"><?= @$slik['ringkasan_fasilitas']['krediturBPR/S'] ?></div>
                    </td>
                  </tr>
                  <tr>
                    <td>Lembaga Pembiayaan</td>
                    <td>:</td>
                    <td>
                      <div class="badge badge-danger"><?= @$slik['ringkasan_fasilitas']['krediturLp'] ?></div>
                    </td>
                  </tr>
                  <tr>
                    <td>Lainnya</td>
                    <td>:</td>
                    <td>
                      <div class="badge badge-danger"><?= @$slik['ringkasan_fasilitas']['krediturLainnya'] ?></div>
                    </td>
                  </tr>
                </table>
              </div>
            </div>
            <div class="col-6">
              <div class="padding">
                <h4 class="bg-accent text-white p-2">Statistik Kreditur:</h4>
                <div class="bg-secondary" style="width:100%;">
                  <img src="{{ $chart['kreditur'] }}" alt="chart_kreditur" width="100%">
                </div>
              </div>
            </div>
            <div style="clear: both;"></div>
          </div>

          <br><br>

          <div class="group">
            <div class="col-6">
              <div class="padding">
                <h4 class="bg-accent text-white p-2">Statistik Data Collect:</h4>
                <div class="bg-secondary" style="width:100%;">
                  <img src="{{ $chart['collect'] }}" alt="chart_kreditur" width="100%">
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="padding">
                <h4 class="bg-accent text-white p-2">Statistik Jumlah Hari Terlambat:</h4>
                <div class="bg-secondary" style="width:100%;">
                  <img src="{{ $chart['tidak_lancar'] }}" alt="chart_kreditur" width="100%">
                </div>
              </div>
            </div>
            <div style="clear: both;"></div>
          </div>

          <br><br>

          <div class="group">
            <div class="padding">
              <h5 style="color:#888">
                <strong style="color:#444;margin-right:10px;">Kualitas Terburuk / Bulan Data:</strong>
                <?= @$slik['ringkasan_fasilitas']['kualitasTerburuk'] ?> /
                <?= tgl_indo(@$slik['ringkasan_fasilitas']['kualitasBulanDataTerburuk']) ?>
              </h5>
              <h5 style="color:#888">
                <strong style="color:#444;margin-right:10px;">Total Baki Debet:</strong>
                {{ format_currency(@$slik['total_bakidebet']) }}
              </h5>
              <h5 style="color:#888">
                <strong style="color:#444;margin-right:10px;">Detail Data Collect Berdasarkan Jenis Kredit:</strong>
              </h5>
              <div style="background-color: #f5f5f5">
                @foreach ($grouped_data_kredit as $kredit => $data)
                  <strong style="color:#777;margin-right:10px;font-size:14px;">{{ $kredit }}:</strong>
                  <ul>
                    @foreach ($data as $key => $d)
                      <li style="color:#777;margin-right:10px;font-size:12px;">{{ $key }}:
                        <span style="color:blue">{{ $d }}</span>
                      </li>
                    @endforeach
                  </ul>
                @endforeach
              </div>
            </div>
          </div>
        </div>

      </div>
    </section>

    <!--ADD_PAGE-->
    <section>
      <div class="panel">
        <div class="panel-header">
          <h3>Data Pokok Debitur</h3>
        </div>
        <div class="panel-body">
          <table class="table">
            @if ($slik['tipe_slik'] == 'perusahaan')
              <thead>
                <tr>
                  <th>Nama Debitur</th>
                  <th>NPWP</th>
                  <th>Bentuk BU / Go Public</th>
                  <th>Tempat Pendirian</th>
                  <th>No/Tgl Akta Pendirian</th>
                  <th>Pelapor / Tanggal Update</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($data_pokok_debitur as $dp)
                  <tr>
                    <td>{{ @$dp['namaDebitur'] }}</td>
                    <td>{{ @$dp['npwp'] }}</td>
                    <td>{{ @$dp['bentukBuKet'] }}</td>
                    <td>{{ @$dp['tempatPendirian'] }}</td>
                    <td>
                      <?php
                      $date_time = DateTime::createFromFormat('Ymd', @$dp['tglAktaPendirian']);
                      if ($date_time) {
                          echo $date_time->format('d F Y');
                      } else {
                          echo '-';
                      }
                      ?>
                    </td>
                    <td>{{ @$dp['pelaporKet'] }} /
                      <?php
                      $date_time = DateTime::createFromFormat('YmdHis', @$dp['tanggalUpdate']);
                      if ($date_time) {
                          echo $date_time->format('d F Y H:i:s');
                      } else {
                          echo '-';
                      }
                      ?>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="6">
                      <table class="detail">
                        <tr>
                          <td>Alamat</td>
                          <td>{{ @$dp['alamat'] }}</td>
                          <td>No / Tanggal Akta Terakhir</td>
                          <td>{{ @$dp['noAktaTerakhir'] }}/{{ @$dp['tglAktaTerakhir'] }}</td>
                        </tr>
                        <tr>
                          <td>Kelurahan</td>
                          <td>{{ @$dp['kelurahan'] }}</td>
                          <td>Bidang Usaha</td>
                          <td>{{ @$dp['sektorEkonomiKet'] }}</td>
                        </tr>
                        <tr>
                          <td>Kabupatan / Kota</td>
                          <td>{{ @$dp['kabKotaKet'] }}</td>
                          <td>Bidang Usaha</td>
                          <td>{{ @$dp['bidangUsahaKet'] }}</td>
                        </tr>
                        <tr>
                          <td>Kode Pos</td>
                          <td>{{ @$dp['kodePos'] }}</td>
                          <td>Gelar</td>
                          <td>{{ @$dp['statusGelarDebitur'] }}</td>
                        </tr>
                        <tr>
                          <td>Negara</td>
                          <td>{{ @$dp['kecamatan'] }}</td>
                          <td></td>
                          <td></td>
                      </table>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            @elseif ($slik['tipe_slik'] == 'individual')
              <thead>
                <tr>
                  <th>Nama Debitur</th>
                  <th>NPWP</th>
                  <th>No. Identitas</th>
                  <th>Jenis Kelamin</th>
                  <th>Tempat Tanggal Lahir</th>
                  <th>Pelapor / Tanggal Update</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($data_pokok_debitur as $dp)
                  <tr>
                    <td>{{ @$dp['namaDebitur'] }}</td>
                    <td>{{ @$dp['npwp'] }}</td>
                    <td>{{ @$dp['noIdentitas'] }}</td>
                    <td>{{ @$dp['jenisKelaminKet'] }}</td>
                    <td>
                      {{ @$dp['tempatLahir'] }} /
                      <?php
                      $date_time = DateTime::createFromFormat('Ymd', @$dp['tanggalLahir']);
                      if ($date_time) {
                          echo $date_time->format('d F Y');
                      } else {
                          echo '-';
                      }
                      ?>
                    </td>
                    <td>{{ @$dp['pelaporKet'] }} /
                      <?php
                      $date_time = DateTime::createFromFormat('YmdHis', @$dp['tanggalUpdate']);
                      if ($date_time) {
                          echo $date_time->format('d F Y H:i:s');
                      } else {
                          echo '-';
                      }
                      ?>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="6">
                      <table class="detail">
                        <tr>
                          <td>Alamat</td>
                          <td>{{ @$dp['alamat'] }}</td>
                          <td>Pekerjaan</td>
                          <td>{{ @$dp['pekerjaanKet'] }}</td>
                        </tr>
                        <tr>
                          <td>Kelurahan</td>
                          <td>{{ @$dp['kelurahan'] }}</td>
                          <td>Tempat Bekerja</td>
                          <td>{{ @$dp['tempatBekerja'] }}</td>
                        </tr>
                        <tr>
                          <td>Kabupatan / Kota</td>
                          <td>{{ @$dp['kabKotaKet'] }}</td>
                          <td>Bidang Usaha</td>
                          <td>{{ @$dp['bidangUsahaKet'] }}</td>
                        </tr>
                        <tr>
                          <td>Kode Pos</td>
                          <td>{{ @$dp['kodePos'] }}</td>
                          <td>Gelar</td>
                          <td>{{ @$dp['statusGelarDebitur'] }}</td>
                        </tr>
                        <tr>
                          <td>Negara</td>
                          <td>{{ @$dp['kecamatan'] }}</td>
                          <td></td>
                          <td></td>
                      </table>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            @endif
          </table>
        </div>
      </div>
    </section>

    @if ($slik['tipe_slik'] == 'perusahaan')
      <!--ADD_PAGE-->
      <section>
        <div class="panel">
          <div class="panel-header">
            <h3>Pemilik / Pengurus</h3>
          </div>
          <div class="panel-body">
            <table class="table">
              <thead>
                <tr>
                  <th>NAMA</th>
                  <th>NO. IDENTITAS</th>
                  <th>JENIS KELAMIN</th>
                  <th>JABATAN</th>
                  <th>STATUS PENGURUS</th>
                  <th>PANGSA KEPEMILIK</th>
                  <th>Alamat</th>
                  <th>Kelurahan</th>
                  <th>Kecamatan</th>
                  <th>Kota</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($grouped_data_pengurus as $key => $dp)
                  <tr class="bg-secondary">
                    <td colspan="10">{{ $key }}</td>
                  </tr>
                  @foreach ($dp as $v)
                    <tr>
                      <td>{{ @$v['namaSesuaiIdentitas'] }}</td>
                      <td>{{ @$v['nomorIdentitas'] }}</td>
                      <td>{{ @$v['jenisKelamin'] }}</td>
                      <td>{{ @$v['posisiPekerjaan'] }}</td>
                      <td>{{ @$v['statusPengurusPemilik'] }}</td>
                      <td>{{ @$v['prosentaseKepemilikan'] }}%</td>
                      <td>{{ @$v['alamat'] }}</td>
                      <td>{{ @$v['kelurahan'] }}</td>
                      <td>{{ @$v['kecamatan'] }}</td>
                      <td>{{ @$v['kota'] }}</td>
                    </tr>
                  @endforeach
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </section>
    @endif

    <!--ADD_PAGE-->
    <section>
      <div class="panel">
        <div class="panel-header">
          <h3>Kredit Pembiayaan</h3>
        </div>
        <div class="panel-body">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>Pelapor</th>
                <th>Bulan/Tahun</th>
                <th>Tenor</th>
                <th>Baki Debet</th>
                <th>Kualitas</th>
                <th>Kondisi</th>
                <th>Angsuran</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($data_kredit_pembiayaan as $dk)
                <tr>
                  <td>{{ $dk['ljk'] }} - {{ $dk['ljkKet'] }}</td>
                  <td>{{ $dk['bulan'] }}/{{ $dk['tahun'] }}</td>
                  <td>{{ $dk['tenor'] }}</td>
                  <td>{{ format_currency($dk['bakiDebet']) }}</td>
                  <td>{{ $dk['kualitasKet'] }}</td>
                  <td>{{ $dk['kondisiKet'] }}</td>
                  <td>{{ format_currency($dk['angsuran']) }}</td>
                </tr>
                <tr style="page-break-after: always;">
                  <td colspan="7">
                    <table class="detail">
                      <tr>
                        <td>No Rekening</td>
                        <td>{{ @$dk['noRekening'] }}</td>
                        <td>Kualitas</td>
                        <td>{{ @$dk['kualitasKet'] }}</td>
                      </tr>
                      <tr>
                        <td>Sifat Kredit/Pembiayaan</td>
                        <td>{{ @$dk['sifatKreditPembiayaanKet'] }}</td>
                        <td>Jumlah Hari Tunggakan</td>
                        <td>{{ @$dk['jumlahHariTunggakan'] }}</td>
                      </tr>
                      <tr>
                        <td>Jenis Kredit/Pembiayaan</td>
                        <td>{{ @$dk['jenisKreditPembiayaanKet'] }}</td>
                        <td>Nilai Proyek</td>
                        <td>{{ @$dk['nilaiProyek'] }}</td>
                      </tr>
                      <tr>
                        <td>Akad Kredit/Pembiayaan</td>
                        <td>{{ @$dk['akadKreditPembiayaanKet'] }}</td>
                        <td>Plafon Awal</td>
                        <td>{{ format_currency(@$dk['plafonAwal']) }}</td>
                      </tr>
                      <tr>
                        <td>Frekuensi Perpanjangan Kredit/Pembiayaan</td>
                        <td>{{ @$dk['frekPerpjganKreditPembiayaan'] }}</td>
                        <td>Plafon</td>
                        <td>{{ format_currency(@$dk['plafon']) }}</td>
                      </tr>
                      <tr>
                        <td>No Akad Awal</td>
                        <td>{{ @$dk['noAkadAwal'] }}</td>
                        <td>Realisasi/Pencairan Bulan Berjalan</td>
                        <td>{{ @$dk['realisasiBulanBerjalan'] }}</td>
                      </tr>
                      <tr>
                        <td>Tanggal Akad Awal</td>
                        <td>
                          <?php
                          $date_time = DateTime::createFromFormat('Ymd', @$dk['tanggalAkadAwal']);
                          if ($date_time) {
                              echo $date_time->format('d F Y');
                          } else {
                              echo '-';
                          }
                          ?>
                        </td>
                        <td>Nilai dalam Mata Uang Asal</td>
                        <td>{{ @$dk['nilaiDalamMataUangAsal'] }}</td>
                      </tr>
                      <tr>
                        <td>No Akad Akhir</td>
                        <td>{{ @$dk['noAkadAkhir'] }}</td>
                        <td>Sebab Macet</td>
                        <td>{{ @$dk['sebabMacetKet'] }}</td>
                      </tr>
                      <tr>
                        <td>Tanggal Akad Akhir</td>
                        <td>
                          <?php
                          $date_time = DateTime::createFromFormat('Ymd', @$dk['tanggalAkadAkhir']);
                          if ($date_time) {
                              echo $date_time->format('d F Y');
                          } else {
                              echo '-';
                          }
                          ?>
                        </td>
                        <td>Tanggal Macet</td>
                        <td>{{ @$dk['tanggalMacet'] }}</td>
                      </tr>
                      <tr>
                        <td>Tanggal Awal Kredit</td>
                        <td>
                          <?php
                          $date_time = DateTime::createFromFormat('Ymd', @$dk['tanggalAwalKredit']);
                          if ($date_time) {
                              echo $date_time->format('d F Y');
                          } else {
                              echo '-';
                          }
                          ?>
                        </td>
                        <td>Tunggakan Pokok</td>
                        <td>{{ @$dk['tunggakanPokok'] }}</td>
                      </tr>
                      <tr>
                        <td>Tanggal Mulai</td>
                        <td>
                          <?php
                          $date_time = DateTime::createFromFormat('Ymd', @$dk['tanggalMulai']);
                          if ($date_time) {
                              echo $date_time->format('d F Y');
                          } else {
                              echo '-';
                          }
                          ?>
                        </td>
                        <td>Tunggakan Bunga</td>
                        <td>{{ @$dk['tunggakanBunga'] }}</td>
                      </tr>
                      <tr>
                        <td>Tanggal Jatuh Tempo</td>
                        <td>
                          <?php
                          $date_time = DateTime::createFromFormat('Ymd', @$dk['tanggalJatuhTempo']);
                          if ($date_time) {
                              echo $date_time->format('d F Y');
                          } else {
                              echo '-';
                          }
                          ?>
                        </td>
                        <td>Frekuensi Tunggakan</td>
                        <td>{{ @$dk['frekuensiTunggakan'] }}</td>
                      </tr>
                      <tr>
                        <td>Kategori Debitur</td>
                        <td>{{ @$dk['kategoriDebiturKet'] }}</td>
                        <td>Denda</td>
                        <td>{{ @$dk['denda'] }}</td>
                      </tr>
                      <tr>
                        <td>Jenis Penggunaan</td>
                        <td>{{ @$dk['jenisPenggunaanKet'] }}</td>
                        <td>Frekuensi Restrukturisasi</td>
                        <td>{{ @$dk['frekuensiRestrukturisasi'] }}</td>
                      </tr>
                      <tr>
                        <td>Sektor Ekonomi</td>
                        <td>{{ @$dk['sektorEkonomiKet'] }}</td>
                        <td>Tanggal Restrukturisasi Akhir</td>
                        <td>{{ @$dk['tanggalRestrukturisasiAkhir'] }}</td>
                      </tr>
                      <tr>
                        <td>Kredit Program Pemerintah</td>
                        <td>{{ @$dk['kreditProgramPemerintahKet'] }}</td>
                        <td>Cara Restrukturisasi</td>
                        <td>{{ @$dk['restrukturisasiKet'] }}</td>
                      </tr>
                      <tr>
                        <td>Kab/Kota Lokasi Proyek</td>
                        <td>{{ @$dk['lokasiProyekKet'] }}</td>
                        <td>Kondisi</td>
                        <td>{{ @$dk['kondisiKet'] }}</td>
                      </tr>
                      <tr>
                        <td>Valuta</td>
                        <td>{{ @$dk['valutaKode'] }}</td>
                        <td>Tanggal Kondisi</td>
                        <td>
                          <?php
                          $date_time = DateTime::createFromFormat('Ymd', @$dk['tanggalKondisi']);
                          if ($date_time) {
                              echo $date_time->format('d F Y');
                          } else {
                              echo '-';
                          }
                          ?>
                        </td>
                      </tr>
                      <tr>
                        <td>Suku Bunga/Imbalan</td>
                        <td>{{ @$dk['sukuBungaImbalan'] }}</td>
                        <td>Jenis Suku Bunga/Imbalan</td>
                        <td>{{ @$dk['jenisSukuBungaImbalanKet'] }}</td>
                      </tr>
                      <tr>
                        <td>Keterangan</td>
                        <td colspan="3">{{ @$dk['keterangan'] }}</td>
                      </tr>
                    </table>
                    <p><strong>Kualitas / Jumlah Hari Tunggakan:</strong></p>
                    <table>
                      <tr>
                        <td>
                          <span>{{ tgl_indo2(@$dk['tahunBulan01']) }}</span>
                          <br>
                          <table>
                            <tbody>
                              <tr>
                                <td>{{ !empty($dk['tahunBulan01Kol']) ? $dk['tahunBulan01Kol'] : '-' }}</td>
                                <td>{{ !empty($dk['tahunBulan01Ht']) ? $dk['tahunBulan01Ht'] : '-' }}</td>
                              </tr>
                            </tbody>
                          </table>
                        </td>
                        <td>
                          <span>{{ tgl_indo2(@$dk['tahunBulan02']) }}</span>
                          <br>
                          <table>
                            <tbody>
                              <tr>
                                <td>{{ !empty($dk['tahunBulan02Kol']) ? $dk['tahunBulan02Kol'] : '-' }}</td>
                                <td>{{ !empty($dk['tahunBulan02Ht']) ? $dk['tahunBulan02Ht'] : '-' }}</td>
                              </tr>
                            </tbody>
                          </table>
                        </td>
                        <td>
                          <span>{{ tgl_indo2(@$dk['tahunBulan03']) }}</span>
                          <br>
                          <table>
                            <tbody>
                              <tr>
                                <td>{{ !empty($dk['tahunBulan03Kol']) ? $dk['tahunBulan03Kol'] : '-' }}</td>
                                <td>{{ !empty($dk['tahunBulan03Ht']) ? $dk['tahunBulan03Ht'] : '-' }}</td>
                              </tr>
                            </tbody>
                          </table>
                        </td>
                        <td>
                          <span>{{ tgl_indo2(@$dk['tahunBulan04']) }}</span>
                          <br>
                          <table>
                            <tbody>
                              <tr>
                                <td>{{ !empty($dk['tahunBulan04Kol']) ? $dk['tahunBulan04Kol'] : '-' }}</td>
                                <td>{{ !empty($dk['tahunBulan04Ht']) ? $dk['tahunBulan04Ht'] : '-' }}</td>
                              </tr>
                            </tbody>
                          </table>
                        </td>
                        <td>
                          <span>{{ tgl_indo2(@$dk['tahunBulan05']) }}</span>
                          <br>
                          <table>
                            <tbody>
                              <tr>
                                <td>{{ !empty($dk['tahunBulan05Kol']) ? $dk['tahunBulan05Kol'] : '-' }}</td>
                                <td>{{ !empty($dk['tahunBulan05Ht']) ? $dk['tahunBulan05Ht'] : '-' }}</td>
                              </tr>
                            </tbody>
                          </table>
                        </td>
                        <td>
                          <span>{{ tgl_indo2(@$dk['tahunBulan06']) }}</span>
                          <br>
                          <table>
                            <tbody>
                              <tr>
                                <td>{{ !empty($dk['tahunBulan06Kol']) ? $dk['tahunBulan06Kol'] : '-' }}</td>
                                <td>{{ !empty($dk['tahunBulan06Ht']) ? $dk['tahunBulan06Ht'] : '-' }}</td>
                              </tr>
                            </tbody>
                          </table>
                        </td>
                        <td>
                          <span>{{ tgl_indo2(@$dk['tahunBulan07']) }}</span>
                          <br>
                          <table>
                            <tbody>
                              <tr>
                                <td>{{ !empty($dk['tahunBulan07Kol']) ? $dk['tahunBulan07Kol'] : '-' }}</td>
                                <td>{{ !empty($dk['tahunBulan07Ht']) ? $dk['tahunBulan07Ht'] : '-' }}</td>
                              </tr>
                            </tbody>
                          </table>
                        </td>
                        <td>
                          <span>{{ tgl_indo2(@$dk['tahunBulan08']) }}</span>
                          <br>
                          <table>
                            <tbody>
                              <tr>
                                <td>{{ !empty($dk['tahunBulan08Kol']) ? $dk['tahunBulan08Kol'] : '-' }}</td>
                                <td>{{ !empty($dk['tahunBulan08Ht']) ? $dk['tahunBulan08Ht'] : '-' }}</td>
                              </tr>
                            </tbody>
                          </table>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <span>{{ tgl_indo2(@$dk['tahunBulan09']) }}</span>
                          <br>
                          <table>
                            <tbody>
                              <tr>
                                <td>{{ !empty($dk['tahunBulan09Kol']) ? $dk['tahunBulan09Kol'] : '-' }}</td>
                                <td>{{ !empty($dk['tahunBulan09Ht']) ? $dk['tahunBulan09Ht'] : '-' }}</td>
                              </tr>
                            </tbody>
                          </table>
                        </td>
                        <td>
                          <span>{{ tgl_indo2(@$dk['tahunBulan10']) }}</span>
                          <br>
                          <table>
                            <tbody>
                              <tr>
                                <td>{{ !empty($dk['tahunBulan10Kol']) ? $dk['tahunBulan10Kol'] : '-' }}</td>
                                <td>{{ !empty($dk['tahunBulan10Ht']) ? $dk['tahunBulan10Ht'] : '-' }}</td>
                              </tr>
                            </tbody>
                          </table>
                        </td>
                        <td>
                          <span>{{ tgl_indo2(@$dk['tahunBulan11']) }}</span>
                          <br>
                          <table>
                            <tbody>
                              <tr>
                                <td>{{ !empty($dk['tahunBulan11Kol']) ? $dk['tahunBulan11Kol'] : '-' }}</td>
                                <td>{{ !empty($dk['tahunBulan11Ht']) ? $dk['tahunBulan11Ht'] : '-' }}</td>
                              </tr>
                            </tbody>
                          </table>
                        </td>
                        <td>
                          <span>{{ tgl_indo2(@$dk['tahunBulan12']) }}</span>
                          <br>
                          <table>
                            <tbody>
                              <tr>
                                <td>{{ !empty($dk['tahunBulan12Kol']) ? $dk['tahunBulan12Kol'] : '-' }}</td>
                                <td>{{ !empty($dk['tahunBulan12Ht']) ? $dk['tahunBulan12Ht'] : '-' }}</td>
                              </tr>
                            </tbody>
                          </table>
                        </td>
                        <td>
                          <span>{{ tgl_indo2(@$dk['tahunBulan13']) }}</span>
                          <br>
                          <table>
                            <tbody>
                              <tr>
                                <td>{{ !empty($dk['tahunBulan13Kol']) ? $dk['tahunBulan13Kol'] : '-' }}</td>
                                <td>{{ !empty($dk['tahunBulan13Ht']) ? $dk['tahunBulan13Ht'] : '-' }}</td>
                              </tr>
                            </tbody>
                          </table>
                        </td>
                        <td>
                          <span>{{ tgl_indo2(@$dk['tahunBulan14']) }}</span>
                          <br>
                          <table>
                            <tbody>
                              <tr>
                                <td>{{ !empty($dk['tahunBulan14Kol']) ? $dk['tahunBulan14Kol'] : '-' }}</td>
                                <td>{{ !empty($dk['tahunBulan14Ht']) ? $dk['tahunBulan14Ht'] : '-' }}</td>
                              </tr>
                            </tbody>
                          </table>
                        </td>
                        <td>
                          <span>{{ tgl_indo2(@$dk['tahunBulan15']) }}</span>
                          <br>
                          <table>
                            <tbody>
                              <tr>
                                <td>{{ !empty($dk['tahunBulan15Kol']) ? $dk['tahunBulan15Kol'] : '-' }}</td>
                                <td>{{ !empty($dk['tahunBulan15Ht']) ? $dk['tahunBulan15Ht'] : '-' }}</td>
                              </tr>
                            </tbody>
                          </table>
                        </td>
                        <td>
                          <span>{{ tgl_indo2(@$dk['tahunBulan16']) }}</span>
                          <br>
                          <table>
                            <tbody>
                              <tr>
                                <td>{{ !empty($dk['tahunBulan16Kol']) ? $dk['tahunBulan16Kol'] : '-' }}</td>
                                <td>{{ !empty($dk['tahunBulan16Ht']) ? $dk['tahunBulan16Ht'] : '-' }}</td>
                              </tr>
                            </tbody>
                          </table>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <span>{{ tgl_indo2(@$dk['tahunBulan17']) }}</span>
                          <br>
                          <table>
                            <tbody>
                              <tr>
                                <td>{{ !empty($dk['tahunBulan17Kol']) ? $dk['tahunBulan17Kol'] : '-' }}</td>
                                <td>{{ !empty($dk['tahunBulan17Ht']) ? $dk['tahunBulan17Ht'] : '-' }}</td>
                              </tr>
                            </tbody>
                          </table>
                        </td>
                        <td>
                          <span>{{ tgl_indo2(@$dk['tahunBulan18']) }}</span>
                          <br>
                          <table>
                            <tbody>
                              <tr>
                                <td>{{ !empty($dk['tahunBulan18Kol']) ? $dk['tahunBulan18Kol'] : '-' }}</td>
                                <td>{{ !empty($dk['tahunBulan18Ht']) ? $dk['tahunBulan18Ht'] : '-' }}</td>
                              </tr>
                            </tbody>
                          </table>
                        </td>
                        <td>
                          <span>{{ tgl_indo2(@$dk['tahunBulan19']) }}</span>
                          <br>
                          <table>
                            <tbody>
                              <tr>
                                <td>{{ !empty($dk['tahunBulan19Kol']) ? $dk['tahunBulan19Kol'] : '-' }}</td>
                                <td>{{ !empty($dk['tahunBulan19Ht']) ? $dk['tahunBulan19Ht'] : '-' }}</td>
                              </tr>
                            </tbody>
                          </table>
                        </td>
                        <td>
                          <span>{{ tgl_indo2(@$dk['tahunBulan20']) }}</span>
                          <br>
                          <table>
                            <tbody>
                              <tr>
                                <td>{{ !empty($dk['tahunBulan20Kol']) ? $dk['tahunBulan20Kol'] : '-' }}</td>
                                <td>{{ !empty($dk['tahunBulan20Ht']) ? $dk['tahunBulan20Ht'] : '-' }}</td>
                              </tr>
                            </tbody>
                          </table>
                        </td>
                        <td>
                          <span>{{ tgl_indo2(@$dk['tahunBulan21']) }}</span>
                          <br>
                          <table>
                            <tbody>
                              <tr>
                                <td>{{ !empty($dk['tahunBulan21Kol']) ? $dk['tahunBulan21Kol'] : '-' }}</td>
                                <td>{{ !empty($dk['tahunBulan21Ht']) ? $dk['tahunBulan21Ht'] : '-' }}</td>
                              </tr>
                            </tbody>
                          </table>
                        </td>
                        <td>
                          <span>{{ tgl_indo2(@$dk['tahunBulan22']) }}</span>
                          <br>
                          <table>
                            <tbody>
                              <tr>
                                <td>{{ !empty($dk['tahunBulan22Kol']) ? $dk['tahunBulan22Kol'] : '-' }}</td>
                                <td>{{ !empty($dk['tahunBulan22Ht']) ? $dk['tahunBulan22Ht'] : '-' }}</td>
                              </tr>
                            </tbody>
                          </table>
                        </td>
                        <td>
                          <span>{{ tgl_indo2(@$dk['tahunBulan23']) }}</span>
                          <br>
                          <table>
                            <tbody>
                              <tr>
                                <td>{{ !empty($dk['tahunBulan23Kol']) ? $dk['tahunBulan23Kol'] : '-' }}</td>
                                <td>{{ !empty($dk['tahunBulan23Ht']) ? $dk['tahunBulan23Ht'] : '-' }}</td>
                              </tr>
                            </tbody>
                          </table>
                        </td>
                        <td>
                          <span>{{ tgl_indo2(@$dk['tahunBulan24']) }}</span>
                          <br>
                          <table>
                            <tbody>
                              <tr>
                                <td>{{ !empty($dk['tahunBulan24Kol']) ? $dk['tahunBulan24Kol'] : '-' }}</td>
                                <td>{{ !empty($dk['tahunBulan24Ht']) ? $dk['tahunBulan24Ht'] : '-' }}</td>
                              </tr>
                            </tbody>
                          </table>
                        </td>
                      </tr>
                    </table>
                    <br>
                    @if (!empty($dk['agunan']))
                      <table class="table">
                        <thead>
                          <th>JENIS AGUNAN</th>
                          <th>NILAI AGUNAN</th>
                          <th>PARIPASU</th>
                          <th>TANGGAL UPDATE</th>
                        </thead>
                        <tbody>
                          @foreach ($dk['agunan'] as $agunan)
                            <tr>
                              <td>{{ $agunan['jenisAgunanKet'] }}</td>
                              <td>{{ format_currency($agunan['nilaiAgunanMenurutLJK']) }}</td>
                              <td>{{ $agunan['prosentaseParipasu'] }}</td>
                              <td>{{ tgl_indo($agunan['tanggalUpdate']) }}</td>
                            </tr>
                            <tr>
                              <td colspan="4">
                                <table class="detail">
                                  <tr>
                                    <td>Nomor Agunan</td>
                                    <td>{{ @$agunan['nomorAgunan'] }}</td>
                                    <td>Peringkat Agunan</td>
                                    <td>{{ @$agunan['peringkatAgunan'] }}</td>
                                  </tr>
                                  <tr>
                                    <td>Jenis Pengikatan</td>
                                    <td>{{ @$agunan['jenisPengikatanKet'] }}</td>
                                    <td>Lembaga Pemeringkat</td>
                                    <td>{{ @$agunan['lembagaPemeringkat'] }}</td>
                                  </tr>
                                  <tr>
                                    <td>Tanggal Pengikatan</td>
                                    <td>{{ tgl_indo(@$agunan['tanggalPengikatan']) }}</td>
                                    <td>Bukti Kepemilikan</td>
                                    <td>{{ @$agunan['buktiKepemilikan'] }}</td>
                                  </tr>
                                  <tr>
                                    <td>Nama Pemilik Agunan</td>
                                    <td>{{ @$agunan['namaPemilikAgunan'] }}</td>
                                    <td>Nilai Agunan (NJOP) / Nilai Wajar</td>
                                    <td>{{ format_currency(@$agunan['nilaiAgunanNjop']) }}</td>
                                  </tr>
                                  <tr>
                                    <td>Alamat Agunan</td>
                                    <td>{{ @$agunan['alamatAgunan'] }}</td>
                                    <td>Nilai Agunan Penilai Independen</td>
                                    <td>{{ format_currency(@$agunan['nilaiAgunanIndep']) }}</td>
                                  </tr>
                                  <tr>
                                    <td>Kab/Kota Lokasi Agunan</td>
                                    <td>{{ @$agunan['kabKotaLokasiAgunanKet'] }}</td>
                                    <td>Nama Penilai Independen</td>
                                    <td>{{ @$agunan['namaPenilaiIndep'] }}</td>
                                  </tr>
                                  <tr>
                                    <td>Tanggal Penilaian Pelapor</td>
                                    <td>{{ tgl_indo(@$agunan['tanggalPenilaianPelapor']) }}</td>
                                    <td>Asuransi</td>
                                    <td>{{ @$agunan['asuransi'] }}</td>
                                  </tr>
                                  <tr>
                                    <td>Keterangan</td>
                                    <td>{{ @$agunan['keterangan'] }}</td>
                                    <td>Tgl Penilaian Penilai Independen</td>
                                    <td>{{ tgl_indo(@$agunan['tanggalPenilaianPenilaiIndependen']) }}</td>
                                  </tr>
                                </table>
                              </td>
                            </tr>
                          @endforeach
                        </tbody>
                      </table>
                    @endif

                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </section>

    <!--ADD_PAGE-->
    <section>
      <div class="panel">
        <div class="panel-header">
          <h3>Irrecovable L/C</h3>
        </div>
        <div class="panel-body">
          <table class="table">
            <thead>
              <tr>
                <th>Pelapor</th>
                <th>Cabang</th>
                <th>Nominal</th>
                <th>Tanggal Udpate</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($data_lc as $lc)
                <tr>
                  <td>{{ $lc['ljk'] }} - {{ $lc['ljkKet'] }}</td>
                  <td>{{ $lc['cabangKet'] }}</td>
                  <td>{{ format_currency($lc['nominalLc']) }}</td>
                  <td>{{ tgl_indo($lc['tanggalUpdate']) }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </section>
    {{-- 
    <section>
      <div class="panel">
        <div class="panel-header">
          <h3>GYD</h3>
        </div>
        <div class="panel-body">
  
        </div>
      </div>
    </section>
  
    <section>
      <div class="panel">
        <div class="panel-header">
          <h3>Surat Berharga</h3>
        </div>
        <div class="panel-body">
  
        </div>
      </div>
    </section>
  
    <section>
      <div class="panel">
        <div class="panel-header">
          <h3>Fasilitas Lain</h3>
        </div>
        <div class="panel-body">
  
        </div>
      </div>
    </section> --}}
  </div>

  <script src="{{ asset('assets/vendor/jquery/dist/jquery.min.js') }}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
  <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.js"></script>

  <script>
    window.jsPDF = window.jspdf.jsPDF;
    const doc = new jsPDF();
    const element = document.getElementById("print"); //The html element to become a pdf
    const sections = document.querySelectorAll("section"); // Select all <section> elements

    let previousY = 10; // Set the initial Y position

    sections.forEach((section, index) => {
      if (index !== 0) {
        doc.addPage(); // Add a new page for each section except the first one
        previousY = 10; // Reset the Y position to the top-left corner
      }

      const sectionHeight = section.offsetHeight; // Get the height of the section

      // Check if the section exceeds the remaining space on the current page
      const remainingSpace = doc.internal.pageSize.getHeight() - previousY;
      if (sectionHeight > remainingSpace) {
        doc.addPage(); // Add a new page if the section exceeds the remaining space
        previousY = 10; // Reset the Y position to the top-left corner
      }

      doc.text(section.innerText, 10, previousY + 10); // Place the content of the section on the PDF
      previousY += sectionHeight + 20; // Update the Y position for the next section
    });

    doc.save("page.pdf"); // Save the PDF after all sections are converted
  </script>
</body>

</html>
