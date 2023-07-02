<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use File;

class AlarmSoundService {

    /** 
     * name, basename and url of all sounds in the storage 
     * 
     * @return array<string>
     */
    protected $alarmSounds; 

    /**
     * Provide value to alarmSounds variable
     * 
     * @return void
     */
    function __construct() 
    {
        $sounds = File::allFiles(public_path('storage\sounds'));
        $sounds = array_map( 
            function ($sound) {
                $soundBasename = basename($sound);
                $soundUrl = url('') . Storage::url('sounds/' . $soundBasename);
                $soundBasename = str_replace('.mp3', '', $soundBasename);
                $soundName = ucwords(str_replace('-', ' ', $soundBasename));
                return collect(['name'=> $soundName, 'basename'=> $soundBasename, 'url' => $soundUrl]);
            }, $sounds);
        $this->alarmSounds = $sounds;
    }

    /** 
     * Get all audios from storage 
     * 
     * @return collection
     */
    function getAlarmSounds() :array
    {
        return $this->alarmSounds;
    }

    /**
     * find audio in the alarmSounds collection and return the corresponding Sound collection
     * 
     * @param string $alarmSoundBasename The audio name to return
     * 
     * @return Collection
     */
    public function getSoundData(string $alarmSoundBasename) 
    {
        foreach($this->alarmSounds as $sound) {
            if ($sound->get('basename') == $alarmSoundBasename) {
                return $sound;
            }
        }
        return NULL;
    }

    /**
     * handle audio file if uploaded and return sound name to update in storage 
     * 
     * @param $request App\Http\Requests
     * 
     * @return string
     */
    public function uploadNewSoundIfUploaded($data)
    {
        $file = $data->file('custom-alarm-sound');
        if(!$file) {
            return $data->validated('alarm-sound');
        } else if ($file->isValid()) {
            $fileBasename = $file->getClientOriginalName();
            $file->move('storage/sounds', $fileBasename);
            $fileBasename = str_replace('.mp3', '', $fileBasename);
            return $fileBasename;
        }
    }
}