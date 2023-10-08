@extends('admin.parent')

@section('title', 'Dashboard')

@section('styles')
  <link rel="stylesheet" href="{{ asset('css/apexcharts/apexcharts.css') }}">
  <style>
    #chart_pengajuan_today tspan {
      text-transform: uppercase;
    }

    #box_ao:hover {
      cursor: pointer;
      background-color: #f1f1f1;
    }

    #chart_pengajuan_today .apexcharts-legend-series {
      font-size: 12px;
      /* Adjust the font size to make it smaller */
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
      max-width: 200px;
      /* Adjust the maximum width as needed */
    }
  </style>
@endsection

@section('breadcrum')
  <div class="col-lg-6 col-7">
    <h6 class="h2 text-white d-inline-block mb-0">Dashboard</h6>
    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
      <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
        <li class="breadcrumb-item"><a href="#"><i class="ni ni-tv-2"></i></a></li>
      </ol>
    </nav>
  </div>
@endsection

@section('page')
  <div class="row">
    <div class="col-xl-12 order-xl-1">
      <div class="card">
        <div class="card-header">
          <div class="row align-items-center">
            <div class="col-12">
              <h3 class="mb-0">Dashboard</h3>
            </div>
          </div>
        </div>
        <div class="card-body">
          {{-- @if ($perm['chart'])
            
          @else --}}
            <div class="box bg-info">
              <p>Selamat datang di aplikasi <b>Verlos</b></p>
            </div>
          {{-- @endif --}}
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script src="https://www.gstatic.com/firebasejs/8.3.2/firebase.js"></script>
  <script>
    // Your web app's Firebase configuration
    const firebaseConfig = {
      apiKey: "AIzaSyBC_a9vd6FsDZ9ilgq4NwnLOsLB9M-3xOk",
      authDomain: "slikreader.firebaseapp.com",
      databaseURL: "https://slikreader-default-rtdb.firebaseio.com",
      projectId: "slikreader",
      storageBucket: "slikreader.appspot.com",
      messagingSenderId: "326056442281",
      appId: "1:326056442281:web:95a9057a0fe01fb3a76cb8"
    };

    // Initialize Firebase
    firebase.initializeApp(firebaseConfig);
    var messaging = firebase.messaging();

    function initFirebaseMessagingRegistration() {
      messaging
        .requestPermission()
        .then(function() {
          return messaging.getToken()
        })
        .then(function(token) {

          $.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
          });
          $.ajax({
            url: "{{ route('dashboard.save_token') }}",
            type: 'POST',
            data: {
              token: token
            },
            dataType: 'JSON',
            success: function(response) {
              console.log(response.status)
            },
            error: function(err) {
              console.log('User Chat Token Error' + err);
            },
          });

        }).catch(function(err) {
          console.log('User Chat Token Error' + err);
        });
    }

    messaging.onMessage(function(payload) {
      const noteTitle = payload.notification.title;
      const noteOptions = {
        body: payload.notification.body,
        icon: payload.notification.icon,
        url: payload.notification.url
      };
      new Notification(noteTitle, noteOptions);
    });
  </script>
  <script>
    @if (session('initFCM'))
      initFirebaseMessagingRegistration()
      console.log('initialize firebase regist')
    @endif
  </script>
  <script src="{{ asset('js/apexcharts/apexcharts.js') }}"></script>
  <script>
    
  </script>

@endsection
