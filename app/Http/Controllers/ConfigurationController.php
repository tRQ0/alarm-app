<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Configuration as Config;
use App\Http\Requests\UpdateConfigurationRequest;

class ConfigurationController extends Controller
{
    /**
     * Update specified resource in configurations 
     */
    public function update(UpdateConfigurationRequest $request)
    {
        $data =  $request->validated();
        Config::first()->update([
            'datetime_format' => $data['datetime-format'],
            'alert_before' => $data['alert-before'],
            'screen_pause_duration' => $data['screen-pause-duration'],
        ]);
        return redirect(route('alarms.index'));
    }
}