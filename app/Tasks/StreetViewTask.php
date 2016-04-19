<?php

namespace App\Tasks;

use App\Main\Models\Location;
use Phalcon\Cli\Task;
use GuzzleHttp\Client;

class StreetViewTask extends Task
{
	private $attemptCount = 10;

	public function exploreAction(array $params = null)
	{
		$count = !empty($params[0]) ? $params[0] : 5;
		if (!empty($params[1])) {
			$this->attemptCount = (int)$params[1];
		}
		for ($i = 0; $i < $count; $i++) {
			$location = $this->getRandomStreetViewLocation();
			if (null === $location) {
				continue;
			}
			(new Location())->save(
				$location,
				[
					'latitude',
					'longitude'
				]
			);
			echo sprintf('lat: %s', $location['latitude']) . PHP_EOL;
			echo sprintf('long: %s', $location['longitude']) . PHP_EOL;
		}
		sleep(60);
		$this->exploreAction($params);
	}

	private function getRandomStreetViewLocation($attemptNum = 0)
	{
		if ($attemptNum > $this->attemptCount) {
			return null;
		}
		if ($attemptNum > 0) {
			sleep(1);
		}
		$attemptNum++;
		$mul = 10000;
		$location = [
			mt_rand(-85 * $mul, 85 * $mul) / $mul,
			mt_rand(-180 * $mul, 180 * $mul) / $mul,
		];
		$searchRadius = 50000;
		$url = "http://cbks0.google.com/cbk?cb_client=apiv3&authuser=0&hl=en&output=polygon&it=1%3A1&rank=closest&ll={$location[0]},{$location[1]}&radius={$searchRadius}";
		$client = new Client(
			[
				'headers' => [
					'User-Agent' => 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:21.0) Gecko/20100101 Firefox/21.0',
				]
			]
		);
		try {
			$res = $client->get($url);
			if ($res->getStatusCode() != 200) {
				return $this->getRandomStreetViewLocation($attemptNum);
			} else {
				$content = json_decode($res->getBody()->getContents(), true);
				if (!empty($content['result']) && !empty($content['result'][0])) {
					return $content['result'][0];
				}
				return $this->getRandomStreetViewLocation($attemptNum);
			}
		} catch (\Exception $e) {
			return $this->getRandomStreetViewLocation($attemptNum);
		}
	}
}