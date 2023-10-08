<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Aplikasi Analisa Slik Calon Debitur">
  <meta name="author" content="Creative Tim">
  <title>Verlos</title>
  <!-- Favicon -->
  <link rel="icon" href="{{ asset('assets/img/brand/favicon.png') }}" type="image/png">
  <!-- Fonts -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
  <!-- Icons -->
  <link rel="stylesheet" href="{{ asset('assets/vendor/nucleo/css/nucleo.css') }}" type="text/css">
  <link rel="stylesheet" href="{{ asset('assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}" type="text/css">
  <!-- Argon CSS -->
  <link rel="stylesheet" href="{{ asset('assets/css/argon.css?v=1.1.0') }}" type="text/css">
  <link rel="stylesheet" href="{{ asset('assets/css/custom.css?v=1.1.0') }}" type="text/css">
  {{-- google recaptcha v2 --}}
  <script src='https://www.google.com/recaptcha/api.js'></script>
  {{-- google font --}}
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Lexend+Deca&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Lexend Deca', sans-serif !important;
    }

    .bg-radial {
      /* background: radial-gradient(circle, rgba(255, 255, 255, 0.5) 0%, rgba(255, 255, 255, 0.5) 100%) */
      background: radial-gradient(#3a3838, #111111);
      /* box-shadow: inset -5px 0px 5px #ddd; */
    }

    .desc {
      display: flex;
      align-items: center;
      justify-content: center;
      flex-direction: column;
      font-family: Arial;
    }
  </style>
</head>

<body class="bg-secondary">
  <!-- Main content -->
  <div class="main-content" style="height: 100vh">
    <!-- Page content -->
    <div class="container-fluid p-0" style="padding:0!important;">
      <div class="row no-gutters">
        <div class="d-none d-lg-block col-lg-8 bg-radial" style="height: 100vh;">
          <div style="width:100%;height:100%;display:flex !important;justify-content:center;align-items:center;flex-direction:column">
            <img src="{{ asset('img/login_illu.png') }}" alt="illu img" style="max-width:400px;margin:30px;margin-top:-50px;">
            <div class="desc">
              {{-- <h1 style="max-width:600px" class="text-center text-primary"><b>SLIK BOOSTER</b></h1> --}}
              {{-- <img src="{{ asset('img/logo.png') }}" alt="logo-login" style="width: 100%;max-width: 200px;" class="mb-2"> --}}
              <h2 style="max-width:600px" class="text-center text-white">Aplikasi Analisa Slik calon debitur.</h2>
              <h3 style="max-width:600px" class="text-center text-white">Proses verifikasi calon debitur jadi lebih Cepat, Tepat, dan Aman</h3>

            </div>

          </div>
        </div>
        <div class="col-lg-4" style="height: 100vh;width:100%;overflow:auto;display:flex;padding:30px;background-color:#363535;">
          <div class="container" style="display:flex;justify-content: center;align-items:center">
            <div class="row justify-content-center">
              <div class="card bg-secondary border-0 mb-0">
                <div class="card-body px-lg-5 py-lg-5">
                  <div class="text-center">
                    <img src="{{ asset('img/logo.png') }}" class="navbar-brand-img" alt="logo_company" style="margin-left:0px">
                  </div>
                  <div class="text-center text-muted mb-4">
                  </div>
                  @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                      {{ session('error') }}
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                  @endif
                  @error('login_failed')
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                      <span class="alert-inner--text"><strong>Warning!</strong> {{ $message }}</span>
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                  @enderror
                  <form role="form" method="post" action="{{ route('auth.login_process') }}">
                    {{ csrf_field() }}
                    <div class="form-group mb-3">
                      <div class="input-group input-group-merge input-group-alternative">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="ni ni-circle-08"></i></span>
                        </div>
                        <input class="form-control" name="username" placeholder="Username" type="text">
                      </div>
                      @if ($errors->has('username'))
                        <span class="text-danger text-sm">{{ $errors->first('username') }}</span>
                      @endif
                    </div>
                    <div class="form-group">
                      <div class="input-group input-group-merge input-group-alternative">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                        </div>
                        <input class="form-control" name="password" placeholder="Password" type="password">
                      </div>
                      @if ($errors->has('password'))
                        <span class="text-danger text-sm">{{ $errors->first('password') }}</span>
                      @endif
                    </div>
                    @if (env('RECAPTCHA'))
                      <div class="form-group">
                        <div class="g-recaptcha" data-sitekey="{{ env('GOOGLE_RECAPTCHA_KEY') }}"></div>
                        @if ($errors->has('g-recaptcha-response'))
                          <span class="text-danger text-sm">{{ $errors->first('g-recaptcha-response') }}</span>
                        @endif
                      </div>
                    @endif
                    <div class="text-center">
                      <button type="submit" class="btn btn-block btn-primary bg-purple2 my-4">MASUK</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Footer -->
  {{-- <footer class="py-5" id="footer-main">
    <div class="container">
      <div class="row align-items-center justify-content-xl-between">
        <div class="col-xl-6">
        <div class="copyright text-center text-lg-left text-muted">
          &copy; {{ date('Y') }} <a href="#" class="font-weight-bold ml-1" target="_blank"> PT Digital Amore Kriyanesia</a>
        </div>
        </div>
        <div class="col-xl-6">
          <div class="copyright text-center text-lg-right text-muted">
            Core Banking System v 0.0.1
          </div>
        </div>
      </div>
    </div>
  </footer> --}}
  <!-- Argon Scripts -->
  <!-- Core -->
  <script src="{{ asset('assets/vendor/jquery/dist/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/js-cookie/js.cookie.js') }}"></script>
  <script src="{{ asset('assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js') }}"></script>
  <!-- Argon JS -->
  <script src="{{ asset('assets/js/argon.js?v=1.1.0') }}"></script>
  <!-- Demo JS - remove this in your project -->
  {{-- <script src="{{ asset('assets/js/demo.min.js') }}"></script> --}}
</body>

</html>
