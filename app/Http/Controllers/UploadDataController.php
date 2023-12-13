<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class UploadDataController extends Controller
{
    public function index(): View
    {
        return view('upload.upload-index');
    }

    public function uploadData(Request $request): Response
    {
        $validator = Validator::make($request->all(), [
            'fileData' => 'required|file',
            'fileName' => 'required|string',
            'isFirstCall' => [
                'required', 'string', 'regex:/(true|false)/',
            ],
        ], [], [
            'fileData' => 'Uploaded File Data',
            'fileName' => 'File Name',
            'isFirstCall' => 'First Call',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], Response::HTTP_BAD_REQUEST);
        }

        $tmpHandle = fopen($request->file('fileData')->getPathname(), 'rb');
        $tmpBuff = fread($tmpHandle, (1024 * 1024 * 5));

        $finalFilePath = Storage::path('/public/' . $request->input('fileName'));
        if ($request->boolean('isFirstCall') && Storage::exists('/public/' . $request->input('fileName'))) {
            Storage::delete('/public/' . $request->input('fileName'));
            sleep(1);
        }

        $fileHandle = fopen($finalFilePath, 'ab');
        fwrite($fileHandle, $tmpBuff);

        fclose($tmpHandle);
        fclose($fileHandle);
        return response()->json([
            'uploadedFileName' => $request->input('fileName'),
        ], 200);
    }
}
