<?php


  function generateSidebar($links, $level = 1)
  {
    if($level > 3)
      return;

    if(empty($level))
      return;

    if($level == 1)
    {
      echo '<div class="navbar-default sidebar" role="navigation">';
      echo '<div class="sidebar-nav navbar-collapse">';
      echo '<ul class="nav" id="side-menu">';

      echo '<ul class="nav" id="side-menu">';
    }
    else if($level == 2)
      echo '<ul class="nav nav-second-level">';
    else if($level == 3)
      echo '<ul class="nav nav-third-level">';
    else
      return;

    foreach($links as $link)
    {
      echo '<li>';
      echo '<a href="'.$link[0].'">';
      if(isset($link[1]))
        echo '<i class="fa '. $link[1] . ' fa-fw"></i>';

      echo ' ' . $link[2];

      if(isset($link[3]))
        echo '<span class="fa arrow"></span>';

      echo '</a>';

      if(isset($link[3]))
        generateSidebar($link[3], $level+1);

      echo '</li>';
    }

    echo '</ul>';

    if($level == 1)
      echo '</div></div>';
  }
?>
