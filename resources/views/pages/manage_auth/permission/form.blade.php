<input type="hidden" name="module_id" value="{{ @$module_id }}">

<div class="form-group">
  <label>Slug</label>
  <input type="text" name="slug" class="form-control" placeholder="Slug" value="{{ @$data->slug }}">
</div>

<div class="form-group">
  <label>Permission</label>
  <input type="text" name="name" class="form-control" placeholder="Permission" value="{{ @$data->name }}">
</div>

<div class="form-group">
  <label>Deskripsi</label>
  <textarea name="description" class="form-control">{{ @$data->description }}</textarea>
</div>

<div class="form-group">
  <label>Module</label>
  <input type="text" name="module" class="form-control" placeholder="Module" value="{{ @$data->module }}">
</div>

<script>
</script>