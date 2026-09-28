<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hotel\Hotel;
use App\Models\Apartment\Apartment;

use App\Models\Contact;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $hotels = Hotel::select()->orderBy('id', 'desc')->take(3)->get();
        $rooms = Apartment::select()->orderBy('id', 'desc')->take(4)->get();
        
        return view('home', compact('hotels', 'rooms'));
    }

    public function about(){
        return view('pages.about');
    }
    
    public function services(){
        return view('pages.services');
    }

    public function contact(){
        return view('pages.contact');
    }

    public function contactSubmit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        Contact::create($validated);

        return redirect()->back()->with('success', 'Your message was sent successfully! Thank you for contacting us.');
    }
}
