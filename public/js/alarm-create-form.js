const $alarmDate = document.getElementById("alarm-datetime")
const $alarmSoundSelector = document.getElementById("select-alarm-sound")
const $alarmForm = document.querySelector("#create-alarm-form")
const $formSubmitButton = document.getElementById('submit-create-alarm-form')
const $formResetButton = document.getElementById('reset-create-alarm-form')
const $alarmSoundUpload = document.getElementById('form-upload-alarm-sound')

$alarmForm.reset()

//assign initial values to the datetime attribute
$alarmDate.setAttribute('value', getCurrentTime())
$alarmDate.setAttribute('min', getCurrentTime())

// Update min value of the datetime selector each minute
setInterval(() => {
    $alarmDate.setAttribute('min', getCurrentTime())
}, 1000 * 60)

// Play the selected sound
$alarmSoundSelector.addEventListener("change", (event) => {
    const $audioPath = event.target.selectedOptions[0].getAttribute("data-path")
    if ($audioPath) {
        // Create a HTTPAudioElement object
        const audio = new Audio($audioPath)
        audio.volume = 0.5
        audio.play()
        setTimeout(() => {
            audio.pause()
        }, 2000);
    }
})

// Disable drop-down menu when uploading custom sound
$alarmSoundUpload.addEventListener("change", (event) => {

    // Disable
    if (event.target.value) {
        $alarmSoundSelector.setAttribute("disabled", "")
        const file = event.target.files[0] //get uploaded file
        var fileName = file.name
        fileName = fileName.replace(".mp3", "")
        fileName = fileName.replace(".wav", "")
        checkIfFileAlreadyExists = Array.from($alarmSoundSelector.options).filter((option) => {
            return option.value == fileName
        }).length

        if (file.size / 1024 > 500 || checkIfFileAlreadyExists) {
            $formSubmitButton.classList.add('disabled')
            event.target.classList.add('is-invalid')
            event.target.setAttribute("title", checkIfFileAlreadyExists ? "File already exist" : "Size should not exceed 500KB")
        } else {
            $formSubmitButton.classList.remove('disabled')
            event.target.classList.remove('is-invalid')
            event.target.classList.add('is-valid')
            event.target.setAttribute("title", "Upload alarm sound")
        }
        // Also check if already exist in list
    }
})

// Enable drop-down menu when form reset occurs
$formResetButton.addEventListener('click', () => {
    $formSubmitButton.classList.remove('disabled')
    $alarmSoundSelector.removeAttribute("disabled")
    $alarmSoundUpload.classList.remove('is-invalid')
    $alarmSoundUpload.classList.remove('is-valid')
    $alarmSoundUpload.setAttribute("title", "Upload alarm sound")

})

// Get the latest time in datetime-local format i.e. YYYY-MM-DDTHH:MM
function getCurrentTime() {
    const date = new Date();
    return `${date.getFullYear()}-${('0' + (date.getMonth() + 1)).slice(-2)}-${('0' + date.getDate()).slice(-2)}T${('0' + date.getHours()).slice(-2)}:${('0' + (date.getMinutes() + 1)).slice(-2)}`
} 