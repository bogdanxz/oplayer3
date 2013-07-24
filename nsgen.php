<?php
// propel namespace hack, do not edit this file.
$confPath = "app/Config";

if ( file_exists("{$confPath}/schema.xml") ) {
  $xml = file_get_contents("{$confPath}/schema.xml");
  $xml = str_replace('namespace="Model"', '', $xml);
  $xml = str_replace('<database', '<database namespace="Model"', $xml);
  file_put_contents("{$confPath}/schema.xml", $xml);
}
