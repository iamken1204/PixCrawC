<?php
include "autoload_app.php";

// use models\App;
use helpers\VarDumper;
use models\Form;
use models\printers\Printer;
use models\SiteView;

// $form = new Form();
// // $res = $form->testCRUD();

// $p = new Printer();
// $p->view('partial/header.php');

echo 'SV is coming!<BR>';
// SiteView::addViews(10000);
$s = new SiteView();
$s->validateViews();
var_dump(SiteView::getViews());

