<?php
  session_start();

  require_once 'dbconfig.php';
  require_once 'pageHeader.php';
  require_once 'pageFooter.php';
  require_once 'navbar.php';
  require_once 'logout.php';
  require_once 'generateSidebar.php';
  require_once 'sidebarLinks.php';

  $dbc = new mysqli($hn, $un, $pw, $db);
  if($dbc->connect_error) die($dbc->connect_error);
/*
  $headers = getallheaders();
/*
  if(substr($headers['Referer'],strrpos($headers['Referer'],'/',-1)+1) != 'admin.php')
  {
    logout(true);
  }
  */
?>
<!DOCTYPE html>
<html>
  <head>
    <?php
      includeHeader('Students | Admin Panel | CMS');
    ?>
  </head>
  <body>
    <div id="wrapper">
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
          <?php includeNavBar('Admin Panel | CMS', $_SESSION['name']); ?>
          <?php generateSidebar($admin_links); ?>
        </nav>
    </div>
    <div id="page-wrapper">
      <?php includeTitle('Add Students'); ?>

      <div class="row">
        <div class="col-lg-12">
          <div class="panel panel-default">
            <div class="panel-heading">
              <i class="fa fa-user-o fa-fw"></i> &nbsp;Add Student
            </div>
            <div class="panel-body">
              <form class="form-horizontal">
                <div class="form-group">
                  <label class="control-label col-sm-4" for="firstName">First Name:</label>
                  <div class="col-sm-offet-1 col-sm-7">
                    <input type="text" class="form-control" id="firstName" placeholder="Enter first name" required name="firstName" autofocus>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-4" for="lastName">Last Name:</label>
                  <div class="col-sm-offet-1 col-sm-7">
                    <input type="text" class="form-control" id="lastName" placeholder="Enter last name" required name="lastName" >
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-4" for="gender">Gender:</label>
                  <div class="col-sm-offet-1 col-sm-7">
                    <label class="radio-inline">
                      <input type="radio" name="gender" value="M" checked>Male
                    </label>
                    <label class="radio-inline">
                      <input type="radio" name="gender" value="F">Female
                    </label>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-4" for="dob">Date of Birth:</label>
                  <div class="col-sm-offet-1 col-sm-7">
                    <input type="date" class="form-control" id="dob" required name="dob" >
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-4" for="cnic">CNIC:</label>
                  <div class="col-sm-offet-1 col-sm-7">
                    <input type="text" class="form-control" id="cnic" placeholder="#####-#######-#" required name="cnic" pattern="[0-9]{5}-[0-9]{7}-[0-9]">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-4" for="fatherFirstName">Father's First Name:</label>
                  <div class="col-sm-offet-1 col-sm-7">
                    <input type="text" class="form-control" id="fatherFirstName" placeholder="Enter father's first name" required name="fatherFirstName" >
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-4" for="fatherLastName">Father's Last Name:</label>
                  <div class="col-sm-offet-1 col-sm-7">
                    <input type="text" class="form-control" id="fatherLastName" placeholder="Enter father's last name" required name="fatherLastName" >
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-4" for="enrollDate">Enrollment Date:</label>
                  <div class="col-sm-offet-1 col-sm-7">
                    <input type="date" class="form-control" id="enrollDate" required name="enrollDate" >
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-4" for="email">Email:</label>
                  <div class="col-sm-offet-1 col-sm-7">
                    <input type="email" class="form-control" id="email" required name="email" placeholder="Enter email address">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-4" for="phone">Phone:</label>
                  <div class="col-sm-offet-1 col-sm-7">
                    <input type="text" class="form-control" id="phone" placeholder="####-#######" required name="phone" pattern="[0-9]{4}-[0-9]{7}">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-4" for="houseNo">House No.</label>
                  <div class="col-sm-offet-1 col-sm-7">
                    <input type="text" class="form-control" id="houseNo" placeholder="Enter house no" required name="houseNo" >
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-4" for="streetNo">Street No.</label>
                  <div class="col-sm-offet-1 col-sm-7">
                    <input type="text" class="form-control" id="streetNo" placeholder="Enter street no" required name="streetNo" >
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-4" for="country-list">Country:</label>
                  <div class="col-sm-offet-2 col-sm-6">
                    <select class="form-control" id="country-list" required name="country">
                      <?php

                        $query = 'SELECT * FROM country WHERE countryName <> "NONE" ORDER BY countryName';
                        $result = $dbc->query($query);

                        for($i = 0; $i < $result->num_rows; $i++)
                        {
                          $result->data_seek($i);
                          $row = $result->fetch_array(MYSQLI_ASSOC);

                          echo '<option value='. $row['countryID'] . '>' . ucwords(strtolower($row['countryName'])) . '</option>';
                        }
                       ?>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-4" for="city-list">City:</label>
                  <div class="col-sm-offet-2 col-sm-6">
                    <select class="form-control" id="city-list" required name="city">
                      <option value="" disabled selected>Please select country</option>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-offset-4 col-sm-8">
                    <button type="submit" class="btn btn-default" formmethod="post" formaction="processAddStudent.php">Add</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

    <?php
      includeScripts();

      $dbc->close();
    ?>
    <script>
    $(document).ready(function() {
      $("#city-list").change( function(){
              jQuery.ajax({
                      url: "processCity.php",
                      type: "POST",
                      data: { "cityID": $(this).val()},
                      success: function (rtndata) {
                         $('#department-list').html(rtndata);
                       }
             });
      });

      $("#country-list").change( function(){
              jQuery.ajax({
                      url: "processCountry.php",
                      type: "POST",
                      data: { "countryID": $(this).val()},
                      success: function (rtndata) {
                         $('#city-list').html(rtndata);
                       }
             });
      });
    });
    </script>
  </body>
</html>
