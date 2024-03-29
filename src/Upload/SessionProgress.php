<?php

namespace Laminas\ProgressBar\Upload;

use Laminas\ProgressBar\Exception;

use function ini_get;
use function is_array;
use function time;

/**
 * Progress Bar Upload Handler for PHP 5.4+ Session Upload Progress handling
 */
class SessionProgress extends AbstractUploadHandler
{
    /**
     * @param  string $id
     * @return array|bool
     * @throws Exception\PhpEnvironmentException
     */
    protected function getUploadProgress($id)
    {
        if (! $this->isSessionUploadProgressAvailable()) {
            throw new Exception\PhpEnvironmentException(
                'Session Upload Progress is not available'
            );
        }

        $sessionKey = ini_get('session.upload_progress.prefix') . $id;
        $uploadInfo = $_SESSION[$sessionKey] ?? null;
        if (! is_array($uploadInfo)) {
            return false;
        }

        $status            = [
            'total'   => 0,
            'current' => 0,
            'rate'    => 0,
            'message' => '',
            'done'    => false,
        ];
        $status            = $uploadInfo + $status;
        $status['total']   = $status['content_length'];
        $status['current'] = $status['bytes_processed'];

        $time           = time() - $status['start_time'];
        $status['rate'] = $time > 0 ? $status['bytes_processed'] / $time : 0;

        if (! empty($status['cancel_upload'])) {
            $status['done']    = true;
            $status['message'] = 'The upload has been canceled';
        }

        return $status;
    }

    /**
     * Checks if Session Upload Progress is available
     *
     * @return bool
     */
    public function isSessionUploadProgressAvailable()
    {
        return (bool) ini_get('session.upload_progress.enabled');
    }
}
