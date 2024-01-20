@php
    
    // @dd($set)
    // @dd($set->exercises)
@endphp
<h2 id="set-heading">Set</h2>
<div class="col-md-6 mb-3 settypechk">
    <label for="setType" class="form-label">Set Type</label>
    <select class="form-select set-type" name="workouts[{{$workoutCount}}][sets][{{$setsCount}}][set_type]"
        aria-label="Default select example" onchange="toggleSetType()">
        <option selected disabled> Select Type</option>
        <option value="set" {{ $set->set_type === 'set' ? 'selected' : '' }}>Set</option>
        <option value="super-set" {{ $set->set_type === 'super-set' ? 'selected' : '' }}>Super Set</option>
    </select>
</div>

<div class="col-md-6 mb-3">
    <label for="set-time-number" class="form-label">Number of Time Set</label>
    <input type="number" class="form-control" name="workouts[{{$workoutCount}}][sets][{{ $setsCount }}][number_of_time_set]" value="{{ $set->number_of_time_set }}" />
</div>

<div class="col-md-6 mb-3">
    <label for="intra-set-rest" class="form-label">Intra-Set Rest</label>
    <input type="number" class="form-control" name="workouts[{{$workoutCount}}][sets][{{ $setsCount }}][intra_set_rest]" value="{{ $set->intra_set_rest }}"/>
</div>

<div class="col-md-6 mb-3">
    <label for="inter-set-rest" class="form-label">Inter-Set Rest</label>
    <input type="number" class="form-control" name="workouts[{{$workoutCount}}][sets][{{ $setsCount }}][inter_set_rest]" value="{{ $set->inter_set_rest }}"/>
</div>


<div class="mb-3 col-md-6">
    <label for="Duration-set" class="form-label">Duration of Set</label>
    <input type="time" name="workouts[{{$workoutCount}}][sets][{{$setsCount}}][set_duration]" class="form-control" value="{{ $set->set_duration }}"/>
</div>

{{-- <div class="col-md-12 exercise-button">
    <button type="button" class="add-exercise btn btn-primary mb-3">Add Exercise</button>
    <button type="button" class="remove-exercise btn btn-primary mb-3 ms-2">Remove Exercise</button>
</div> --}}

<div class="col-md-12 main-exercises" id="main-exercises">
    @php
        $ecerciseCount = 0;
    @endphp
    @foreach ($set->exercises as $key => $exercise )
    @php
        $ecerciseCount++;
    @endphp
        @include('form._partial_exercises_edit', ['exercise' => $exercise, 'workoutCount' => $workoutCount, 'setsCount' => $setsCount, 'ecerciseCount', $ecerciseCount])
    @endforeach
</div>
