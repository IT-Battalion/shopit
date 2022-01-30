<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageUploader extends Controller
{
    protected $tmpPath = 'product' . DIRECTORY_SEPARATOR . 'images';

    /**
     * Asynchronously uploading files with FilePond is called processing.
     * In short, FilePond sends a file to the server and expects the server
     * to return a unique file id. This unique id is then used to revert
     * uploads or restore earlier uploads.
     *
     * The upload process described over time:
     *
     * 1. FilePond uploads file my-file.jpg as multipart/form-data using
     *      a POST request
     * 2. server saves file to unique location tmp/12345/my-file.jpg
     * 3. server returns unique location id 12345 in text/plain response
     * 4. FilePond stores unique id 12345 in a hidden input field
     * 5. client submits the FilePond parent form containing the hidden
     *      input field with the unique id
     * 6. server uses the unique id to move tmp/12345/my-file.jpg to
     *      its final location and remove the tmp/12345 folder
     * 7. Process chunks
     *
     * To process files in chunks set chunkUploads to true.
     *
     * FilePond will then slice up files bigger than the set
     * chunkSize into parts. Files smaller than the chunkSize
     * will be posted to the process end point. If you want
     * to force all files to be posted to the chunk end point
     * set chunkForce to true.
     *
     * Custom headers used in requests
     *
     * Header  |    Description
     * Upload-Length  |    The total size of the file being transferred
     * Upload-Name  |    The name of the file being transferred
     * Upload-Offset  |     The offset of the chunk being transferred
     * Content-Type  |    The content type of a patch request, set to 'application/offset+octet-stream'
     *
     * In short:
     *
     * - FilePond will send a POST request (without file) to start a
     *      chunked transfer, expecting to receive a unique transfer
     *      id in the response body, it'll add the Upload-Length header
     *      to this request.
     * - FilePond will send a PATCH request to push a chunk to the
     *      server. Each of these requests is accompanied by a
     *      Content-Type, Upload-Offset, Upload-Name, and
     *      Upload-Length header.
     * - FilePond will send a HEAD request to determine which chunks
     *      have already been uploaded, expecting the file offset
     *      of the next expected chunk in the Upload-Offset response
     *      header.
     *
     * In detail:
     *
     * 1. FilePond requests a transfer id from the server, a unique
     *      location to identify this transfer with. It does this
     *      using a POST request. The request is accompanied by the
     *      metadata and the total file upload size set to the
     *      Upload-Length header.
     * 2. server create unique location tmp/12345/
     * 3. server returns unique location id 12345 in text/plain response
     * 4. FilePond stores unique id 12345 in file item
     * 5. FilePond sends first chunk using a PATCH request adding the
     *      unique id 12345 in the URL, each PATCH request is
     *      accompanied by a Upload-Offset, Upload-Length, and Upload-Name
     *      header. The Upload-Offset header contains the byte offset of
     *      the chunk, the Upload-Length header contains the total file
     *      size, the Upload-Name header contains the file name.
     * 6. FilePond sends chunks until all chunks have been uploaded succesfully.
     * 7. server creates the file if all chunks have been received succesfully.
     * 8. FilePond stores the unique id 12345 as the server id of this file.
     * 9. client submits the FilePond parent form containing the hidden
     *      input field with the unique id
     * 10. server uses the unique id to move tmp/12345/my-file.jpg to
     *      its final location and remove the tmp/12345 folder
     *
     * If one of the chunks fails to upload after the set amount of
     * retries in chunkRetryDelays the user has the option to retry
     * the upload.
     *
     * 1. FilePond As FilePond remembers the previous transfer id the
     *      process now starts of with a HEAD request accompanied by
     *      the transfer id (12345) in the URL.
     * 2. server responds with Upload-Offset set to the next expected
     *      chunk offset in bytes.
     * 3. FilePond marks all chunks with lower offsets as complete
     *      and continues with uploading the chunk at the requested offset.
     *
     * Everything continues like normal.
     * @param Request $request
     * @return Application|ResponseFactory|Response
     */
    public function process(Request $request): Response|Application|ResponseFactory
    {
        $file = $request->file('uploadImages');
        if (!isset($file)) {
            abort(422);
        }
        $file = is_array($file) ? $file[0] : $file;
        if (!($tmpFile = $file->storeAs($this->tmpPath . DIRECTORY_SEPARATOR . now()->timestamp, $file->getClientOriginalName(), 'local'))) {
            abort(500);
        }

        $response = Crypt::encryptString(Storage::disk('local')->path($tmpFile));
        return response($response, 200);
    }

    /**
     * There's one way the client can deviate from the previous
     * path and that is by reverting the upload. Let's go back to step
     * five and switch to this alternate reality.
     *
     * FilePond sends DELETE request with 12345 as body by tapping the undo button
     * server removes temporary folder matching the supplied id tmp/12345
     * and returns an empty response
     *
     * This is another reason why FilePond uses unique ids. If
     * we're going to give the client the power to influence
     * the server file system that power should be very minimal.
     * @param Request $request
     * @return Application|Response|ResponseFactory
     */
    public function revert(Request $request): Response|Application|ResponseFactory
    {
        $id = $request->getContent();
        if (!trim($id)) {
            abort(422, 'File not found');
        }

        $filePath = Crypt::decryptString($id);
        $basePath = Storage::disk('local')->path($this->tmpPath);
        if (!Str::startsWith($filePath, $basePath)) {
            abort(501, 'Invalid File Path');
        }
        if (Storage::disk('local')->delete($filePath)) {
            return response('', 200);
        }
        abort(500);
    }
}
