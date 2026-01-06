<?php

namespace App\Http\Controllers\Hotels;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Apartment\Apartment;
use App\Models\Booking\Booking;
use App\Models\Hotel\Hotel;
use Auth;
use DateTime;
use Redirect;
use Session;

class HotelsController extends Controller
{
    public function rooms($id)
    {

        $getRooms = Apartment::select()->orderBy('id', 'desc')->take(6)
            ->where('hotel_id', $id)->get();


        return view('hotels.rooms', compact('getRooms'));
    }


    public function roomsDetails($id)
    {
        $getRoom = Apartment::find($id);

        if (!$getRoom) {
            abort(404, 'Room not found');
        }

        return view('hotels.roomdetails', compact('getRoom'));
    }

    // public function roomsBooking(Request $request, $id)
    // {

    //     $room = Apartment::find($id);
    //     $hotel = Hotel::find($id);

    //     if (strval(date("n/j/Y")) < strval($request->check_in) and strval(date("n/j/Y")) > strval($request->check_out)) {

    //         ///contine with logic

    //         if ($request->check_in < $request->check_out) {


    //             $datetime1 = new DateTime($request->check_in);
    //             $datetime2 = new DateTime($request->check_out);
    //             $interval = $datetime1->diff($datetime2);
    //             $days = $interval->format('%a'); //now do whatever you like with $days

    //             ///contine with logic
    //             $bookRooms = Booking::create([

    //                 "name" => $request->name,
    //                 "email" => $request->email,
    //                 "phone_number" => $request->phone_number,
    //                 "check_in" => $request->check_in,
    //                 "check_out" => $request->check_out,
    //                 "days" => $days,
    //                 "price" => $days * $room->price,
    //                 "user_id" =>    Auth::user()->id,
    //                 "room_name" => $room->name,
    //                 "hotel_name" => $hotel->name,
    //             ]);

    //             $totalPrice = $days * $room->price;
    //             $price = Session::put('price', $totalPrice);

    //             $gePrice = Session::get($price);

    //             return Redirect::route('hotel.pay');
    //         } else {
    //             return Redirect::route('hotel.rooms.details', $room->id)->with(['error' => 'check out date should be greater than check in date']);
    //             // echo "check out date should be greater than check in date";
    //         }
    //     } else {
    //         return Redirect::route('hotel.rooms.details', $room->id)->with(['error_dates' => 'choose dates in the future, invalid check in or check out dates']);
    //         // echo "choose dates in the future, invalid check in or check out dates";
    //     }
    // }


    public function roomsBooking(Request $request, $id)
    {
        $room = Apartment::find($id);
        $hotel = Hotel::find($id);

        // Validation rules
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'country_code' => 'required|in:+1,+91,+44,+61,+81,+86,+49,+33',
            'phone_number' => 'required|numeric',
            'check_in' => 'required|string',
            'check_out' => 'required|string',
        ]);

        // Phone number length validation based on country code
        $phoneLengths = [
            '+1' => 10,    // USA
            '+91' => 10,   // India
            '+44' => 10,   // UK
            '+61' => 9,    // Australia
            '+81' => 10,   // Japan
            '+86' => 11,   // China
            '+49' => 10,   // Germany
            '+33' => 9     // France
        ];

        $expectedLength = $phoneLengths[$request->country_code] ?? 10;
        if (strlen($request->phone_number) != $expectedLength) {
            return redirect()->back()->withErrors([
                'phone_number' => "Phone number must be {$expectedLength} digits for the selected country code."
            ])->withInput();
        }

        try {
            // CORRECT FORMAT: MM/DD/YYYY (not DD/MM/YYYY)
            $checkIn = DateTime::createFromFormat('m/d/Y', $request->check_in);
            $checkOut = DateTime::createFromFormat('m/d/Y', $request->check_out);

            if (!$checkIn || !$checkOut) {
                return redirect()->back()->with('error', 'Invalid date format. Please use MM/DD/YYYY format.');
            }

            $currentDate = new DateTime();
            $currentDate->setTime(0, 0, 0);
            $checkIn->setTime(0, 0, 0);
            $checkOut->setTime(0, 0, 0);

            // Debug: Uncomment to see dates
            // return redirect()->back()->with('error',
            //     "Current: " . $currentDate->format('m/d/Y') .
            //     " | Check-in: " . $checkIn->format('m/d/Y') .
            //     " | Check-out: " . $checkOut->format('m/d/Y'));

            if ($checkIn < $currentDate) {
                return redirect()->back()->with('error', 'Check-in date cannot be in the past. Please choose future dates.');
            }

            if ($checkOut <= $checkIn) {
                return redirect()->back()->with('error', 'Check-out date must be after check-in date.');
            }

            $interval = $checkIn->diff($checkOut);
            $days = $interval->days;
            $totalPrice = $room->price * $days;

            Booking::create([
                "name" => $request->name,
                "email" => $request->email,
                "country_code" => $request->country_code,
                "phone_number" => $request->phone_number,
                "check_in" => $checkIn->format('Y-m-d'),
                "check_out" => $checkOut->format('Y-m-d'),
                "days" => $days,
                "price" => $totalPrice,
                "user_id" => Auth::user()->id,
                "room_name" => $room->name,
                "hotel_name" => $hotel->name,
            ]);

            // Store price in session (make sure this line exists)
            Session::put('price', number_format($totalPrice, 2, '.', ''));

            return redirect()->route('hotel.pay')->with('success', 'Room booked successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function payWithPayPal()
    {
        // Check if user can access this page
        if (!session()->has('price')) {
            return redirect()->route('home')->with('error', 'Please complete the booking process first.');
        }
        return view('hotels.pay');
    }

    public function success()
    {
        // // Check if user can access this page
        // if (!session()->has('price')) {
        //     return redirect()->route('home')->with('error', 'Please complete the booking process first.');
        // }

        // // Session::forget('price');
        // // return view('hotels.success');

        // // Get price before clearing session
        // $price = session('price');

        // // Clear session after payment success
        // session()->forget('price');

        // return view('hotels.success', compact('price'));


        if (!session()->has('price')) {
        return redirect()->route('home')->with('error', 'Please complete the booking process first.');
    }

    $price = session('price');
    $bookingData = session('booking_data'); // If you have booking data

    // Complete logout process
    Auth::logout();
    session()->flush(); // Clear all session data
    session()->regenerate(); // Generate new session ID

    return view('hotels.success', compact('price', 'bookingData'));
    }
}
