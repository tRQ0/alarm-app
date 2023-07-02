# Alarm App

## Installation

1. run `composer install` in project directory
2. update database credentials in .env file
3. run `artisan migrate` in project directory
4. Enable **autoplay** for audio in your browser for the webapp

## Accessing the application

- the app home is at `/` path

## Functionalities

### Alarm

The app at the top displays the alarm time at which it will trigger with additional information at the end. A tooltip will appear if you will place the cursor at the data present at the end of the alarm box
The alarm has following features:
    - Alarm tone is played at the specified time and **cannot** be stopped once start playing
    - Alarm box will turn **red** once **played** or if the time has **passed**
    - An **alert** is generated before the specified number of minutes
    - In the footer the fields signify 
        - Alarm Sound - the **sound** to play when the alarm is triggered
        - Alarm Duration - the **duration** for which the alarm sound will play for. This is specified in **seconds**
        - Alert time - the time in **minutes** before which an **alert** will be generated

### Creating new alarm

New alarm can be created by filling the details in the **Create alarm** form
User can:
    - Select the alarm **date** from the **date picker** and **input** the **time** manually
    - Select an alarm sound from pre-existing alarm sounds
    `--or--`
    - Upload their custom sound if they want to

### Updating Configuration

The alarm settings can be updated using the **Update configuration** form.
The setting which can be changed by the user are:
    - Alarm duration - Time for which the alarm will play. This accepts value from **1** to **120** where the number signifies **seconds**
    - Alert time - This signifies how many minutes before the alarm time an alert be generated. This takes input in **minutes** and is limited between **1-1440**
    - At last is the date format selector from which a user can choose in what format the alarm time should be displayed. The user can choose from following values:
        - Y-M-D H:M (2023-07-01 20:01)
        - D/M/Y H:M (01/07/2023 20:01)
        - H:M (20:01)
        - Day H:M (Sat 20:01)
        - Day Month H:M (Sat Jul 20:01)

<hr>
