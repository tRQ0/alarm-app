const $alarm = document.getElementById('alarm')
const $alarmTime = document.getElementById('alarm-time')
const $timeToAlarm = document.getElementById('alarm-time-left')
const $alarmAlert = document.getElementById('alert-alarm-time-left')
const $alertBefore = document.getElementById('alert-before')

const alarmSoundUrl = document.getElementById('alarm-sound').dataset.sound
const screenPauseDuration = document.getElementById('screen-pause-duration').dataset.duration
const alarmDuration = screenPauseDuration
const alertBeforeTime = $alertBefore.dataset.duration * 60000
const alarmTime = new Date(Date.parse($alarmTime.dataset.time.replace(/-/g, '/')))
const audio = new Audio(alarmSoundUrl)
const now = new Date()
// var myModal = new bootstrap.Modal(document.getElementById('staticBackdrop'))
// myModal.show

var timeToAlarm = alarmTime - now
audio.volume = 1

if (timeToAlarm > 0) {
    $timeToAlarm.classList.remove('visually-hidden')
    $timeToAlarm.innerHTML = 'Alarm ' + parseTimeToAlarm(timeToAlarm)

    //interval to update time to alarm field 
    setInterval(() => {
        let now_ = new Date()
        let timeLeft = alarmTime - now_
        $timeToAlarm.innerHTML = 'Alarm ' + parseTimeToAlarm(timeLeft)
    }, 1000 * 60);

    //timeout to alarm time trigger alarm sound and do miscellaneous tasks
    setTimeout(() => {
        $alarm.classList.add('btn-danger', 'disabled')
        $timeToAlarm.classList.add('visually-hidden')
        $alertBefore.classList.remove('visually-hidden')
        $alarmAlert.classList.add('visually-hidden')
        audio.loop = true
        audio.play()

        //timeout to stop alarm after the desired duration and unfreeze the window
        setTimeout(() => {
            audio.pause()
        }, screenPauseDuration * 1000);
    }, timeToAlarm)

    //generate alert before alarm
    setTimeout(() => {
        let now_ = new Date()
        let timeLeft = alarmTime - now_
        $alarmAlert.firstElementChild.innerHTML = parseTimeToAlarm(timeLeft)
        $alarmAlert.classList.remove('visually-hidden')
    }, timeToAlarm - alertBeforeTime)
} else {
    $alarm.classList.add('btn-danger', 'disabled')
}

function parseTimeToAlarm(timeToAlarmRaw) {
    timeToAlarmRaw /= 1000
    timeToAlarmParsed =
        `In: ${Math.floor(timeToAlarmRaw / (60 * 60))}hr ${Math.floor(timeToAlarmRaw / 60)}min`
    return timeToAlarmParsed
}