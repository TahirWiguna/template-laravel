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
                    <a class="nav-link active" aria-current="page" href="{{ route('setting.profile')}}"><i class="fas fa-user"></i> Profil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('setting.change_password')}}"><i class="fas fa-user-lock"></i> Ganti Password</a>
                </li>
            </ul>
            <br>

            <form action="{{ route('user.update', $user->id) }}" id="myForm">
              @csrf
              @method('PUT')
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>* Name</label>
                    <input type="text" name="name" class="form-control" placeholder="Name" value="{{ @$user->name }}">
                  </div>
                  <div class="form-group">
                    <label>* Email</label>
                    <input type="email" name="email" class="form-control" placeholder="Email" value="{{ @$user->email }}">
                  </div>
                  <div class="form-group">
                    <label>Phone Number</label>
                    <input type="phone_number" name="phone_number" class="form-control" placeholder="Phone number" value="{{ @$user->phone_number }}">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Whatsapp Number</label>
                    <input type="whatsapp" name="whatsapp" class="form-control" placeholder="Whatsapp number" value="{{ @$user->whatsapp }}">
                  </div>
                  <div class="form-group">
                    <label>Telegram Number</label>
                    <input type="telegram" name="telegram" class="form-control" placeholder="Telegram number" value="{{ @$user->telegram }}">
                  </div>
                </div>
              </div>
             
             
              <button type="button" class="btn btn-primary" onclick="save()">Update</button>
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
