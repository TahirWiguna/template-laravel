<nav class="sidenav navbar navbar-vertical fixed-left navbar-expand-xs navbar-light bg-white" id="sidenav-main">

  <div class="scrollbar-inner">
    <!-- Brand -->
    <div class="sidenav-header d-flex align-items-center">
      <a class="navbar-brand" style="flex-grow:2;">
        <img src="{{ asset('img/logo.png') }}" class="navbar-brand-img" alt="..." style="width:100%;object-fit:contain;margin:0;">
      </a>
      <div class="ml-auto">
        <!-- Sidenav toggler -->
        <div class="sidenav-toggler d-none d-xl-block" data-action="sidenav-unpin" data-target="#sidenav-main">
          <div class="sidenav-toggler-inner">
            <i class="sidenav-toggler-line">

            </i>
            <i class="sidenav-toggler-line"></i>
            <i class="sidenav-toggler-line"></i>
          </div>
        </div>
      </div>
    </div>
    <div class="navbar-inner">
      @php
        use App\Helpers\Menu;
        use App\Helpers\AuthCommon;
        $menu = '';
        $permission = session('slug_permit');
        $user = AuthCommon::user();
        
        $obj_menu = new Menu();
        $obj_menu->setPermission($permission);
        
        $obj_menu
            ->init()
            ->start_group()
            ->item('Dashboard', 'ni ni-tv-2', 'admin/dashboard', Request::is('admin/dashboard'), 'dashboard.dashboard')
            ->end_group();
        
        $obj_menu
            // ->divinder('User Management', ['user.read', 'role_list'])
            ->start_group()
            ->item('User', 'fas fa-user', 'admin/manage_auth/user', Request::is('admin/manage/user'), 'user.read')
            ->end_group();
        
        $obj_menu
            ->divinder('Administrator', ['role.read', 'chat.read'])
            ->start_group()
            ->item('Role', 'fas fa-user-shield', 'admin/manage_auth/role', Request::is('admin/manage_auth/role'), 'role.read')
            ->item('Live Support', 'far fa-comments', 'admin/utilitas/chat', Request::is('admin/report/chat'), 'chat.read')
            ->item('Laporan Penggunaan', 'far fa-file', 'admin/report/penggunaan', Request::is('admin/report/penggunaan'), 'chat.read')
            ->end_group();
        
        $menu = $obj_menu->to_html();
        
      @endphp
      {!! $menu !!}
    </div>
  </div>
</nav>
