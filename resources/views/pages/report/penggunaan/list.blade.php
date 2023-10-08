@extends('admin.parent')

@section('title', 'Laporan Penggunaan')

@section('styles')
  <style>

  </style>
@endsection

@section('page')
  <div class="row">
    <div class="col-xl-12 order-xl-1">
      <div class="card" id="card_form">
        <div class="card-header border-1">
          <div class="row align-items-center">
            <div class="col">
              <h3 class="mb-0">Laporan Penggunaan</h3>
            </div>
          </div>
        </div>
        <div class="card-body">

          <ul class="nav nav-tabs">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="{{ route('penggunaan.report') }}"><i class="fas fa-chart-bar"></i> Laporan Pengajuan Data Nasabah (BPR)</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('pengajuan_comparation.report') }}"><i class="fas fa-chart-line"></i> Laporan Perbandingan Hasil Pengajuan & Rekomendasi</a>
            </li>
          </ul>
          <br>
          <div class="table-responsive py-2">
            <table class="table align-items-center table-flush dt-wow" style="width: 100% !important;" id="tbl_status_pengajuan">
              <thead class="thead-light">
                <tr>
                  <th>BPR</th>
                  <th>Menunggu SLIK</th>
                  <th>Menunggu Rekomendasi</th>
                  <th>Selesai</th>
                  <th>Semua Status</th>
                </tr>
              </thead>
              <tbody>

              </tbody>
            </table>
          </div>

        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script>
    let table;

    $(() => {
      let dt_buttons = [{
        extend: 'colvis',
        text: 'Column',
        titleAttr: 'Column',
        tag: "button",
        className: ""
      }];


      dt_buttons.unshift({
        extend: 'print',
        text: '<i class="fas fa-file-pdf"></i>',
        titleAttr: 'pdf',
        tag: "button",
        className: ""
      }, {
        extend: 'csv',
        text: '<i class="fas fa-file-csv"></i>',
        titleAttr: 'csv',
        tag: "button",
        className: ""
      }, {
        extend: 'excelHtml5',
        text: '<i class="fas fa-file-excel"></i>',
        titleAttr: 'excel',
        tag: "button",
        className: ""
      })

      table = $("#tbl_status_pengajuan").DataTable({
        language: {
          search: `<i class="fas fa-search"></i>`,
          infoFiltered: ``
        },
        dom: "<'row'<'col-sm-6'B><'col-sm-3'f><'col-sm-3'l>> <'row'<'col-sm-12'tr>><'row'<'col-sm-5'i><'col-sm-7'p>>",
        order: [
          [4, 'asc']
        ],
        buttons: dt_buttons,
        processing: true,
        serverSide: true,
        lengthMenu: [
          [10, 25, 50, -1],
          [10, 25, 50, 'All'],
        ],
        ajax: {
          url: "{{ route('datatable_pengajuan_status.report') }}",
          type: 'POST',
          beforeSend: function(request) {
            request.setRequestHeader("X-CSRF-TOKEN", $('meta[name="csrf-token"]').attr(
              'content'));
          }
        },
        columns: [{
            searchable: true,
            orderable: true,
            name: 'name',
            data: 'name',
            render: (data, type, row) => {

              return data

            }
          },
          {
            searchable: true,
            orderable: true,
            name: 'status_1',
            data: 'status_1',
            render: (data, type, row) => {

              return data

            }
          },
          {
            searchable: true,
            orderable: true,
            name: 'status_2',
            data: 'status_2',
            render: (data, type, row) => {

              return data

            }
          },
          {
            searchable: true,
            orderable: true,
            name: 'status_3',
            data: 'status_3',
            render: (data, type, row) => {

              return data

            }
          },
          {
            searchable: true,
            orderable: true,
            name: 'name',
            data: 'name',
            render: (data, type, row) => {

              return parseInt(row.status_1) + parseInt(row.status_2) + parseInt(row.status_3);

            }
          },
        ],
        // scrollY: (Ryuna.heightWindow() <= 660 ? 500 : (Ryuna.heightWindow() - 426)),
        scrollX: true
      });
    })
  </script>
@endsection
