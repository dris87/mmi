<?php
namespace App\Helpers;

use App\Rules\YoutubeOrVimeoUrl;
use Illuminate\Support\Facades\Validator;

class Video
{
    /** Determines whether $url is a YouTube or Vimeo url
     * @param $url
     * @return array
     */
    public static function determineVideoUrlType($url): array
    {
        $yt_rx = '/^((?:https?:)?\/\/)?((?:www|m)\.)?((?:youtube\.com|youtu.be))(\/(?:[\w\-]+\?v=|embed\/|v\/)?)([\w\-]+)(\S+)?$/';
        $has_match_youtube = preg_match($yt_rx, $url, $yt_matches);


        $vm_rx = '/(https?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([‌​0-9]{6,11})[?]?.*/';
        $has_match_vimeo = preg_match($vm_rx, $url, $vm_matches);


        //Then we want the video id which is:
        if($has_match_youtube) {
            $video_id = $yt_matches[5];
            $type = 'youtube';
        }
        elseif($has_match_vimeo) {
            $video_id = $vm_matches[5];
            $type = 'vimeo';
        }
        else {
            $video_id = 0;
            $type = 'none';
        }


        $data['video_id'] = $video_id;
        $data['video_type'] = $type;

        return $data;

    }

    /**
     * Returns the video title, description and thumbnail by given valid vimeo or YouTube url
     * @param $url
     * @return bool|array
     */
    public static function getVideoDetails($url)
    {
        $validator = Validator::make(['url' => $url],[
            'url' => ['required', new YoutubeOrVimeoUrl()
            ]
        ]);
        if ($validator->fails()) {
            return false;
        }

        $data = Video::determineVideoUrlType($url);
        $videoData = [];

        switch($data['video_type']){
            case 'youtube':{
                $videoData = Video::getYoutubeVideoDetails($data['video_id']);
                break;
            }
            case 'vimeo':{
                $videoData = Video::getVimeoVideoDetails($data['video_id']);
                break;
            }
            default: {
                break;
            }
        }

        return $videoData;
    }

    public static function getVimeoVideoDetails($video_id){

        $hash = json_decode(@file_get_contents("https://vimeo.com/api/v2/video/{$video_id}.json"));

        if(!$hash){
            return [];
        }

        return array(
            'provider'          => 'Vimeo',
            'title'             => $hash[0]->title,
            'description'       => str_replace(array("<br>", "<br/>", "<br />"), NULL, $hash[0]->description),
            'description_nl2br' => str_replace(array("\n", "\r", "\r\n", "\n\r"), NULL, $hash[0]->description),
            'thumbnail'         => $hash[0]->thumbnail_large,
            'video'             => "https://vimeo.com/" . $hash[0]->id,
            'embed_video'       => "https://player.vimeo.com/video/" . $hash[0]->id,
        );
    }

    /** Calls the YouTube API and returns the video details by video ID
     * @param $video_id
     * @return mixed
     */
    public static function getYoutubeVideoDetails($video_id){

        $hash = json_decode(file_get_contents("https://www.googleapis.com/youtube/v3/videos?part=snippet,contentDetails&id=".$video_id."&key=".config("app.youtube_api_key")));

        if(!$hash || empty($hash->items)){
            return [];
        }

        return array(
            'provider'          => 'YouTube',
            'title'             => $hash->items[0]->snippet->title,
            'description'       => str_replace(array("", "<br/>", "<br />"), NULL, $hash->items[0]->snippet->description),
            'description_nl2br' => str_replace(array("\n", "\r", "\r\n", "\n\r"), NULL, nl2br($hash->items[0]->snippet->description)),
            'thumbnail'         => 'https://i.ytimg.com/vi/'.$hash->items[0]->id.'/default.jpg',
            'video'             => "https://www.youtube.com/watch?v=" . $hash->items[0]->id,
            'embed_video'       => "https://www.youtube.com/embed/" . $hash->items[0]->id,
        );
    }
}
