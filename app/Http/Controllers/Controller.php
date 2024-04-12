<?php

namespace App\Http\Controllers;
use App\User;
use App\Slides;
use Illuminate\Support\Facades\Auth; // Add this line
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
// Import Validator from the correct namespace
use Illuminate\Support\Facades\Validator;


use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        // Apply the 'auth' middleware to the dashboard and users methods
        $this->middleware('auth')->only(['dashboard', 'users']);
    }

    public function welcome(){
        $Slides = Slides::all();
        return view('welcome', ['slides' => $Slides]);
    }


    public function login(){
        if (Auth::check()) {
            return redirect(route('admin.dashboard'));
        }
        
        return view('login');
    }

    public function register(){
        if (Auth::check()) {
            return redirect(route('admin.dashboard'));
        }
        
        return view('register');
    }


    public function loginPost(Request $request){

        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ], [
            'email.required' => 'Please enter your email address.',
            'password.required' => 'Please enter your password.'
        ]);
    
        $credentials = $request->only('email','password');
    
        if(Auth::attempt($credentials)){
            return redirect()->intended(route('admin.dashboard'));
        }
    
        // If authentication failed, return back with error message and input data
        return redirect()->back()->with('status', 'Login Details are not valid')->withInput($request->except('_token'));
    }
    
    
    

    public function registrationPost(Request $request){

        $request->validate([
            "first_name" => "required",
            "last_name" => "required",
            "middle_name" => "required",
            'email' => 'required|email|unique:users', // Add the table name 'users'
            "password" => "required"
        ]);

     

        $data['first_name'] = $request->first_name;
        $data['last_name'] = $request->last_name;
        $data['middle_name'] = $request->middle_name;
        $data['email'] = $request->email;
        $data['password'] = Hash::make($request->password);

        $user = User::create($data);



        if(!$user){
            return redirect(route('register'))->with('status', 'Register Details are not valid');
        }

        return redirect(route('login'))->with('status', 'Register successfully');
        // dd($request);
    }


    public function logout(){
        // Clear the session and log the user out
        Session::flush();
        Auth::logout();
        return redirect(route('login'));
    }



 

    public function dashboard(){
        $Slides = Slides::all();
        return view('admin.home', ['slides' => $Slides]);

   
    }

    public function users(){
        return view('admin.users');
    }


    public function addSlide(){
        return view('admin.addSlide');
    }


    public function addSlidePost(Request $request){
        $image = $request->file('file_name');

        $name_database = $image->getClientOriginalName();

        $request->validate([
            "title" => "required",
            "description" => "required",

        ]);

        $data['title'] = $request->title;
        $data['description'] = $request->description;
        $data['file'] = $name_database;

        $name = $image->getClientOriginalName();
        $path = public_path('image_upload');
        $image->move($path,$name);

        $slide_insert = Slides::create($data);


        if(!$slide_insert){
            return redirect(route('admin.dashboard'))->with('error', 'Slide added failed');
        }else{
            return redirect(route('admin.dashboard'))->with('success', 'Slide added successfully');
        }
    
    }




    public function addVideoslide(Request $request){
        $video = $request->file('file_name');
        $name_database = $video->getClientOriginalName();
        $data['file'] = $name_database;

        $name = $video->getClientOriginalName();
        $path = public_path('image_upload');
        $video->move($path,$name);

        $slide_insert = Slides::create($data);
        if(!$slide_insert){
            return redirect(route('admin.dashboard'))->with('error', 'Slide added failed');
        }else{
            return redirect(route('admin.dashboard'))->with('success', 'Slide added successfully');
        }
    }

    public function addDocumentslide(Request $request){
        $document = $request->file('file_name');
        $name_database = $document->getClientOriginalName();
        $data['file'] = $name_database;

        $name = $document->getClientOriginalName();
        $path = public_path('image_upload');
        $document->move($path,$name);

        $slide_insert = Slides::create($data);
        if(!$slide_insert){
            return redirect(route('admin.dashboard'))->with('error', 'Slide added failed');
        }else{
            return redirect(route('admin.dashboard'))->with('success', 'Slide added successfully');
        }
    }









    function editSlide(Slides $slide){
        return view('admin.editSlide', ['slide' => $slide]);
    }


    public function updateSlide(Request $request, Slides $slide)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
         

            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        // Check if a new image file has been uploaded
        if ($request->hasFile('new_file_name')) {
            // Handle file upload
            $uploadedFile = $request->file('new_file_name');
            $fileName = time() . '_' . $uploadedFile->getClientOriginalName();
            $uploadedFile->move(public_path('image_upload'), $fileName);

            // Update the file name in the database
            $slide->file = $fileName;
        }

        // Update other fields
        $slide->title = $validatedData['title'];
        $slide->description = $validatedData['description'];

        // Save the changes to the database
        $slide->save();

        // Redirect the user or return a response as needed
        return redirect(route('admin.dashboard'))->with('success', 'Slide updated successfully');
    }



    public function updateVideo(Request $request, Slides $slide)
    {
        // Validate the incoming request
        $request->validate([
            'new_file_name' => 'required|mimes:mp4,ogg|max:2048', // Example validation rules, adjust as needed
        ]);

        // Check if a new file has been uploaded
        if ($request->hasFile('new_file_name')) {
            // Delete the old file if it exists
            if (Storage::exists('image_upload/'.$slide->file)) {
                Storage::delete('image_upload/'.$slide->file);
            }
            
            // Store the new file
            $newFileName = $request->file('new_file_name')->store('image_upload');
            
            // Update the slide record with the new file name
            $slide->file = $newFileName;
            $slide->save();
        }

        // Redirect back with a success message or do whatever you need

        return redirect(route('admin.dashboard'))->with('success', 'Video file updated successfully');
    }
    


    function destroy(Slides $slide){
        $slide->delete();
        return redirect(route('admin.dashboard'))->with('success', 'Slide Deleted successfully');
    }
    


  
}
