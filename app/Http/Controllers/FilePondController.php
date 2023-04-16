<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FilePondController extends Controller
{
    public function process(Request $request): Response|string
    {
        $file = $request->file('file');

        if (! $file) {
            $filePath = 'files/' . Str::random();

            if (! Storage::put($filePath, '')) {
                return response('', 500);
            }

            return response($filePath, 201);
        }

        return $file->store('files');
    }

    public function chunk(Request $request): Response
    {
        $offset = $request->server('HTTP_UPLOAD_OFFSET');
        $length = (int) $request->server('HTTP_UPLOAD_LENGTH');

        $path = $request->query('patch');

        Storage::put("chunks/$path/$offset.part", $request->getContent());

        $this->mergeChunkFiles($path, $length);

        return response('', 204);
    }

    public function revert(Request $request): Response
    {
        $file = $request->getContent();

        if (Storage::delete($file)) {
            return response('', 204);
        }

        return response('', 500);
    }

    protected function mergeChunkFiles(string $path, int $length): void
    {
        $size = 0;

        $chunks = Storage::files("chunks/$path");

        foreach ($chunks as $file) {
            $size += Storage::size($file);
        }

        if ($size < $length) {
            return;
        }

        usort($chunks, function (string $a, string $b) {
            return (int) basename($a) <=> (int) basename($b);
        });

        $data = '';
        foreach ($chunks as $file) {
            $data .= Storage::get($file);
        }

        Storage::put("$path.csv", $data, ['mimetype' => 'text/csv']);
        Storage::deleteDirectory(dirname("chunks/$path", 2));
    }
}
