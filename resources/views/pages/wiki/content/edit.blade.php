@extends('admin.parent')

@section('title', 'Manual Guide')

@section('breadcrum')
<div class="col-lg-6 col-7">
  <h6 class="h2 text-white d-inline-block mb-0">Manual Guide</h6>
  <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
    <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
      <li class="breadcrumb-item"><a href="#"><i class="fas fa-question"></i></a></li>
      <li class="breadcrumb-item"><a href="{{ route('wiki_header.index') }}">Header</a></li>
      <li class="breadcrumb-item"><a href="{{ route('wiki_content.index') }}">Content</a></li>
      <li class="breadcrumb-item active" aria-current="page">Edit</li>
    </ol>
  </nav>
</div>
@endsection

@section('page')
<div class="row">
  <div class="col-xl-12 order-xl-1">
    <div class="card">
      <div class="card-header">
        <div class="row align-items-center">
          <div class="col-12">
            <h3 class="mb-0">Edit Content </h3>
          </div>
        </div>
      </div>
      <div class="card-body">
        @include('admin.alert')
        <form action="{{ route('wiki_content.update', $id) }}" method="POST">
          @csrf
          @method('PUT')
          
          @include('pages.wiki.content.form')            
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
{{-- call summernote from vendor --}}
<script src="{{ asset('assets/vendor/summernote/summernote-bs4.min.js') }}"></script>
{{-- summernote theme --}}
<link rel="stylesheet" href="{{ asset('assets/vendor/summernote/summernote-bs4.css') }}">

<script>
  $(() => {
    $('#editor').summernote({
      placeholder: '',
      tabsize: 2,
      height: 150
    });

    $('#editor').summernote('code', '{!! old('isi', @$data->isi) !!}')
  })
</script>
@endsection