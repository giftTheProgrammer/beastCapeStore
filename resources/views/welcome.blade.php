@extends('layouts.landing')

@section('content')
    <h1 class="heading">Artworks</h1>
    <div class="display-body">
    	@if(count($artworks) > 0)
    	
    		<div class="tiled">
		    	@foreach($artworks as $artwork)
			        
			        <div class="tiled-item">
			           	<div class="card">
			           		<a href="/show/{{$artwork->id}}" class="art-pic">
			            		<img src="{{URL::asset('storage/photos/'.$artwork->artwork_thumbnail)}}" class="card-img-top" />
			            	</a>
			            	<div class="card-body">
			            		<h2 class="card-title">{{ $artwork->title }}</h2>
			            		<h3 id="the-money" class="card-text">
			            			<strong>R{{ $artwork->artwork_price }}</strong>
			            		</h3>

			            		<button class="press_play" type="button" name="{{$artwork->id}}">
			            		<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-play-btn" viewBox="0 0 16 16">
								  <path d="M6.79 5.093A.5.5 0 0 0 6 5.5v5a.5.5 0 0 0 .79.407l3.5-2.5a.5.5 0 0 0 0-.814l-3.5-2.5z"/>
								  <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm15 0a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4z"/>
								</svg>
			            		</button>
			            	</div>

			            </div>

			        </div>
			        
		        @endforeach
	        </div>


	        <div id="player">
				<div class="movement-container" id="progress-container">
					<div class="movement" id="progress"></div>
				</div>

				<audio id="mymuze"></audio>

				<div id="buttons">
					<img class="player-control" id="prevSong" src="http://localhost:8000/storage/previous.png" />
					<img class="player-control" id="playit" src="http://localhost:8000/storage/play-button-arrowhead.png" />
					<img class="player-control" id="nextSong" src="http://localhost:8000/storage/next.png" />
				</div>
				
				<div id="timer">
					<span id="currTime"></span><span id="divider">/</span>
					<span id="durTime"></span>
				</div>
				
				<div class="sound">
					<div class="vol-gauge" id="vol-gauge">
						<div class="vol" id="vol"></div>
					</div>
					<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-volume-up-fill" viewBox="0 0 16 16">
					  <path d="M11.536 14.01A8.473 8.473 0 0 0 14.026 8a8.473 8.473 0 0 0-2.49-6.01l-.708.707A7.476 7.476 0 0 1 13.025 8c0 2.071-.84 3.946-2.197 5.303l.708.707z"/>
					  <path d="M10.121 12.596A6.48 6.48 0 0 0 12.025 8a6.48 6.48 0 0 0-1.904-4.596l-.707.707A5.483 5.483 0 0 1 11.025 8a5.483 5.483 0 0 1-1.61 3.89l.706.706z"/>
					  <path d="M8.707 11.182A4.486 4.486 0 0 0 10.025 8a4.486 4.486 0 0 0-1.318-3.182L8 5.525A3.489 3.489 0 0 1 9.025 8 3.49 3.49 0 0 1 8 10.475l.707.707zM6.717 3.55A.5.5 0 0 1 7 4v8a.5.5 0 0 1-.812.39L3.825 10.5H1.5A.5.5 0 0 1 1 10V6a.5.5 0 0 1 .5-.5h2.325l2.363-1.89a.5.5 0 0 1 .529-.06z"/>
					</svg>
				</div>

				<div class="song-info">
					<p id="song-name"></p>
				</div>
				
			</div>
    	@endif
    </div>
<script type="text/javascript">
	const musicContainer = document.getElementById("player");
		const playBtn = document.getElementById("playit");
		const aud = document.getElementById("mymuze");
		const progress = document.getElementById("progress");
		const progressContainer = document.getElementById("progress-container");
		const currTime = document.getElementById("currTime"); 
		const durTime = document.getElementById("durTime");
		const divider = document.getElementById("divider");
		const volumeGauge = document.getElementById("vol-gauge");
		const sound = document.getElementById("vol");
		const songname = document.getElementById("song-name");

		$(document).ready(function(){
			$(".press_play").click(function(){
				$.get("http://localhost:8000/playerLoad/"+this.name+"/", function(result, state){
					console.warn(result);

					loadSong(result.mainfile, result.title);
				});
			});
		});

		function loadSong(song, title){
			aud.src = "http://localhost:8000/storage/songs/" + song;
			songname.innerHTML = title;
		}

		function playSound(){
			divider.style.display = "inline-block";
			musicContainer.classList.add('play');
			playBtn.src = "http://localhost:8000/storage/pause.png";
			aud.play();
		}

		function pauseSound(){
			musicContainer.classList.remove('play');
			playBtn.src = "http://localhost:8000/storage/play-button-arrowhead.png";
			aud.pause();
		}

		// to update the progress bar
		function updateProgress(e){
			const { duration, currentTime } = e.srcElement;
			const progressPercent = (currentTime / duration) * 100;
			progress.style.width = `${progressPercent}%`;
		}

		// to set the progress bar
		function setProgress(e){
			const width = this.clientWidth;
			const clickX = e.offsetX;
			const duration = aud.duration;

			aud.currentTime = (clickX / width) * duration;
		}

		// get the duration & current time of the song
		function DurTime(e){
			const {duration, currentTime} = e.srcElement;
			var sec;
			var sec_d;

			// define minutes of currentTime
			let min = (currentTime == null) ? 0 : Math.floor(currentTime / 60);
			min = min < 10 ? '0' + min : min;

			//define seconds of current time
			function get_sec(x){
				if (Math.floor(x) >= 60) {
					for (var i = 1; i <= 60; i++) {
						if (Math.floor(x) >= (60 * i) && Math.floor(x) < 60 * (i + 1)) {
							sec = Math.floor(x) - (60 * i);
							sec = sec < 10 ? '0' + sec : sec;
						}
					}
				} else {
					sec = Math.floor(x);
					sec = sec < 10 ? '0' + sec : sec;
				}
			}

			get_sec(currentTime, sec);

			// change current time DOM
			currTime.innerHTML = min + ':' + sec + ' ';

			//define minutes of duration
			let min_d = (isNaN(duration) === true) ? '0' : Math.floor(duration / 60);
			min_d = min_d < 10 ? '0' + min_d : min_d;

			//
			function get_sec_d(x){
				if (Math.floor(x) >= 60) {
					for (var i = 0; i <= 60; i++) {
						if (Math.floor(x) >= (60 * i) && Math.floor(x) < 60 * (i + 1)) {
							sec_d = Math.floor(x) - (60 * i);
							sec_d = sec_d < 10 ? '0' + sec_d : sec_d;
						}
					}
				} else {
					sec_d = (isNaN(duration) === true) ? '0' : Math.floor(x);
					sec_d = sec_d < 10 ? '0' + sec_d : sec_d;
				}

			}

			// define second of duration
			get_sec_d(duration);


			// change duration DOM
			durTime.innerHTML = min_d + ":" + sec_d;
		} //end of function DurTime


		// to set the volume.
		function setVolume(e){
			const width = this.clientWidth;
			const clickX = e.offsetX;
			aud.volume = clickX/64;
			sound.style.width = `${aud.volume * 100}%`;
		}



		playBtn.addEventListener('click', () => {
			const isPlaying = musicContainer.classList.contains('play');

			if (isPlaying) {
				pauseSound();
			}else{
				playSound();
			}
			
		});


		// Time/song change
		aud.addEventListener('timeupdate', updateProgress);

		// Pressing on the seeker
		progressContainer.addEventListener('click', setProgress);

		// Song ends
		aud.addEventListener('ended', pauseSound);

		// Time of song 
		aud.addEventListener('timeupdate', DurTime);

		// Clicking on the volume seeker
		volumeGauge.addEventListener('click', setVolume);
    // $(document).ready(function(){
    //     $("#press_play").click(function(){
    //         alert("Yeah I did it");
    //         // $("#mp3_src").attr("src", "{{URL::asset('storage/songs/'.$artwork->mainfile)}}");
    //         // $("#play").load();
    //     });
    // });     

    // function myFunction(){
    // 	var musik = this.name.value;
    // 	alert(this);
    //     document.getElementById("mp3_src").src = musik;
    //     document.getElementById("play").load();
    // }


    // onclick="document.getElementById('mp3_src').src =this.name;document.getElementById('play').load()"
</script>
    
@endsection