# File Upload Handlers

## Introduction

`Laminas\ProgressBar\Upload` provides handlers that can give you the actual state of a file upload in
progress. To use this feature you need to choose one of the upload progress handlers (APC,
uploadprogress, or Session) and ensure that your server setup has the appropriate extension or
feature enabled. All of the progress handlers use the same interface.

When uploading a file with a form POST, you must also include the progress identifier in a hidden
input. The \[File Upload Progress View Helpers\](laminas.form.view.helper.file) provide a convenient
way to add the hidden input based on your handler type.

## Methods of Reporting Progress

There are two methods for reporting the current upload progress status. By either using a
ProgressBar Adapter, or by using the returned status array manually.

### Using a ProgressBar Adapter

A `Laminas\ProgressBar` adapter can be used to display upload progress to your users.

```php
$adapter  = new \Laminas\ProgressBar\Adapter\JsPush();
$progress = new \Laminas\ProgressBar\Upload\SessionProgress();

$filter   = new \Laminas\I18n\Filter\Alnum(false, 'en_US');
$id       = $filter->filter($_GET['id']);

$status   = null;
while (empty($status['done'])) {
    $status = $progress->getProgress($id);
}
```

Each time the `getProgress()` method is called, the ProgressBar adapter will be updated.

### Using the Status Array

You can also work manually with `getProgress()` without using a `Laminas\ProgressBar` adapter.

The `getProgress()` will return you an array with several keys. They will sometimes differ based on
the specific Upload handler used, but the following keys are always standard:

- `total`: The total file size of the uploaded file(s) in bytes as integer.
- `current`: The current uploaded file size in bytes as integer.
- `rate`: The average upload speed in bytes per second as integer.
- `done`: Returns `TRUE` when the upload is finished and `FALSE` otherwise.
- `message`: A status message. Either the progress as text in the form "10kB / 200kB", or a helpful
error message in the case of a problem. Problems such as: no upload in progress, failure while
retrieving the data for the progress, or that the upload has been canceled.

All other returned keys are provided directly from the specific handler.

An example of using the status array manually:

```php
// In a Controller...

public function sessionProgressAction()
{
    $id = $this->params()->fromQuery('id', null);
    $progress = new \Laminas\ProgressBar\Upload\SessionProgress();
    return new \Laminas\View\Model\JsonModel($progress->getProgress($id));
}

// Returns JSON
//{
//    "total"    : 204800,
//    "current"  : 10240,
//    "rate"     : 1024,
//    "message"  : "10kB / 200kB",
//    "done"     : false
//}
```

## Standard Handlers

`Laminas\ProgressBar\Upload` comes with the following three upload handlers:

> -   \[Laminas\\Progressbar\\Upload\\ApcProgress\](laminas.progress-bar.upload.apc-progress)
- \[Laminas\\ProgressBar\\Upload\\SessionProgress\](laminas.progress-bar.upload.session-progress)
- \[Laminas\\Progressbar\\Upload\\UploadProgress\](laminas.progress-bar.upload.upload-progress)

orphan  

### APC Progress Handler

The `Laminas\ProgressBar\Upload\ApcProgress` handler uses the [APC
extension](http://php.net/manual/en/book.apc.php) for tracking upload progress.

> ## Note
The [APC extension](http://php.net/manual/en/book.apc.php) is required.

This handler is best used with the
\[FormFileApcProgress\](laminas.form.view.helper.form-file-apc-progress) view helper, to provide a
hidden element with the upload progress identifier.

orphan  

### Session Progress Handler

The `Laminas\ProgressBar\Upload\SessionProgress` handler uses the PHP 5.4 [Session
Progress](http://php.net/manual/en/session.upload-progress.php) feature for tracking upload
progress.

> ## Note
PHP 5.4 is required.

This handler is best used with the
\[FormFileSessionProgress\](laminas.form.view.helper.form-file-session-progress) view helper, to
provide a hidden element with the upload progress identifier.

orphan  

### Upload Progress Handler

The `Laminas\ProgressBar\Upload\UploadProgress` handler uses the [PECL Uploadprogress
extension](http://pecl.php.net/package/uploadprogress) for tracking upload progress.

> ## Note
The [PECL Uploadprogress extension](http://pecl.php.net/package/uploadprogress) is required.

This handler is best used with the
\[FormFileUploadProgress\](laminas.form.view.helper.form-file-upload-progress) view helper, to provide
a hidden element with the upload progress identifier.
