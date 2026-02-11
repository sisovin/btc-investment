<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Plan;

class HomeController extends Controller
{
    /**
     * Home page
     */
    public function index()
    {
        $plans = Plan::getActive();
        // Show only first 3 plans for preview
        $plans = array_slice($plans, 0, 3);

        // Debug
        error_log('Plans count: ' . count($plans));
        error_log('Plans: ' . json_encode($plans));

        return $this->view('public.home.index', [
            'title' => 'Welcome to BTC Crypto Investment',
            'plans' => $plans
        ]);
    }

    /**
     * About page
     */
    public function about()
    {
        return $this->view('public.about', [
            'title' => 'About Us'
        ]);
    }

    /**
     * Contact page
     */
    public function contact()
    {
        return $this->view('public.contact', [
            'title' => 'Contact Us'
        ]);
    }

    /**
     * Investment plans page
     */
    public function plans()
    {
        $plans = Plan::getActive();

        return $this->view('public.plans', [
            'title' => 'Investment Plans',
            'plans' => $plans
        ]);
    }

    /**
     * FAQs page
     */
    public function faqs()
    {
        return $this->view('public.faqs', [
            'title' => 'Frequently Asked Questions'
        ]);
    }

    /**
     * Services page
     */
    public function services()
    {
        return $this->view('public.services', [
            'title' => 'Our Services'
        ]);
    }

    /**
     * 404 Not Found page
     */
    public function notFound()
    {
        return $this->view('errors.404', [
            'title' => 'Page Not Found'
        ]);
    }
}