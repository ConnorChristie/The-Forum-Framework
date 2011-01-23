<?php
if(empty($title)) $title = "$action $model";
include (ROOT.DS."application".DS."header.php");
try {
  if (is_file ( ROOT.DS."application".DS.$model.DS.$action.".php" )) {
    include ROOT.DS."application".DS.$model.DS.$action.".php";
  }
  else
    throw new tffw_exception ( 100, "Controller not found for $action" );
}
catch ( tffw_error $e ) {
	exit($e->getMessage());;
}

include (ROOT.DS."application".DS."footer.php");