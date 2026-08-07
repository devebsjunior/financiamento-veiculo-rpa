<?php

return [
	'default' => 'default',
	'documentations' => [
		'default' => [
			'api' => [
				'title' => 'L5 Swagger UI',
			],
			'routes' => [
				'api' => 'api/documentation',
			],
			'paths' => [
				'use_absolute_path' => env('L5_SWAGGER_USE_ABSOLUTE_PATH', true),
				'swagger_ui_assets_path' => env('L5_SWAGGER_UI_ASSETS_PATH', 'vendor/swagger-api/swagger-ui/dist/'),
				'docs_json' => 'api-docs.json',
				'docs_yaml' => 'api-docs.yaml',
				'format_to_use_for_docs' => env('L5_FORMAT_TO_USE_FOR_DOCS', 'json'),
				'annotations' => [
					base_path('app'),
				],
			],
		],
	],
	'defaults' => [
		'servers' => [
			[
				'url' => env('APP_URL'),
				'description' => 'Servidor atual',
			],
		],
		'routes' => [
			'docs' => 'docs',
			'oauth2_callback' => 'api/oauth2-callback',
			'middleware' => [
				'api' => [],
				'asset' => [],
				'docs' => [],
				'oauth2_callback' => [],
			],
			'group_options' => [],
		],
		'paths' => [
			'docs' => storage_path('api-docs'),
			'views' => base_path('resources/views/vendor/l5-swagger'),
			'base' => env('L5_SWAGGER_BASE_PATH', null),
			'excludes' => [],
		],
		'scanOptions' => [
			'generator_factory' => null,
			'default_processors_configuration' => [],
			'analyser' => null,
			'analysis' => null,
			'processors' => [
			],
			'pattern' => null,
			'exclude' => [],
			'open_api_spec_version' => env('L5_SWAGGER_OPEN_API_SPEC_VERSION', \L5Swagger\Generator::OPEN_API_DEFAULT_SPEC_VERSION),
		],
		'securityDefinitions' => [
			'securitySchemes' => [],
			'security' => [
				[],
			],
		],
		'generate_always' => env('L5_SWAGGER_GENERATE_ALWAYS', false),
		'generate_yaml_copy' => env('L5_SWAGGER_GENERATE_YAML_COPY', false),
		'proxy' => false,
		'additional_config_url' => null,
		'operations_sort' => env('L5_SWAGGER_OPERATIONS_SORT', null),
		'validator_url' => null,
		'ui' => [
			'display' => [
				'dark_mode' => env('L5_SWAGGER_UI_DARK_MODE', false),
				/*
                 * Controls the default expansion setting for the operations and tags. It can be :
                 * 'list' (expands only the tags),
                 * 'full' (expands the tags and operations),
                 * 'none' (expands nothing).
                 */
				'doc_expansion' => env('L5_SWAGGER_UI_DOC_EXPANSION', 'none'),

				/**
				 * If set, enables filtering. The top bar will show an edit box that
				 * you can use to filter the tagged operations that are shown. Can be
				 * Boolean to enable or disable, or a string, in which case filtering
				 * will be enabled using that string as the filter expression. Filtering
				 * is case-sensitive matching the filter expression anywhere inside
				 * the tag.
				 */
				'filter' => env('L5_SWAGGER_UI_FILTERS', true), // true | false
			],

			'authorization' => [
				/*
                 * If set to true, it persists authorization data, and it would not be lost on browser close/refresh
                 */
				'persist_authorization' => env('L5_SWAGGER_UI_PERSIST_AUTHORIZATION', false),

				'oauth2' => [
					/*
                     * If set to true, adds PKCE to AuthorizationCodeGrant flow
                     */
					'use_pkce_with_authorization_code_grant' => false,
				],
			],
		],
		/*
         * Constants which can be used in annotations
         */
		'constants' => [
			'L5_SWAGGER_CONST_HOST' => env('L5_SWAGGER_CONST_HOST', 'http://my-default-host.com'),
		],
	],
];
