<?php

declare(strict_types=1);

namespace Quark;

final class Plugin
{
    private static ?self $instance = null;

    public static function instance(): self
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function boot(): void
    {
        // Bootstrap core components.
    }
}
