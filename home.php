<?php
include("conex/connect.php");
include("includes/header.php");
?>

<body>
  <?php
  include("includes/top.php");
  ?>
  <div class="main">
    <div class="main-inner">
      <div class="container">
        <div class="row">
          <div class="span12">
            <div class="widget widget-nopad">
              <div class="widget-header"> <i class="icon-list-alt"></i>
                <h3> Ultimas Postagens</h3>
              </div>
              <!-- /widget-header -->
              <div class="widget-content">
                <table class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th>Titulo</th>
                      <th>Data</th>
                      <th>Preview</th>
                      <th class="td-actions"></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $select_query = "SELECT * FROM posts ORDER BY post_id DESC LIMIT 3";
                    $result = $conection->prepare($select_query);
                    $result->execute();

                    while ($ultP = $result->FETCH(PDO::FETCH_ASSOC)) {

                      ?>
                      <tr>
                        <td><?php echo $ultP["post_title"]; ?></td>
                        <td><?php echo $ultP["post_date"]; ?></td>
                        <td><?php echo substr(strip_tags($ultP["post_content"]), 0, 100) . "..."; ?></td>
                        <td class="td-actions"><a href="#" class="btn btn-small btn-success"> <i class="btn-icon-only icon-edit"></i></a>
                          <a href="#" class="btn btn-small btn-danger"><i class="btn-icon-only icon-remove"></i></a></td>
                      </tr>
                    <?php
                  }
                  ?>
                  </tbody>
                </table>
              </div>
              <!-- /widget-content -->
            </div>
            <!-- /widget -->
          </div>
          <!-- /span6 -->
        </div>
        <!-- /row -->
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
              About Free Admin Template</h4>
            <ul>
              <li><a href="javascript:;">EGrappler.com</a></li>
              <li><a href="javascript:;">Web Development Resources</a></li>
              <li><a href="javascript:;">Responsive HTML5 Portfolio Templates</a></li>
              <li><a href="javascript:;">Free Resources and Scripts</a></li>
            </ul>
          </div>
          <!-- /span3 -->
          <div class="span3">
            <h4>
              Support</h4>
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
              Something Legal</h4>
            <ul>
              <li><a href="javascript:;">Read License</a></li>
              <li><a href="javascript:;">Terms of Use</a></li>
              <li><a href="javascript:;">Privacy Policy</a></li>
            </ul>
          </div>
          <!-- /span3 -->
          <div class="span3">
            <h4>
              Open Source jQuery Plugins</h4>
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
  <?php
  include("includes/footer.php");
  ?>
</body>

</html>