@extends('admin.parent')

@section('title', 'Setting')

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
                    <a class="nav-link active" aria-current="page" href="{{ route('setting.change_password')}}"><i class="fas fa-user-lock"></i> Ganti Password</a>
                </li>
            </ul>
            <br>
            @include('admin.alert')

            <form action="{{ route('setting.do_change_password') }}" id="myForm">
              @csrf
              @method('POST')
              
              <input type="hidden" name="username" value="{{ $user->username }}">

              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="old_password">Password Lama</label>
                    <input type="password" class="form-control" id="old_password" name="old_password" placeholder="Masukan password lama">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="password">Password Baru</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Masukan password baru">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Password Baru</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                      placeholder="Konfirmasi password baru">
                  </div>
                </div>
              </div>
             
              <div class="form-group">
                <label for="">&nbsp;</label>
                <button type="button" class="btn btn-primary" onclick="save()">Update</button>
              </div>
            </form>
            <br>
            <div id="response_container"></div>
          
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script>
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
  </script>
@endsection
