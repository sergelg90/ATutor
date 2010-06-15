<?php
/***********************************************************************/
/* ATutor															   */
/***********************************************************************/
/* Copyright (c) 2002-2009											   */
/* Adaptive Technology Resource Centre / Inclusive Design Institute	   */
/* http://atutor.ca													   */
/*																	   */
/* This program is free software. You can redistribute it and/or	   */
/* modify it under the terms of the GNU General Public License		   */
/* as published by the Free Software Foundation.					   */
/***********************************************************************/
// $Id$

define(AT_INCLUDE_PATH, '../../../include/');
include(AT_INCLUDE_PATH.'vitals.inc.php');
include(AT_JB_INCLUDE.'classes/Job.class.php');
include(AT_JB_INCLUDE.'classes/Employer.class.php');
$_custom_css = $_base_path . AT_JB_BASENAME . 'module.css'; // use a custom stylesheet

if (!Employer::authenticate()){
	$msg->addError('ACCESS_DENIED');
	header('Location: ../index.php');
	exit;
}

$job = new Job();
$all_categories = $job->getCategories();

//on submit
if(isset($_POST['submit'])){
	//concat the closing date values
	$year = intval($_POST['year_jb_closing_date']);
	$month = intval($_POST['month_jb_closing_date']);
	$month = ($month < 10)?'0'.$month:$month;
	$day = intval($_POST['day_jb_closing_date']);
	$day = ($day < 10)?'0'.$day:$day;
	$hour = intval($_POST['hour_jb_closing_date']);
	$hour = ($hour < 10)?'0'.$hour:$hour;
	$min = intval($_POST['min_jb_closing_date']);
	$min = ($min < 10)?'0'.$min:$min;
	$jb_closing_date = $year.'-'.$month.'-'.$day.' '.$hour.':'.$min.':00';

	$job->addJob($_POST['jb_title'], $_POST['jb_description'], $_POST['jb_categories'], $_POST['jb_is_public'], $jb_closing_date);
	$msg->addFeedback('JOB_POST_ADDED_SUCCESSFULLY');
	header('Location: home.php');
	exit;
}


include(AT_INCLUDE_PATH.'header.inc.php');
$savant->assign('categories', $all_categories);
$savant->display('employer/jb_add_new_post.tmpl.php');
include(AT_INCLUDE_PATH.'footer.inc.php'); 
?>