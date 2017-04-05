<?php
$userName = $_POST['e3_std_nom'];

echo json_encode(array(
    'message' => sprintf('Welcome %s', $userName),
));
