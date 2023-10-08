<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="Ari Ardiansyah">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Verlos | @yield('title')</title>
  <!-- Favicon -->
  <link rel="icon" href="{{ asset('assets/img/brand/favicon.png') }}" type="image/png">
  <!-- Fonts -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
  <!-- Icons -->
  <link rel="stylesheet" href="{{ asset('assets/vendor/nucleo/css/nucleo.css') }}" type="text/css">
  <link rel="stylesheet" href="{{ asset('assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}" type="text/css">
  <!-- Page plugins -->
  @yield('styles')
  <link rel="stylesheet" href="{{ asset('assets/vendor/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendor/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendor/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}">

  <link rel="stylesheet" href="{{ asset('assets/vendor/datatable-extensions/fixedColumns.bootstrap4.min.css') }}">

  <link rel="stylesheet" href="{{ asset('assets/vendor/select2/dist/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendor/sweetalert2/dist/sweetalert2.min.css') }}">
  <!-- Custom css -->
  <link rel="stylesheet" href="{{ asset('css/scrollbar.css') }}">
  <!-- <link rel="stylesheet" href="{{ asset('assets/vendor/wizard/bd-wizard.css') }}"> -->
  <!-- <link rel="stylesheet" href="{{ asset('assets/vendor/wizard/materialdesignicons.min.css') }}"> -->
  <link rel="stylesheet" href="{{ asset('assets/vendor/summernote/summernote-bs4.min.css') }}">
  <!-- Custom wizard css -->
  <link rel="stylesheet" href="{{ asset('assets/wizard/css/bd-wizard.css') }}">
  <!-- Argon CSS -->
  <link rel="stylesheet" href="{{ asset('assets/css/argon.css?v=1.1.0') }}" type="text/css">
  <link rel="stylesheet" href="{{ asset('assets/css/custom.css?' . date('Ym')) }}" type="text/css">
  <link rel="stylesheet" href="{{ asset('css/datatables-searchbuilder.min.css') }}" type="text/css">
  <link rel="stylesheet" href="{{ asset('css/datatables-datetime.min.css') }}" type="text/css">
  {{-- Date CSS --}}
  <link href="{{ asset('assets/vendor/flatpickr/flatpickr.min.css') }}" rel="stylesheet">
  {{-- <link href="{{ asset('assets/vendor/flatpickr/material_blue.css') }}" rel="stylesheet"> --}}
  {{-- Noty --}}
  <link href="{{ asset('assets/vendor/noty/noty.css') }}" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Lexend+Deca&display=swap" rel="stylesheet">

  {{-- <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" /> --}}
  <link href="{{ asset('assets/vendor/dropzone/dist/dropzone.css') }}" rel="stylesheet">

  {{-- check app debug false --}}
  @if (config('app.debug') == false)
    @laravelPWA
  @endif
  <script>
    var base_url = "{{ url('') . '/' }}"
  </script>

  <style>
    input[readonly].flatpickr {
      background-color: transparent;
      font-size: 1em;
    }
  </style>
</head>

<body>
  <!-- Sidenav -->
  @include('admin.sidebar')

  <!-- Main content -->
  <div class="main-content" id="panel">
    <!-- Topnav -->
    @include('admin.navbar')
    <!-- Header -->
    {{-- <div class="header bg-purple2 pb-6">
      <div class="container-fluid">
        <div class="header-body">
          <div class="row align-items-center py-4">
            @yield('breadcrum')
          </div>
        </div>
      </div>
    </div> --}}
    <!-- Page content -->
    <div class="container-fluid" style="margin-top: 10px">
      @yield('page')
      <!-- Footer -->
      {{-- @include('admin.footer') --}}
    </div>
  </div>
  <!-- The Modal -->
  <div class="modal fade" id="myModal" data-backdrop="static" data-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modal_title"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="modal_body"></div>
        <div class="modal-footer" id="modal_footer"></div>
      </div>
    </div>
  </div>
  <!-- Fab Button -->
  <button class="btn btn-fab btn-info" title="Panduan" onclick="Ryuna.helpModal(`{{ isset($help_key) ? $help_key : '' }}`)">
    <i class="fas fa-question"></i>
  </button>
  <!-- Argon Scripts -->
  <!-- Core -->
  <script src="{{ asset('assets/vendor/jquery/dist/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/js-cookie/js.cookie.js') }}"></script>
  <script src="{{ asset('assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js') }}"></script>
  <!-- Optional JS -->
  <script src="{{ asset('js/chart.js') }}"></script>
  <script src="{{ asset('assets/vendor/datatables.net/js/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
  <script src="{{ asset('js/jszip.js') }}"></script>
  <script src="{{ asset('js/colvis.js') }}"></script>
  <script src="{{ asset('assets/vendor/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/datatables.net-buttons/js/buttons.flash.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/datatables.net-select/js/dataTables.select.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/datatable-extensions/dataTables.fixedColumns.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/select2/dist/js/select2.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/sweetalert2/dist/sweetalert2.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/jquery-block-ui/jquery-block-ui.js') }}"></script>
  <script src="{{ asset('js/autoNumeric.js') }}"></script>
  <script src="{{ asset('js/numeral.js') }}"></script>
  <script src="{{ asset('assets/vendor/summernote/summernote-bs4.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/flatpickr/flatpickr.js') }}"></script>
  <script src="{{ asset('assets/vendor/datatables-buttons-excel-styles/buttons.html5.styles.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/datatables-buttons-excel-styles/buttons.html5.styles.templates.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/datatables-selected-box/dataTables.checkboxes.min.js') }}"></script>

  <!-- Custom js -->
  <script src="{{ asset('js/datatables-language.js') }}"></script>
  <script src="{{ asset('js/datatables-searchbuilder.min.js') }}"></script>
  <script src="{{ asset('js/datatables-datetime.min.js') }}"></script>
  <script src="{{ asset('js/moment.min.js') }}"></script>
  <script src="{{ asset('js/datetime-moment.js') }}"></script>
  <script src="{{ asset('assets/vendor/wizard/jquery.steps.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/wizard/bd-wizard.js') }}"></script>
  <script src="{{ asset('assets/vendor/dropzone/dist/dropzone.js') }}"></script>
  <script>
    Dropzone.autoDiscover = false
  </script>
  {{-- Noty JS --}}
  <script src="{{ asset('assets/vendor/noty/noty.js') }}" type="text/javascript"></script>
  <!-- Argon JS -->
  <script src="{{ asset('assets/js/argon.js?v=1.1.0') }}"></script>
  <!-- Demo JS - remove this in your project -->
  <script src="{{ asset('assets/js/demo.min.js') }}"></script>
  {{-- Global js --}}
  <script src="{{ asset('js/global.js') }}"></script>
  <script>
    const MAX_FILE_SIZE = "{{ App\Constants\Constant::MAX_FILE_SIZE }}"
    const MAX_FILE_SIZE_TOTAL = "{{ App\Constants\Constant::MAX_FILE_SIZE * 3 }}"

    $(document).ajaxComplete(function(event, xhr, settings) {
      if (xhr.status == 401) {
        window.location.href = "{{ route('auth.logout') }}"
      }
    });

    $(() => {

      $("input[type=file]").change(function() {
        var fileInput = $(this);
        var maxFileSizeKB = MAX_FILE_SIZE;
        var maxFileSizeMB = maxFileSizeKB / 1024;
        var fileSizeMB = fileInput.prop("files")[0].size / (1024 * 1024);
        if (fileSizeMB > maxFileSizeMB) {
          alert("Please select a file smaller than " + maxFileSizeMB.toFixed(2) + " MB. You selected a file of " +
            fileSizeMB.toFixed(2) + " MB.");
          fileInput.val("");
        }

        var acceptFile = fileInput.attr('accept');
        var ext = '.' + fileInput.val().split('.').pop().toLowerCase();
        var acceptExt = acceptFile.split(',').map(function(item) {
          return item.trim()
        });
        if ($.inArray(ext, acceptExt) == -1) {
          alert('Please upload file with extension ' + acceptExt.join(', '));
          fileInput.val("");
        }
      });

      $('.flatpickr').flatpickr({
        dateFormat: "Y-m-d",
        altFormat: "d-m-Y",
        altInput: true
      })
    })

    getCountNotif()

    function getCountNotif() {
      let url = "{{ route('dashboard.count_notification') }}"

      $('#notif_count').text('...')
      $.get(url).done((res) => {
        $('#notif_count').text(res?.data ?? 0)
      })
    }

    function getNotif() {
      let url = "{{ route('dashboard.notification') }}"

      Ryuna.blockUI()
      $.get(url).done((res) => {
        $('#notif_count').text('0')
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

    // Calculate the size of the FormData object in bytes
    function calculateFormDataSize(formData) {
      let size = 0;
      for (let pair of formData.entries()) {
        const value = pair[1];
        if (value instanceof File) {
          size += value.size;
        } else if (value instanceof Blob) {
          size += value.size;
        } else {
          size += new Blob([value]).size;
        }
      }
      return size;
    }

    // Validate the size of the formData object before sending it
    function validateFormDataSize(formData, maxSizeInKB = MAX_FILE_SIZE_TOTAL) {
      const maxSizeInBytes = maxSizeInKB * 1024;
      const formDataSize = calculateFormDataSize(formData);
      const maxSizeInMB = maxSizeInBytes / (1024 * 1024);

      if (formDataSize > maxSizeInBytes) {
        // Validation failed
        alert(`Max total size of all files is ${maxSizeInMB}MB, Your total size is ${(formDataSize / (1024 * 1024)).toFixed(2)}MB`)
        return false;
      }

      // Validation passed
      return true;
    }
  </script>

  @yield('scripts')
  <script>
    $('.dt_table thead').addClass('thead-light');
    $('.select2').select2({
      width: 'resolve'
    });

    $(() => {

    })

    $('.btn-saldo-refresh').on('click', () => {

    })
  </script>
</body>

</html>
