<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(25);
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'profile_pic' => 'required',
            'type' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]{6,}$/',
            'confirm_password' => 'required|same:password',
        ]);

        if($request->hasFile('profile_pic'))
        {
            $profile_pic = $request->profile_pic;
            $path_pic = $profile_pic->store('images', 'public');
        }


        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->profile_pic = $path_pic;
        $user->type = $request->type;
        $user->password = Hash::make($request->password);
        $user->save();

        $center_url = env('CENTER_URL');
        $qrCode = QrCode::generate($center_url . '/save-qr-data/' . $user->id);
        $user->qr_code = $qrCode;
        $user->save();

        if($user){
            return redirect()->route('users.index')->with('status', 'User registered successfully.');
        }
        return redirect()->route('users.index')->with('delete', 'User registration faild, try again.');
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email' . $user->id,
            'type' => 'required',
            'status' => 'required',
        ]);

        if($request->hasFile('updatepic'))
        {
            $profile_pic = $request->updatepic;
            $path_pic = $profile_pic->store('images', 'public');

            if($user->profile_pic != null){
                $profile_pic = $user->profile_pic;
                Storage::disk('public')->delete($profile_pic);
            }
        }

        if($request->hasFile('updatepic'))
        {
            $user->profile_pic = $path_pic;
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->type = $request->type;
        $user->status = $request->status;
        $user->save();

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(Request $request)
    {
        $user = User::find($request->data_id);
        if($user)
        {
            if($user->profile_pic != null){
                $profile_pic = $user->profile_pic;
                Storage::disk('public')->delete($profile_pic);
            }

            $user->delete();
            return redirect()->route('users.index')->with('delete', 'User deleted successfully.');
        }
        else
        {
            return redirect()->route('users.index')->with('delete', 'No user found!.');
        }    
    }

    public function pdf($id)
    {
        $user = User::find($id);
        if ($user && $user->qr_code) {
            $qrCodeSvg = $user->qr_code;
            $qrCodeBase64 = 'data:image/svg+xml;base64,' . base64_encode($qrCodeSvg);
        } else {
            $qrCodeBase64 = null;
        }
        $pdf = Pdf::loadView('users.user_pdf', compact('user', 'qrCodeBase64'));
        return $pdf->stream('user_'. $id .'.pdf');
    }

    public function emailcheck(Request $request)
    {
        $email = $request->input("email");
        $success = false;
        $user = User::where('email', $email)->first();
        if($user == null){
            $success = true;
        }else{
            $success = false;
        }

        return response()->json([
            "success" => $success
        ]);
    }
}