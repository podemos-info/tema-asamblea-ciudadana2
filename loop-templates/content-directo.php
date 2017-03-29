<?php
global $current_ids, $current_id;
$yt_url = get_post_meta(get_the_ID(), "youtube_url", true);
$yt_id = get_yt_id($yt_url);
if(in_array(get_the_ID(),$current_ids)) $thumb_num = 7;
else $thumb_num = 6;
$get_yt_thumb_url = get_yt_thumb_url( $yt_id, $thumb_num );
$streaming_time = _x("DIRECTO", "podemos-streamings", "podemos-streamings");
?>
<div class="ps-thumb col-6 col-sm-6 col-md-6 col-lg-4 <?php echo $current_id == get_the_ID() ? "ps-selected" : "" ?>">
  <a class="ps-thumb-a" href="#content" data-id="<?php echo $yt_id;?>">
    <div>
      <img src="<?php echo $get_yt_thumb_url;?>" /><?php echo (in_array(get_the_ID(),$current_ids) ? "<span class='yt-directo-time'>".$streaming_time."</span>" : ""); ?>
    </div>
    <div class="elipsis"><h6><?php echo the_title(); ?></h6></div>
    <span class="yt-thumb-date"><?php echo date_i18n("j/n/Y",get_post_meta(get_the_ID(), "streaming_starts_at", true));?></span>
  </a>
</div>

