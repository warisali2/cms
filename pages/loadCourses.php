<?php

  require_once 'dbconfig.php';

  $dbc = new mysqli($hn, $un, $pw, $db);
  if($dbc->connect_error) die($dbc->connect_error);

  $query = 'SELECT courseName FROM course';
  $result = $dbc->query($query);

  if(!$result) die($dbc->error);

  if($result->num_rows == 0)
    echo  "$('#coursePreReq').prop('disabled',true);\n
           $('#coursePreReq').attr('placeholder','No course available');";
  else {

    $source = "";
    while($row = $result->fetch_array(MYSQLI_ASSOC))
      $source = $source . sprintf("'%s',", ucwords(strtolower($row['courseName'])));

    echo <<<_END
    $('#coursePreReq').tokenfield({
      autocomplete: {
        source: [$source],
        delay: 100
      },
      showAutocompleteOnFocus: true
    }).on('tokenfield:createtoken', function (event) {
        var exists = false;
        $.each([$source], function(index, token) {
          if (token === event.attrs.value)
            exists = true;
        });
        if(exists === false)
          event.preventDefault();
    });
_END;
  }
 ?>

<?php
/*
 //Outputing courses
 echo '[';
 while($row = $result->fetch_array(MYSQLI_ASSOC))
   echo sprintf("{value:'%s',label:'%s'},",
                         ucwords(strtolower($row['courseID']))
                         ,ucwords(strtolower($row['courseName'])));
 echo ']';
 */
 ?>
