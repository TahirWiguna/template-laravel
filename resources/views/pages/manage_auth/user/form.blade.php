<div class="form-group">
  <label>* Name</label>
  <input type="text" name="name" class="form-control" placeholder="Name" value="{{ @$data->name }}">
</div>
<div class="form-group">
  <label>* Email</label>
  <input type="email" name="email" class="form-control" placeholder="Email" value="{{ @$data->email }}">
</div>
<div class="form-group">
  <label>Phone Number</label>
  <input type="phone_number" name="phone_number" class="form-control" placeholder="Phone number" value="{{ @$data->phone_number }}">
</div>
<div class="form-group">
  <label>Whatsapp Number</label>
  <input type="whatsapp" name="whatsapp" class="form-control" placeholder="Whatsapp number" value="{{ @$data->whatsapp }}">
</div>
<div class="form-group">
  <label>Telegram Number</label>
  <input type="telegram" name="telegram" class="form-control" placeholder="Telegram number" value="{{ @$data->telegram }}">
</div>
@if ($allow['is_adminroot'])
  <div class="form-group">
    <label>* BPR</label>
    <select name="bpr_id" id="bpr_id" class="form-control select2">
      <option value="">-- Choose One --</option>
      @foreach ($bpr as $b)
        <option value="{{ $b->id }}" {{ @$data->bpr_id == $b->id ? 'selected' : '' }}>{{ $b->name }}</option>
      @endforeach
    </select>
  </div>
  <div class="form-group">
    <label>BPR Cabang</label>
    <select name="bpr_branch_id" id="bpr_branch_id" class="form-control select2" {{ isset($edit) ? '' : 'disabled' }}>
      <option value="">-- Choose One --</option>
      {{-- @foreach ($bpr_branch as $b)
        <option value="{{ $b->id }}" {{ @$data->bpr_id == $b->id ? 'selected' : '' }}>{{ $b->name }}</option>
      @endforeach --}}
      @if (isset($edit))
        <option value="{{ $current_branch->id }}" selected>{{ $current_branch->name }}</option>
      @endif
    </select>
  </div>
  <div class="form-group">
    <label>* Role</label>
    <select name="role_id" id="role_id" class="form-control select2">
      <option value="">-- Choose One --</option>
      @foreach ($role as $r)
        <option value="{{ $r->id }}" {{ @$data->role_id == $r->id ? 'selected' : '' }}>{{ $r->name }}</option>
      @endforeach
    </select>
  </div>
@endif
@if (!isset($edit))
  <div class="form-group">
    <label>* Username</label>
    <input type="text" name="username" class="form-control" placeholder="Username" value="{{ @$data->username }}">
  </div>
  <div class="form-group">
    <label>* Password</label>
    <input type="password" name="password" class="form-control" placeholder="Password" value="{{ @$data->password }}">
  </div>
@endif

<script>
  $(".select2").select2();

  var urlSelect2 = {
    bpr_branch: `{{ route('bpr.select2_branch') }}`,
  }

  var _limit = 10

  function formatResult(res) {
    if (res.loading) {
      return res.text;
    }

    console.log(res)

    var $container = $(
      "<div class='select2-result-repository clearfix'>" +
      "<div class='select2-result-repository__avatar'><img src='" + base_url + 'img/office.png' + "'/></div>" +
      "<div class='select2-result-repository__meta'>" +
      "<div class='select2-result-repository__title'></div>" +
      "<div class='select2-result-repository__description'></div>" +
      "<div class='select2-result-repository__statistics'>" +
      "<div class='select2-result-repository__forks'><i class='far fa-circle'></i> </div>" +
      "</div>" +
      "</div>" +
      "</div>"
    );

    $container.find(".select2-result-repository__title").text(res.name);
    // $container.find(".select2-result-repository__description").text(res.cabang);
    // $container.find(".select2-result-repository__forks").append(res.kota || '-');

    return $container
  }

  function formatSelection(res) {

    return res.name;
  }

  function initSelect2() {
    $(`#bpr_branch_id`).select2({
      allowClear: true,
      ajax: {
        url: urlSelect2.bpr_branch,
        dataType: 'json',
        delay: 1000,
        data: function(params) {
          return {
            term: params.term,
            page: params.page || 0,
            limit: _limit,
            bpr_id: $("#bpr_id").val()
          };
        },
        processResults: function(data, params) {
          params.page = params.page || 0;
          let check = params.page + 1;
          return {
            results: data.items.map(function(item) {
              return {
                ...item,
                id: item.id,
                text: item.name
              };
            }),
            pagination: {
              more: (data.total - (check * _limit)) > 0
            }
          };
        },
        cache: true
      },
      placeholder: 'Pilih Salah Satu',
    });
  }

  $(() => {
    $("#bpr_id").on("change", function() {
      let val = $(this).val()
      let $branch = $("#bpr_branch_id")
      if (val) {
        $branch.attr("disabled", false)
        $branch.empty()

        initSelect2()

      } else {
        $branch.attr("disabled", true)
        $branch.empty()
      }
    })

    @if (isset($edit))
      initSelect2()
    @endif
  })
</script>
