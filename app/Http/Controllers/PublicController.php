<?php
namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Faq;
use App\Models\Page;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function home()
    {
        $announcements = Announcement::published()->latest('published_at')->limit(6)->get();
        return view('public.home', compact('announcements'));
    }

    public function about()
    {
        $page = Page::where('slug', 'about')->first();
        return view('public.about', compact('page'));
    }

    public function contact()
    {
        return view('public.contact');
    }

    public function news()
    {
        $announcements = Announcement::published()->latest('published_at')->paginate(12);
        return view('public.news', compact('announcements'));
    }

    public function newsShow($slug)
    {
        $announcement = Announcement::where('slug', $slug)->where('is_published', true)->firstOrFail();
        return view('public.news-show', compact('announcement'));
    }

    public function faqs()
    {
        $faqs = Faq::active()->get()->groupBy('category');
        return view('public.faqs', compact('faqs'));
    }

    public function page($slug)
    {
        $page = Page::where('slug', $slug)->where('is_published', true)->firstOrFail();
        return view('public.page', compact('page'));
    }
}
