@extends('layouts.default')
@section('content')
    <!-- Button trigger modal -->


    {{-- Alert --}}
    <div class="alert alert-warning visually-hidden" id="alert-alarm-time-left" role="alert">
        Alarm rings in <span id="alert-alarm-time-left"></span>
    </div>

    {{-- <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Understood</button>
                </div>
            </div>
        </div>
    </div> --}}
    {{-- Fetch and show alarm from the DB --}}
    <div class="row pt-5 justify-content-center align-content-center">

        <div class="col col-8">

            @if ($alarm)
                <div id="alarm" class="card p-10 mt-4" id="alarm-{{ $alarm->id }}">
                    <div class="card-header">
                        Alarm
                    </div>
                    <div class="card-body">
                        <p class="display-1">
                            <span id="alarm-time" data-time="{{ $alarm->alarm_time }}">
                                {{ date($config->datetime_format, strtotime($alarm->alarm_time)) }}
                            </span>
                        </p>
                    </div>
                    <div class="div card-footer">
                        <span class="btn btn-secondary" id="alarm-sound" data-sound="{{ $alarm->sound->url }}"
                            data-bs-toggle="tooltip" data-bs-placement="bottom" title="Alarm Sound">
                            {{ $alarm->sound->name }}
                        </span>
                        <span id="screen-pause-duration" class="btn btn-secondary"
                            data-duration="{{ $config->screen_pause_duration }}" data-bs-toggle="tooltip"
                            data-bs-placement="bottom" title="Alarm duration">
                            {{ date('s', (int) $config->screen_pause_duration) }}sec
                        </span>
                        <span id="alert-before" class="btn btn-secondary" data-duration="{{ $config->alert_before }}"
                            data-bs-toggle="tooltip" data-bs-placement="bottom" title="Alert time">
                            {{ date('m', (int) $config->alert_before) }}min
                        </span>
                        <span class="btn btn-secondary visually-hidden" id="alarm-time-left" data-bs-toggle="tooltip"
                            data-bs-placement="bottom" title="Time left to ring alarm">
                        </span>
                    </div>
                </div>
            @else
                <div class="card p-10 mt-4">
                    <div class="card-header">
                        Create new alarm
                    </div>
                    <div class="card-body">
                        No alarm found create new alarm
                    </div>
                </div>
            @endif
        </div>

        <div class="row pt-5 justify-content-center align-content-center">
            {{-- Create an alarm --}}
            <div class="col col-4">
                <div class="card">
                    <div class="card-header">
                        Create alarm
                    </div>
                    <div class="card-body">
                        <form id="create-alarm-form" class="row row-cols-lg-auto g-3 align-items-center"
                            action="{{ route('alarms.update') }}" method="post" enctype="multipart/form-data"
                            name="create-alarm-form">
                            @csrf
                            @method('put')
                            <input type="datetime-local" class="form-control" id="alarm-datetime" name="alarm-datetime"
                                required />
                            @if ($errors->has('alarm-datetime'))
                                <span class="text-danger">{{ $errors->first('alarm-datetime') }}</span>
                            @endif
                            <select name="alarm-sound" class="form-control form-select" id="select-alarm-sound" required>
                                <option value="" selected>Select a sound</option>
                                @foreach ($alarmSounds as $sound)
                                    <option value="{{ $sound->get('basename') }}" data-path="{{ $sound->get('url') }}">
                                        {{ $sound->get('name') }}
                                    </option>
                                @endforeach
                            </select>
                            @if ($errors->has('alarm-sound'))
                                <span class="text-danger">{{ $errors->first('alarm-sound') }}</span>
                            @endif
                            <input id="form-upload-alarm-sound" name="custom-alarm-sound"
                                class="form-control form-control-sm" type="file" accept=".mp3, .wav"
                                data-bs-toggle="tooltip" data-bs-placement="bottom" title="Upload alarm sound">
                            @if ($errors->has('custom-alarm-sound'))
                                <span class="text-danger">{{ $errors->first('custom-alarm-sound') }}</span>
                            @endif
                            <div class="d-grid gap-2 d-md-flex ">
                                <button type="submit" class="btn form-control btn-outline-primary"
                                    name="submit-create-alarm-form" id="submit-create-alarm-form">Create
                                    Alarm</button>
                                <button type="reset" class="btn form-control btn-outline-primary"
                                    name="reset-create-alarm-form" id="reset-create-alarm-form">Reset</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Configuration  --}}
            <div class="col col-4">
                <div class="card">
                    <div class="card-header">
                        Update configuration
                    </div>
                    <div class="card-body">
                        <form id="update-configuration-form" class="row row-cols-lg-auto g-3 align-items-center"
                            action="{{ route('config.update') }}" method="post" name="update-configuration-form">
                            @csrf
                            @method('put')
                            <input type="number" min="1" max="120" class="form-control"
                                name="screen-pause-duration" placeholder="Alarm duration" required />
                            @if ($errors->has('screen-pause-duration'))
                                <span class="text-danger">{{ $errors->first('screen-pause-duration') }}</span>
                            @endif
                            <input type="number" min="1" max="1440" class="form-control" name="alert-before"
                                placeholder="Alert before alarm (in minutes)" required />
                            @if ($errors->has('alert-before'))
                                <span class="text-danger">{{ $errors->first('alert-before') }}</span>
                            @endif
                            <select name="datetime-format" class="form-control form-select" required>
                                <option value="">Date format</option>
                                <option value="Y-m-d H:i">Y-M-D H:M (2023-07-01 20:01)</option>
                                <option value="d/m/Y H:i">D/M/Y H:M (01/07/2023 20:01)</option>
                                <option value="h:i">H:M (20:01)</option>
                                <option value="D h:i">Day H:M (Sat 20:01)</option>
                                <option value="D M h:i">Day Month H:M (Sat Jul 20:01)</option>
                            </select>
                            @if ($errors->has('alarm-format'))
                                <span class="text-danger">{{ $errors->first('screen-pause-duration') }}</span>
                            @endif
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn form-control btn-outline-primary"
                                    name="update-config">Update
                                    Config</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>




    <script src="{{ asset('js/alarm-create-form.js') }}"></script>
    <script src="{{ asset('js/alarm.js') }}"></script>
@stop
