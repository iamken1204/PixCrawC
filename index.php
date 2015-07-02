<?php
include "autoload_app.php";

use cronnos\printers\Printer;
use helpers\Arr;

// $form = new Form();
// // $res = $form->testCRUD();

// $p = new Printer();
// $p->view('partial/header.php');

// echo 'SV is coming!<BR>';
// $s = new SiteView();
// $s->validateViews();
// var_dump(SiteView::getViews());
$p = new Printer;
$p->view('view_index.php');

###########################################
##### route example #######################
###########################################
// $route = Arr::get($_POST, 'route', '');#
// if (function_exists($route))           #
//     $route();                          #
// else {                                 #
//     $p = new Printer();                #
//     $p->view('view_index.php');        #
// }                                      #
// function handleForm()                  #
// {                                      #
//     $form = new Form;                  #
//     $res = $form->insert($_POST);      #
//     echo json_encode($res);            #
// }                                      #
###########################################
##### route example #######################
###########################################
?>
