<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Mail\OrderMail;
use App\Order;
use App\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable if user is a manager return all customers orders.
     */
    public function index()
    {
        $currentUser = Auth::user();
        if ($currentUser->hasRole('manager')) {
            $orders = Order::all();
            return view('home')->with('orders', $orders);
        }
        return view('home');
    }

    /**
     * Save a customer order.
     *
     * @param OrderRequest $request
     * @return \Illuminate\View\View home view
     */
    public function form(OrderRequest $request)
    {
        $user = Auth::user();
        $validated = $request->validated();
        $sended = Order::whereDate('created_at', Carbon::today())
            ->where('user_id', $user->id)
            ->first();
        if ($validated && empty($sended)) {
            $order = new Order();
            $order->subject = $request->input('subject');
            $order->message = $request->input('message');
            $order->file_link = $request->input('file_link');
            $order->user()->associate($user);
            $order->save();

            $this->sendMail($order, $user);
        } else {
            return view('home')->withErrors(['repetition' => ' You sent the form yet!']);
        }
        return view('home')->with('successfully', 'Successfully sent');
    }

    /**
     * Send mail
     *
     * @param Order $order
     * @param User $user
     */
    public function sendMail(Order $order, User $user)
    {
        Mail::to('exemple@gmail.com')->queue(new OrderMail($order, $user));
    }
}
