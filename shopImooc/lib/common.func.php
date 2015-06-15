<?php
function alertMes($mes, $url) 
{
	echo "<script>alert('{$mes}');</script>";
	echo "<script>window.location='{$url}';</script>";
}

function startSessionIfSOff()
{
	if(!isset($_SESSION))
	{
		session_start();
	}
}