<div class="form-group">
  <label>Versi</label>
  <input type="text" name="versi" class="form-control" placeholder="Versi" value="{{ old('versi', @$data->versi) }}">
  @if($errors->has('versi'))
    <span class="text-danger text-sm">{{ $errors->first('versi') }}</span>
  @endif
</div>
<div class="form-group">
  <label>Keterangan</label>
  <textarea type="text" name="keterangan" class="form-control" placeholder="Keterangan">{{ old('keterangan', @$data->keterangan) }}</textarea>
  @if($errors->has('keterangan'))
    <span class="text-danger text-sm">{{ $errors->first('keterangan') }}</span>
  @endif
</div>
<div class="form-group">
  <button id="btn-save" type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
  <a href="{{ route('wiki_header.index') }}" class="btn btn-light"><i class="fas fa-arrow-left"></i> Back</a>
</div>  