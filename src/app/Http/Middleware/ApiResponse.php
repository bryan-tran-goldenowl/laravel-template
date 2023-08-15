<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use Symfony\Component\HttpFoundation\Response;

class ApiResponse
{

    public function handle(Request $request, Closure $next, string ...$guards): Response
    {

        $response = $next($request);

        if ($request->is('api/*') && $response->headers->get('Content-Type') == 'application/json') {
            $responseData = json_decode($response->getContent(), true);

            if ($response->isOk()) {
                $newResponseData = [
                    'success' => true,
                    'data' => $responseData
                ];
            } else {
                $newResponseData = [
                    'success' => false,
                    'data' => $responseData["message"] ?
                        ["message" => $responseData["message"]] : $responseData
                ];
            }


            $newResponse = response()->json($newResponseData);
            $newResponse->setStatusCode($response->getStatusCode());

            foreach ($response->headers->all() as $name => $values) {
                $newResponse->headers->set($name, $values);
            }

            return $newResponse;
        }

        return $response;
    }
}
