<?php

declare(strict_types = 1);

namespace Rpodwika\FakeRestServerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class FakeServerApiController extends Controller
{
    /**
     * Perform GET request
     *
     * @param Request $request
     *
     * @return Response
     */
    public function getAction(Request $request): Response
    {
        return new JsonResponse($this->getDataFromRequest($request));
    }

    /**
     * Perform HEAD request
     *
     * @return Response
     *
     * @see https://www.w3.org/Protocols/rfc2616/rfc2616-sec9.html#sec9.4
     */
    public function headAction(): Response
    {
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * Simulate update operation on an existing object
     *
     * @param Request $request
     *
     * @return Response
     */
    public function putAction(Request $request): Response
    {
        return new JsonResponse(array_merge($this->getDataFromRequest($request), $request->request->all()));
    }

    /**
     * Simulate creating new object and return Response 201 Created with Location header set to new fake resource URI
     *
     * @param Request $request
     *
     * @return Response
     *
     * @see https://www.w3.org/Protocols/rfc2616/rfc2616-sec9.html#sec9.5
     */
    public function postAction(Request $request): Response
    {
        $newResourceUri = $this
            ->get('router')
            ->generate($request->get('_route'), [], UrlGeneratorInterface::ABSOLUTE_URL);

        return new Response('', Response::HTTP_CREATED, [
            'Location' => sprintf("%s/%d", $newResourceUri, rand(1, 500)),
        ]);
    }

    /**
     * Returns OPTIONS of communication with an API
     *
     * @return Response
     *
     * @see https://www.w3.org/Protocols/rfc2616/rfc2616-sec9.html#sec9.2
     */
    public function optionsAction(): Response
    {
        return new Response('', Response::HTTP_OK, [
            'Allow' => 'GET, PUT, POST, OPTIONS, DELETE, HEAD',
        ]);
    }

    /**
     * Perform DELETE request
     *
     * @return Response
     *
     * @see https://www.w3.org/Protocols/rfc2616/rfc2616-sec9.html#sec9.7
     */
    public function deleteAction(): Response
    {
        return new Response(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * @param Request $request
     *
     * @return array
     *
     * @throws NotFoundHttpException
     */
    private function getDataFromRequest(Request $request): array
    {
        // Filter data if request attributes starts with _ then remove them from a new array

        $filteredRequestAttributes = array_filter($request->attributes->all(), function ($key) {
            return is_string($key) && strpos($key, '_') !== 0;
        }, ARRAY_FILTER_USE_KEY);

        $resourceId = current($filteredRequestAttributes);
        $resourceName = key($filteredRequestAttributes);
        $resourceData = $this->get('fake_rest_server.schema_reader')->find($resourceName, (int)$resourceId);

        if (null === $resourceData) {
            throw new NotFoundHttpException("You have tried to access a non existing resource");
        }

        return $resourceData;
    }

}
