<?php

declare(strict_types=1);

namespace Quark\Auth;

final class Access
{
    private const OPTION = 'quark_user_tokens';

    public function issue(int $user_id): string
    {
        $value = wp_generate_uuid4() . wp_generate_uuid4();
        $items = get_option(self::OPTION, []);
        $items[$value] = [
            'user_id' => $user_id,
            'expires' => time() + HOUR_IN_SECONDS,
        ];
        update_option(self::OPTION, $items, false);

        return $value;
    }

    public function user_id(string $value): int
    {
        $items = get_option(self::OPTION, []);

        if (! is_array($items) || ! isset($items[$value])) {
            return 0;
        }

        if ((int) $items[$value]['expires'] < time()) {
            unset($items[$value]);
            update_option(self::OPTION, $items, false);
            return 0;
        }

        return (int) $items[$value]['user_id'];
    }
}
