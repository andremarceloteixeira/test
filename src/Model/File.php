<?php
namespace Language\Model;
use Language\Exception\ApiException;
use Language\Exception\BadContextException;
use Language\Exception\ResponseException;

class File
{

    public function checkFileApiResult($result)
    {
        // Error during the api call.
        if ($result === false || !isset($result['status'])) {
            throw new ApiException('Error during the api call');
        }
        // Wrong response.
        if ($result['status'] != 'OK') {
            throw new ResponseException('Wrong response: '
                . (!empty($result['error_type']) ? 'Type(' . $result['error_type'] . ') ' : '')
                . (!empty($result['error_code']) ? 'Code(' . $result['error_code'] . ') ' : '')
                . ((string)$result['data']));
        }
        // Wrong content.
        if ($result['data'] === false) {
            throw new BadContextException('Wrong content!');
        }
    }

}