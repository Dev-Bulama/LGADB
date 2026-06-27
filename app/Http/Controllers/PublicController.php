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

    public function contactSubmit(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:150',
            'email'   => 'required|email|max:255',
            'phone'   => 'nullable|string|max:20',
            'subject' => 'required|string|max:100',
            'message' => 'required|string|min:10|max:5000',
        ]);

        // Store as a simple notification or log entry for now.
        // In production, wire to a ContactMessage model or dispatch a mail notification.
        \Illuminate\Support\Facades\Log::info('Contact form submission', [
            'name'    => $request->name,
            'email'   => $request->email,
            'subject' => $request->subject,
        ]);

        return redirect()->route('contact')
            ->with('success', 'Thank you for your message. We will get back to you within 1-2 business days.');
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
