<?php
include_once 'JustGivingClient.php';
include_once 'ApiClients/Model/CreateAccountRequest.php';

function WriteLine($string)
{
	echo $string . "<br/>";
}

$ApiLocation = "https://api.staging.justgiving.com/";
$ApiKey = "decbf1d2";
$TestUsername = "apiunittests@justgiving.com";
$TestValidPassword = "password";

$client = new JustGivingClient($ApiLocation, $ApiKey, 1);

		
// Create account		
$uniqueId = uniqid();
$request = new CreateAccountRequest();
$request->email = "test+".$uniqueId."@test.com";
$request->firstName = "first".$uniqueId;
$request->lastName = "last".$uniqueId;
$request->password = "testpassword";
$request->title = "Mr";
$request->address->line1 = "testLine1".$uniqueId;
$request->address->line2 = "testLine2".$uniqueId;
$request->address->country = "testCountry".$uniqueId;
$request->address->countyOrState = "testCountyOrState".$uniqueId;
$request->address->townOrCity = "testTownOrCity".$uniqueId;
$request->address->postcodeOrZipcode = "M130EJ";
$request->acceptTermsAndConditions = true;
$response = $client->Account->Create($request);

WriteLine("Created accounts email/login: " . $response->email);

// Create page
$client = new JustGivingClient($ApiLocation, $ApiKey, 1, $request->email, $request->password);

$dto = new RegisterPageRequest();
$dto->reference = "12345";
$dto->pageShortName = "api-test-" . uniqid();
$dto->activityType = "OtherCelebration";
$dto->pageTitle = "api test";
$dto->eventName = "The Other Occasion of ApTest and APITest";
$dto->charityId = 2050;
$dto->targetAmount = 20;
$dto->eventDate = "/Date(1235764800000)/";
$dto->justGivingOptIn = true;
$dto->charityOptIn = true;
$dto->charityFunded = false;
	
$page = $client->Page->Create($dto);

WriteLine("Created page url - " . $page->next->uri);

// Retrieve page				
$json = $client->Page->Retrieve($dto->pageShortName);

WriteLine("pageId - " . $json->pageId);
WriteLine("activityId - " . $json->activityId);
WriteLine("eventName - " . $json->eventName);
WriteLine("pageShortName - " . $json->pageShortName);
WriteLine("status - " . $json->status);
WriteLine("owner - " . $json->owner);
WriteLine("event date - " . $json->eventDate);
WriteLine("branding->buttonColour - " . $json->branding->buttonColour);
WriteLine("branding->buttonTextColour - " . $json->branding->buttonTextColour);
WriteLine("branding->headerTextColour - " . $json->branding->headerTextColour);		
WriteLine("Story - " . strip_tags($json->story));
