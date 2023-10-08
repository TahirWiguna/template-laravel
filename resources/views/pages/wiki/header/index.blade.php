@extends('admin.parent')

@section('title', 'Manual Guide')

@section('styles')
<style>
  .avatar{
    object-fit: cover;
  }
</style>
@endsection

@section('breadcrum')
<div class="col-lg-6 col-7">
  <h6 class="h2 text-white d-inline-block mb-0">Manual Guide</h6>
  <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
    <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
      <li class="breadcrumb-item"><a href="#"><i class="fas fa-question"></i></a></li>
      <li class="breadcrumb-item active" aria-current="page">Header</li>
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
        <div class="table-responsive py-4">
          {!! $dataTable->table(['class' => 'table align-items-center table-bordered']) !!}
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('/vendor/datatables/buttons.server-side.js') }}"></script>
{!! $dataTable->scripts() !!}

<script>
  function update(){
    const selected_length = window.LaravelDataTables["wiki-table"].rows('.selected').data().length;
    if(selected_length == 0 && selected_length > 1){ 
      Swal.fire(
        'Please select only one row',
        '',
        'info'
      )
      return false;
    }

    let selected = window.LaravelDataTables["wiki-table"].rows('.selected').data();
    let id = selected[0].id

    window.location.href = "{{ route('wiki_header.edit', ':id') }}".replace(':id', id)
  }

  function destroy(){
    const selected_length = window.LaravelDataTables["wiki-table"].rows('.selected').data().length;
    if(selected_length == 0 && selected_length > 1){ 
      Swal.fire(
        'Please select only one row',
        '',
        'info'
      )
      return false;
    }

    let selected = window.LaravelDataTables["wiki-table"].rows('.selected').data();
    let id = selected[0].id

    Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      type: 'question',
      showCancelButton: true,
      confirmButtonColor: '#dc3545',
      cancelButtonColor: '#007bff',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      console.log(result)
      if (result.value) {
        $.ajax({
          url: "{{ route('wiki_header.destroy', ':id') }}".replace(':id', id),
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: 'DELETE',
          data: {
            id: id
          },
          success: function (response){
            Swal.fire(
              response.message,
              '',
              'info'
            )
            setTimeout(() => {
              //Change to id datatable
              window.LaravelDataTables["wiki-table"].draw()
            }, 500);
          }
        });
      }
    })
  }

  function list(){
    const selected_length = window.LaravelDataTables["wiki-table"].rows('.selected').data().length;
    if(selected_length == 0 && selected_length > 1){ 
      Swal.fire(
        'Please select only one row',
        '',
        'info'
      )
      return false;
    }

    let selected = window.LaravelDataTables["wiki-table"].rows('.selected').data();
    let id = selected[0].id

    window.location.href = "{{ route('wiki_content.index') }}"+'?wiki_header_id='+id
  }
</script>
@endsection
