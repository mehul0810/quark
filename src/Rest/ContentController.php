<?php

declare(strict_types=1);

namespace Quark\Rest;

final class ContentController
{
    public function register_routes(): void
    {
        // Internal use via MCP only
    }

    public function create_post(array $data): array
    {
        $post_id = wp_insert_post([
            'post_title'   => $data['title'] ?? '',
            'post_content' => $data['content'] ?? '',
            'post_status'  => $data['status'] ?? 'draft',
        ]);

        return [
            'post_id' => $post_id,
        ];
    }

    public function update_post(array $data): array
    {
        $post_id = $data['id'] ?? 0;

        wp_update_post([
            'ID'           => $post_id,
            'post_title'   => $data['title'] ?? '',
            'post_content' => $data['content'] ?? '',
        ]);

        return [
            'post_id' => $post_id,
        ];
    }

    public function audit_posts(): array
    {
        $posts = get_posts([
            'numberposts' => 5,
        ]);

        return array_map(function ($post) {
            return [
                'id' => $post->ID,
                'title' => $post->post_title,
                'status' => $post->post_status,
            ];
        }, $posts);
    }
}
