<?php

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class RoutesTest extends TestCase
{
    /**
     * A route must return 200 and render its expected heading.
     */
    #[DataProvider('routes')]
    public function test_route_returns_200_and_renders_heading(string $uri, string $heading): void
    {
        $response = $this->get($uri);

        $response->assertStatus(200);
        $response->assertSee($heading);
    }

    public static function routes(): array
    {
        return [
            ['/', 'Dashboard'],
            ['/products', 'Product Catalog'],
            ['/staff', 'Staff management'],
            ['/pos', 'Point of sale terminal'],
            ['/reports', 'Reports'],
            ['/settings', 'Settings'],
            ['/legal/terms', 'Terms of Service'],
            ['/legal/privacy', 'Privacy Policy'],
        ];
    }

    /**
     * Every page must include the main layout scaffolding.
     */
    public function test_layout_contains_navbar_and_sidebar(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('RetailPulse');
        $response->assertSee('main-content');
    }

    /**
     * Staff route must render staff data, not product data.
     */
    public function test_staff_route_shows_staff_content(): void
    {
        $response = $this->get('/staff');

        $response->assertStatus(200);
        $response->assertSee('Staff management');
        $response->assertSee('staff-search');
    }
}
