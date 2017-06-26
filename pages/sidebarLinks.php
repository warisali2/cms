<?php

  $admin_links = array(
                    array('admin.php', 'fa-dashboard', 'Dashboard'),
                    array('deleteLocation.php','fa-map-marker','Locations',array(
                              array('addLocation.php','','Add Location'),
                              array('deleteLocation.php','','Delete Location')
                    )),
                    array('departments.php','fa-building-o','Department'),
                    array('rooms.php','fa-th-large','Rooms'),
                    array('deleteCourse.php','fa-book', 'Course', array(
                              array('addCourse.php', '', 'Add Course'),
                              array('deleteCourse.php', '', 'Delete Course'),
                              array('assignCourse.php', '', 'Course Assignment')
                    )),
                    array('deleteTeacher.php', 'fa-user', 'Teachers', array(
                              array('addTeacher.php','','Add Teacher'),
                              array('deleteTeacher.php','','Delete Teacher'),
                    )),
                    array('deleteStudent.php', 'fa-user-o', 'Students', array(
                              array('addStudent.php','','Add Student'),
                              array('deleteStudent.php','','Delete Student')
                    ))
                  );

?>
