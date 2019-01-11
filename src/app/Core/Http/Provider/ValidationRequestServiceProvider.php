<?php

namespace App\Core\Http\Provider;

use App\Core\Http\Request\ValidatableRequest;
use Cron\CronExpression;
use Illuminate\Contracts\Validation\ValidatesWhenResolved;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ValidationRequestServiceProvider
 *
 * @package App\Core\Http\Provider
 */
class ValidationRequestServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('cron', function ($attribute, $value, $parameters, $validator)
        {
            try {
                CronExpression::factory($value);
            } catch (\InvalidArgumentException $e) {
                return false;
            }

            return true;
        }, 'The :attribute is not a valid cron expression.');

        Validator::extend('empty_when', function ($attribute, $value, $parameters, $validator)
        {
            foreach ($parameters as $parameter) {
                if (!empty(Input::get($parameter))) {
                    return false;
                }
            }

            return true;
        }, 'The :attribute must be empty if other parameter is specified');

        Validator::extend('array_int', function ($attribute, $value, $parameters, $validator)
        {
            if (!\is_array($value)) {
                return false;
            }

            foreach ($value as $v) {
                if (filter_var($v, FILTER_VALIDATE_INT) === false) {
                    return false;
                }
            }

            return true;
        }, 'The :attribute must be array of integers.');

        Validator::extend('array_string', function ($attribute, $value, $parameters, $validator)
        {
            if (!\is_array($value)) {
                return false;
            }

            foreach ($value as $v) {
                if (!\is_string($v)) {
                    return false;
                }
                if (\is_bool($v)) {
                    return false;
                }
            }

            return true;
        }, 'The :attribute must be array of strings.');

        Validator::extend('array_bool', function ($attribute, $values, $parameters, $validator): bool
        {
            if (!\is_array($values)) {
                return false;
            }
            $acceptedValues = ['0', 0, '1', 1, true, false];

            foreach ($values as $value) {
                if (\in_array($value, $acceptedValues, true) === false) {
                    return false;
                }
            }

            return true;
        }, 'The :attribute must be array of boolean.');

        Validator::extend('strict_int', function ($attribute, $value, $parameters, $validator): bool
        {
            if (filter_var($value, FILTER_VALIDATE_INT) === false) {
                return false;
            }

            if (\is_bool($value)) {
                return false;
            }

            return true;
        }, 'The :attribute must be an integer.');

        Validator::extend('gt_than', function ($attribute, $value, $parameters, $validator)
        {
            $validator->addReplacer('gt_than', function ($message, $attribute, $rule, $parameters)
            {
                return str_replace([':other'], $parameters[0], $message);
            });
            $minField = $parameters[0];
            $data = $validator->getData();
            return isset($data[$minField]) ? $value > $data[$minField] : false;
        });

        Validator::extend('gte_than', function ($attribute, $value, $parameters, $validator)
        {
            $validator->addReplacer('gte_than', function ($message, $attribute, $rule, $parameters)
            {
                return str_replace([':other'], $parameters[0], $message);
            });
            $minField = $parameters[0];
            $data = $validator->getData();
            return isset($data[$minField]) ? $value >= $data[$minField] : false;
        });

        Validator::extend('time', function ($attribute, $value, $parameters, $validator)
        {
            $parsed = date_parse_from_format('H:i:s', $value);
            if ($parsed['error_count'] === 0 && $parsed['warning_count'] === 0) {
                return true;
            }

            $parsed = date_parse_from_format('H:i', $value);
            if ($parsed['error_count'] === 0 && $parsed['warning_count'] === 0) {
                return true;
            }

            return false;
        }, 'The :attribute must be in date format [H:i:s] or [H:i].');

        Validator::extend('file_object', function ($attribute, $value, $parameters, $validator)
        {
            if (!is_array($value)) {
                return false;
            }

            return isset($value['name'], $value['content'], $value['type']);
        }, 'The :attribute must be object like this: {"name":"filename.xlsx", "content":"base64_encoded_content==", "type":"mime-type"}');

        Validator::extend('file_object_image', function ($attribute, $value, $parameters, $validator)
        {
            if (!is_array($value)) {
                return false;
            }

            if (!isset($value['name'], $value['content'], $value['type'])) {
                return false;
            }

            return in_array($value['type'], ['image/gif', 'image/jpeg', 'image/png', 'image/bmp']);
        }, 'The :attribute must be image');

        Validator::extend('file_object_pdf', function ($attribute, $value, $parameters, $validator)
        {
            if (!is_array($value)) {
                return false;
            }

            if (!isset($value['name'], $value['content'], $value['type'])) {
                return false;
            }

            return in_array($value['type'], ['application/pdf']);
        }, 'The :attribute must be image');

        $this->configureValidatableRequests();
    }

    /**
     * Configure the form request related services.
     *
     * @return void
     */
    protected function configureValidatableRequests()
    {
        $this->app->afterResolving(ValidatesWhenResolved::class, function (ValidatesWhenResolved $resolved)
        {
            $resolved->validateResolved();
        });

        $this->app->resolving(ValidatableRequest::class, function (ValidatableRequest $request, $app)
        {
            $this->initializeRequest($request, $app['request']);
            $request->setContainer($app);
        });
    }

    /**
     * @param ValidatableRequest $validatableRequest
     * @param Request $current
     */
    protected function initializeRequest(ValidatableRequest $validatableRequest, Request $current)
    {
        $files = $current->files->all();

        $files = is_array($files) ? array_filter($files) : $files;

        $validatableRequest->initialize(
            array_merge($current->query->all(), $current->route()->parameters()), $current->request->all(), $current->attributes->all(),
            $current->cookies->all(), $files, $current->server->all(), $current->getContent()
        );

        if ($session = $current->getSession()) {
//            $validatableRequest->setSession($session);
            $validatableRequest->setLaravelSession($session);
        }

        $validatableRequest->setUserResolver($current->getUserResolver());

        $validatableRequest->setRouteResolver($current->getRouteResolver());
    }
}
