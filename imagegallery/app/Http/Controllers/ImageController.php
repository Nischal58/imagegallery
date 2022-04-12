<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;
use Session;
use Auth;
class ImageController extends Controller
{

    public function index(){
        $images = Image::paginate(9);
        return view('welcome')->with('images',$images);
    }
    public function post(Request $request){
        $this->validate($request,[
            'image'=>'required'
        ]);
        $images = $request->image;
        foreach($images as $image){
            $image_new_name = time() . $image->getClientOriginalName();
            $image->move('images',$image_new_name);
            $post = new Image;
            $post->user_id = Auth::user()->id;
            $post->image = 'images/' .$image_new_name;
            $post->save();

        }

        Session::flash('success','Images uploaded');

        return redirect('/');
    }
    public function destroy($id){
        $image = Image::find($id);
        $image->delete();
        Session::flash('success','Images deleted');

        return redirect('/');
        
    }


}