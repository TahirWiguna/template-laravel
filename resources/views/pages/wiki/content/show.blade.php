@extends('admin.parent')

@section('title', 'Manual Guide')

@section('breadcrum')
<div class="col-lg-6 col-7">
  <h6 class="h2 text-white d-inline-block mb-0">Manual Guide</h6>
  <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
    <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
      <li class="breadcrumb-item"><a href="#"><i class="fas fa-question"></i></a></li>
      <li class="breadcrumb-item"><a href="{{ route('wiki_header.index') }}">Header</a></li>
      <li class="breadcrumb-item"><a href="{{ route('wiki_content.index').'?wiki_header_id='.$wiki->wiki_header_id}}">Content</a></li>
      <li class="breadcrumb-item active" aria-current="page">Show</li>
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
          <div class="col-9">
            <h3 class="mb-0">{{ $wiki->judul }}</h3>
          </div>
          <div class="col-3 text-right">
            <span class="badge badge-pill badge-primary"><i class="fas fa-tag"></i> {{ $wiki->slug }}</span>
            <a href="{{ route('wiki_content.pdf', $wiki->id) }}" class="btn btn-danger btn-sm"><i class="fas fa-file-pdf"></i> Download</a>
          </div>
        </div>
      </div>
      <div class="card-body">
        {!! $wiki->isi !!}
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
{{-- <script src="{{ asset('/vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script> --}}
<script>
  // $('#lfm').filemanager('image');
</script>
@endsection