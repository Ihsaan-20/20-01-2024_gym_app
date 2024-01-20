<?php

namespace App\Http\Controllers\AdminDashboard;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Models\ProgramWorkoutExerciseSet;
use Illuminate\Support\Facades\Validator;
use App\Models\ProgramWithExerciseSet; // new

class FormController extends Controller
{
    
    public function index()
    {
        $data = ProgramWithExerciseSet::latest()->get();
        $decode = json_decode($data);
        

        // foreach($decode as $de)
        // {
        //     echo '<pre>';
        //     foreach(json_decode($de->program) as $pro)
        //     {
        //         print_r($pro);
        //     }
        //     echo '</pre>';
        // }
        // print_r($decode[0]->program);
        // $program = $decode[0]->program;
        // $de = json_decode($program);
        // print_r($de);
        // die;
        // dd($data);
        return view('form.index', compact('decode'));

    }

    public function create()
    {
        return view('form.create');
    }


    public function store(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'program_name' => 'required',
            'program_text_bio' => 'required',
            'coach_id' => 'required',
            'program_duration' => 'required',
            'program_level' => 'required',
            'program_price' => 'required',
            'program_intro_video' => 'required',
            'program_profile' => 'required',
            'workouts' => 'required|array',
        ]);
        
        if ($validator->fails()) {
            return redirect()->route('form.create')->with('error', 'Validation failed')->withErrors($validator)->withInput();
        }
        

        $programObj = $request->all();
        
        // setup program videos, and image path;
        $newProgramVideoPath = '';
        $newProgramImagePath = '';

        if ($request->has('program_intro_video')){
            $video=rand(000000,456423).'.'.$programObj['program_intro_video']->extension();
            $path=$programObj['program_intro_video']->storeAs('program_intro_videos',$video,'public');
            $newProgramVideoPath = $path;
            $programObj['program_intro_video'] = $newProgramVideoPath;
        }
        
        if ($request->has('program_profile')){
            $image=rand(000000,456423).'.'.$programObj['program_profile']->extension();
            $path=$programObj['program_profile']->storeAs('program_profiles',$image,'public');
            $newProgramImagePath = $path;
            $programObj['program_profile'] = $newProgramImagePath;
        }

        
        $newFilePaths = [];
        // set up workout files video/image;
        // if ($request->has('workouts') && $programObj['workouts'] && $programObj['workouts'] !== null) {
        //     foreach ($programObj['workouts'] as &$workout) {
        //         $file = $workout['workout_video'];
        //         $newFileName = rand(000000, 456423) . '.' . $file->extension();
        //         $newFilePath = $file->storeAs('workout_videos', $newFileName, 'public');
        //         $workout['workout_video'] = $newFilePath;
        //         $newFilePaths[] = $newFilePath;
        //     }
        // }

        if ($request->has('workouts') && $programObj['workouts'] && $programObj['workouts'] !== null) {
            $request->validate([
                'workouts.*.workout_video' => 'required|file|mimes:mp4,avi,mov|max:10240', 
            ]);
            
    
            foreach ($programObj['workouts'] as &$workout) {
                $file = $workout['workout_video'];
                $newFileName = rand(000000, 456423) . '.' . $file->extension();
                $newFilePath = $file->storeAs('workout_videos', $newFileName, 'public');
                $workout['workout_video'] = $newFilePath;
                $newFilePaths[] = $newFilePath;
            }
        }


        // Create and save the model
        $programModel = new ProgramWithExerciseSet();
        $programModel->program = json_encode($programObj);
        $programModel->save();

        // Optionally, you can return a response
        return redirect()->route('form.index');
    }


    public function edit($id)
    {
        $json_data = ProgramWithExerciseSet::findOrFail($id);
        $data = json_decode($json_data);
        return view('form.edit', compact('data'));
    }

    public function update(Request $request)
    {
        // Find the existing program record
        $program = ProgramWithExerciseSet::findOrFail($request->id);

        // Create a copy of the existing program data
        $programObj = json_decode($program->program, true);

        // Update program videos and image path if new files are provided
        if ($request->hasFile('program_intro_video')) {
            $file = $request->file('program_intro_video');
            $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('program_intro_videos', $fileName, 'public');
            $newProgramVideoPath = 'program_intro_videos/' . $fileName;
            $programObj['program_intro_video'] = $newProgramVideoPath;
        }

        if ($request->hasFile('program_profile')) {
            $file = $request->file('program_profile');
            $image = rand(000000, 456423) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('program_profiles', $image, 'public');
            $newProgramImagePath = $path;
            $programObj['program_profile'] = $newProgramImagePath;
        }

        // Convert the updated program data back to JSON
        $updatedProgram = json_encode($programObj);

        // Update the database record
        DB::table('program_with_exercise_sets')
            ->where('id', $request->id)
            ->update(['program' => $updatedProgram]);

        session()->flash('success', 'Edited successfully.');
        return redirect()->route('form.edit', ['id' => $request->id]);
    }


    public function destroy($id)
    {
        // return $id;
        $data = ProgramWithExerciseSet::findOrFail($id);
        if($data)
        {   
            $data->delete();
            return redirect()->route('form.index')->with('success', 'Program deleted successfully.');
        }else{

            return redirect()->route('form.index')->with('error', 'Record not found!');
        }


        
    }


    

}
