var playlist = [];
var playlist_id = 0;
var current = 0;
var player = null;

var apiKey = 'AIzaSyCKlMUEjUPMPayiDRADUpwDQW1AOBSOIms';
var googleApiClientReady = function(){};

//IFrame Player APIを非同期にロード
var tag = document.createElement('script');
tag.src = 'http://www.youtube.com/player_api';
var firstScriptTag = document.getElementsByTagName('script')[0];
firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

function onYouTubePlayerAPIReady(){
	
}
//プレイヤが準備できたら呼び出させる
function onPlayerReady(event){
	event.target.playVideo();
}
//ステータスが変更されたら呼び出させる
function onPlayerStateChange(event){
	if(event.data = YT.PlayerState.ENDED){
		console.log('ended');
		playNext();
	}else if(event.data == YT.PlayerState.PLAYING){
		console.log('playling');
	}else if(event.data == YT.PlayerState.PAUSED){
		console.log('paused');
	}
}
//エラーが起きたら次を再生
function onPlayerError(event){
	playNext();
}

function playNext(){
	current++;
	if(current >= playlist.length){
		current = 0;
	}
	player.loadVideoById(playlist[current]);
	$('.movie_box').css('background-color', 'white');
	$('.movie_box').eq(current).css('background-color', 'red');
}
function playPrev(){
	current++;
	if(current < 0){
		current = playlist.length -1;
	}
	player.loadVideoById(playlist[current]);
	$('.movie_box').css('background-color', 'white');
	$('.movie_box').eq(current).css('background-color', 'red');
}
function exe(){
	if(player.getPlayerState() == YT.PlayerState.PLAYING){
		player.pauseVideo();
	}else{
		player.playVideo();
	}
}


$(function(){
	$('#movie').hide();
	$('#main').hide();
	$('*[name=viewPlaylist]').on('click', adminPlaylistViewRequest);
});

function adminPlaylistViewRequest(){
	$('#movie').show();
	playlist_id = $(this).val();
	$.ajax({
		url: "/cake3movie/playlists/view",
		type: "POST",
		data: {playlist_id : playlist_id},
		dataType: "json",
		success: adminPlaylistViewSuccess,
		error: adminPlaylistViewError
	});
}
function adminPlaylistViewSuccess(result){
	playlist = result['movies'];
	console.log(playlist);
	showPlaylist(playlist);
}
function adminPlaylistViewError(result){
	console.log(result);
}

function showPlaylist(movies){
	playlist = movies;
	console.log(movies);
	idlist = playlist.join(',');
	gapi.client.setApiKey(apiKey);
	gapi.client.load('youtube', 'v3', function(){});
	var request = gapi.client.request({
		'path': '/youtube/v3/videos',
		'params': {
			'part': 'snippet',
			'id': idlist
		}
	});
	
	request.execute(function(data){
		console.log(data);
		$('#sidebar').text('');
		$('#sidebar').append('<table>');
		
		for(var i in data.items){
			if(data.items[i].kind == "youtube#video"){
				$('#sidebar table').append(
						'<tr class="movie_box" id="' + data.items[i].id + '">' +
						'<td class="thum" onclick="playMovie(this, \''+ data.items[i].id +'\');">' +
						'<img src="' + data.items[i].snippet.thumbnails.default.url + '"/>' +
						'</td>' +
						'<td class="details" onclick="playMovie(this, \''+ data.items[i].id +'\');">' + data.items[i].snippet.title + '<br />' +
						'</td>' +
						'<\tr>'
				);
			}
		}
	});
}

function playMovie(event, video_id){
	$('#main').show();
	current = $('.thum').index(event);
	if(current == -1){
		current = $('.details').index(event);
	}
	$('.movie_box').css('background-color', 'white');
	$('.movie_box').eq(current).css('background-color', 'red');
	
	if(player === null){
		player = new YT.Player('player', {
			height: '315',
			width: '500',
			videoId: video_id,
			events: {
				'onReady': onPlayerReady,
				'onStateChange': onPlayerStateChange,
				'onError': onPlayerError
			}
		});
	}else{
		player.loadVideoById(video_id);
	}
}

function adminPlaylistFormInit(){
	$('#message').remove();
	$('.help-block').remove();
	$('.form-group').removeClass('has-error');
}

function showSuccessMessage(message){
	var tag = '<div id="message" class="alert alert-success">';
	tag += message;
	tag += '</div>';
	$('.main').prepend(tag);
}
function showErrorMessage(message){
	var tag = '<div id="message" class="alert alert-danger">';
	tag += message;
	tag += '</div>';
	$('.main').prepend(tag);
}