<?php

	require_once __DIR__ . '/vendor/autoload.php';

	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Response;
	use Symfony\Component\Routing;

	$request = Request::createFromGlobals();
	$routes = new Routing\RouteCollection();

	$routes->add(
		'hello',
		new Routing\Route('/{name}')
	);

	$context = new Routing\RequestContext();
	$context->fromRequest($request);
	$matcher = new Routing\Matcher\UrlMatcher($routes, $context);

	$attributes = $matcher->match($request->getPathInfo());

	var_dump($request->getPathInfo());

	try {
		$response = new Response();
	} catch (Routing\Exception\ResourceNotFoundException $e) {
		$response = new Response('Not Found', 404);
	} catch (Exception $e) {
		$response = new Response('An error occurred', 500);
	}

	$response->send();