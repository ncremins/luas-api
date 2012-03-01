<?php

	/**
	 * Ajax endpoint for getting luas (dublin light rail), times and geo-coded data.
	 *
	 * PHP version 5
	 *
	 * Redistribution and use in source and binary forms, with or without
	 * modification, are permitted provided that the following conditions are met:
	 *
	 * - Redistributions of source code must retain the above copyright notice,
	 *   this list of conditions and the following disclaimer.
	 * - Redistributions in binary form must reproduce the above copyright notice,
	 *   this list of conditions and the following disclaimer in the documentation
	 *   and/or other materials provided with the distribution.
	 *
	 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
	 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
	 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
	 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE
	 * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
	 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
	 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
	 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
	 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
	 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
	 * POSSIBILITY OF SUCH DAMAGE.
	 *
	 * @author     Neil Cremins <neilcremins@gmail.com>
	 * @version    1.0
	 * @link       http://www.neilcremins.com/
	 *
	 */


	/**
	 *
	 * $action 	= which case to call in switch statement.
	 * $station = needs to be in the format of array keys below.
	 * 
	 *
	 * This endpoint was originally built to request data from luas.ie and still does for gettimes.
	 * 
	 * This means it can break at any time and I am in no way responsible for this.
	 *
	 */
	
	$action 	= $_GET['action'];
	$station 	= $_GET['station'];
	
	$stations = array(
		  "st-stephens-green"       => urlencode("St. Stephen's Green")
		, "harcourt"                => "Harcourt" 
		, "charlemont"              => "Charlemont" 
		, "ranelagh"                => "Ranelagh" 
		, "beechwood"               => "Beechwood" 
		, "cowper"                  => "Cowper" 
		, "milltown"                => "Milltown" 
		, "windy-arbour"            => urlencode("Windy Arbour") 
		, "dundrum"                 => "Dundrum" 
		, "balally"                 => "Balally" 
		, "kilmacud"                => "Kilmacud" 
		, "stillorgan"              => "Stillorgan" 
		, "sandyford"               => "Sandyford" 
		, "central-park"            => urlencode("Central Park") 
		, "glencalm"                => "Glencairn" 
		, "the-gallops"             => urlencode("The Gallops") 
		, "leopardstown-valley"     => urlencode("Leopardstown Valley")
		, "ballyogan-wood"          => urlencode("Ballyogan Wood") 
		, "carrickmines"            => "Carrickmines" 
		, "laughanstown"            => "Laughanstown" 
		, "cherrywood"              => "Cherrywood" 
		, "brides-glen"             => urlencode("Brides Glen")
		// red line
		, "the-point"           	=> urlencode("The Point")
		, "spencer-dock"        	=> urlencode("Spencer Dock") 
		, "mayor-square-nci"    	=> urlencode("Mayor Square - NCI")
		, "georges-dock"        	=> urlencode("George's Dock")
		, "busaras"					=> "Bus%E1ras" // flithy hack
		, "connolly"            	=> "Connolly"
		, "abbey-street"        	=> urlencode("Abbey Street") 
		, "jervis"              	=> "Jervis"
		, "the-four-courts"     	=> urlencode("Four Courts")
		, "smithfield"          	=> "Smithfield" 
		, "museum"              	=> "Museum" 
		, "heuston"             	=> "Heuston" 
		, "jamess"              	=> urlencode("James's") 
		, "fatima"              	=> "Fatima" 
		, "rialto"              	=> "Rialto" 
		, "suir-road"           	=> urlencode("Suir Road") 
		, "goldenbridge"        	=> "Goldenbridge" 
		, "drimnagh"            	=> "Drimnagh" 
		, "blackhorse"          	=> "Blackhorse" 
		, "bluebell"            	=> "Bluebell" 
		, "kylemore"            	=> "Kylemore" 
		, "red-cow"             	=> urlencode("Red Cow") 
		, "kingswood"           	=> "Kingswood" 
		, "belgard"             	=> "Belgard" 
		, "cookstown"           	=> "Cookstown" 
		, "hospital"            	=> "Hospital" 
		, "tallaght"            	=> "Tallaght"
		, "fettercairn"				=> "Fettercairn"
		, "cheeverstown"			=> "Cheeverstown"
		, "citywest-campus"			=> urlencode("Citywest Campus")
		, "fortunestown"			=> "Fortunestown"
		, "saggart"					=> "Saggart"
	);
	
	
	$gps = array(
		  "st-stephens-green"       => array(53.339605, -6.26128) 
		, "harcourt"                => array(53.333551, -6.26290) 
		, "charlemont"              => array(53.330681, -6.25880) 
		, "ranelagh"                => array(53.326266, -6.25636)
		, "beechwood"               => array(53.320845, -6.25486)
		, "cowper"                  => array(53.309839, -6.25174)
		, "milltown"                => array(53.309839, -6.25174)
		, "windy-arbour"            => array(53.293798, -6.24699) 
		, "dundrum"                 => array(53.293798, -6.24699)
		, "balally"                 => array(53.286102, -6.23679)
		, "kilmacud"                => array(53.282997, -6.223969)
		, "stillorgan"              => array(53.279347, -6.210156)
		, "sandyford"               => array(53.277596, -6.204679)
		, "central-park"            => array(53.270321, -6.203531)
		, "glencalm"                => array(53.266313, -6.210161)
		, "the-gallops"             => array(53.262109, -6.208775)
		, "leopardstown-valley"     => array(53.257996, -6.197485)
		, "ballyogan-wood"          => array(53.255901, -6.188200)
		, "carrickmines"            => array(53.254518, -6.172085)
		, "laughanstown"            => array(53.250955, -6.156045)
		, "cherrywood"              => array(53.247832, -6.14845)
		, "brides-glen"             => array(53.242160, -6.142961)
		, "the-point"        		=> array(53.34834, -6.22962)
		, "spencer-dock"     		=> array(53.34882, -6.23718)
		, "mayor-square-nci" 		=> array(53.34933, -6.24355)
		, "georges-dock"     		=> array(53.34961, -6.24807)
		, "connolly"         		=> array(53.351499, -6.24993)
		, "bus aras"         		=> array(53.350289, -6.25277)
		, "abbey-street"     		=> array(53.348588, -6.258371)
		, "jervis"           		=> array(53.347669, -6.26609)
		, "the-four-courts"  		=> array(53.346824, -6.27291)
		, "smithfield"       		=> array(53.347259, -6.27860)
		, "museum"           		=> array(53.347842, -6.28673)
		, "heuston"          		=> array(53.346388, -6.29223)
		, "jamess"           		=> array(53.342033, -6.29384)
		, "fatima"           		=> array(53.338350, -6.29277)
		, "rialto"           		=> array(53.337869, -6.29750)
		, "suir-road"        		=> array(53.33664, -6.30733)
		, "goldenbridge"     		=> array(53.335857, -6.31366)
		, "drimnagh"         		=> array(53.335383, -6.31833)
		, "blackhorse"       		=> array(53.334192, -6.32793)
		, "bluebell"         		=> array(53.32930, -6.33396)
		, "kylemore"         		=> array(53.32649, -6.34390)
		, "red-cow"          		=> array(53.31666, -6.36939)
		, "kingswood"        		=> array(53.30247, -6.36862)
		, "belgard"          		=> array(53.29874, -6.37450)
		, "cookstown"        		=> array(53.294253, -6.38623)
		, "hospital"         		=> array(53.289591, -6.37930)
		, "tallaght"        		=> array(53.28771, -6.37359)
		, "fettercairn"				=> array(53.29395, -6.3957)
		, "cheeverstown"			=> array(53.29103, -6.40760)
		, "citywest-campus"			=> array(53.28781, -6.42022)
		, "fortunestown"			=> array(53.28441, -6.42501)
		, "saggart"					=> array(53.28483, -6.43904)
	);

	if($action != 'getstations')
	{
		if(in_array($station, array_keys($stations)) && ($action == 'gettimes' || $action == 'getcoords') )
		{
			$stop = str_replace(" ", "+", $stations[$station]);
		}
		else
		{
			$error = array('Unknown input');
			echo json_encode($error);
			exit;
		}
	}


	switch($action)
	{
		/**
		 * Get the coordinates of a specific station.
		 *
		 * @return json coords of the the station.
		 */
		case 'getcoords':
		{
			echo json_encode($gps[$station]);
			exit;
		}
		
		/**
		 * Get the next luas times.
		 * 
		 * @return json of the next luas' at selected stop.
		 */
		case 'gettimes':
		{
			$url = 'http://www.luas.ie/luaspid.html?get=' . $stop;	
			$yqlBaseUrl = "http://query.yahooapis.com/v1/public/yql";
			$yqlQuery = "SELECT * FROM html WHERE url='$url'";
			$yqlQueryUrl = $yqlBaseUrl . "?q=" . urlencode($yqlQuery) . "&format=json";

			$session = curl_init($yqlQueryUrl);
			curl_setopt($session, CURLOPT_RETURNTRANSFER, true);    
			$json = curl_exec($session);    
				
			$obj = json_decode($json);
								
			$inbound = $obj->query->results->body->div[0];
			$outbound = $obj->query->results->body->div[1];
				
			$inboundTimes = array();
			$outboundTimes = array();
				
			$limit = count($inbound->div);
			$i = 0;
			$j = 0;
				
			//inbound.
			for($j = 0 ; $j < $limit ; $j+= 2)
			{
				if(is_array($inbound->div))
				{
					$inboundTimes[$i]['dest'] = $inbound->div[$j]->p;
					$inboundTimes[$i]['time'] = $inbound->div[$j+1]->p;
				}
					
				$i++;
			}
				
			$limit = count($outbound->div);
			$i = 0;
			$j = 0;
								
			//outbound.
			for($j = 0 ; $j < $limit ; $j+= 2)
			{
				if(is_array($outbound->div))
				{
					if( strlen(trim($outbound->div[$j]->p)) > 0)
					{
						$outboundTimes[$i]['dest'] = $outbound->div[$j]->p;
					}
					
					if( strlen(trim($outbound->div[$j+1]->p)) > 0)
					{
						$outboundTimes[$i]['time'] = $outbound->div[$j+1]->p;
					}
				}
					
				$i++;    
			}
								
			$times['inbound'] = $inboundTimes;
			$times['outbound'] = $outboundTimes;
				
			echo json_encode($times);
			exit;
		}

		/**
		 * Grab all stations for a specific luas line.
		 *
		 * @return json indexed by stop name of GPS coords. 
		 */
		case 'getstations':
		{
			echo json_encode($gps);
			exit;
		}
	}