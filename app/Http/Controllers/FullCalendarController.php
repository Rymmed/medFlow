<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FullCalendarController extends Controller
{
    public function index() : View
    {
        return view('fullcalendar.index');
    }
    public function myCalendar()
    {
        $data['header_title'] = "Mon Calendrier";
        return view('doctor.myCalendar', $data);
    }

}
