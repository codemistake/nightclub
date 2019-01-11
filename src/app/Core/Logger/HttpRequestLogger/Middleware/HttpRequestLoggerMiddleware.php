<?php

namespace App\Core\Logger\HttpRequestLogger\Middleware;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class HttpRequestLoggerMiddleware
 * @package App\Core\Logger\HttpRequestLogger\Middleware
 */
class HttpRequestLoggerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, \Closure $next)
    {
        return $next($request);
    }

    /**
     * @param Request $request
     * @param Response $response
     */
    public function terminate($request, $response)
    {
        // Логгируем только запросы, которые прописаны в routes
        if ($response->getStatusCode() === 404) {
            return;
        }

        $now = current_time();

        $text = $now->format('d.m.Y H:i:s.u') . PHP_EOL;
        $text .= 'Time: ' . number_format(1000 * (microtime(true) - LARAVEL_START), 3, '.', '') . ' ms' . PHP_EOL;

        $text .= PHP_EOL . str_repeat('=', 15) . ' REQUEST ' . str_repeat('=', 16). PHP_EOL . PHP_EOL;

        $text .= $request->getMethod() . ' ' . $request->url() . PHP_EOL;
        foreach ($request->headers->getIterator() as $k => $v) {
            $text .= $k . ': ' . (is_array($v) ? implode(',', $v) : $v) . PHP_EOL;
        }

        // Вырезаем содержимое файлов в формате base64
        $input = [];
        foreach ($request->input() as $key => $value) {
            if (is_array($value) && isset($value['name'], $value['content'], $value['type']) && $value['content'] !== "" && $value['content'] !== null) {
                $value['content'] = '<file-content>';
            }
            $input[$key] = $value;
        }
        $text .= json_encode($input) . PHP_EOL;

        /** @var \Illuminate\Http\UploadedFile $file */
        foreach ($request->allFiles() as $file) {
            $text .= json_encode([
                    'originalName' => $file->getClientOriginalName(),
                    'mimeType' => $file->getClientMimeType(),
                    'size' => $file->getClientSize()
                ]) . PHP_EOL;
        }

        $text .= PHP_EOL . PHP_EOL . str_repeat('=', 15) . ' RESPONSE ' . str_repeat('=', 15). PHP_EOL . PHP_EOL;

        foreach ($response->headers->getIterator() as $k => $v) {
            $text .= $k . ': ' . (is_array($v) ? implode(',', $v) : $v) . PHP_EOL;
        }
        $text .= $response->getContent() . PHP_EOL;


        /** @var Filesystem $filesystem */
        $filesystem = app('files');

        $pathParts = explode('-', $now->format('Y-m-d'));
        $pathParts[] = 'requests';
        $pathParts[] = $request->path();

        $dir = logs_path() . DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, $pathParts);
        if (!$filesystem->exists($dir)) {
            $oldUmask = umask();
            @umask(0);
            @$filesystem->makeDirectory($dir, 0775, true);
            @umask($oldUmask);
        }

        $path = $dir . DIRECTORY_SEPARATOR . $now->format('Y_m_d_H_i_s_u') . '.log';

        if (!$filesystem->exists($path)) {
            $filesystem->put($path, '');
            @chmod($path, 0775);
        }

        $filesystem->put($path, $text);
    }
}
