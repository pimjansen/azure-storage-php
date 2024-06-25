<?php

namespace AzureOSS\Storage\Common\Internal\Serialization;

use AzureOSS\Storage\Common\Internal\Resources;
use AzureOSS\Storage\Common\Internal\Validate;
use GuzzleHttp\Exception\RequestException;

class MessageSerializer
{
    /**
     * Serialize a message to a string. The message object must be either a type
     * of \Exception, or have following methods implemented.
     * getHeaders()
     * getProtocolVersion()
     * (getUri() && getMethod()) || (getStatusCode() && getReasonPhrase())
     *
     * @return string
     */
    public static function objectSerialize($targetObject)
    {
        //if the object is of exception type, serialize it using the methods
        //without checking the methods.
        if ($targetObject instanceof RequestException) {
            return self::serializeRequestException($targetObject);
        }
        if ($targetObject instanceof \Exception) {
            return self::serializeException($targetObject);
        }

        Validate::methodExists($targetObject, 'getHeaders', 'targetObject');
        Validate::methodExists($targetObject, 'getProtocolVersion', 'targetObject');

        // Serialize according to the implemented method.
        if (
            method_exists($targetObject, 'getUri')
            && method_exists($targetObject, 'getMethod')
        ) {
            return self::serializeRequest($targetObject);
        }
        if (
            method_exists($targetObject, 'getStatusCode')
            && method_exists($targetObject, 'getReasonPhrase')
        ) {
            return self::serializeResponse($targetObject);
        }
        throw new \InvalidArgumentException(
            Resources::INVALID_MESSAGE_OBJECT_TO_SERIALIZE,
        );
    }

    /**
     * Serialize the request type that implemented the following methods:
     * getHeaders()
     * getProtocolVersion()
     * getUri()
     * getMethod()
     *
     * @param object $request The request to be serialized.
     *
     * @return string
     */
    private static function serializeRequest($request)
    {
        $headers = $request->getHeaders();
        $version = $request->getProtocolVersion();
        $uri = $request->getUri();
        $method = $request->getMethod();

        $resultString = "Request:\n";
        $resultString .= "URI: {$uri}\nHTTP Version: {$version}\nMethod: {$method}\n";
        $resultString .= self::serializeHeaders($headers);

        return $resultString;
    }

    /**
     * Serialize the response type that implemented the following methods:
     * getHeaders()
     * getProtocolVersion()
     * getStatusCode()
     * getReasonPhrase()
     *
     * @param object $response The response to be serialized
     *
     * @return string
     */
    private static function serializeResponse($response)
    {
        $headers = $response->getHeaders();
        $version = $response->getProtocolVersion();
        $status = $response->getStatusCode();
        $reason = $response->getReasonPhrase();

        $resultString = "Response:\n";
        $resultString .= "Status Code: {$status}\nReason: {$reason}\n";
        $resultString .= "HTTP Version: {$version}\n";
        $resultString .= self::serializeHeaders($headers);

        return $resultString;
    }

    /**
     * Serialize the message headers.
     *
     * @param array $headers The headers to be serialized.
     *
     * @return string
     */
    private static function serializeHeaders(array $headers)
    {
        $resultString = "Headers:\n";
        foreach ($headers as $key => $value) {
            $resultString .= sprintf("%s: %s\n", $key, $value[0]);
        }

        return $resultString;
    }

    /**
     * Serialize the request exception.
     *
     * @param RequestException $e the request exception to be serialized.
     *
     * @return string
     */
    private static function serializeRequestException(RequestException $e)
    {
        $resultString = sprintf("Reason:\n%s\n", $e);
        if ($e->hasResponse()) {
            $resultString .= self::serializeResponse($e->getResponse());
        }

        return $resultString;
    }

    /**
     * Serialize the general exception
     *
     * @param \Exception $e general exception to be serialized.
     *
     * @return string
     */
    private static function serializeException(\Exception $e)
    {
        return sprintf("Reason:\n%s\n", $e);
    }
}
