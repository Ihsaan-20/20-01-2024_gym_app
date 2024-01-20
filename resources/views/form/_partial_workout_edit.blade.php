<h2 class="accordion-header" id="heading{{ $workoutCount }}">
    <button class="accordion-button" type="button" data-bs-toggle="collapse"
        data-bs-target="#collapse{{ $workoutCount }}" aria-expanded="true" aria-controls="collapse{{ $workoutCount }}">
        Workout 
    </button>
</h2>

@php
    // @dd($workout->workout_training_type)
    // @dd($workout->sets)
@endphp
<div id="collapse{{ $workoutCount }}" class="accordion-collapse collapse show" aria-labelledby="heading{{ $workoutCount }}" data-bs-parent="#accordionExample">
    <div class="accordion-body">

        <div class="row mb-3 bg-light py-3 rounded-3">
            <div class="mb-3 col-md-6">
                <label for="workout" class="form-label">Workout Name</label>
                <input type="text" class="form-control" name="workouts[{{$workoutCount}}][name]" value="{{ $workout->name }}" aria-describedby="emailHelp" />
            </div>
            <div class="mb-3 col-md-6">
                <label for="file" class="form-label">Introdutory Video</label>
                <input type="hidden" class="form-control" name="workouts[{{$workoutCount}}][workout_video]" value="{{ $workout->workout_video }}" id="file" />
                <input type="file" class="form-control" name="workouts[{{$workoutCount}}][workout_video]" value="{{ $workout->workout_video }}" id="file" />
                <span class="text-muted">{{ $workout->workout_video??'not uploaded' }}</span>
            </div>
            <div class="mb-3 col-md-6">
                <label for="file" class="form-label">Bio</label>
                <textarea name="workouts[{{ $workoutCount}}][workout_bio]" class="form-control">{{ $workout->workout_bio }}</textarea>
            </div>

            <div class="mb-3 col-md-6">
                <label for="trainingType" class="form-label">Training Type:</label>
                <select multiple="multiple" name="workouts[{{$workoutCount}}][workout_training_type]" class="form-control trainingType">
                    <option value="body" {{ $workout->workout_training_type === 'body' ? 'selected' : '' }}>Body</option>
                    <option value="legs" {{ $workout->workout_training_type === 'legs' ? 'selected' : '' }}>Legs</option>
                    <option value="back" {{ $workout->workout_training_type === 'back' ? 'selected' : '' }}>Back</option>
                    <option value="shoulder" {{ $workout->workout_training_type === 'shoulder' ? 'selected' : '' }}>Shoulder</option>
                </select>
            </div>

            <div class="mb-3 col-md-6">
                <label for="equipmentNeeded" class="form-label">Equipment Needed:</label>
                <select multiple="multiple" name="workouts[{{$workoutCount}}][workout_equi_needed]" class="form-control equipmentNeeded">
                    <option value="body" {{ $workout->workout_equi_needed === 'body' ? 'selected' : '' }}>Body</option>
                    <option value="legs" {{ $workout->workout_equi_needed === 'legs' ? 'selected' : '' }}>Legs</option>
                    <option value="back" {{ $workout->workout_equi_needed === 'back' ? 'selected' : '' }}>Back</option>
                    <option value="shoulder" {{ $workout->workout_equi_needed === 'shoulder' ? 'selected' : '' }}>Shoulder</option>
                </select>
            </div>

            <div class="mb-3 col-md-6">
                <label for="timeInput" class="form-label">Estimated Duration (hours)</label>
                <input type="time" name="workouts[{{$workoutCount}}][workout_duration]" value="{{ $workout->workout_duration }}" class="form-control" />
            </div>

            <div class="mb-3 col-md-6">
                <label for="restDays" class="form-label">Rest (Days)</label>
                <input type="tel" class="form-control" name="workouts[{{$workoutCount}}][workout_rest_days]" value="{{ $workout->workout_rest_days }}" placeholder="1"
                oninput="validateNumericInput(this)" />
            </div>


            <div class="mb-3 col-md-6">
                <label for="exercises" class="form-label">Number of Exercises</label>
                <input type="number" class="form-control" name="workouts[{{$workoutCount}}][num_of_exercises]" value="{{ $workout->num_of_exercises }}"/>
            </div>

        </div>

            <div>
                {{-- <div class="col-md-12">
                    <button type="button" class="add-set btn btn-primary mb-3">Add Set</button>
                    <button type="button" class="remove-set btn btn-primary mb-3">Remove Set</button>
                </div> --}}
                <div class="settypeparent" id="main-sets">
                    <!-- Initial Set Section -->
                    @php
                        $setsCount = 0;    
                    
                    @endphp
                    @foreach ($workout->sets as $key => $set )
                    @php
                        $setsCount++;
                    @endphp
                        @include('form._partial_sets_edit', ['set' => $set, 'workoutCount' => $workoutCount, 'setsCount' => $setsCount])
                    @endforeach
                    
                </div>
            </div>
        </div>
    </div>
</div>