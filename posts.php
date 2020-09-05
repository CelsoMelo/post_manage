<?php
ob_start();
session_start();
include("conex/connect.php");

if (!isset($_SESSION["usrcms"]) && !isset($_SESSION['pswcms'])) {
  header("Location: index.php?access=denied");
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>Reports - Bootstrap Admin Template</title>

    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"
    />
    <meta name="apple-mobile-web-app-capable" content="yes" />

    <link href="css/bootstrap.min.css" rel="stylesheet" />
    <link href="css/bootstrap-responsive.min.css" rel="stylesheet" />

    <link
      href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600"
      rel="stylesheet"
    />
    <link href="css/font-awesome.css" rel="stylesheet" />

    <link href="css/style.css" rel="stylesheet" />

    <link href="css/pages/reports.css" rel="stylesheet" />

    <!--EDITOR DE TEXTO-->
    <script
      src="http://js.nicedit.com/nicEdit-latest.js"
      type="text/javascript"
    ></script>
    <script type="text/javascript">
      bkLib.onDomLoaded(nicEditors.allTextAreas);
    </script>
    <!--/Editor de texto-->

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
  </head>

  <body>
    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a
            class="btn btn-navbar"
            data-toggle="collapse"
            data-target=".nav-collapse"
          >
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>

          <a class="brand" href="index.html">
            Bootstrap Admin Template
          </a>

          <div class="nav-collapse">
            <ul class="nav pull-right">
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="icon-cog"></i>
                  Account
                  <b class="caret"></b>
                </a>

                <ul class="dropdown-menu">
                  <li><a href="javascript:;">Settings</a></li>
                  <li><a href="javascript:;">Help</a></li>
                </ul>
              </li>

              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="icon-user"></i>
                  EGrappler.com
                  <b class="caret"></b>
                </a>

                <ul class="dropdown-menu">
                  <li><a href="javascript:;">Profile</a></li>
                  <li><a href="javascript:;">Logout</a></li>
                </ul>
              </li>
            </ul>

            <form class="navbar-search pull-right">
              <input type="text" class="search-query" placeholder="Search" />
            </form>
          </div>
          <!--/.nav-collapse -->
        </div>
        <!-- /container -->
      </div>
      <!-- /navbar-inner -->
    </div>
    <!-- /navbar -->

    <div class="subnavbar">
      <div class="subnavbar-inner">
        <div class="container">
          <ul class="mainnav">
            <li>
              <a href="home.php">
                <i class="icon-dashboard"></i>
                <span>Home</span>
              </a>
            </li>

            <li class="active">
              <a href="posts.php">
                <i class="icon-list-alt"></i>
                <span>Posts</span>
              </a>
            </li>

            <li>
              <a href="post-manage.php"
                ><i class="icon-wrench"></i><span>Gerenciar Postagens</span>
              </a>
            </li>

            <li>
              <a href="charts.html">
                <i class="icon-bar-chart"></i>
                <span>Charts</span>
              </a>
            </li>

            <li>
              <a href="shortcodes.html">
                <i class="icon-code"></i>
                <span>Shortcodes</span>
              </a>
            </li>

            <li class="dropdown">
              <a
                href="javascript:;"
                class="dropdown-toggle"
                data-toggle="dropdown"
              >
                <i class="icon-long-arrow-down"></i>
                <span>Drops</span>
                <b class="caret"></b>
              </a>

              <ul class="dropdown-menu">
                <li><a href="icons.html">Icons</a></li>
                <li><a href="faq.html">FAQ</a></li>
                <li><a href="pricing.html">Pricing Plans</a></li>
                <li><a href="login.html">Login</a></li>
                <li><a href="signup.html">Signup</a></li>
                <li><a href="error.html">404</a></li>
              </ul>
            </li>
          </ul>
        </div>
        <!-- /container -->
      </div>
      <!-- /subnavbar-inner -->
    </div>
    <!-- /subnavbar -->

    <div class="main">
      <div class="main-inner">
        <div class="container">
          <div class="row">
            <div class="span12">
              <div class="widget-header">
                <i class="icon-file"></i>
                <h3>Nova Postagem</h3>
              </div>
              <div class="widget-content">
                <?php
              if (isset($_POST["submit"]) && !empty($_POST['title_post'])) {
                $post_title = trim(strip_tags($_POST['title_post']));
                $post_date = $_POST['date_post'];
                $post_content = trim($_POST['content_post']);

                if (isset($_FILES['image_post']['name']) && $_FILES['image_post']['error'] == 0) {
                  $file_tmp = $_FILES['image_post']['tmp_name'];
                  $file_name = $_FILES['image_post']['name'];

                  $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
                  $file_ext = strtolower($file_ext);

                  if (strstr('.jpg;.jpeg;.png;', $file_ext)) {
                    $new_name = uniqid(time()) . '.' . $file_ext;
                    $destiny = '../image/post/title/' . $new_name;

                    try {
                      if (!move_uploaded_file($file_tmp, $destiny)) {
                        throw new Exception("Impossivel mover o arquivo.");
                      }
                    } catch (Exception $e) {
                      echo 'ERRO: ' . $e;
                    }
                  } else {
                    echo 'Tipo de arquivo não suportado!';
                  }
                }

                $insert_querry = "INSERT INTO posts(post_title, post_date, post_img, post_content) VALUES (:title, :date_post, :img, :content)";

                try {
                  $result = $conection->prepare($insert_querry);
                $result->bindParam(':title', $post_title, PDO::PARAM_STR);
                $result->bindParam(':date_post', $post_date, PDO::PARAM_STR);
                $result->bindParam(':img', $new_name, PDO::PARAM_STR);
                $result->bindParam(':content', $post_content, PDO::PARAM_STR);
                $result->execute(); echo '
                <div class="alert alert-success">
                  <button type="button" class="close" data-dismiss="alert">
                    &times;
                  </button>
                  <strong>Sucesso!</strong> Postagem realizada.
                </div>
                '; } catch (PDOExeption $e) { echo 'Error: ' . $e; } } ?>
                <div class="tab-pane" id="formcontrols">
                  <form
                    id="new_post"
                    class="form-horizontal"
                    method="post"
                    enctype="multipart/form-data"
                  >
                    <fieldset>
                      <div class="control-group">
                        <label class="control-label" for="username"
                          >Titulo</label
                        >
                        <div class="controls">
                          <input
                            type="text"
                            class="span6 disabled"
                            id="post_title"
                            placeholder="Titulo da postagem"
                            name="title_post"
                          />
                        </div>
                        <!-- /controls -->
                      </div>
                      <!-- /control-group -->

                      <br />

                      <div class="control-group">
                        <label class="control-label" for="password1"
                          >Data</label
                        >
                        <div class="controls">
                          <input
                            type="date"
                            class="span4"
                            id="post_date"
                            value=""
                            name="date_post"
                          />
                        </div>
                        <!-- /controls -->
                      </div>
                      <!-- /control-group -->

                      <div class="control-group">
                        <label class="control-label" for="password1"
                          >Imagem</label
                        >
                        <div class="controls">
                          <input
                            type="file"
                            class="span4"
                            id="post_image"
                            name="image_post"
                          />
                        </div>
                        <!-- /controls -->
                      </div>
                      <!-- /control-group -->
                      <div class="control-group">
                        <label class="control-label" for="password1"
                          >Conteúdo</label
                        >
                        <div class="controls">
                          <textarea
                            class="span7"
                            id="post_content"
                            name="content_post"
                            rows="20"
                          ></textarea>
                        </div>
                        <!-- /controls -->
                      </div>
                      <!-- /control-group -->

                      <br />

                      <div class="form-actions">
                        <input
                          name="submit"
                          type="submit"
                          class="btn btn-primary"
                          value="Confirmar"
                        />
                        <input
                          name="reset"
                          type="reset"
                          class="btn"
                          value="Cancelar"
                        />
                      </div>
                      <!-- /form-actions -->
                    </fieldset>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /container -->
      </div>
      <!-- /main-inner -->
    </div>
    <!-- /main -->

    <div class="extra">
      <div class="extra-inner">
        <div class="container">
          <div class="row">
            <div class="span3">
              <h4>
                About Free Admin Template
              </h4>
              <ul>
                <li><a href="javascript:;">EGrappler.com</a></li>
                <li><a href="javascript:;">Web Development Resources</a></li>
                <li>
                  <a href="javascript:;"
                    >Responsive HTML5 Portfolio Templates</a
                  >
                </li>
                <li><a href="javascript:;">Free Resources and Scripts</a></li>
              </ul>
            </div>
            <!-- /span3 -->
            <div class="span3">
              <h4>
                Support
              </h4>
              <ul>
                <li><a href="javascript:;">Frequently Asked Questions</a></li>
                <li><a href="javascript:;">Ask a Question</a></li>
                <li><a href="javascript:;">Video Tutorial</a></li>
                <li><a href="javascript:;">Feedback</a></li>
              </ul>
            </div>
            <!-- /span3 -->
            <div class="span3">
              <h4>
                Something Legal
              </h4>
              <ul>
                <li><a href="javascript:;">Read License</a></li>
                <li><a href="javascript:;">Terms of Use</a></li>
                <li><a href="javascript:;">Privacy Policy</a></li>
              </ul>
            </div>
            <!-- /span3 -->
            <div class="span3">
              <h4>
                Open Source jQuery Plugins
              </h4>
              <ul>
                <li><a href="">Open Source jQuery Plugins</a></li>
                <li><a href="">HTML5 Responsive Tempaltes</a></li>
                <li><a href="">Free Contact Form Plugin</a></li>
                <li><a href="">Flat UI PSD</a></li>
              </ul>
            </div>
            <!-- /span3 -->
          </div>
          <!-- /row -->
        </div>
        <!-- /container -->
      </div>
      <!-- /extra-inner -->
    </div>
    <!-- /extra -->

    <div class="footer">
      <div class="footer-inner">
        <div class="container">
          <div class="row">
            <div class="span12">
              &copy; 2013 <a href="#">Bootstrap Responsive Admin Template</a>.
            </div>
            <!-- /span12 -->
          </div>
          <!-- /row -->
        </div>
        <!-- /container -->
      </div>
      <!-- /footer-inner -->
    </div>
    <!-- /footer -->

    <script src="js/jquery-1.7.2.min.js"></script>
    <script src="js/excanvas.min.js"></script>
    <script src="js/chart.min.js" type="text/javascript"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/base.js"></script>
  </body>
</html>
