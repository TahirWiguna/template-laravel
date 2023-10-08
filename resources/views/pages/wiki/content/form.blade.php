<input type="hidden" name="wiki_header_id" value="{{ isset($wiki_header_id) ? $wiki_header_id: @$data->wiki_header_id }}">

<div class="form-group">
  <label>Slug</label>
  <input type="text" name="slug" class="form-control" placeholder="Slug" value="{{ old('slug', @$data->slug) }}">
  @if($errors->has('slug'))
    <span class="text-danger text-sm">{{ $errors->first('slug') }}</span>
  @endif
</div>

<div class="form-group">
  <label>Judul</label>
  <input type="text" name="judul" class="form-control" placeholder="Judul" value="{{ old('judul', @$data->judul) }}">
  @if($errors->has('judul'))
    <span class="text-danger text-sm">{{ $errors->first('judul') }}</span>
  @endif
</div>

<div class="form-group">
  <label>Isi</label>
  <textarea name="isi" class="form-control" placeholder="Isi" id="editor"></textarea>
  @if($errors->has('isi'))
    <span class="text-danger text-sm">{{ $errors->first('isi') }}</span>
  @endif
</div>

<div class="form-group">
  <button id="btn-save" type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
  <a href="{{ route('wiki_content.index').'?wiki_header_id='.@$data->wiki_header_id}}" class="btn btn-light"><i class="fas fa-arrow-left"></i> Back</a>
</div>  