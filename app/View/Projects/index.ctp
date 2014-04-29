
<!--<script src="--><?php //echo $this->webroot?><!--js/timer.jquery.js"></script>-->


	<div class="control-btn">
		<a href="<?=$this->webroot?>projects/showstats">Today Report</a>
	</div>

    <div class="counter-slide">
            <div class="couter-timer">
                <div id="timer-digits" class="badge"></div>
				<div id="ajax-loader"></div>
            </div>
        </div>

        <ul class="projects-list">
            <?php
            foreach($projects as $project){
                echo '
                <li class="project">
                    <a href="javascript:void(0)" class="project-bttn" id="prod-'.$project['Project']['id'].'">
						<img src="'.$this->webroot.'img/play-icon.png">
					</a>
                    <span> '.$project['Project']['name'].' </span>
                </li>
                ';
            }
            ?>
        </ul>
		
		<div class="control-btn">
			<a href="<?=$this->webroot?>projects/plist">Edit Projects</a>
		</div>	

		<div style="display: none">
			<div id="unix-start"></div>
			<div id="unix-end"></div>
			<div id="unix-diff"></div>
			<div id="unix-proid"></div>
		</div>

  
	
	
	
	
	
	
	
	
	

    <script>

        var interval;


        //$(document).ready(function(){
        jQuery(function($) {

            $('.counter-slide').slideUp();			

            $.toHHMMSS = function (sec_num) {

                var hours   = Math.floor(sec_num / 3600);
                var minutes = Math.floor((sec_num - (hours * 3600)) / 60);
                var seconds = sec_num - (hours * 3600) - (minutes * 60);

                if (hours   < 10) {hours   = "0"+hours;}
                if (minutes < 10) {minutes = "0"+minutes;}
                if (seconds < 10) {seconds = "0"+seconds;}
                var time    = hours+':'+minutes+':'+seconds;
                return time;
            }

            $.getCurentUnixTime = function (){
                var timestamp = parseInt(Math.floor(Date.now() / 1000)  )// current time in seconds
                // Math.floor(Date.now() / 1000) // current time in seconds
                return timestamp;
            }

            $.convertUnix2Time = function(timestamp){

                /*
                 var hours = Math.floor(parseInt(timestamp) / 60 / 60);
                 var minutes = Math.floor((parseInt(timestamp) - hours* 60 * 60) / 60);
                 var seconds = Math.floor(timestamp - hours * 60 * 60 - minutes * 60 );
                 var duration = hours + ':' + minutes + ':' + seconds;
                 */

                var a = new Date(timestamp*1000);
                var hour = a.getHours()
                var min = a.getMinutes()
                var sec = a.getSeconds()
                var currentTime = hour + ':' + min + ':' + sec;

                return currentTime;
            }

            $('.project-bttn').click(function(){
               $('.counter-slide').slideDown();
                var unixCurrent = $.getCurentUnixTime();
                var startTime =  unixCurrent + '|' + $.convertUnix2Time(unixCurrent);
                $('#unix-start').text(startTime);
                $('#unix-proid').text($(this).attr("id").replace("prod-",""));
                $.counterUp();
				
				$('#ajax-loader').html('<br /><img src="<?=$this->webroot?>img/ajax-loader_3.gif" width="30%">')
            });

            $('.counter-slide').click(function(){
                $('.counter-slide').slideUp();
                var unixCurrent = $.getCurentUnixTime();
                var startTime =  unixCurrent + '|' + $.convertUnix2Time(unixCurrent);
                $('#unix-end').text(startTime);
                $.counterStop();
                $.writeUnix2DB();
				
				$('#ajax-loader').html('');
            });

            $.counterUp = function(timestampUp){
                var $div = $('#timer-digits');
                var timestampUp = 1;
                interval  = setInterval(function() { // execute code each second
                    timestampUp++; // decrement timestamp with one second each second
                    $div.text($.toHHMMSS(timestampUp)); // display
                    $('#unix-diff').text(timestampUp);
                }, 1000); // interval each second = 1000 ms
            };

            $.counterStop = function(){
                 clearInterval(interval)
                 $('#timer-digits').text('');
             };

            $.writeUnix2DB = function(){

                $.ajax({
                    type: "POST",
                    url: "http://<?=$_SERVER['HTTP_HOST']?><?=$this->webroot?>projects/savetime/" + $('#unix-proid').text(),
                    data: {
                        unixStart: $('#unix-start').text(),
                        unixEnd: $('#unix-end').text(),
                        unixDiff: $('#unix-diff').text()
                    }
                })
                .done(function( msg ) {
                    //alert( "Data Saved: " + msg );
                    $('#unix-start').text('')
                    $('#unix-end').text('')
                    $('#unix-diff').text('')
                    $('#unix-proid').text('')
                });

            }

        });
    </script>