<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RouteTest extends TestCase
{
    /** @test */
    public function test_welcome_page_is_accessible()
    {
        $this->get('/')->assertStatus(200);
    }

    /** @test */
    public function test_list_obat_page_is_accessible()
    {
        $this->get('/list_obat')->assertStatus(200);
    }

    /** @test */
    public function test_signa_page_is_accessible()
    {
        $this->get('/signa')->assertStatus(200);
    }

    /** @test */
    public function test_form_pilih_obat_page_is_accessible()
    {
        $this->get('/pilih-obat')->assertStatus(200);
    }

    /** @test */
    public function test_form_non_racikan_page_is_accessible()
    {
        $this->get('/beri-obat')->assertStatus(200);
    }

    /** @test */
    public function test_transaksi_obat_page_is_accessible()
    {
        $this->get('/transaksi-obat')->assertStatus(200);
    }

    /** @test */
    public function test_racikan_buat_page_is_accessible()
    {
        $this->get('/racikan/buat')->assertStatus(200);
    }

    /** @test */
    public function test_racikan_list_page_is_accessible()
    {
        $this->get('/racikan')->assertStatus(200);
    }

    /** @test */
    public function test_checkout_history_page_is_accessible()
    {
        $this->get('/obat/checkout/history')->assertStatus(200);
    }

    /** @test */
    public function test_checkout_nonracikan_history_page_is_accessible()
    {
        $this->get('/checkout/nonracikan/history')->assertStatus(200);
    }

    /** @test */
    public function test_ajax_obat_search_is_accessible()
    {
        $this->get('/ajax/obat-search')->assertStatus(200);
    }
}
