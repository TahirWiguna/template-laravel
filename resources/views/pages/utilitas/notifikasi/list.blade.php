@extends('admin.parent')

@section('title', 'Notification Merchant')

@section('styles')
  <style>
    .avatar {
      object-fit: cover;
    }
  </style>
@endsection

@section('breadcrum')
  <div class="col-lg-6 col-7">
    <h6 class="h2 text-white d-inline-block mb-0">Utilitas</h6>
    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
      <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
        <li class="breadcrumb-item"><a href="#"><i class="fas fa-bell"></i></a></li>
        <li class="breadcrumb-item active" aria-current="page">Notification</li>
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
                  <th>Title</th>
                  <th>Header</th>
                  <th>Created At</th>
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
      datatable: `{{ route('notifikasi.datatable') }}`,
      create: `{{ route('notifikasi.create') }}`,
      edit: `{{ route('notifikasi.edit', ':id') }}`,
      destroy: `{{ route('notifikasi.destroy', ':id') }}`,
      show: `{{ route('notifikasi.show', ':id') }}`,
    }


    let table;

    $(() => {
      let dt_buttons = [
        'csv',
        {
          extend: 'colvis',
          text: 'Column',
          titleAttr: 'Column',
          tag: "button",
          className: ""
        }
      ];

      if (allow.export) {
        dt_buttons.unshift({
          extend: 'print',
          text: '<i class="fas fa-print"></i>',
          titleAttr: 'Print',
          tag: "button",
          className: ""
        }, {
          extend: 'excelHtml5',
          text: '<i class="far fa-file-excel"></i>',
          titleAttr: 'Excel',
          tag: "button",
          className: ""
        })
      }

      if (allow.create) {
        dt_buttons.unshift({
          text: '<i class="fas fa-plus"></i> Create',
          attr: {
            id: 'create'
          },
          action: function(e, dt, node, config) {
            create()
          }
        })
      }

      table = $(".dt-wow").DataTable({
        language: {
          search: `<i class="fas fa-search"></i>`,
          infoFiltered: ``
        },
        dom: "<'row'<'col-sm-6'B><'col-sm-3'f><'col-sm-3'l>> <'row'<'col-sm-12'tr>><'row'<'col-sm-5'i><'col-sm-7'p>>",
        order: [
          [2, 'desc']
        ],
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
          beforeSend: function(request) {
            request.setRequestHeader("X-CSRF-TOKEN", $('meta[name="csrf-token"]').attr('content'));
          }
        },
        columns: [{
            searchable: true,
            orderable: true,
            name: 'title',
            data: 'title',
            render: (data, type, row) => {
              return data
            }
          },
          {
            searchable: true,
            orderable: true,
            name: 'header',
            data: 'header',
            render: (data, type, row) => {
              return data
            }
          },
          {
            searchable: true,
            orderable: true,
            name: 'created_at',
            data: 'created_at',
            render: (data, type, row) => {
              if (data == null) {
                return "-";
              }
              return moment(data).format("DD-MM-YYYY HH:mm:ss")
            }
          },
        ],
        scrollY: 350,
        scrollX: true
      });
    })

    function create() {
      Ryuna.blockUI()
      $.get(_url.create).done((res) => {
        Ryuna.modal({
          title: res?.title,
          body: res?.body,
          footer: res?.footer
        })
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

    function show(id) {
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

    function edit(id) {
      Ryuna.blockUI()
      $.get(_url.edit.replace(':id', id)).done((res) => {
        Ryuna.modal({
          title: res?.title,
          body: res?.body,
          footer: res?.footer
        })
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

    function save() {
      $('#response_container').empty();
      Ryuna.blockElement('.modal-content');
      let el_form = $('#myForm')
      let target = el_form.attr('action')
      let formData = new FormData(el_form[0])

      $.ajax({
        url: target,
        data: formData,
        processData: false,
        contentType: false,
        type: 'POST',
      }).done((res) => {
        if (res?.status == true) {
          let html = '<div class="alert alert-success alert-dismissible fade show">'
          html += `${res?.message}`
          html += '</div>'
          Ryuna.noty('success', '', res?.message)
          $('#response_container').html(html)
          Ryuna.unblockElement('.modal-content')

          setTimeout(() => {
            Ryuna.close_modal();
          }, 500);
          if ($('[name="_method"]').val() == undefined) el_form[0].reset()
          table.draw()
        }
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
      })
    }

    function destroy(id) {
      Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#007bff',
        confirmButtonText: 'Yes',
        cancelButtonText: 'No'
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
  </script>
@endsection
