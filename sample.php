<!DOCTYPE html>
<!--
***********  GOOGLE CALENDAR  ****************************
Author: Vanderlei Bailo
E-mail: vanbailo@gmail.com
Script: insert, change and delete Google Calenda event
-->
<html>
    <head>
        <title>GOOGLE CALENDAR - insert, change and delete Google Calenda event</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta charset="UTF-8">
        <style>
            body{
                margin: 0;
                width: 100%;
                font-family: Verdana, Arial;
            }
            #centro{
                width: 780px;
                margin: auto;
            }
            .calendario{
                position: relative;
                width: 800px;
                height: 600px;
                margin-left:-390px;
                left: 50%;
                float: left;
                -webkit-border-radius: 5px;
                -moz-border-radius: 5px;
                border-radius: 5px;
            }
            #datahora{
                width: 250px;
                float: left;
            }
            #cento{
                width: 780px;
                float: left;
            }
            #centro .primo{
                width: 100%;
                background-color: #E3E9FF;
                padding: 10px;
                margin: 50px 0;
                float: left;
                -webkit-border-radius: 5px;
                -moz-border-radius: 5px;
                border-radius: 5px;
            }
            label {
                width: 780px;
                margin: 5px 5px 0;
                float: left;
                padding-top: 10px;
            }

            input{
                margin: 5px;
                float: left;
                padding: 5px 10px;
                -webkit-border-radius: 5px;
                -moz-border-radius: 5px;
                border-radius: 5px;
                border: 1px #CCC solid;
            }
            input[type="text"]{
                width: 750px;
            }
            input[type="date"]{
                width: 125px;
            }
            input[type="time"]{
                width: 70px;
            }
            input[type="submit"]{

            }

            input:focus{
                border: 1px  #cc0000 solid;
                box-shadow: 0 0 5px #cc0000;
            }
            .btn {
                background: #3498db;
                background-image: -webkit-linear-gradient(top, #3498db, #2980b9);
                background-image: -moz-linear-gradient(top, #3498db, #2980b9);
                background-image: -ms-linear-gradient(top, #3498db, #2980b9);
                background-image: -o-linear-gradient(top, #3498db, #2980b9);
                background-image: linear-gradient(to bottom, #3498db, #2980b9);
                -webkit-border-radius: 5;
                -moz-border-radius: 5;
                border-radius: 5px;
                font-family: Arial;
                color: #ffffff;
                font-size: 20px;
                padding: 10px 20px 10px 20px;
                text-decoration: none;
                cursor: pointer;
            }

            .btn:hover {
                background: #3cb0fd;
                background-image: -webkit-linear-gradient(top, #3cb0fd, #3498db);
                background-image: -moz-linear-gradient(top, #3cb0fd, #3498db);
                background-image: -ms-linear-gradient(top, #3cb0fd, #3498db);
                background-image: -o-linear-gradient(top, #3cb0fd, #3498db);
                background-image: linear-gradient(to bottom, #3cb0fd, #3498db);
                text-decoration: none;
            }

        </style>
    </head>
    <body>

        <?php
        session_start();
        require 'src/Google/autoload.php';
        require_once 'src/Google/Client.php';
        require_once 'src/Google/Service/Calendar.php';

        $client_id = 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx.apps.googleusercontent.com'; //change this
        $Email_address = 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx.gserviceaccount.com'; //change this
        $key_file_location = 'xxxxxxxxxxxxxxxxxxxxxxxx.p12'; //change this
        $client = new Google_Client();
        $client->setApplicationName("Client_Library_Examples");
        $key = file_get_contents($key_file_location);


        $scopes = "https://www.googleapis.com/auth/calendar";
        $cred = new Google_Auth_AssertionCredentials(
                $Email_address, array($scopes), $key
        );
        $client->setAssertionCredentials($cred);
        if ($client->getAuth()->isAccessTokenExpired()) {
            $client->getAuth()->refreshTokenWithAssertion($cred);
        }
        $service = new Google_Service_Calendar($client);

        $calendarList = $service->calendarList->listCalendarList();
        while (true) {
            foreach ($calendarList->getItems() as $calendarListEntry) {
                echo "<a href='Oauth2.php?type=event&id=" . $calendarListEntry->id . " '>" . $calendarListEntry->getSummary() . "</a><br>\n";
            }
            $pageToken = $calendarList->getNextPageToken();
            if ($pageToken) {
                $optParams = array('pageToken' => $pageToken);
                $calendarList = $service->calendarList->listCalendarList($optParams);
            } else {
                break;
            }
        }


        if ($_POST) {
            
            $Summary = $_POST['Summary'];
            $Location = $_POST['Location'];
            $DateStart = $_POST['DateStart'];
            $TimeStart = $_POST['TimeStart'];
            $DateEnd = $_POST['DateEnd'];
            $TimeEnd = $_POST['TimeEnd'];
            $acao = $_POST['acao'];



            if ($acao == 'Inserire') {
                //--------------- trying to insert EVENT --------------- 
                $event = new Google_Service_Calendar_Event();
                $event->setSummary($Summary);
                $event->setLocation($Location);
                $start = new Google_Service_Calendar_EventDateTime();
                $datatimeI = geratime(DataIT2DB($DateStart), $TimeStart);

                $start->setDateTime($datatimeI);
                $event->setStart($start);
                $end = new Google_Service_Calendar_EventDateTime();
                $datatimeF = geratime(DataIT2DB($DateEnd), $TimeEnd);

                $end->setDateTime($datatimeF);
                $event->setEnd($end);
                $attendee1 = new Google_Service_Calendar_EventAttendee();
                $attendee1->setEmail('web@ideart.it');
                $attendees = array($attendee1);
                $event->attendees = $attendees;
                $createdEvent = $service->events->insert('primary', $event);
                $_SESSION['eventID'] = $createdEvent->getId();
            } else if ($acao == 'Cancellare') {
                //--------------- trying to del EVENT --------------- 
                $createdEvent = $service->events->delete('primary', $_SESSION['eventID']);
            } else if ($acao == 'Aggiornare') {
                //--------------- trying to update EVENT --------------- 

                $rule = $service->events->get('primary', $_SESSION['eventID']);


                $event = new Google_Service_Calendar_Event();
                $event->setSummary($Summary);
                $event->setLocation($Location);
                $start = new Google_Service_Calendar_EventDateTime();
                $datatimeI = geratime(DataIT2DB($DateStart), $TimeStart);

                $start->setDateTime($datatimeI);
                $event->setStart($start);
                $end = new Google_Service_Calendar_EventDateTime();
                $datatimeF = geratime(DataIT2DB($DateEnd), $TimeEnd);

                $end->setDateTime($datatimeF);
                $event->setEnd($end);
                $attendee1 = new Google_Service_Calendar_EventAttendee();
                $attendee1->setEmail('xxx@xxxxx.xxx'); //change this
                $attendees = array($attendee1);
                $event->attendees = $attendees;

                $updatedRule = $service->events->update('primary', $rule->getId(), $event);
            }
        }

        function DataIT2DB($datapega) {
            if ($datapega) {
                $data = explode('/', $datapega);
                if (count($data) > 1) {
                    $datacerta = $data[2] . '-' . $data[1] . '-' . $data[0];
                } else {
                    $datacerta = $datapega;
                }
            } else {
                $datacerta = $datapega;
            }
            return $datacerta;
        }

        function geratime($DateStart, $TimeStart) {
            $dataHora = $DateStart . 'T' . $TimeStart . ':00.000+02:00'; //Fuso Rome
            return $dataHora;
        }
        ?>

        <div id="contenut" style="width: 100%; float: left;">
            <div id="centro">
                <div class="primo">
                    <form name="adicionar" method="POST" action="#">
                        ID evento: <?php echo ( isset($_SESSION['eventID']) ? $_SESSION['eventID'] : "" ); ?>
                        <input type="hidden" name="" value="<?php echo ( isset($_SESSION['eventID']) ? $_SESSION['eventID'] : "" ); ?>" />
                        <input type="text" name="Summary" value="<?php echo ( isset($_POST['Summary']) ? $_POST['Summary'] : "" ); ?>" placeholder="Titolo"/>
                        <input type="text" name="Location" value="<?php echo ( isset($_POST['Location']) ? $_POST['Location'] : "" ); ?>" placeholder="LocalitÃ "/>
                        <div id="datahora">
                            <label>Data e ora di inizio</label>
                            <input type="date" name="DateStart" value="<?php echo ( isset($_POST['DateStart']) ? $_POST['DateStart'] : "" ); ?>" placeholder="GG/MM/AAAA"/>
                            <input type="time" name="TimeStart" value="<?php echo ( isset($_POST['TimeStart']) ? $_POST['TimeStart'] : "" ); ?>" placeholder="10:20"/>
                        </div>
                        <div id="datahora">
                            <label>Data e ora di fine</label>
                            <input type="date" name="DateEnd" value="<?php echo ( isset($_POST['DateEnd']) ? $_POST['DateEnd'] : "" ); ?>" placeholder="GG/MM/AAAA"/>
                            <input type="time" name="TimeEnd" value="<?php echo ( isset($_POST['TimeEnd']) ? $_POST['TimeEnd'] : "" ); ?>" placeholder="10:20" />
                        </div>
                        <div id="cento">
                            <input class="btn" type="submit" value="Inserire" name="acao" />
                            <input class="btn" type="submit" value="Cancellare" name="acao" />
                            <input class="btn" type="submit" value="Aggiornare" name="acao" />
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </body>
</html>