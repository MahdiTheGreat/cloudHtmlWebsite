<?php
if(isset($_GET['destinationPage'])) {
    echo "now redirecting";
    header("Location: http://mafarideh1998.ihweb.ir/cgi-bin/".$_GET['destinationPage']);
    exit();
}