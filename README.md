## Support us

At Opscale, we’re passionate about contributing to the open-source community by providing solutions that help businesses scale efficiently. If you’ve found our tools helpful, here are a few ways you can show your support:

⭐ **Star this repository** to help others discover our work and be part of our growing community. Every star makes a difference!

💬 **Share your experience** by leaving a review on [Trustpilot](https://www.trustpilot.com/review/opscale.co) or sharing your thoughts on social media. Your feedback helps us improve and grow!

📧 **Send us feedback** on what we can improve at [feedback@opscale.co](mailto:feedback@opscale.co). We value your input to make our tools even better for everyone.

🙏 **Get involved** by actively contributing to our open-source repositories. Your participation benefits the entire community and helps push the boundaries of what’s possible.

💼 **Hire us** if you need custom dashboards, admin panels, internal tools or MVPs tailored to your business. With our expertise, we can help you systematize operations or enhance your existing product. Contact us at hire@opscale.co to discuss your project needs.

Thanks for helping Opscale continue to scale! 🚀



## Description

Nova Mailbox captures and processes inbound emails in your Nova app. It stores emails and attachments, and supports extraction rules to automatically extract structured data from incoming messages.

![Demo](https://raw.githubusercontent.com/opscale-co/nova-mailbox/refs/heads/main/screenshots/nova-mailbox.gif)

## Installation

[![Latest Version on Packagist](https://img.shields.io/packagist/v/opscale-co/nova-mailbox.svg?style=flat-square)](https://packagist.org/packages/opscale-co/nova-mailbox)

You can install the package in to a Laravel app that uses [Nova](https://nova.laravel.com) via composer:

```bash
composer require opscale-co/nova-mailbox
```

Run the install command:

```bash
php artisan mailbox:install
```

Register the tool in the `tools` method of your `NovaServiceProvider`:

```php
// in app/Providers/NovaServiceProvider.php

public function tools()
{
    return [
        new \Opscale\NovaMailbox\Tool(),
    ];
}
```

## Configuration

The configuration file is published at `config/mailbox.php`:

```php
return [
    // Storage path for emails and attachments (relative to disk)
    'path' => env('MAILBOX_STORAGE_PATH', 'mailbox'),

    // Extraction rules: classes implementing the Extractor interface
    'extraction_rules' => [
        // \App\Extractors\MyExtractor::class,
    ],
];
```

## Templates

Extractions use templates from [Nova Dynamic Resources](https://github.com/opscale-co/nova-dynamic-resources) to define their fields. Refer to the composition example for setting up templates.

## Extraction Rules

You can create custom extraction rules by implementing the `Extractor` interface. Each rule defines when it should match an inbound email and how to process it.

```php
use BeyondCode\Mailbox\InboundEmail;
use Opscale\NovaMailbox\Contracts\Extractor;
use Opscale\NovaMailbox\Models\Email;
use Opscale\NovaMailbox\Models\Extraction;

class MyExtractor implements Extractor
{
    public function matches(InboundEmail $email): bool
    {
        // Return true if this rule should process the email
    }

    public function process(InboundEmail $email): ?Extraction
    {
        // Extract data and create an Extraction record
        // Use $email->id() to find the stored Email record:
        $record = Email::where('message_id', $email->id())->firstOrFail();

        return Extraction::create([
            'email_id' => $record->id,
            'template_id' => $template->id,
            'status' => ExtractionStatus::Completed,
            'data' => [
                // extracted fields
            ],
        ]);
    }
}
```

Register your extractor in `config/mailbox.php`:

```php
'extraction_rules' => [
    \App\Extractors\MyExtractor::class,
],
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](https://github.com/opscale-co/.github/blob/main/CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email development@opscale.co instead of using the issue tracker.

## Credits

- [Opscale](https://github.com/opscale-co)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.