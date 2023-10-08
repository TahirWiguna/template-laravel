@extends('admin.parent')

@section('title', 'Sampah - '.$module_name)

@section('styles')
<style>
  .avatar{
    object-fit: cover;
  }
</style>
@endsection

@section('breadcrum')
<div class="col-lg-6 col-7">
  <h6 class="h2 text-white d-inline-block mb-0">{{ $group }}</h6>
  <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
    <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
      <li class="breadcrumb-item"><a href="#"><i class="{{ $icon }}"></i></a></li>
      <li class="breadcrumb-item active" aria-current="page">{{ $module_name }}</li>
    </ol>
  </nav>
</div>
@endsection

@section('page')
<div class="row">
  <div class="col-xl-12 order-xl-1">
    <div class="card">
      <div class="card-body">
        @include('admin.alert')
        <div class="table-responsive py-2">
          <table class="table align-items-center table-flush dt-wow" style="width: 100% !important;">
            <thead class="thead-light">
              <tr>
                <th>Aksi</th>
                <th>Module</th>
                <th>Slug</th>
                <th>Permission</th>
                <th>Deskripsi</th>
                <th>Status</th>
                <th>Created At</th>
                <th>Updated At</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')

<script>
  let allow = JSON.parse(`{!! $allow !!}`)
  let _url = {
    datatable: `{{ route('datatable.'.$module) }}`,
    restore: `{{ route($module.'.restore', ':id') }}`,
    destroy: `{{ route($module.'.destroy', ':id') }}`,
  }

  let table;

  $(() => {
    let dt_buttons = [
      {
        extend: 'colvis',
        text: 'Column',
        titleAttr: 'Column',
        tag: "button",
        className: ""
      }
    ];

    if(allow.export){
      dt_buttons.unshift({
        extend: 'print',
        text: '<i class="fas fa-file-pdf"></i>',
        titleAttr: 'pdf',
        tag: "button",
        className: ""
      },
      {
        extend: 'csv',
        text: '<i class="fas fa-file-csv"></i>',
        titleAttr: 'csv',
        tag: "button",
        className: ""
      },
      {
        extend: 'excelHtml5',
        text: '<i class="fas fa-file-excel"></i>',
        titleAttr: 'excel',
        tag: "button",
        className: ""
      })
    }

    table = $(".dt-wow").DataTable({
      language: {
        search: `<i class="fas fa-search"></i>`,
        infoFiltered: ``
      },
      dom: "<'row'<'col-sm-6'B><'col-sm-3'f><'col-sm-3'l>> <'row'<'col-sm-12'tr>><'row'<'col-sm-5'i><'col-sm-7'p>>",
      order: [[1, 'asc']],
      buttons: dt_buttons,
      processing: true,
      serverSide: true,
      lengthMenu: [
        [10, 25, 50, -1],
        [10, 25, 50, 'All'],
      ],
      ajax: {
        url: _url.datatable,
        type: 'POST',
        beforeSend: function (request) {
          request.setRequestHeader("X-CSRF-TOKEN", $('meta[name="csrf-token"]').attr('content'));
        },
        data: function(d) {
          d.deleted = true;
          return d;
        }
      },
      columns: [
        { searchable: false, orderable: false, name: 'id', data: 'id', className: 'text-center',
          render: (data, type, row) => {
            html = `<div class="btn-group btn-group-sm" branch="group">
              ${allow.restore ? `<button onclick="restore(${data})" type="button" class="btn btn-sm btn-default" title="Hapus"><i class="fas fa-undo"></i></button>`: '' }
              ${allow.delete ? `<button onclick="destroy(${data})" type="button" class="btn btn-sm btn-default" title="Ubah"><i class="fas fa-trash"></i></button>`: '' }
            </div>`

            return html
          }
        },
        { searchable: true, orderable: true, name: 'module', data: 'module',
          render: (data, type, row) => {
            return data.module
          }
        },
        { searchable: true, orderable: true, name: 'slug', data: 'slug',
          render: (data, type, row) => {
            if(allow.show){
              return `<a href="javascript:show(${row.id})">${data}</a>`
            }else{
              return data
            }
          }
        },
        { searchable: true, orderable: true, name: 'permission', data: 'permission',
          render: (data, type, row) => {
            return data
          }
        },
        { searchable: true, orderable: true, name: 'deskripsi', data: 'deskripsi',
          render: (data, type, row) => {
            return data
          }
        },
        { searchable: true, orderable: true, name: 'status', data: 'status',
          render: (data, type, row) => {
            return `
            <label class="custom-toggle">
                <input type="checkbox" ${ (data ? 'checked': '') } disabled>
                <span class="custom-toggle-slider rounded-circle"></span>
            </label>
            `
          }
        },
        { searchable: true, orderable: true, name: 'createdAt', data: 'createdAt',
          render: (data, type, row) => {
            if(data == null){
              return "-";
            }
            return moment(data).format("DD-MM-YYYY HH:mm:ss")
          }
        },
        { searchable: true, orderable: true, name: 'updatedAt', data: 'updatedAt',
          render: (data, type, row) => {
            if(data == null){
              return "-";
            }
            return moment(data).format("DD-MM-YYYY HH:mm:ss")
          }
        },
      ],
      scrollY: (Ryuna.heightWindow() <= 660 ? 500 : (Ryuna.heightWindow() - 426)),
      scrollX: true
    });
  })

  function show(id){
    Ryuna.blockUI()
    $.get(_url.show.replace(':id', id)).done((res) => {
      Ryuna.modal({
        title: res?.title,
        body: res?.body,
        footer: res?.footer
      })
      Ryuna.large_modal()
      Ryuna.unblockUI()
    }).fail((xhr) => {
      Ryuna.unblockUI()
      Swal.fire({
        title: 'Whoops!',
        text: xhr?.responseJSON?.message ? xhr.responseJSON.message : 'Internal Server Error',
        type: 'error',
        confirmButtonColor: '#007bff'
      })
    })
  }

  function destroy(id){
    Swal.fire({
      title: 'Apakah anda yakin?',
      text: "Data yang di hapus akan permanen!",
      type: 'question',
      showCancelButton: true,
      confirmButtonColor: '#dc3545',
      cancelButtonColor: '#007bff',
      confirmButtonText: 'Ya',
      cancelButtonText: 'Tidak'
    }).then((result) => {
      console.log(result)
      if (result.value) {
        $.ajax({
          url: _url.destroy.replace(':id', id),
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: 'DELETE',
        }).done((res) => {
          Swal.fire({
            title: res.message,
            text: '',
            type: 'success',
            confirmButtonColor: '#007bff'
          })
          table.draw()
        }).fail((xhr) => {
          Swal.fire({
            title: xhr.responseJSON.message,
            text: '',
            type: 'error',
            confirmButtonColor: '#007bff'
          })
        })
      }
    })
  }

  function restore(id){
    Swal.fire({
      title: 'Apakah anda yakin?',
      text: "Data akan dipulihkan!",
      type: 'question',
      showCancelButton: true,
      confirmButtonColor: '#dc3545',
      cancelButtonColor: '#007bff',
      confirmButtonText: 'Ya',
      cancelButtonText: 'Tidak'
    }).then((result) => {
      console.log(result)
      if (result.value) {
        $.ajax({
          url: _url.restore.replace(':id', id),
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: 'POST',
        }).done((res) => {
          Swal.fire({
            title: res.message,
            text: '',
            type: 'success',
            confirmButtonColor: '#007bff'
          })
          table.draw()
        }).fail((xhr) => {
          Swal.fire({
            title: xhr.responseJSON.message,
            text: '',
            type: 'error',
            confirmButtonColor: '#007bff'
          })
        })
      }
    })
  }
</script>
@endsection
