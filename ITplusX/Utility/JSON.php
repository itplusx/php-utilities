<?php
namespace ITplusX\Utility;

use ITplusX\Utility\Exception\JSONParseException;

class JSON
{

    public static $errors = [
        JSON_ERROR_NONE           => 'No error',
        JSON_ERROR_DEPTH          => 'Maximum stack depth exceeded',
        JSON_ERROR_STATE_MISMATCH => 'State mismatch (invalid or malformed JSON)',
        JSON_ERROR_CTRL_CHAR      => 'Control character error, possibly incorrectly encoded',
        JSON_ERROR_SYNTAX         => 'Syntax error',
        JSON_ERROR_UTF8           => 'Malformed UTF-8 characters, possibly incorrectly encoded',
    ];

    /**
     * (PHP 5 &gt;= 5.2.0, PECL json &gt;= 1.2.0)<br/>
     * Returns the JSON representation of a value
     *
     * @link http://php.net/manual/en/function.json-encode.php
     *
     * @param mixed $value   <p>
     *                       The <i>value</i> being encoded. Can be any type except
     *                       a resource.
     *                       </p>
     *                       <p>
     *                       All string data must be UTF-8 encoded.
     *                       </p>
     *                       <p>PHP implements a superset of
     *                       JSON - it will also encode and decode scalar types and <b>NULL</b>. The JSON standard
     *                       only supports these values when they are nested inside an array or an object.
     *                       </p>
     * @param int   $options [optional] <p>
     *                       Bitmask consisting of <b>JSON_HEX_QUOT</b>,
     *                       <b>JSON_HEX_TAG</b>,
     *                       <b>JSON_HEX_AMP</b>,
     *                       <b>JSON_HEX_APOS</b>,
     *                       <b>JSON_NUMERIC_CHECK</b>,
     *                       <b>JSON_PRETTY_PRINT</b>,
     *                       <b>JSON_UNESCAPED_SLASHES</b>,
     *                       <b>JSON_FORCE_OBJECT</b>,
     *                       <b>JSON_UNESCAPED_UNICODE</b>. The behaviour of these
     *                       constants is described on
     *                       the JSON constants page.
     *                       </p>
     * @param int   $depth   [optional] <p>
     *                       Set the maximum depth. Must be greater than zero.
     *                       </p>
     *
     * @link http://php.net/manual/en/function.json-decode.php
     * @link http://php.net/manual/en/function.json-last-error.php
     *
     * @return string a JSON encoded string on success or <b>FALSE</b> on failure.
     */
    public static function encode($value, $options = 0, $depth = 512)
    {
        return json_encode($value, $options, $depth);
    }

    /**
     * (PHP 5 &gt;= 5.2.0, PECL json &gt;= 1.2.0)<br/>
     * Decodes a JSON string
     *
     * @link http://php.net/manual/en/function.json-decode.php
     *
     * @param string $json    <p>
     *                        The <i>json</i> string being decoded.
     *                        </p>
     *                        <p>
     *                        This function only works with UTF-8 encoded strings.
     *                        </p>
     *                        <p>PHP implements a superset of
     *                        JSON - it will also encode and decode scalar types and <b>NULL</b>. The JSON standard
     *                        only supports these values when they are nested inside an array or an object.
     *                        </p>
     * @param bool   $assoc   [optional] <p>
     *                        When <b>TRUE</b>, returned objects will be converted into
     *                        associative arrays.
     *                        </p>
     * @param int    $depth   [optional] <p>
     *                        User specified recursion depth.
     *                        </p>
     * @param int    $options [optional] <p>
     *                        Bitmask of JSON decode options. Currently only
     *                        <b>JSON_BIGINT_AS_STRING</b>
     *                        is supported (default is to cast large integers as floats)
     *                        </p>
     *
     * @return mixed the value encoded in <i>json</i> in appropriate
     * PHP type. Values true, false and
     * null (case-insensitive) are returned as <b>TRUE</b>, <b>FALSE</b>
     * and <b>NULL</b> respectively. <b>NULL</b> is returned if the
     * <i>json</i> cannot be decoded or if the encoded
     * data is deeper than the recursion limit.
     * @throws JSONParseException
     */
    public static function decode($json, $assoc = false, $depth = 512, $options = 0)
    {
        $result = json_decode($json, $assoc, $depth, $options);

        $errorCode = json_last_error();
        if ($errorCode !== JSON_ERROR_NONE) {
            $errorMessage = isset(self::$errors[$errorCode]) ? self::$errors[$errorCode] : json_last_error_msg();
            throw new JSONParseException($errorMessage, $errorCode);
        }

        return $result;
    }
}