<?php
require_once realpath(dirname(__FILE__) . '/app/business/DocBusiness.php');

$data = $_GET;

$docBusiness = new DocBusiness();
$resp = $docBusiness->getDadosDocs($data);
echo json_encode($resp);

