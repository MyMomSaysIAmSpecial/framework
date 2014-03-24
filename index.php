<?php

	require_once __DIR__ . '/vendor/autoload.php';

	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Response;
	use Symfony\Component\Routing;
	use Symfony\Component\HttpKernel;

	$request = Request::createFromGlobals();
	$routes = new Routing\RouteCollection();

    function mock($get) {

    }

	$routes->add(
		'experiment',
        new Routing\Route('/{get}', ['_controller' => 'mock'])
    );

	$context = new Routing\RequestContext();
	$context->fromRequest($request);
	$matcher = new Routing\Matcher\UrlMatcher($routes, $context);
	$resolver = new HttpKernel\Controller\ControllerResolver();

	try {
		$request->attributes->add($matcher->match($request->getPathInfo()));
		$controller = $resolver->getController($request);
		$arguments = $resolver->getArguments($request, $controller);
		$response = new Response();
	} catch (Routing\Exception\ResourceNotFoundException $e) {
		$response = new Response('Not Found', 404);
	} catch (Exception $e) {
		$response = new Response('This is fcuked up. Server thinks so. ' .  $e->getMessage(), 500);
	}

	$response->send();