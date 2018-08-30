var playlist = [];
var current = 0;
var player = null;
var videoId = null;

var apiKey = 'AIzaSyCKlMUEjUPMPayiDRADUpwDQW1AOBSOIms';
var googleApiClientReady = function(){
	init();
};
var init = function(){
	$('#adminHomesSearchButton').attr('disabled', false);
};

//IFrame Player APIを非同期にロード
var tag = document.createElement('script');
tag.src = 'http://www.youtube.com/player_api';
var firstScriptTag = document.getElementsByTagName('script')[0];
firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

function onYouTubePlayerAPIReady(){}
//プレイヤが準備できたら呼び出させる
function onPlayerReady(event){
	event.target.playVideo();
}
// ステータスが変更されたら呼び出させる
function onPlayerStateChange(event){
	if(event.data == YT.PlayerState.ENDED){
		playNext();
	} else if(event.data == YT.PlayerState.PLAYING){
		
	} else if(event.data == YT.PlayerState.PAUSED){
		
	}
}
// エラーが起きたら次を再生
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
	current--;
	if(current < 0){
		current = playlist.length - 1;
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



var search = function(keyword){
	playlist = [];
	gapi.client.setApiKey(apiKey);
	gapi.client.load('youtube', 'v3', function(){});
	var request = gapi.client.request({
		'path': '/youtube/v3/search',
		'params': {
			'q': keyword,
			'type': 'video',
			'maxResults': 20,
			'part': 'snippet',
		}
	});
	request.execute(function(data){
		console.log(data);
		$('#sidebar').text('');
		$('#sidebar').append('<table>');
		for(var i in data.items){
			if(data.items[i].id.videoId &&
					data.items[i].id.kind == "youtube#video"){
				playlist.push(data.items[i].id.videoId);
				$('#sidebar table').append(
						'<tr class="movie_box" onclick="playMovie(this);" id="' + data.items[i].id.videoId + '">' +
						'<td class="thum">' +
						'<img src="' + data.items[i].snippet.thumbnails.default.url + '"/>' +
						'</td>' +
						'<td class="details">' + data.items[i].snippet.title + '<br />' +
						'<span class="description">' + '' + '</span>' +
						'</td>' +
						'<\tr>'
				);
			}
		}
	});
};


// CakePHPに使うjs

$(function(){
	$('#main').hide();
	$('#adminHomesSearchButton').on('click', adminHomesSearchRequest);
	$('#addPlaylist').on('click', adminMovieAddRequest);
	
	$('#prev').on('click', function(){
		playPrev();
	});
	$('#next').on('click', function(){
		playNext();
	});
	$('#exe').on('click', function(){
		exe();
	});
});

function adminHomesSearchRequest(event){
	var data = $('#homeSearch').serialize();
	$.ajax({
		url: "/cake3movie/admin/homes/indexajax",
		type: "POST",
		data: data,
		dataType: "json",
		success: adminHomeSearchSuccess,
		error: adminHomeSearchError,
	});
}

function adminHomeSearchSuccess(result){
	console.log(result);	
	search(result['search']);
}

function adminHomeSearchError(result){
	console.log(result);
}

function adminMovieAddRequest(event){
	adminMovieAddFormInit();
	playlist_id = $('*[name=playlist_id]').val();
	console.log(playlist_id);
	$.ajax({
		url: "/cake3movie/admin/movies/add",
		type: "POST",
		data: {playlist_id : playlist_id, video_id : playlist[current]},
		dataType: "json",
		success: adminMovieAddSuccess,
		error: adminMovieAddError,
	});
}
function adminMovieAddSuccess(result){
	console.log(result);
	if(result['status'] == 'success'){
		showSuccessMessage("プレイリストに動画を登録しました");
	}else{
		showErrorMessage(result['errors']);
	}
	
}
function adminMovieAddError(result){
	showErrorMessage("エラーが発生しました");
}

function adminMovieAddFormInit(){
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

// 検索リストの動画を押した時
function playMovie(event){
	$('#main').show();
	current = $('.movie_box').index(event);
	
	if(player === null){
		player = new YT.Player('player', {
			height: '315',
			width: '500',
			videoId: playlist[current],
			events: {
				'onReady': onPlayerReady,
				'onStateChange': onPlayerStateChange,
				'onError': onPlayerError
			}
		});
	}else{
		player.loadVideoById(event.id);
	}
	$('.movie_box').css('background-color', 'white');
	$(event).css('background-color', 'red');
	
}