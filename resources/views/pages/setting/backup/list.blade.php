@extends('admin.parent')

@section('title', 'Backup')

@section('styles')
  <style>
    .form-inline .form-group {
      margin-right: 10px;
      flex-direction: column !important;
      align-items: flex-start !important;
    }

    .form-inline .form-group label {
      margin-bottom: 5px;
      text-align: left;
    }

    .modal img {
      width: 100%;
    }

    .modal li {
      /* margin-bottom: 10px; */
      padding: 5px;
      /* border-bottom: 1px solid rgb(205, 205, 205) */
    }
  </style>
@endsection

@section('breadcrum')
  <div class="col-lg-6 col-7">
    <h6 class="h2 text-white d-inline-block mb-0">Manage</h6>
    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
      <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
        <li class="breadcrumb-item"><a href="#"><i class="fas fa-hands-helping"></i></a></li>
        <li class="breadcrumb-item active" aria-current="page">Slik</li>
      </ol>
    </nav>
  </div>
@endsection

@section('page')
  <div class="row">
    <div class="col-xl-12 order-xl-1">
      <div class="card" id="card_form">
        <div class="card-header border-1">
          <div class="row align-items-center">
            <div class="col">
              <h3 class="mb-0">Setting</h3>
            </div>
          </div>
        </div>
        <div class="card-body">
          <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('setting.profile')}}"><i class="fas fa-user"></i> Profil</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('setting.change_password')}}"><i class="fas fa-user-lock"></i> Ganti Password</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('key.index')}}"><i class="fas fa-key"></i> Atur Chiper Key</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="{{ route('backup.index')}}"><i class="fab fa-google"></i>  Pindahkan Data Ke Google Drive</a>
            </li>
          </ul>
          <br>
          <div class="card bg-info text-white pt-3">
            <ul>
              <li>
                <a href="javascript:show_guide_credentials()" class="text-white">Cara membuat & mendapatkan Client ID & Secret Key</a>
              </li>
              <li>
                <a href="javascript:show_guide_usage()" class="text-white">Cara menggunakan fitur backup</a>
              </li>
            </ul>
          </div>

          <form id="myForm" class="form-inline">
            <div class="form-group">
              <label for="client_id">Client ID</label>
              <input type="text" autocomplete="off" class="form-control" id="client_id" name="client_id" placeholder="Masukan client ID" value="{{ @$google_credentials['GOOGLE_DRIVE_CLIENT_ID'] }}">
            </div>
            <div class="form-group">
              <label for="client_secret">Client Secret</label>
              <input type="text" autocomplete="off" class="form-control" id="client_secret" name="client_secret" placeholder="Masukan client secret"
                value="{{ @$google_credentials['GOOGLE_DRIVE_SECRET_KEY'] }}">
            </div>
            <div class="form-group">
              <label for="">&nbsp;</label>
              <button type="button" class="btn btn-primary" onclick="google_credentials_save()">Save</button>
            </div>
          </form>
          <div id="response-submit" style="margin-top:20px;"></div>

          <hr>

          @include('admin.alert')
          @if ($is_logged_in)
            <p>You Already Logged in</p>
          @else
            <a href="{{ route('backup.login') }}" class="btn btn-primary">Login</a>
          @endif
          {{-- <form id="myForm" class="form-inline">
            <div class="form-group">
              <label for="client_id">Client ID</label>
              <input type="password" class="form-control" id="client_id" name="client_id" placeholder="Masukan client id">
            </div>
            <div class="form-group">
              <label for="client_secret">Client Secret</label>
              <input type="password" class="form-control" id="client_secret" name="client_secret" placeholder="Masukan client secret">
            </div>
            <div class="form-group">
              <label for="">&nbsp;</label>
              <button type="button" class="btn btn-primary" onclick="cipher_key_save()">Save</button>
            </div>
          </form>
          <div id="response-submit" style="margin-top:20px;"></div> --}}

          @if ($is_logged_in)
            <br>
            <h2>Available Data</h2>
            <table class="table align-items-center table-flush dt-available_data" style="width: 100% !important;" id="dt-available_data">
              <thead class="thead-light">
                <tr>
                  <th>ACTION</th>
                  <th>Nasabah</th>
                  <th>type</th>
                  <th>file name</th>
                  <th>nomor laporan</th>
                  <th>diajukan oleh</th>
                  <th>tanggal pengajuan</th>
                </tr>
              </thead>
              <tbody>

              </tbody>
            </table>

            <hr>
            <br>
            <h2>Your Drive</h2>
            <table class="table align-items-center table-flush dt-your_drive" style="width: 100% !important;" id="dt-your_drive">
              <thead class="thead-light">
                <tr>
                  <th>id</th>
                  <th>File Name</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($files as $f)
                  <tr>
                    <td>{{ $f['id'] }}</td>
                    <td>{{ $f['name'] }}</td>

                  </tr>
                @endforeach
              </tbody>
            </table>

            <br>
            <h2></h2>

          @endif
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="show_guide_credentials" data-backdrop="static" data-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modal_title">Cara Mendapatkan Credentials Google Drive</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="modal_body">
          <div class="guide-wrapper">
            <p>Untuk dapat melakukan backup data menggunakan Google Drive silahkan ikuti petunjuk berikut:</p>
            <ol>
              <li>
                <p>Login ke Google Console : <a href="https://console.cloud.google.com" target="_blank">https://console.cloud.google.com</a></p>
                <div class="img-guide"><img src="{{ asset('/img/drive/gconsole1.png') }}"></div>
              </li>
              <li>
                <p>Buat Project dengan nama SLIK Booster</p>
                <div class="img-guide"><img src="{{ asset('/img/drive/gconsole2.png') }}"></div>
                <div class="img-guide"><img src="{{ asset('/img/drive/gconsole3.png') }}"></div>
              </li>
              <li>
                <p>Pilih Project yang sudah dibuat tadi</p>
                <div class="img-guide"><img src="{{ asset('/img/drive/gconsole4.png') }}"></div>
              </li>
              <li>
                <p>Pada menu Quick Access pilih APIs &amp; Services</p>
                <div class="img-guide"><img src="{{ asset('/img/drive/gconsole5.png') }}"></div>
              </li>
              <li>
                <p>Masuk ke Menu Enabled APIs &amp; Services, kemudian klik tombol ENABLE APIS &amp; SERVICES</p>
                <div class="img-guide"><img src="{{ asset('/img/drive/gconsole6.png') }}"></div>
              </li>
              <li>
                <p>Ketikan 'Google Drive' pada input pencarian API dan pilih 'google drive api' seperti gambar berikut</p>
                <div class="img-guide"><img src="{{ asset('/img/drive/gconsole7.png') }}"></div>
                <div class="img-guide"><img src="{{ asset('/img/drive/gconsole8.png') }}"></div>
              </li>
              <li>
                <p>Aktifkan Google Drive API dengan cara klik tombol 'Enable'</p>
                <div class="img-guide"><img src="{{ asset('/img/drive/gconsole9.png') }}"></div>
              </li>
              <li>
                <p>Setelah aktif kita buat Credential APInya dengan cara klik tombol 'Create Credentials'</p>
                <div class="img-guide"><img src="{{ asset('/img/drive/gconsole10.png') }}"></div>
              </li>
              <li>
                <p>Isi formulir pendaftaran Credential seperti berikut</p>
                <div class="img-guide"><img src="{{ asset('/img/drive/gconsole11.png') }}"></div>
                <p>Pada inputan user support isikan email google anda</p>
                <div class="img-guide"><img src="{{ asset('/img/drive/gconsole12.png') }}"></div>
                <div class="img-guide"><img src="{{ asset('/img/drive/gconsole13.png') }}"></div>
                <div class="img-guide"><img src="{{ asset('/img/drive/gconsole14.png') }}"></div>
                <p>Hapus semua data pada tabel 'sensitive scopes' dengan cara klik tombol dengan icon 'tempat sampah'</p>
                <div class="img-guide"><img src="{{ asset('/img/drive/gconsole15.png') }}"></div>
                <div class="img-guide"><img src="{{ asset('/img/drive/gconsole16.png') }}"></div>
                <p>Pada Step OAuth Client ID isikan inputan Authorize Redirect URis dengan <b>'{{ url('admin/setting/backup') }}'</b></p>
                <div class="img-guide"><img src="{{ asset('/img/drive/gconsole17.png') }}"></div>
                <div class="img-guide"><img src="{{ asset('/img/drive/gconsole18.png') }}"></div>
              </li>
              <li>
                <p>Setelah Credential berhasil dibuat masuk ke menu 'Credentials' untuk melihat Client Secret &amp; Client ID. Copy keduanya dan isikan ke Menu setting -&gt; google drive pada inputan
                  Client Secret &amp; Client ID</p>
                <div class="img-guide"><img src="{{ asset('/img/drive/gconsole20.png') }}"></div>
              </li>
              <li>
                <p>Masuk ke menu 'OAuth Consent Screen' dan kemudian masukkan akun gmail yang akan dipakai sebagai backup.</p>
                <div class="img-guide"><img src="{{ asset('/img/drive/gconsole21.png') }}"></div>
              </li>
              <li>Selesai. Credentials siap dimasukan ke dalam web</li>
            </ol>
          </div>
        </div>
        <div class="modal-footer" id="modal_footer"></div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="show_guide_usage" data-backdrop="static" data-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modal_title">Cara menggunakan fitur</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="modal_body">
          <div class="guide-wrapper">
            <p>Untuk dapat melakukan backup data menggunakan Google Drive silahkan ikuti petunjuk berikut:</p>
            <ol>
              <li>
                <p>Masukan Client ID & Client Secret ke dalam inputan yang telah disediakan. Lalu klik Save</p>
              </li>
              <li>
                <p>Klik tombol Login</p>
              </li>
              <li>
                <p>Jika Client ID & Client Secret benar maka akan muncul tampilan seperti ini jika anda klik tombol login</p>
                <img src="{{ asset('/img/drive/step1.png') }}" alt="">
              </li>
              <li>
                <p>Jika Client ID & Client Secret benar maka akan muncul tampilan seperti ini jika anda klik tombol login. Klik akun yang akan dijadikan tempat penyimpanan</p>
                <img src="{{ asset('/img/drive/step1.png') }}" alt="">
              </li>
              <li>
                <p>Jika akun baru pertama login akan muncul tampilan seperti ini. Klik tombol "Advanced" lalu klik "Go to ... (unsafe)"</p>
                <img src="{{ asset('/img/drive/step3.png') }}" alt="">
              </li>
              <li>
                <p>Selanjutnya klik tombol "Continue" seperti gambar di bawah ini</p>
                <img src="{{ asset('/img/drive/step4.png') }}" alt="">
              </li>
              <li>
                <p>Selesai. Jika berhasil login maka tampilan web akan berubah seperti ini. Klik Backup pada data slik yang ingin di backup. Data yang akan dibackup akan tersimpan menjadi .txt lagi</p>
                <img src="{{ asset('/img/drive/step5.png') }}" alt="">
              </li>
            </ol>
          </div>
        </div>
        <div class="modal-footer" id="modal_footer"></div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')

  <script>
    function google_credentials_save() {
      let id = $('#client_id').val();
      let secret = $('#client_secret').val();

      if (id == '') {
        alert('Please google client id');
        return;
      }

      if (secret == '') {
        alert('Please google client secret');
        return;
      }

      let formData = new FormData($('#myForm')[0])

      Ryuna.blockElement('#card_form')
      $.ajax({
        url: "{{ route('setting_bpr.set_google_credentials') }}",
        data: JSON.stringify({
          client_id: id,
          client_secret: secret
        }),
        type: 'POST',
        processData: true,
        contentType: 'application/json',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
      }).done((res) => {
        if (res?.status == true) {
          let html = '<div class="alert alert-success alert-dismissible fade show">'
          html += `${res?.message}`
          html += '</div>'
          Ryuna.noty('success', '', res?.message)
          $('#response-submit').html(html)
          Ryuna.unblockElement('#card_form')

          localStorage.setItem('x', res.data);
        }
      }).fail((xhr) => {
        if (xhr?.status == 422) {
          let errors = xhr.responseJSON.errors
          let html = '<div class="alert alert-danger alert-dismissible fade show">'
          html += '<ul>';
          for (let key in errors) {
            if (Array.isArray(errors[key])) {
              for (let i = 0; i < errors[key].length; i++) {
                html += `<li>${errors[key][i]}</li>`;
              }
            } else {
              html += `<li>${errors[key]}</li>`;
            }
          }
          html += '</ul>'
          html += '</div>'
          $('#response-submit').html(html)
          Ryuna.unblockElement('#card_form')
        } else {
          let html = '<div class="alert alert-danger alert-dismissible fade show">'
          html += `${xhr?.responseJSON?.message}`
          html += '</div>'
          Ryuna.noty('error', '', xhr?.responseJSON?.message)
          $('#response-submit').html(html)
          Ryuna.unblockElement('#card_form')
        }
      })

      $('#cipher').val('');
      $('#cipher_confirm').val('');

    }

    $(() => {
      let dt_buttons = [{
        extend: 'colvis',
        text: 'Column',
        titleAttr: 'Column',
        tag: "button",
        className: ""
      }];

      table_your_drive = $(".dt-your_drive").DataTable({
        language: {
          search: `<i class="fas fa-search"></i>`,
          infoFiltered: ``
        },
        dom: "<'row'<'col-sm-6'B><'col-sm-3'f><'col-sm-3'l>> <'row'<'col-sm-12'tr>><'row'<'col-sm-5'i><'col-sm-7'p>>",
        order: [
          [0, 'asc']
        ],
        buttons: dt_buttons,
        lengthMenu: [
          [10, 25, 50, -1],
          [10, 25, 50, 'All'],
        ],
        scrollX: true
      });


      table_available_data = $(".dt-available_data").DataTable({
        language: {
          search: `<i class="fas fa-search"></i>`,
          infoFiltered: ``
        },
        dom: "<'row'<'col-sm-6'B><'col-sm-3'f><'col-sm-3'l>> <'row'<'col-sm-12'tr>><'row'<'col-sm-5'i><'col-sm-7'p>>",
        order: [
          [0, 'asc']
        ],
        buttons: dt_buttons,
        processing: true,
        serverSide: true,
        lengthMenu: [
          [10, 25, 50, -1],
          [10, 25, 50, 'All'],
        ],
        ajax: {
          url: "{{ route('slik.get_all_slik') }}",
          type: 'POST',
          beforeSend: function(request) {
            request.setRequestHeader("X-CSRF-TOKEN", $('meta[name="csrf-token"]').attr(
              'content'));
          }
        },
        columns: [{
            searchable: false,
            orderable: false,
            name: 'slik_detail_id',
            data: 'slik_detail_id',
            className: 'text-center',
            render: function(data, type, row, meta) {
              let cipher = localStorage.getItem('x')
              let url = `{{ route('slik.preview_slik', [':id_slik', ':cipher_key']) }}`.replace(':id_slik', data).replace(':cipher_key', encodeURIComponent(cipher))
              return `<div class="btn-group">
                        <button type="button" class="btn btn-sm btn-primary" onClick="backup_file(${data},'${cipher}')" data-id="${data}">BACKUP</button>
                      </div>`
            }
          },
          {
            searchable: true,
            orderable: true,
            name: 'nama_nasabah',
            data: 'nama_nasabah',
          },
          {
            searchable: true,
            orderable: true,
            name: 'type',
            data: 'type',
          },
          {
            searchable: true,
            orderable: true,
            name: 'nomor_laporan',
            data: 'nomor_laporan',
          },
          {
            searchable: true,
            orderable: true,
            name: 'file_name',
            data: 'file_name',
          },
          {
            searchable: true,
            orderable: true,
            name: 'diajukan_oleh',
            data: 'diajukan_oleh',
          },
          {
            searchable: true,
            orderable: true,
            name: 'tanggal_pengajuan',
            data: 'tanggal_pengajuan',
          },
        ],
        scrollX: true
      });

    })

    function backup_file(id, cipher) {
      Ryuna.noty("info", "", "Backuping Data...")

      let text = $(`[data-id="${id}"]`).text()
      $(`[data-id="${id}"]`).attr('disabled', true)
      $(`[data-id="${id}"]`).text('Backuping...')

      $.ajax({
        url: "{{ route('backup.backup_slik') }}",
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: JSON.stringify({
          id: id,
          key: cipher
        }),
        processData: true,
        contentType: 'application/json',
        type: 'POST',
      }).done((res) => {
        Ryuna.noty("success", "", res.message)
        $(`[data-id="${id}"]`).attr('disabled', false)
        $(`[data-id="${id}"]`).text(text)
      }).fail((xhr) => {
        if (xhr?.status == 422) {
          let errors = xhr.responseJSON.errors
          let html = '<div class="alert alert-danger alert-dismissible fade show">'
          html += '<ul>';
          for (let key in errors) {
            html += `<li>${errors[key]}</li>`;
          }
          html += '</ul>'
          html += '</div>'
          $('#response_container').html(html)
          Ryuna.unblockElement('.modal-content')
        } else {
          let html = '<div class="alert alert-danger alert-dismissible fade show">'
          html += `${xhr?.responseJSON?.message}`
          html += '</div>'
          Ryuna.noty('error', '', xhr?.responseJSON?.message)
          $('#response_container').html(html)
          Ryuna.unblockElement('.modal-content')
        }
        $(`[data-id="${id}"]`).attr('disabled', false)
        $(`[data-id="${id}"]`).text(text)
      })

    }

    function show_guide_credentials() {
      $("#show_guide_credentials").modal('show')
    }

    function show_guide_usage() {
      $("#show_guide_usage").modal('show')
    }
  </script>
@endsection
