<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Display a listing of the resource.
     * @return View|Application|Factory
     */
    public function index(): View|Application|Factory
    {
        $data = [
            'title' => __('Welcome'),
            'description' => __('
                Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,
                when an unknown printer took a galley of type and scrambled it to make a type specimen book.
                It has survived not only five centuries, but also the leap into electronic typesetting,
                remaining essentially unchanged. It was popularised in the 1960s with the release of
                Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing
                software like Aldus PageMaker including versions of Lorem Ipsum.
            '),
        ];

        return view('pages.guest', compact('data'));
    }

    /**
     * Display a listing of the resource.
     * @return View|Application|Factory
     */
    public function privacyPolicy(): View|Application|Factory
    {
        $data = [
            'title' => __('Privacy Policy'),
            'description' => __('
                Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,
                when an unknown printer took a galley of type and scrambled it to make a type specimen book.
                It has survived not only five centuries, but also the leap into electronic typesetting,
                remaining essentially unchanged. It was popularised in the 1960s with the release of
                Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing
                software like Aldus PageMaker including versions of Lorem Ipsum.
            '),
        ];

        return view('pages.privacy-policy', compact('data'));
    }

    /**
     * Display a listing of the resource.
     * @return View|Application|Factory
     */
    public function termsAndConditions(): View|Application|Factory
    {
        $data = [
            'title' => __('Terms and conditions'),
            'description' => __('
                Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,
                when an unknown printer took a galley of type and scrambled it to make a type specimen book.
                It has survived not only five centuries, but also the leap into electronic typesetting,
                remaining essentially unchanged. It was popularised in the 1960s with the release of
                Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing
                software like Aldus PageMaker including versions of Lorem Ipsum.
            '),
        ];

        return view('pages.terms-and-conditions', compact('data'));
    }

    /**
     * Display a listing of the resource.
     * @return View|Application|Factory
     */
    public function dataProtection(): View|Application|Factory
    {
        $data = [
            'title' => __('Data protection'),
            'description' => __('
                Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,
                when an unknown printer took a galley of type and scrambled it to make a type specimen book.
                It has survived not only five centuries, but also the leap into electronic typesetting,
                remaining essentially unchanged. It was popularised in the 1960s with the release of
                Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing
                software like Aldus PageMaker including versions of Lorem Ipsum.
            '),
        ];

        return view('pages.data-protection', compact('data'));
    }

    /**
     * Display a listing of the resource.
     * @return View|Application|Factory
     */
    public function renderContentPage(string $contentSlug): View|Application|Factory
    {
        dd('renderContentPage', $contentSlug);
        // $data = [
        //     'title' => __('Data protection'),
        //     'description' => __('
        //         Lorem Ipsum is simply dummy text of the printing and typesetting industry.
        //         Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,
        //         when an unknown printer took a galley of type and scrambled it to make a type specimen book.
        //         It has survived not only five centuries, but also the leap into electronic typesetting,
        //         remaining essentially unchanged. It was popularised in the 1960s with the release of
        //         Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing
        //         software like Aldus PageMaker including versions of Lorem Ipsum.
        //     '),
        // ];

        // return view('pages.data-protection', compact('data'));
    }
}
