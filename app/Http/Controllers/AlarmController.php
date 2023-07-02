<?php

namespace App\Http\Controllers;

use App\Models\Alarm;
use App\Models\Configuration as Config;
use Illuminate\Http\Request;
use App\Services\AlarmSoundService;
use App\Http\Requests\UpdateAlarmRequest;

class AlarmController extends Controller
{
    protected $alarmSoundService;
    protected $alarm;

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct(AlarmSoundService $alarmSoundService) {
        $this->alarmSoundService = $alarmSoundService;
        if (!Config::first()) {
            Config::create();
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $config = Config::first();
        $alarmSounds = $this->alarmSoundService->getAlarmSounds();
        $alarm = Alarm::first();
        if($alarm) {
            $alarm = collect($alarm);
            $alarm->put ('sound', $this->alarmSoundService->getSoundData($alarm->get('sound')));
            // $alarm->put ('url', $this->alarmSoundService->getSoundUrl($alarm->get('sound')));
            $alarm = json_decode($alarm);
        }
        return view('pages.home', compact('alarm', 'config', 'alarmSounds'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAlarmRequest $request)
    {
        $data = $request->validated();
        $sound =  $this->alarmSoundService->uploadNewSoundIfUploaded($request);
        if(!Alarm::first()) {
            Alarm::create([
                'alarm_time' => $data['alarm-datetime'],
                'sound' => $sound,
            ]);
            return redirect(route('alarms.index'));
        }
        Alarm::first()->update([
            'alarm_time' => $data['alarm-datetime'],
            'sound' => $sound,
        ]);
        return redirect(route('alarms.index'));
    }

}
