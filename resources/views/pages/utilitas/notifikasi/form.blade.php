<div class="form-group"><label for="title">Title</label><input type="text" name="title" id="title" value="{{ @$data->title }}" class="form-control"></div>
<div class="form-group"><label for="header">Header</label><input type="text" name="header" id="header" class="form-control" value="{{ @$data->header }}"></div>
<div class="form-group"><label for="body">Body Lengkap</label>
  <textarea name="body" id="body" class="form-control">{{ @$data->body }}</textarea>
</div>
<div class="form-group"><label for="image_url">Image Url</label><input type="text" name="image_url" id="image_url" class="form-control" value="{{ @$data->imageUrl }}"></div>
<div id="res_image_url" class="mb-3"></div>

{{-- @if (!$group)
  <div class="form-group">
    <label for="select2-mitra">Pilih Mitra</label>
    <select class="form-control" name="mitra_id" id="select2-mitra">
      @if (@$data->mitraName)
        <option value="{{ $data->mitraName }}" selected>{{ $data->mitraCode }} - {{ $data->mitraName }}</option>
      @endif
    </select>
  </div>
  <input type="hidden" name="mitra_code" id="mitra_code" value="{{ @$data->mitraCode }}">
  <input type="hidden" name="mitra_name" id="mitra_name" value="{{ @$data->mitraName }}">
@endif --}}

<div class="form-group">
  <label for="">Notification Type</label>
  <div class="form-check">
    <input class="form-check-input" type="radio" name="notification_type" id="notification_type_all" value="all">
    <label class="form-check-label" for="notification_type_all">
      All
    </label>
  </div>
  <div class="form-check">
    <input class="form-check-input" type="radio" name="notification_type" id="notification_type_custom" value="custom">
    <label class="form-check-label" for="notification_type_custom">
      Custom
    </label>
  </div>
</div>

<div class="form-group" id="group-custom_type" style="display: none;">
  <label for="">Custom Type</label>
  {{-- <div class="form-check">
    <input class="form-check-input" type="radio" name="custom_type" id="custom_type_bpr" value="bpr">
    <label class="form-check-label" for="custom_type_bpr">
      BPR
    </label>
  </div> --}}
  <div class="form-check">
    <input class="form-check-input" type="radio" name="custom_type" id="custom_type_user" value="user">
    <label class="form-check-label" for="custom_type_user">
      User
    </label>
  </div>
</div>

<div class="form-group" id="group-target_bpr" style="display: none;">
  <label for="select2-target_bpr">Target BPR</label>
  <select id="select2-target_bpr" class="form-control" name="target_bpr[]" multiple disabled>

  </select>
</div>

<div class="form-group" id="group-target_user" style="display: none;">
  <label for="select2-target_user">Target User</label>
  <select id="select2-target_user" class="form-control" name="ids_user[]" multiple>
    @foreach ($target_user as $target)
      <option value="{{ $target->id }}">{{ $target->name }}</option>
    @endforeach
  </select>
</div>

<script type="text/javascript">
  $(() => {
    Ryuna.summernote('[name="body"]');
  })

  $("#select2-target_user").select2()
  var _url_select2 = {}

  var _limit = 10


  var imagePreviewHandle = () => {
    const value = document.querySelector('#image_url').value
    if (value) {
      document.querySelector('#res_image_url').innerHTML = `<img  class="img-fluid" src="${value}" style="height: 100px;">`
    } else {
      document.querySelector('#res_image_url').innerHTML = ''
    }
  }

  $(() => {
    imagePreviewHandle()
    document.querySelector('#image_url').addEventListener('input', function(e) {
      e.preventDefault()

      imagePreviewHandle()
    })

    $("#select2-mitra").on('select2:select', function(e) {
      $('#mitra_code').val(e.params.data.mitraCode)
      $('#mitra_name').val(e.params.data.mitraName)
    })

    $("#select2-branch").on('select2:select', function(e) {
      $('#branch_code').val(e.params.data.code)
      $('#branch_name').val(e.params.data.name)
    })

    $('input[name="notification_type"]').change(function() {
      $('#select2-target_bpr').prop('disabled', true)
      $('#select2-target_bpr').val(null).trigger('change')

      $('#select2-target_user').prop('disabled', true)
      $('#select2-target_user').val(null).trigger('change')

      $('#group-target_user').hide()
      $('#group-target_bpr').hide()

      if ($('#notification_type_custom').is(':checked')) {
        $('#group-custom_type').show()
      } else {
        $('#group-custom_type').hide()

        $('#custom_type_bpr').prop('checked', false)
        $('#custom_type_user').prop('checked', false)
      }
    });

    $('input[name="custom_type"]').change(function() {

      if ($('#custom_type_bpr').is(':checked')) {

        $('#select2-target_user').prop('disabled', true)
        $('#select2-target_user').val(null).trigger('change')
        $('#select2-target_bpr').prop('disabled', false)

        $('#group-target_bpr').show()
        $('#group-target_user').hide()


      } else if ($('#custom_type_user').is(':checked')) {
        $('#select2-target_user').prop('disabled', false)
        $('#select2-target_bpr').prop('disabled', true)
        $('#select2-target_bpr').val(null).trigger('change')

        $('#group-target_bpr').hide()
        $('#group-target_user').show()

      }

    });


  })
</script>
