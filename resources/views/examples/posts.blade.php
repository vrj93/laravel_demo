<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <title>
    {{__('title.user_dashboard')}}
  </title>
  <!--     Fonts and icons     -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,600,700,800" rel="stylesheet" />
  <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
  <!-- Nucleo Icons -->
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link href="../assets/css/black-dashboard.css?v=1.0.0" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="../assets/demo/demo.css" rel="stylesheet" />
</head>

<body class="">
  <div class="wrapper">
    <div class="sidebar">
      <!--
        Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red"
    -->
      <div class="sidebar-wrapper">
        <div class="logo">
          <a href="javascript:void(0)" style="text-align: center" class="simple-text logo-normal">
            Menu
          </a>
        </div>
        <ul class="nav">
          <li class={{ (request()->segment(1) == 'dashboard') ? "active":"" }}>
            <a href={{ route('dashboard') }}>
              <i class="tim-icons icon-chart-pie-36"></i>
              <p>User Profile</p>
            </a>
          </li>

          <li class={{ (request()->segment(1) == 'posts') ? "active":"" }}>
            <a href={{ route('posts') }}>
              <i class="tim-icons icon-single-02"></i>
              <p>My Posts</p>
            </a>
          </li>
        </ul>
      </div>
    </div>
    <div class="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-absolute navbar-transparent">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <div class="navbar-toggle d-inline">
              <button type="button" class="navbar-toggler">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
              </button>
            </div>
            <a class="navbar-brand" href="javascript:void(0)">{{__('title.user_dashboard')}}</a>
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
          </button>
          <div class="collapse navbar-collapse" id="navigation">
            <ul class="navbar-nav ml-auto">
              <li class="dropdown nav-item">
                <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                  <div class="photo">
                    <img src="../assets/img/anime3.png" alt="Profile Photo">
                  </div>
                  <b class="caret d-none d-lg-block d-xl-block"></b>
                  <p class="d-lg-none">
                    <b>Log out</b>
                  </p>
                </a>
                <ul class="dropdown-menu dropdown-navbar">
                  <li class="nav-link"><a href="javascript:void(0)" class="nav-item dropdown-item">Profile</a></li>
                  <li class="dropdown-divider"></li>
                  <li class="nav-link">
                      <a href="{{ route('logout') }}" class="nav-item dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Log out
                      </a>

                      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                      </form>
                  </li>
                </ul>
              </li>
              <li class="separator d-lg-none"></li>
            </ul>
          </div>
        </div>
      </nav>
      <div class="modal modal-search fade" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="searchModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <input type="text" class="form-control" id="inlineFormInputGroup" placeholder="SEARCH">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <i class="tim-icons icon-simple-remove"></i>
              </button>
            </div>
          </div>
        </div>
      </div>
      <!-- End Navbar -->
      <div class="content">
        <div class="row">
          <div class="col-12">
            <div class="card card-chart">
              <div class="card-body">
                <div class="chart-area" style="height:auto">
                    <section class="ftco-section">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-6 mb-5 mt-3">
                                    <h2 class="heading-section mt-10"><b>{{ __('title.posts') }}</b></h2>
                                </div>
                                <div class="col-md-6 mb-5 mt-3">
                                    <a href="" class="btn" name="btnAddMore" data-toggle="modal" data-target="#modalContactForm" style="float: right; margin-right:20%;">Create Post</a>
                                </div>
                            </div>
                            @if(!$posts->isEmpty())
                                @foreach($posts as $post)
                                    <div class="row" style="width:60%; margin-bottom:3%; border:1px solid #BF40BF;">
                                        <div class="col-md-12">
                                            <div class="table-wrap">
                                                <div style="float:left; width:50%">
                                                    <h4 style="color: #BF40BF; margin-top:10px"><b>{{ $post->title }}</b></h4>
                                                    <p style="margin-bottom: 10px">{{ $post->post }}</p>
                                                </div>
                                                <div class="container" style="float:right; width:50%; margin-top:20px">
                                                    <ul class="list-inline" style="float:right">
                                                        <a href="" data-toggle="modal" data-target="#modalContactForm_edit" onclick="Edit({{$post->id}}, '{{$post->title}}', '{{$post->post}}')"><li style="margin-bottom:5px; color:#00ff00"><i class="fas fa-pencil-alt"></i></li></a>
                                                        <form action="{{ route('delete-post', [$post->id]) }}" method="post">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button style="background-color: transparent; border:none;" onclick="return confirm('Are you sure you want to remove this post?');"><li><i class="fas fa-trash-alt" style="color: red"></i></li>
                                                            </button>
                                                        </form>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-wrap">
                                            <h4>No Post found</h4>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </section>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="fixed-plugin">
    <div class="dropdown show-dropdown">
      <a href="#" data-toggle="dropdown">
        <i class="fa fa-cog fa-2x"> </i>
      </a>
      <ul class="dropdown-menu">
        <li class="header-title"> Sidebar Background</li>
        <li class="adjustments-line">
          <a href="javascript:void(0)" class="switch-trigger background-color">
            <div class="badge-colors text-center">
              <span class="badge filter badge-primary active" data-color="primary"></span>
              <span class="badge filter badge-info" data-color="blue"></span>
              <span class="badge filter badge-success" data-color="green"></span>
            </div>
            <div class="clearfix"></div>
          </a>
        </li>
        <li class="adjustments-line text-center color-change">
          <span class="color-label">LIGHT MODE</span>
          <span class="badge light-badge mr-2"></span>
          <span class="badge dark-badge ml-2"></span>
          <span class="color-label">DARK MODE</span>
        </li>
      </ul>
    </div>
  </div>

  {{-- Create post model --}}
  <div class="modal fade" id="modalContactForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="POST" id="form_post" action="{{ route('create-post') }}">
            @csrf
            <input type="hidden" name="user_id" value="{{ $user->id }}">
            <div class="modal-content" style="background-color: #202020">
                <div class="modal-header text-center">
                <h4 class="modal-title w-100 font-weight-bold" style="color: #BF40BF;">Create Post</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body mx-3">
                    <div class="md-form mb-3">
                        <h4 data-error="wrong" data-success="right" for="form34">Title</h4>
                        <input type="text" name="title" id="title" value="" class="form-control validate">
                    </div>
                    <div class="md-form mb-3">
                        <textarea name="post" id="post" cols="30" rows="30" class="form-control validate"></textarea>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button class="btn btn-unique" id="submit_post">Post</button>
                </div>
            </div>
        </form>
    </div>
  </div>

  {{-- Edit post model --}}
  <div class="modal fade" id="modalContactForm_edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="POST" id="form_post_edit" action="{{ route('edit-post') }}">
            @csrf
            <input type="hidden" name="post_id" id="post_id" value="">
            <div class="modal-content" style="background-color: #202020">
                <div class="modal-header text-center">
                <h4 class="modal-title w-100 font-weight-bold" style="color: #BF40BF;">Edit Post</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body mx-3">
                    <div class="md-form mb-3">
                        <h4 data-error="wrong" data-success="right" for="form34">Title</h4>
                        <input type="text" name="title_e" id="title_e" value="" class="form-control validate">
                    </div>
                    <div class="md-form mb-3">
                        <textarea name="post_e" id="post_e" cols="30" rows="30" class="form-control validate"></textarea>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button class="btn btn-unique" id="submit_post_e">Edit Post</button>
                </div>
            </div>
        </form>
    </div>
  </div>

  <!--   Core JS Files   -->
  <script src="../assets/js/core/jquery.min.js"></script>
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <!--  Google Maps Plugin    -->
  <!-- Place this tag in your head or just before your close body tag. -->

  <!-- Chart JS -->
  <script src="../assets/js/plugins/chartjs.min.js"></script>
  <!--  Notifications Plugin    -->
  <script src="../assets/js/plugins/bootstrap-notify.js"></script>
  <!-- Control Center for Black Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../assets/js/black-dashboard.min.js?v=1.0.0"></script><!-- Black Dashboard DEMO methods, don't include it in your project! -->
  <script src="../assets/demo/demo.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/additional-methods.js"></script>

  <script>
    $(document).ready(function() {
      $().ready(function() {
        $sidebar = $('.sidebar');
        $navbar = $('.navbar');
        $main_panel = $('.main-panel');

        $full_page = $('.full-page');

        $sidebar_responsive = $('body > .navbar-collapse');
        sidebar_mini_active = true;
        white_color = false;

        window_width = $(window).width();

        fixed_plugin_open = $('.sidebar .sidebar-wrapper .nav li.active a p').html();



        $('.fixed-plugin a').click(function(event) {
          if ($(this).hasClass('switch-trigger')) {
            if (event.stopPropagation) {
              event.stopPropagation();
            } else if (window.event) {
              window.event.cancelBubble = true;
            }
          }
        });

        $('.fixed-plugin .background-color span').click(function() {
          $(this).siblings().removeClass('active');
          $(this).addClass('active');

          var new_color = $(this).data('color');

          if ($sidebar.length != 0) {
            $sidebar.attr('data', new_color);
          }

          if ($main_panel.length != 0) {
            $main_panel.attr('data', new_color);
          }

          if ($full_page.length != 0) {
            $full_page.attr('filter-color', new_color);
          }

          if ($sidebar_responsive.length != 0) {
            $sidebar_responsive.attr('data', new_color);
          }
        });

        $('.switch-sidebar-mini input').on("switchChange.bootstrapSwitch", function() {
          var $btn = $(this);

          if (sidebar_mini_active == true) {
            $('body').removeClass('sidebar-mini');
            sidebar_mini_active = false;
            blackDashboard.showSidebarMessage('Sidebar mini deactivated...');
          } else {
            $('body').addClass('sidebar-mini');
            sidebar_mini_active = true;
            blackDashboard.showSidebarMessage('Sidebar mini activated...');
          }

          // we simulate the window Resize so the charts will get updated in realtime.
          var simulateWindowResize = setInterval(function() {
            window.dispatchEvent(new Event('resize'));
          }, 180);

          // we stop the simulation of Window Resize after the animations are completed
          setTimeout(function() {
            clearInterval(simulateWindowResize);
          }, 1000);
        });

        $('.switch-change-color input').on("switchChange.bootstrapSwitch", function() {
          var $btn = $(this);

          if (white_color == true) {

            $('body').addClass('change-background');
            setTimeout(function() {
              $('body').removeClass('change-background');
              $('body').removeClass('white-content');
            }, 900);
            white_color = false;
          } else {

            $('body').addClass('change-background');
            setTimeout(function() {
              $('body').removeClass('change-background');
              $('body').addClass('white-content');
            }, 900);

            white_color = true;
          }


        });

        $('.light-badge').click(function() {
          $('body').addClass('white-content');
        });

        $('.dark-badge').click(function() {
          $('body').removeClass('white-content');
        });
      });
    });
  </script>

  <script>
    window.TrackJS &&
      TrackJS.install({
        token: "ee6fab19c5a04ac1a32a645abde4613a",
        application: "black-dashboard-free"
      });

    $('#form_post').validate({
        rules: {
            title: 'required',
            post: 'required'
        },
        messages: {
            title: 'title is required.',
            post: 'post is required.'
        }
    });

    $('#form_post_edit').validate({
        rules: {
            title_e: 'required',
            post_e: 'required'
        },
        messages: {
            title_e: 'title is required.',
            post_e: 'post is required.'
        }
    });

    function Edit(id, title, post)
    {
        $('#post_id').val(id);
        $('#title_e').val(title);
        $('#post_e').val(post);
    }

  </script>
</body>

</html>
