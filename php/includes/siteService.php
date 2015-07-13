<?php
require_once("mbApi.php");

class MBSiteService extends MBAPIService 
{
	function __construct($debug = false)
	{
		$endpointUrl = "https://" . GetApiHostname() . "/0_5/SiteService.asmx";
		$wsdlUrl = $endpointUrl . "?wsdl";
	
		$this->debug = $debug;
		$option = array();
		if ($debug)
		{
			$option = array('trace'=>1);
		}
		$this->client = new soapclient($wsdlUrl, $option);
		$this->client->__setLocation($endpointUrl);
	}
	
	/**
	 * Returns the raw result of the MINDBODY SOAP call.
	 * @param int $PageSize
	 * @param int $CurrentPage
	 * @param string $XMLDetail
	 * @param string $Fields
	 * @param SourceCredentials $credentials A source credentials object to use with this call
	 * @return object The raw result of the SOAP call
	 */
	public function GetActivationCode($siteID, $test = false, $PageSize = null, $CurrentPage = null, $XMLDetail = XMLDetail::Full, $Fields = null, SourceCredentials $credentials = null)
	{		
		$additions = array();
		$additions['SiteIDs'] = $siteID;
		error_log("%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%");
		error_log("Got some request for activitation code for site id: " . $siteID);
		error_log(var_export( $additions, true));
		
		$params = $this->GetMindbodyParams($additions, $this->GetCredentials($credentials), $XMLDetail, $PageSize, $CurrentPage, $Fields);
		
		$result = $this->client->GetActivationCode($params);
		
		error_log("@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@");
		error_log("Got some results baby!");
		error_log(var_export( $results, true));
		
		if ($this->debug)
		{
			DebugRequest($this->client);
			DebugResponse($this->client, $result);
		}
		
		return $result;
	}
}