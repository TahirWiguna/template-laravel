@extends('admin.parent')

@section('title', 'Setting Key')

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
                <a class="nav-link active" aria-current="page" href="{{ route('key.index')}}"><i class="fas fa-key"></i> Atur Chiper Key</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('backup.index')}}"><i class="fab fa-google"></i>  Pindahkan Data Ke Google Drive</a>
            </li>
          </ul>
          <br>

          @include('admin.alert')

          <form id="myForm" class="form-inline">
            <div class="form-group">
              <label for="cipher_key">Cipher Key</label>
              <input type="password" class="form-control" id="cipher_key" name="cipher_key" placeholder="Masukan cipher key">
            </div>
            <div class="form-group">
              <label for="cipher_key_confirm">Cipher Key Confirm</label>
              <input type="password" class="form-control" id="cipher_key_confirm" name="cipher_key_confirm"
                placeholder="Konfirmasi cipher key">
            </div>
            <div class="form-group">
              <label for="">&nbsp;</label>
              <button type="button" class="btn btn-primary" onclick="cipher_key_save()">Save</button>
            </div>
          </form>
          <div id="response-submit" style="margin-top:20px;"></div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')

  <script>
    function cipher_key_save() {
      key = $('#cipher_key').val();
      key_confirm = $('#cipher_key_confirm').val();

      if (key == '') {
        alert('Please enter cipher key');
        return;
      }

      if (key != key_confirm) {
        alert('key does not match');
        return;
      }

      if (key.length < 16) {
        alert('key must be at least 16 characters');
        return;
      }

      old_key = localStorage.getItem('x');
      if (old_key && !confirm("You already have a key setted. Do you want to change it?")) {
        return;
      }


      let formData = new FormData($('#myForm')[0])

      Ryuna.blockElement('#card_form')
      $.ajax({
        url: "{{ route('slik.encrypt_key') }}",
        data: formData,
        processData: false,
        contentType: false,
        type: 'POST',
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
  </script>
@endsection
