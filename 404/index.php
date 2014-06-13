<?php
// Include RSS & HTML Parsers
require_once("lastRSS.php");

// Setup RSS Parser
$rss = new lastRSS();
$rss->cache_dir = './cache';
$rss->cache_time = 3600; // one hour

// Get RSS URL, including state (if specified)
$url = "http://www.missingkids.com/missingkids/servlet/XmlServlet?act=rss&LanguageCountry=en_US&orgPrefix=NCMC";
$states = array('AL', 'AK', 'AZ', 'AR', 'CA', 'CO', 'CT', 'DE', 'DC', 'FL', 'GA', 'HI', 'ID', 'IL', 'IN', 'IA', 'KS', 'KY', 'LA', 'ME', 'MD', 'MA', 'MI', 'MN', 'MS', 'MO', 'MT', 'NE', 'NV', 'NH', 'NJ', 'NM', 'NY', 'NC', 'ND', 'OH', 'OK', 'OR', 'PA', 'RI', 'SC', 'SD', 'TN', 'TX', 'UT', 'VT', 'VA', 'WA', 'WV', 'WI', 'WY');

if(!empty($_GET['state']) && in_array($_GET['state'], $states)) {
	$url .= "&state=".$_GET['state'];
}
// Parse RSS
if ($feed = $rss->get($url)) {
	$index = rand(0, count($feed['items'])-1);
	
	if(!empty($feed['items'][$index])) {
		$idPos = strpos($feed['items'][$index]['link'], "caseNum");
		$childId = substr($feed['items'][$index]['link'], $idPos+8);
		$ampPos = strpos($childId, "&");
		$childId = substr($childId, 0, $ampPos);
		
		?>
		<style>
		#innerdiv {
			position:absolute;
			display: none;
			top:-200px;
			left:0px;
			width:1000;
			height:825px;
		}
		</style>
		<div id="container">
			<div id="outerdiv">      
				<iframe id="innerdiv" src="http://www.missingkids.com/poster/NCMC/<?php echo $childId; ?>" scrolling="no" frameborder="0"></iframe>
			</div>
		</div>
		<script>
		document.getElementById('innerdiv').onload = setTimeout(displayIframe, 4000);
		function displayIframe() {
			document.getElementById('innerdiv').style.display = 'inline';
		}
		</script>
		<?php
	} else {
		
	}
	
	
}
else {
	die ('Error: RSS file not found...');
}
