<?php

	require_once __DIR__ . '/vendor/autoload.php';

	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Response;

	$request = Request::createFromGlobals();

	$input = $request->get('var');
	$response = new Response('Var is: ' . $input);
	$response->send();