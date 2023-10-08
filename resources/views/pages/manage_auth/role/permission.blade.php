@extends('admin.parent')

@section('title', 'Permission')

@section('styles')
<style>
  .avatar{
    object-fit: cover;
  }
</style>
@endsection

@section('breadcrum')
<div class="col-lg-6 col-7">
  <h6 class="h2 text-white d-inline-block mb-0">Web Users</h6>
  <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
    <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
      <li class="breadcrumb-item"><a href="#"><i class="ni ni-key-25"></i></a></li>
      <li class="breadcrumb-item" aria-current="page"><a href="{{ route('role.index') }}">Manage User Group</a></li>
      <li class="breadcrumb-item active" aria-current="page">Manage Permission</li>
    </ol>
  </nav>
</div>
@endsection

@section('page')
<div class="row">
  <div class="col-xl-12 order-xl-1">
    <div class="card">
      <div class="card-header border-0">
        <div class="row align-items-center">
          <div class="col">
            <h3 class="mb-0">{{ $role->name }}</h3>
          </div>
        </div>
      </div>
      <div class="card-body">
        <form action="{{ route('role.update_permission', $role->id) }}" method="POST" id="myForm">
          <input type="hidden" name="name" value="{{ $role->name }}">
          @csrf
          @method('PUT')        
          <div class="table-responsive">
            <table class="table align-items-center table-flush">
              <thead class="thead-light">
                <tr>
                  <th>Module</th>
                  <th>Permission</th>
                  <th>Allow</th>
                </tr>
              </thead>
              <tbody> 
                @foreach ($grouped_perm as $key => $item)
                  <tr>
                    <th colspan="3"><i class="ni ni-app"></i> {{$key}}</th>
                  </tr>
                  @foreach ($item as $nested)
                    <tr>
                      <td></td>
                      <td><i class="fas fa-cog"></i> {{ $nested->name }}</td>
                      <td><input type="checkbox" name="permission[]" value="{{ $nested->id }}" {{ $nested->checked ? 'checked': ''}}></td>
                    </tr>
                  @endforeach
                @endforeach
              </tbody>
            </table>
          </div>
        </form>
      </div>
      <div class="card-footer border-0">
        <div class="row">
          <div class="col-md-12">
            <div id="response_container"></div>
          </div>
          <div class="col-md-12">
            <div class="float-right">
              <a href="{{ route('role.index') }}" class="btn btn-secondary">Back</a>
              <button type="button" class="btn btn-primary" onclick="save()">Save</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')

<script>
  function save(){
    Ryuna.blockUI()
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
      if(res?.status == true){
        let html = '<div class="alert alert-success alert-dismissible fade show">'
        html += `${res?.message}`
        html += '</div>'
        Ryuna.noty('success', '', res?.message)
        $('#response_container').html(html)
        Ryuna.unblockElement('.modal-content')
        
        if($('[name="_method"]').val() == undefined) el_form[0].reset()
      }
      Ryuna.unblockUI()
    }).fail((xhr) => {
      if(xhr?.status == 422){
        let errors = xhr.responseJSON.errors
        let html = '<div class="alert alert-danger alert-dismissible fade show">'
        html += '<ul>';
        for(let key in errors){
          html += `<li>${errors[key]}</li>`;
        }
        html += '</ul>'
        html += '</div>'
        $('#response_container').html(html)
        Ryuna.unblockElement('.modal-content')
      }else{
        let html = '<div class="alert alert-danger alert-dismissible fade show">'
        html += `${xhr?.responseJSON?.message}`
        html += '</div>'
        Ryuna.noty('error', '', xhr?.responseJSON?.message)
        $('#response_container').html(html)
        Ryuna.unblockElement('.modal-content')
      }
      Ryuna.unblockUI()
    })
  }
</script>
@endsection