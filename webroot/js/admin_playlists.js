var playlist = [];
var playlist_id = 0;
var current = 0;
var player = null;

var apiKey = 'AIzaSyCKlMUEjUPMPayiDRADUpwDQW1AOBSOIms';
var googleApiClientReady = function(){};

//IFrame Player APIを非同期にロード
//var tag = document.createElement('script');
//tag.src = 'http://www.youtube.com/player_api';
//var firstScriptTag = document.getElementsByTagName('script')[0];
//firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

function onYouTubePlayerAPIReady(){}
//プレイヤが準備できたら呼び出させる
function onPlayerReady(event){
	event.target.playVideo();
}
//ステータスが変更されたら呼び出させる
function onPlayerStateChange(event){
	if(event.data = YT.PlayerState.ENDED){
		playNext();
	}else if(event.data == YT.PlayerState.PLAYING){
		
	}else if(event.data == YT.PlayerState.PAUSED){
		
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
}
function playPrev(){
	current++;
	if(current < 0){
		current = playlist.length -1;
	}
	player.loadVideoById(playlist[current]);
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
	$('*[name=viewPlaylist]').on('click', adminPlaylistViewRequest);
});

function adminPlaylistViewRequest(){
	$('#movie').show();
	playlist_id = $(this).val();
	$.ajax({
		url: "/cake3movie/admin/playlists/view",
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
	showPlaylist(result['movies']);
}
function adminPlaylistViewError(result){
	console.log(result);
}

function showPlaylist(movies){
	gapi.client.setApiKey(apiKey);
	gapi.client.load('youtube', 'v3', function(){});
	$('#sidebar').text('');
	$('#sidebar').append('<table>');
	$.each(movies, function(i, value){
		var request = gapi.client.request({
			'path': '/youtube/v3/videos',
			'params': {
				'part': 'snippet',
				'id': this
			}
		});
		request.execute(function(data){
//			console.log(data);
				if(data.kind == "youtube#videoListResponse"
					&& data.items[0].kind == "youtube#video"){
					$('#sidebar table').append(
							'<tr class="movie_box" id="' + data.items[0].id + '">' +
							'<td class="thum" onclick="playMovie(\''+ data.items[0].id +'\');">' +
							'<img src="' + data.items[0].snippet.thumbnails.default.url + '"/>' +
							'</td>' +
							'<td class="details">' + data.items[0].snippet.title + '<br />' +
							'</td>' +
							'<td>'+
							'<div class="btn btn-default glyphicon glyphicon-arrow-up" onclick="" id="up'+ i +'"></div>'+
							'<div class="btn btn-default glyphicon glyphicon-arrow-down" onclick="" id="down'+ i +'"></div>'+
							'<div class="btn btn-warning" onclick="removeMovie(\'' +data.items[0].id + '\');" >削除</div></td>' +
							'<\tr>'
					);
				}
		});
	});
	
}

function removeMovie(video_id){
	console.log(playlist_id);
	console.log(video_id);
	//TODO::ajaxでプレイリストに入っている動画削除
	$.ajax({
		url: "/cake3movie/admin/movies/delete",
		type: "POST",
		data: {playlist_id : playlist_id, video_id: video_id},
		dataType: "json",
		success: adminPlaylistDeleteSuccess(video_id),
		error: adminPlaylistDeleteError
	});
}
function adminPlaylistDeleteSuccess(video_id, result){
	$('#' + video_id).text('');
}
function adminPlaylistDeleteError(result){
	console.log(result);
}


function upMovie(){
	//TODO::選択した動画の順番を繰り上げ
}

function downMovie(){
	//TODO::選択した動画の順番を繰り下げ
}