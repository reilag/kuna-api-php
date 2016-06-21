<?php namespace Kuna\Endpoint;


use Endpoint\EndpointAbstract;
use Kuna\Request;

/**
 * Class PrivateMethod
 * @package Kuna\Endpoint
 */
class PrivateMethod extends EndpointAbstract
{

	/**
	 * PrivateMethod constructor.
	 *
	 * @param \Kuna\Client $client
	 */
	public function __construct($client)
	{
		parent::__construct($client);
	}

	/**
	 * @param Request $request
	 *
	 * @return bool
	 */
	public function beforeExecude(Request $request)
	{

		if( empty($this->client) )
		{
			$this->error = 'For using Private Methods, Client must be set';
			return false;
		}
		
		$publicKey = $this->client->getPublicKey();
		if( empty($publicKey) )
		{
			$this->error = 'Public KEY is empty';
			return false;
		}

		$secretKey = $this->client->getSecretKey();
		if( empty($secretKey) )
		{
			$this->error = 'Secret KEY is empty';
			return false;
		}
		
		$request->subscribeSignature($publicKey, $secretKey);
		
		return true;
	}

}