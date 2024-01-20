@php
    
    // @dd($exercise)
@endphp
<h2 id="exercise-heading">Exercise</h2>
    <div class="col-md-6">
        <label for="set-time-number" class="form-label">Text Bio</label>
        <div class="form-floating">
            <textarea class="form-control" 
            placeholder="Leave a comment here"
            name="workouts[{{$workoutCount}}][sets][{{$setsCount}}][exercises][{{$ecerciseCount}}][bio]">{{ $exercise->bio }}</textarea>
            <label for="floatingTextarea">Comments</label>
        </div>
    </div>

    <div class="col-md-6">
        <label for="repeat-num" class="form-label">Number of Repeatation</label>
        <input type="number" class="form-control"
            name="workouts[{{$workoutCount}}][sets][{{$setsCount}}][exercises][{{$ecerciseCount}}][num_of_repeat]"
            id="repeat-num"
            value="{{ $exercise->num_of_repeat }}" />
    </div>

    <div class="col-md-6">
        <label for="formFile" class="form-label">Default file input example</label>
        {{-- <input class="form-control" 
            type="file"
            name="workouts[{{ $key }}][sets][{{ $key }}][exercises][{{ $key }}}][input_example]"
            > --}}
            
    </div>