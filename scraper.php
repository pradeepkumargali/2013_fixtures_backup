<?php
require 'scraperwiki.php';
require 'scraperwiki/simple_html_dom.php';
$iplSeries="2014";
//$html_content= scraperWiki::scrape("http://www.thatscricket.com/indian-premier-league/".$iplSeries."/");
//ScraperWiki::attach("sqads", "src");
//$playerIds=scraperwiki::select("distinct player_id from src.data desc");
$matchNId=1;
while($matchNId<=1){

//Carrer Stats http://dynamic.pulselive.com/test/data/core/cricket/careerStats/1_careerStats.js?_1363343668516=
//http://dynamic.pulselive.com/dynamic/data/core/cricket/2012/ipl2012/ipl2012-70/scoring.js?_1364576135590=
//http://dynamic.pulselive.com/dynamic/data/core/cricket/2012/ipl2013/matchSchedule2.js?_1364793413209=
$json_content= scraperWiki::scrape("http://dynamic.pulselive.com/dynamic/data/core/cricket/2012/ipl2014/matchSchedule2.js?_1364793413209=");

//print "JSON".$json_content;
 
if(strpos($json_content,"The page is not found") === FALSE){       
        //http://dynamic.pulselive.com/dynamic/data/core/cricket/2012/ipl2012/23_careerStats.js
        $json_content=str_replace("onMatchSchedule(","",$json_content);
            $json_content=str_replace(");","",$json_content);
        $myMatchData=null;
        $myMatchData=json_decode($json_content,true); 
        //var_dump($myPlayerData);
        // PLAYER DATA
        foreach ($myMatchData["schedule"] as $match){
     
        //var_dump($match);
        // Prepare Overall Record
        if(array_key_exists('team1', $match)){
        $allrecord=array(
                'matchId'=> $match["matchId"]["name"],
                'venueCity'=> $match["venue"]["city"],
                'season'=> "ipl".$iplSeries,
                'teamA'=>$match["team1"]["team"]["shortName"],
                'teamB'=>$match["team2"]["team"]["shortName"],
                    
                );
        
         scraperwiki::save(array('matchId','venueCity'), $allrecord); 
         }
        }

}
else
{
    print "Empty JSON FOR".$matchId."\n";
}

$matchNId++;


}

?>

