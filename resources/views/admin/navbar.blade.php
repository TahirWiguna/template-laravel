@if(!app("session")->get("is_google_login"))
<div class="alert alert-warning d-flex align-items-center" style="border-radius: 0px;margin-bottom: 0;background-color: #e8b75c;color: #3a3939;" role="alert">
  <i class="fas fa-exclamation-triangle"></i>&nbsp;
  <div>
    Google Drive tidak terhubung! Silahkan hubungkan google drive untuk mengamankan data secara berkala. Klik <a href="{{ route('backup.index')}}">disini</a>.
  </div>
</div>
@endif
<nav class="navbar navbar-top navbar-expand navbar-dark bg-gradient border-bottom">
  
  <div class="container-fluid">
    
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <!-- Search form -->
      <!-- Navbar links -->
      <ul class="navbar-nav align-items-center ml-md-auto">
        <li class="nav-item d-xl-none">
          <!-- Sidenav toggler -->
          <div class="pr-3 sidenav-toggler sidenav-toggler-dark" data-action="sidenav-pin" data-target="#sidenav-main">
            <div class="sidenav-toggler-inner">
              <i class="sidenav-toggler-line"></i>
              <i class="sidenav-toggler-line"></i>
              <i class="sidenav-toggler-line"></i>
            </div>
          </div>
        </li>

        @include('admin.bpr_info')
        <li class="dropdown notifications-menu">
          <a href="#" class="" data-toggle="dropdown" onclick="getNotif()" style="position: relative;display: block;padding: 10px 15px;">
            <i class="fa fa-bell text-white" style="font-size:1.4rem;"></i>
            <span class="label text-white bg-primary" id="notif_count"
              style="position: absolute;top: 5px;right: 7px;text-align: center;font-size: 15px;padding: 2px 3px;line-height: .9;border-radius:50%;">0</span>
          </a>
        </li>
      </ul>
      <ul class="navbar-nav align-items-center ml-auto ml-md-0">
        @include('admin.userbar')
      </ul>
    </div>
  </div>
</nav>
