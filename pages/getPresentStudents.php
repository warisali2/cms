<?php

  require_once 'dbconfig.php';

  $courseID = $_POST['courseID'];
  $date = $_POST['date'];

  $dbc = new mysqli($hn, $un, $pw, $db);
  if($dbc->connect_error) die($dbc->connect_error);

  $query = sprintf('SELECT sc.studentID, s.firstName, s.lastName
                    FROM studentCourse sc, student s WHERE sc.courseID = %d
                    AND sc.studentID IN (SELECT studentID FROM attendance
                                          WHERE courseID = %d
                                          AND attendDate = STR_TO_DATE("%s","%%Y-%%m-%%d"))
                    AND sc.studentID = s.studentID',

                                          $courseID,
                                          $courseID,
                                          $date);

  $result = $dbc->query($query);
  if(!$result) die($dbc->error);

  while($row = $result->fetch_array(MYSQLI_ASSOC))
  {
    echo sprintf('
    <tr>
      <td>%d</td>
      <td>
        <div class="row">
          <div class="col-lg-8">
              %s
          </div>
          <div clss="col-lg-4">
              <button name="absent-btn" class="btn btn-default btn-xs pull-right"
              style="margin-right: 20px; margin-left: 0;" value="%d,%d,%s" type="button">
                Mark Absent
              </button>
          </div>
        </div>
      </td>
    </tr>
    ', $row['studentID'],
       ucwords(strtolower($row['firstName'] . ' ' . $row['lastName'])),
       $courseID,
       $row['studentID'],
       $date
     );
  }
?>
