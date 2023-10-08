@php
  $auth = \App\Helpers\AuthCommon::user();
@endphp

<li class="nav-item">
  <div class="box-saldo mr-4">
    <div class="text-bold text-white" style="text-transform: uppercase">
      {{ @$auth->bpr->name }}
      @if (@$auth->bpr_branch)
        <small>({{ @$auth->bpr_branch->name }})</small>
      @endif
    </div>
  </div>
</li>
