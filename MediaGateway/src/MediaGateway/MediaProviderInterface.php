<?php
namespace MediaGateway;

interface MediaProviderInterface
{
	public function search(array $data);
	public function normalize(array $data);
	public function getName();
	public function getType();
	public function validateApiConfig();
}