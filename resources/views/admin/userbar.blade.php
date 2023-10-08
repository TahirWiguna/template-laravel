<li class="nav-item dropdown">
  <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <div class="media align-items-center">
      <span>
        @php
          $avatar = null;
          $avatar = $avatar != null ? $avatar : asset('img/default-avatar.png');
        @endphp
        <img class="avatar avatar-sm rounded-circle" style="object-fit: cover" alt="Image placeholder" src="{{ $avatar }}">
      </span>
      <div class="media-body ml-2 d-none d-lg-block">
        <span class="mb-0 text-sm  font-weight-bold">{{ @\App\Helpers\AuthCommon::user()->username }}</span>
      </div>
    </div>
  </a>
  <div class="dropdown-menu dropdown-menu-right">
    <a href="{{ route('setting.profile') }}" class="dropdown-item">
      <i class="fas fa-user-cog"></i>
      <span>Setting</span>
    </a>
    <div class="dropdown-divider"></div>
    <a href="{{ route('auth.logout') }}" class="dropdown-item">
      <i class="fas fa-sign-out-alt"></i>
      <span>Logout</span>
    </a>
  </div>
</li>
